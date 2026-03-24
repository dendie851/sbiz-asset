<?php ob_start(); ?>	
	<?php
		header("Cache-Control: no-cache, no-store, must-revalidate");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=KARTU-ASSET.xls");
	?>
	<?php include 'printCardRead.php' ?>
	
	<center>
		<h1><big>KARTU ASSET / INVENTORI</big></h1>
		<h2>
			<?php echo $infoLocation['name'] ?><br />
			<small><?php echo $dataLocation[$infoLocation['id']]?></small><br />
			<?php echo $infoLocation['alias'] ?>
		</h2>	
	</center>
		
	<?php if(mysql_num_rows($data) < 1) : ?>
		<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<fieldset >
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>					
							<th align="center" width="5%">NO</th>						
							<th align="center" width="15%">KODE ASSET</th>							
							<th align="center" width="20%">NAMA ASSET</th>
							<th align="center" width="8%">JML</th>
							<th align="center" >NO SERI ASSET</th>							
						</tr>	
					</thead>
					<tbody>
						<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
						<?php $locationIdDump = '' ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>	
								<td align="center" valign="top">
									<?php echo $i ?>
								</td>		
								<td align="center" valign="top">			
									'<?php echo $val['code'] ?>'			
								</td>
								<td align="center"  valign="top">		
									<?php echo $val['asset_name'] ?><br />
									<small>(<?php echo $val['category_name'] ?>)</small>
								</td>								
								<td align="center">
									<?php echo $val['jml'] ?>
								</td>									
								<td align="left">
									<?php include '../../lib/connection.php'; ?> 
										<?php
											$query = "select no_serries, cond												  
												from asset_series as ase
												  where 1=1
													and ase.is_delete = '0'
													and ase.is_remove = '0'
													and asset_id = '{$val['asset_id']}'
													and location_id = '{$val['location_id']}'
													and ase.departement_id in ($loginAccessDepartement)
													and ase.fund_id in ($loginAccessFund)		   	
												  order by no_serries";	
												  
											$tmp = mysql_query($query) or die (mysql_error());										
										?>											
									<?php include '../../lib/connection-close.php'; ?>
									<small>
									<?php while($valAssetSerires = mysql_fetch_array($tmp)): ?>
										<?php echo $val['code'] ?>-<?php echo $valAssetSerires['no_serries'] ?> 
										(<?php if($valAssetSerires['cond'] == '0'): ?>R<?php endif; ?><?php if($valAssetSerires['cond'] == '1'): ?>B<?php endif; ?><?php if($valAssetSerires['cond'] == '2'): ?>SB<?php endif; ?>),
									<?php endwhile; ?>
									</small>
								</td>		
							</tr>	
							<?php $i++ ?>	
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>	
		</fieldset>	
	<?php endif; ?>
	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
