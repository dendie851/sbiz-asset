<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1>LAPORAN KONDISI ASSET</h1>
	<hr />
	
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	<?php if(mysqli_num_rows($dataCategory) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
			<table width="100%">
				<tr>
					<td style="text-align:right">
						<input type="button" onclick="window.open('excel.php')" value="PRINT TO EXCEL">
						<input type="button" onclick="window.open('print.php')" value="PRINT">
					</td>
				</tr>
			</table>	
	
			<table width="100%" border="0">
				<tbody>
					<?php $i = 1; ?>
					<?php $assetGrandTotal = 0; ?>
					<?php $assetGrandNilai = 0; ?>
					
					<?php while($val = mysqli_fetch_array($dataCategory)): ?>					
						<tr>
							<td width="2%" valign="top"><?php echo $i ?>. </td>
							<td valign="top"><b><?php echo $val['name'] ?></b><br />
								<p style="padding-left:15px">
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select a.id,a.name,a.code,a.foto, a.foto_thumb
										from asset as a
										inner join asset_series as ase
										  on ase.asset_id = a.id
										    and ase.departement_id in ($loginAccessDepartement)
										    and ase.fund_id in ($loginAccessFund)		   	
										where a.is_delete = '0'
											and a.category_id = '{$val['id']}'
										group by a.id		
										order by a.name";	
										$dataAsset = mysqli_query($con, $query) or die(mysqli_error($con));
									?>
									<?php $j = 1; ?>
									<?php if(mysqli_num_rows($dataAsset) > 0) : ?>
										<div id="tbl">
											<table width="100%" border="1">		
												<thead>
													<tr>
														<th width="30%" align="left">NAMA</th>	
														<th width="20%" align="center">KODE</th>
														<th width="15%" align="left">BAIK</th>												
														<th width="20%" align="left">SETENGAH BAIK</th>												
														<th align="left">RUSAK</th>												
													</tr>					
												<thead>		
												<?php $assetTotal = 0 ?>
												<?php $assetNilai = 0 ?>
												<?php while($valAsset = mysqli_fetch_array($dataAsset)): ?>
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
															<?php 	 
																$query = "select count(id) as jumlah
																from asset_series as ase
																where ase.is_delete = '0'
																  and ase.is_remove = '0'
																  and cond = '1'	
																  and ase.asset_id = '{$valAsset['id']}'
																  and ase.departement_id in ($loginAccessDepartement)
																  and ase.fund_id in ($loginAccessFund)";	
																$tmpJml = mysqli_query($con, $query) or die(mysqli_error($con));
																$dataJml = mysqli_fetch_array($tmpJml);																		
															?>

															<?php if($dataJml['jumlah'] > 0): ?>
																<div class="button">
																	<a href="detail.php?assetId=<?php echo $valAsset['id'] ?>&condId=1"  data-title="DETAIL" data-width="600" data-height="550"><?php echo $dataJml['jumlah'] ?></a>
																</div>
															<?php else: ?>
																<?php echo $dataJml['jumlah'] ?>
															<?php endif; ?>															
														</td>	
														<td align="center">
															<?php 	 
																$query = "select count(id) as jumlah
																from asset_series as ase
																where ase.is_delete = '0'
																  and ase.is_remove = '0'
																  and cond = '2'	
																  and ase.asset_id = '{$valAsset['id']}'
																  and ase.departement_id in ($loginAccessDepartement)
																  and ase.fund_id in ($loginAccessFund)";	
																$tmpJml = mysqli_query($con, $query) or die(mysqli_error($con));
																$dataJml = mysqli_fetch_array($tmpJml);																		
															?>

															<?php if($dataJml['jumlah'] > 0): ?>
																<div class="button">
																	<a href="detail.php?assetId=<?php echo $valAsset['id'] ?>&condId=2"  data-title="DETAIL" data-width="600" data-height="550"><?php echo $dataJml['jumlah'] ?></a>
																</div>
															<?php else: ?>
																<?php echo $dataJml['jumlah'] ?>
															<?php endif; ?>															
														</td>
														<td align="center">
															<?php 	 
																$query = "select count(id) as jumlah
																from asset_series as ase
																where ase.is_delete = '0'
																  and ase.is_remove = '0'
																  and cond = '0'	
																  and ase.asset_id = '{$valAsset['id']}'
																  and ase.departement_id in ($loginAccessDepartement)
																  and ase.fund_id in ($loginAccessFund)";	
																$tmpJml = mysqli_query($con, $query) or die(mysqli_error($con));
																$dataJml = mysqli_fetch_array($tmpJml);																		
															?>

															<?php if($dataJml['jumlah'] > 0): ?>
																<div class="button">
																	<a href="detail.php?assetId=<?php echo $valAsset['id'] ?>&condId=0"  data-title="DETAIL" data-width="600" data-height="550"><?php echo $dataJml['jumlah'] ?></a>
																</div>
															<?php else: ?>
																<?php echo $dataJml['jumlah'] ?>
														</td>												
															<?php endif; ?>															
													</tr>											 
													<?php $j++; ?>
												<?php endwhile; ?>	
											</table>
										<?php else: ?>
											<div class="warning" style="padding:1px; margin:1px">
												<h6>TIDAK ADA ASSET</h6>
											</div>												
										<?php endif; ?>												
									</div>	
									<?php include '../../lib/connection-close.php'; ?>
								</p>
							</td>							
						</tr>	
						<?php $i++; ?>
					<?php endwhile; ?>					
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
