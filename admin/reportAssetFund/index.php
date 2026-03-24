<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1>LAPORAN SUMBER DANA ASSET</h1>
	
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<?php if(strlen($msgError['id']) > 0) : ?>
	 	<div class="error">
			<h3><?php echo $msgError['id'] ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post">
			<table width="100%">		
				<tr>
					<td width="14%">LOKASI</td>
					<td>
						<select name="locationId" style="width:245px">
							<option value="x">SEMUA</option>
							<?php foreach($dataLocationCmb as $val): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['locationId']) ? $_REQUEST['locationId'] : $data['locationId']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td width="14%">SUMBER DANA</td>
					<td>
						<select name="fundId" style="width:245px">
							<option value="x">SEMUA</option>
							<?php while($val = mysql_fetch_array($dataFund)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['fundId']) ? $_REQUEST['fundId'] : $data['fundId']) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</td>
				</tr>		
				<tr>
					<td></td>
					<td>
						<input type="submit" value="FILTER" name="filter" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p></p>
	<?php if(isset($_REQUEST['filter'])): ?>
		<?php if(mysql_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<table width="100%">
				<tr>
					<td style="text-align:right">
						<input type="button" onclick="window.open('excel.php?locationId=<?php echo $_REQUEST['locationId'] ?>&fundId=<?php echo $_REQUEST['fundId'] ?>')" value="PRINT TO EXCEL">
						<input type="button" onclick="window.open('print.php?locationId=<?php echo $_REQUEST['locationId'] ?>&fundId=<?php echo $_REQUEST['fundId'] ?>')" value="PRINT">
					</td>
				</tr>
			</table>		
			<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword']?>" size="1" maxlength="4" />
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>					
							<th align="center" width="5%">NO</th>	
							<th align="center" width="25%">LOKASI</th>							
							<th align="center" width="13%">KODE ASSET</th>							
							<th align="center" width="15%">NAMA ASSET</th>
							<th align="center">
								
							</th>							
						</tr>	
					</thead>
					<tbody>
						<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
						<?php $locationIdDump = '' ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>	
								<?php if($val['location_id'] == $locationIdDump): ?>
									<td align="left" colspan="2">&nbsp;</td>
								<?php else: ?>
									<?php $locationIdDump =  $val['location_id'] ?>
									<td align="center">
										<?php echo $i ?>
									</td>									
									<td align="left">
										<?php echo $dataLocation[$val['location_id']] ?>
									</td>	
									<?php $i++; ?>
								<?php endif; ?>
								<td align="center" valign="top">
									<?php if(strlen($val['foto']) > 0 ): ?>
										<a href="../asset/foto/<?php echo $val['foto'] ?>" class="lightbox" title="<?php echo $val['code'] ?>">
											<?php echo $val['code'] ?>	
										</a>	
									<?php else: ?>
										<?php echo $val['code'] ?>			
									<?php endif; ?>
								</td>
								<td align="center"  valign="top">		
									<?php echo $val['asset_name'] ?><br />
									<small>(<?php echo $val['category_name'] ?>)</small>
								</td>								
								<td align="center">									
									<?php include '../../lib/connection.php'; ?> 
										<?php
											$where = '';														
											if($fundId != 'x'){
											  $where = " and id = '$fundId'";
											} else {
											  $where = " and id in ($loginAccessFund) ";
											} 										
										?>
									
										<?php
											$query = "select id, name												  
												from fund
												 where is_delete = '0' 
												   $where
												 order by name";													  
											$tmpFund = mysql_query($query) or die (mysql_error());										
										?>											
									<?php include '../../lib/connection-close.php'; ?>
									<small>
									<table width="100%">
										<thead>
											<tr>
												<th width="45%">SUMBER DANA</th>
												<th width="20%" >JUMLAH</th>
												<th>NILAI</th>
											</tr>	
										</thead>	
										<?php while($valFund = mysql_fetch_array($tmpFund)): ?>
											<tr>
												<td width="40%"><?php echo $valFund['name'] ?></td>
												<td align="center">													
													<?php include '../../lib/connection.php'; ?> 
													<?php
														$query = "select count(id) as jumlah												  
															from asset_series as ase
															  where 1=1
																and ase.is_delete = '0'
																and ase.is_remove = '0'
																and asset_id = '{$val['asset_id']}'
																and location_id = '{$val['location_id']}'
																and fund_id = '{$valFund['id']}'
															    and departement_id in ($loginAccessDepartement)";	
															  
														$tmpFundJml = mysql_query($query) or die (mysql_error());	
														$resultFundJml = mysql_fetch_array($tmpFundJml);
													?>
													<?php if($resultFundJml['jumlah'] > 0): ?>	
														<div class="button">						
															<a href="detail.php?assetId=<?php echo $val['asset_id'] ?>&fundId=<?php echo $valFund['id'] ?>&locationId=<?php echo $val['location_id'] ?>" data-title="DETAIL" data-width="600" data-height="550"><?php echo $resultFundJml['jumlah'] ?></a>						
														</div>
													<?php else: ?>
														<?php echo $resultFundJml['jumlah'] ?>	
													<?php endif; ?>
													<?php include '../../lib/connection-close.php'; ?>												
												</td>
												<td align="right">													
													<?php include '../../lib/connection.php'; ?> 
													<?php
														$query = "select sum(price) as jumlah												  
															from asset_series as ase
															  where 1=1
																and ase.is_delete = '0'
																and ase.is_remove = '0'
																and asset_id = '{$val['asset_id']}'
																and location_id = '{$val['location_id']}'
																and fund_id = '{$valFund['id']}'
																and departement_id in ($loginAccessDepartement)";	
															  
														$tmpFundNilai = mysql_query($query) or die (mysql_error());	
														$resultFundNilai = mysql_fetch_array($tmpFundNilai);
													?>							
													<?php echo number_format($resultFundNilai['jumlah'], 0 , '' , '.')  ?>														
													<?php include '../../lib/connection-close.php'; ?>												
												</td>												
											</tr>
										<?php endwhile; ?>
									</table>
									</small>
								</td>		
							</tr>	
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>					
		<?php endif; ?>
	<?php else: ?>
		<div class="info">
			<h3>Silakan memilih lokasi terlebih dahulu</h3>
		</div>		
	<?php endif; ?>		

	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateMove" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-20y:+0y'
				}); 

				$("#dateMove" ).datepicker("setDate",new Date());
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

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
