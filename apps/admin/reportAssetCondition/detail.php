<?php ob_start(); ?>
	<?php include 'detailRead.php' ?>
	<?php if(mysqli_num_rows($data) < 1) : ?>
		<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="editSave.php" method="post">
			<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword']?>" size="1" maxlength="4" />
		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>					
						<th align="center" width="5%">NO</th>	
						<th align="center" width="45%">LOKASI</th>							
						<th align="center" width="8%">JML</th>
						<th align="center" >NO SERI ASSET</th>							
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
												and cond = '$condId'
											  order by no_serries";	
											  
										$tmp = mysqli_query($con, $query) or die(mysqli_error($con));										
									?>											
								<?php include '../../lib/connection-close.php'; ?>
								<small>
								<?php while($valAssetSerires = mysqli_fetch_array($tmp)): ?>
									<?php echo $val['code'] ?>-<?php echo $valAssetSerires['no_serries'] ?> 
									(<?php if($valAssetSerires['cond'] == '0'): ?>R<?php endif; ?><?php if($valAssetSerires['cond'] == '1'): ?>B<?php endif; ?><?php if($valAssetSerires['cond'] == '2'): ?>SB<?php endif; ?>),
								<?php endwhile; ?>
								</small>
							</td>		
						</tr>	
					<?php endwhile; ?>
				<tbody>
			</table>
		</div>				
		</form>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popupModal.php' ?>	
