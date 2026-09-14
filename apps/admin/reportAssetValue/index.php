<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1>LAPORAN NILAI & JUMLAH ASSET</h1>
	<hr />
	
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	<form action="index.php" method="post">	
		<table width="100%">
			<tr>
				<td width="24%">SUMBER DANA</td>
				<td align="left" width="50%">
					<select name="fundId" style="width:245px" >
						<option value="x">SEMUA</option>
						<?php while($val = mysqli_fetch_array($dataFund)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['fundId']) ? $_REQUEST['fundId'] : $data['fundId']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>		
				</td>
				<td style="text-align:right">
					<input type="button" onclick="window.open('excel.php?categoryAssetId=<?php echo implode(',',$categoryAssetId) ?>&dateBuy=<?php echo $dateBuy ?>&fundId=<?php echo $fundId ?>&departementId=<?php echo $departementId ?>&referencePrice=<?php echo $referencePrice ?>&condition=<?php echo str_replace("'",'',implode(',',$_REQUEST['condition'])) ?>')" value="PRINT TO EXCEL">				
					<input type="button" onclick="window.open('print.php?categoryAssetId=<?php echo implode(',',$categoryAssetId) ?>&dateBuy=<?php echo $dateBuy ?>&fundId=<?php echo $fundId ?>&departementId=<?php echo $departementId ?>&referencePrice=<?php echo $referencePrice ?>&condition=<?php echo str_replace("'",'',implode(',',$_REQUEST['condition'])) ?>')" value="PRINT">
				</td>
			</tr>
			<tr>
				<td>REFERENSI HARGA</td>
				<td align="left">
					<select name="referencePrice" style="width:245px" >
					<option value="0" <?php echo 0 == (isset($_REQUEST['referencePrice']) ? $_REQUEST['referencePrice'] : '') ? 'selected' : '' ?>>Harga Sekarang</option>
					<option value="1" <?php echo 1 == (isset($_REQUEST['referencePrice']) ? $_REQUEST['referencePrice'] : '') ? 'selected' : '' ?>>Harga Beli</option>
					</select>		
				</td>
				<td style="text-align:right">&nbsp;</td>
			</tr>
			<tr>
				<td>DEPARTEMEN</td>
				<td align="left"> 
					<select name="departementId" style="width:245px" >
						<option value="x">SEMUA</option>
						<?php while($val = mysqli_fetch_array($dataDepartement)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['departementId']) ? $_REQUEST['departementId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select>		
				</td>
				<td style="text-align:right">&nbsp;</td>
			</tr>
			<tr>
				<td valign="top">KONDISI</td>
				<td>
					<select name="condition[]" style="width:245px; height:70px" multiple>
						<option value="'0'" <?php echo in_array("'0'",$_REQUEST['condition']) ? 'selected' : '' ?>>RUSAK</option>
						<option value="'1'" <?php echo in_array("'1'",$_REQUEST['condition']) ? 'selected' : '' ?>>BAIK</option>
						<option value="'2'" <?php echo in_array("'2'",$_REQUEST['condition']) ? 'selected' : '' ?>>SETENGAH BAIK</option>
					</select>
				</td>
			</tr>
			<tr>
				<td valign="top">KATEGORI ASSET</td>
				<td align="top">
					<select name="categoryAssetId[]" style="width:245px; height:200px" multiple>										
						<?php while($val = mysqli_fetch_array($dataCategoryAsset)): ?>
							<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryAssetId']) ? in_array($val['id'],$_REQUEST['categoryAssetId']) : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
						<?php endwhile; ?>
					</select><br />	
					<i><small><b>Yang Tidak di Sertakan</b></small></i>
				</td>
			</tr>		
			<tr>
				<td valign="top">Tanggal Beli di Mulai dari</td>
				<td>
					<input name="dateBuy" readonly id="dateBuy" type="text" value="<?php echo isset($_POST['dateBuy']) ? $_POST['dateBuy'] : '' ?>" />
					<input type="button" value="KOSONGKAN" onclick="document.getElementById('dateBuy').value=''" />
					<div style="color:red"><?php echo isset($msgError['dateBuy']) ? $msgError['dateBuy'] : '' ?></div>					
				
					<script type="text/javascript">
					$(document).ready(function() {
						$(function() {
								$( "#dateBuy" ).datepicker({
									dateFormat : 'dd/mm/yy',
									changeMonth : true,
									changeYear : true,
									yearRange: '-20y:+0y'
								}); 
								<?php $tmp = strlen(trim($_REQUEST['dateBuy'])) == 0 ?  '' : explode('/',$_REQUEST['dateBuy']) ?>
								$("#dateBuy" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
							});	
					});

					</script>					
				</td>
			</tr>			
			<tr>
				<td valign="top">&nbsp;</td>
				<td><input type="submit" value="FILTER" />
				</td>
			</tr>			
		</table>
	</form>
	<hr />
	<?php if(mysqli_num_rows($dataCategory) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
			<table width="100%" border="0">
				<tbody>
					<?php $i = 1; ?>
					<?php $assetGrandTotal = 0; ?>
					<?php $assetGrandNilai = 0; ?>
					
					<?php while($val = mysqli_fetch_array($dataCategory)): ?>					
						<?php include '../../lib/connection.php'; ?>
						<?php 	 
							$query = "select sum((select count(ase.id) 
											  from asset_series as ase 
											  where ase.asset_id = asset.id 
											  and ase.is_delete = '0' 
											  and ase.is_remove = '0'
											  $where
											  )) as jml
							from asset
							where asset.is_delete = '0'
								and asset.category_id = '{$val['id']}'
							group by asset.category_id";	

						
							$tmpCount = mysqli_query($con, $query) or die(mysqli_error($con));
							$dataCountCategoryAsset = mysqli_fetch_array($tmpCount);
						?>
						<?php if($dataCountCategoryAsset['jml'] > 0) : ?>
							<?php 	 
								/*
								$query = "select id,name,code,foto, foto_thumb, 
									(select count(id) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as jml,
									(select sum(price) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai,											
									(select sum(price_buy) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai_buy											
								from asset
								where is_delete = '0'
									and category_id = '{$val['id']}'
								order by name";	
								$dataAsset = mysqli_query($con, $query) or die(mysqli_error($con));
								*/
								//echo $dateBuy; 
								
								//inner join asset_history as ah on as.id = ah.asset_serries_id and ah.type = 0 and ah.date >= '$dateBuy'

								
								$query = "select a.id,name,code,foto, foto_thumb, 
									(   select count(ase.id) as jml 
										from asset_series as ase 									
										inner join asset_history as ah
										on ah.asset_series_id = ase.id
										  and ah.type = '0'
										  and ah.date >= '$dateBuy'
										where ase.asset_id = a.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as jml,
									(select sum(price) as jml 
									 from asset_series as ase 
										inner join asset_history as ah
										on ah.asset_series_id = ase.id
										  and ah.type = '0'
										  and ah.date >= '$dateBuy'									 
									 where ase.asset_id = a.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai,											
									(select sum(price_buy) as jml 
									 from asset_series as ase 
										inner join asset_history as ah
										on ah.asset_series_id = ase.id
										  and ah.type = '0'
										  and ah.date >= '$dateBuy'									 
									 where ase.asset_id = a.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai_buy											
								from asset as a
								where is_delete = '0'
									and category_id = '{$val['id']}'
								order by name";	
								$dataAsset = mysqli_query($con, $query) or die(mysqli_error($con));								
							?>
							<tr>
								<td width="2%" valign="top"><?php echo $i ?>. </td>
								<td valign="top"><b><?php echo $val['name'] ?></b><br />
									<p style="padding-left:15px">
										<?php $j = 1; ?>
										<?php if(mysqli_num_rows($dataAsset) > 0) : ?>
											<div id="tbl">
												<table width="100%" border="1">		
													<thead>
														<tr>
															<th width="30%" align="left">NAMA</th>	
															<th width="15%" align="center">KODE</th>
															<th width="15%" align="center">JUMLAH</th>	
															<th align="left">NILAI</th>												
														</tr>					
													<thead>		
													<?php $assetTotal = 0 ?>
													<?php $assetNilai = 0 ?>
													<?php while($valAsset = mysqli_fetch_array($dataAsset)): ?>
														<?php if($valAsset['jml'] > 0): ?>	
															<tr>
																<td align="left">
																<?php if(strlen($valAsset['foto_thumb']) > 0 ): ?>
																	<a href="../asset/foto/<?php echo $valAsset['foto'] ?>" class="lightbox" title="<?php echo $valAsset['name'] ?>">
																		<?php echo $i.'.'.$j ?> <?php echo $valAsset['name'] ?>
																	</a>	
																<?php else: ?>
																	<?php echo $i.'.'.$j ?> <?php echo $valAsset['name'] ?>	
																<?php endif; ?>														
																</td>	
																<td align="center"> <b><?php echo $valAsset['code'] ?></b></td>
																<td align="center">
																	<div class="button">
																		<a href="detail.php?dateBuy=<?php echo $dateBuy ?>&assetId=<?php echo $valAsset['id'] ?>&fundId=<?php echo $fundId ?>&departementId=<?php echo $departementId ?>&condition=<?php echo str_replace("'",'',implode(',',$_REQUEST['condition'])) ?>"  data-title="DETAIL" data-width="600" data-height="550"><?php echo $valAsset['jml'] ?></a>
																	</div>
																	<?php $assetTotal = $assetTotal + $valAsset['jml'] ?>
																</td>	
																<td align="center">
																	<?php if($referencePrice == 0): ?>
																		<?php echo number_format($valAsset['nilai'], 0 , '' , '.')  ?>															
																		<?php $assetNilai = $assetNilai + $valAsset['nilai'] ?>
																	<?php else : ?>
																		<?php echo number_format($valAsset['nilai_buy'], 0 , '' , '.')  ?>															
																		<?php $assetNilai = $assetNilai + $valAsset['nilai_buy'] ?>
																	<?php endif; ?>
																</td>												
															</tr>											 
															<?php $j++; ?>
														<?php endif; ?>	
													<?php endwhile; ?>	
													<thead>
														<tr>
															<th width="25%" align="left">&nbsp;</th>	
															<th width="15%" align="center">&nbsp;</th>
															<th width="15%" align="center"><?php echo $assetTotal ?></th>	
															<th align="left"><?php echo number_format($assetNilai, 0 , '' , '.')  ?></th>												
														</tr>					
													<thead>	
												</table>
												<?php $assetGrandTotal = $assetGrandTotal + $assetTotal ?>
												<?php $assetGrandNilai = $assetGrandNilai + $assetNilai ?>
											
												<?php $assetTotal = 0 ?>
												<?php $assetNilai = 0 ?>
											<?php else: ?>
												<div class="warning" style="padding:1px; margin:1px">
													<h6>TIDAK ADA ASSET</h6>
												</div>												
											<?php endif; ?>	
										</div>	
									</p>
								</td>							
							</tr>	
							<?php $i++; ?>

						<?php endif; ?>
						<?php include '../../lib/connection-close.php'; ?>

						<?php $assetGrandTotal = $assetGrandTotal + $assetTotal ?>
						<?php $assetGrandNilai = $assetGrandNilai + $assetNilai ?>
					<?php endwhile; ?>					
					<tr>
						<td></td>
						<td>
							<div id="tbl">
								<table width="100%" border="1">		
									<thead>
										<tr>
											<th width="45%" align="left" colspan="2">GRAND TOTAL</th>	
											<th width="15%" align="center"><?php echo $assetGrandTotal ?></th>	
											<th align="left"><?php echo number_format($assetGrandNilai, 0 , '' , '.') ?></th>											
										</tr>					
									<thead>					
								</table>
						</div>							
						</td>
					</tr>
				<tbody>
			</table>	
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>

	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateRepair" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-20y:+0y'
				}); 

				$("#dateRepair" ).datepicker("setDate",new Date());
			});	
	});

		$(function () {
			var iframe = $('<iframe frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
			var dialog = $("<div></div>").append(iframe).appendTo("body").dialog({
				autoOpen: false,
				modal: true,
				resizable: false,
				width: "auto",
				height: "auto",
				close: function () {
					iframe.attr("src", "");
				}
			});
			$(".button a").on("click", function (e) {
				e.preventDefault();
				var src = $(this).attr("href");
				var title = $(this).attr("data-title");
				var width = $(this).attr("data-width");
				var height = $(this).attr("data-height");
				iframe.attr({
					width: +width,
					height: +height,
					src: src
				});	
				dialog.dialog("option", "title", title).dialog("open");
			});
		});

	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
