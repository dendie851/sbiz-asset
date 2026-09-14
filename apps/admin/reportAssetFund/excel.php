<?php ob_start(); ?>
	<?php
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=LAPORAN-SUMBER-DANA=ASSET.xls");
	?>
	<?php include 'indexRead.php' ?>

	<h1>LAPORAN SUMBER DANA ASSET</h1>
	
	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<form action="index.php" method="post">
			<table width="100%">		
				<tr>
					<td width="17%">LOKASI</td>
					<td><b><?php echo $locationId != 'x' ? $printDataLocation['name'] : 'SEMUA' ?></b>
					</td>
				</tr>
				<tr>
					<td width="14%">SUMBER DANA</td>
					<td><b><?php echo $fundId != 'x' ? $printDataFund['name'] : 'SEMUA' ?></b></td>
				</tr>		
			</table>
		</form>
	</fieldset>
	<p></p>
	<?php if(mysqli_num_rows($data) < 1) : ?>
		<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>					
						<th align="center" width="5%">NO</th>	
						<th align="center" width="25%">LOKASI</th>							
						<th align="center" width="13%">KODE ASSET</th>							
						<th align="center" width="15%">NAMA ASSET</th>
						<th align="center">&nbsp;</th>							
					</tr>	
				</thead>
				<tbody>
				<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
				<?php $locationIdDump = '' ?>
				<?php while($val = mysqli_fetch_array($data)): ?>
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
							<?php echo $val['code'] ?>			
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
									$tmpFund = mysqli_query($con, $query) or die(mysqli_error($con));										
								?>											
							<?php include '../../lib/connection-close.php'; ?>
							<small>
							<table width="100%" border="1">
								<thead>
									<tr>
										<th width="45%">SUMBER DANA</th>
										<th width="20%" >JUMLAH</th>
										<th>NILAI</th>
									</tr>	
								</thead>	
								<?php while($valFund = mysqli_fetch_array($tmpFund)): ?>
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
														and departement_id in ($loginAccessDepartement)
														and fund_id = '{$valFund['id']}'";	
													  
												$tmpFundJml = mysqli_query($con, $query) or die(mysqli_error($con));	
												$resultFundJml = mysqli_fetch_array($tmpFundJml);
											?>
											<?php echo $resultFundJml['jumlah'] ?>	
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
														and departement_id in ($loginAccessDepartement)
														and fund_id = '{$valFund['id']}'";	
													  
												$tmpFundNilai = mysqli_query($con, $query) or die(mysqli_error($con));	
												$resultFundNilai = mysqli_fetch_array($tmpFundNilai);
											?>	
											<?php echo number_format($resultFundNilai['jumlah'], 0 , '' , '.'),',-'  ?>														
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
		
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
