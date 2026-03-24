<?php include 'detailRead.php' ?>

<?php ob_start(); ?>
<?php if(mysql_num_rows($data) < 1) : ?>
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
					<th align="center" width="35%">NOMOR SERI</th>	
					<th align="center" width="25%">HARGA</th>							
					<th align="center" >KONDISI</th>							
				</tr>	
			</thead>
			<tbody>
				<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
				<?php while($val = mysql_fetch_array($data)): ?>
					<tr>						
						<td align="center"><?php echo $i ?></td>							
						<td align="center" valign="top">
							<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>			
						</td>
						<td align="center" valign="top">
							<?php echo number_format($val['price'], 0 , '' , '.')  ?>										
						</td>
						<td align="center">
							<?php if($val['cond'] == '0'): ?>
								RUSAK
							<?php endif; ?>
							
							<?php if($val['cond'] == '1'): ?>
								BAIK
							<?php endif; ?>

							<?php if($val['cond'] == '2'): ?>
								SETENGAH BAIK
							<?php endif; ?>									
						</td>		
					</tr>	
				<?php $i++; ?>
				<?php endwhile; ?>
			<tbody>
		</table>
		<p style="text-align:center; padding:10px">
			<?php
				echo $split->splitPage($_GET['SplitLanjut'],array('assetId='.$_REQUEST['assetId'],'fundId='.$_REQUEST['fundId'],'locationId='.$_REQUEST['locationId']));
				echo '<br /><br />';
				echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
			?>
		</p>	
	</div>			
<?php endif; ?>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popupModal.php' ?>	
