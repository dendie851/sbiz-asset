<?php ob_start(); ?>
	<?php include 'historyRead.php' ?>

	<fieldset>
		<legend><b>INFORMASI</b></legend>
		<table width="100%">
			<tr>
				<td width="35%">NOMOR SERI ASSET</td>
				<td>: <b><?php echo $assetSeriNomor ?></b></td>			
			</tr>
			<tr>
				<td>NAMA ASSET</td>
				<td>: <b><?php echo $dataAsset['name'] ?> <small>(<?php echo $dataAsset['category_name'] ?>)</small></b></td>
			</tr>		
		</table>
	</fieldset>
	<p></p>
	<?php if(mysql_num_rows($data) < 1) : ?>
		<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<form action="editSave.php" method="post">
			<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword']?>" size="1" maxlength="4" />
			<input name="assetId" type="hidden" value="<?php echo $_REQUEST['id']?>" size="1" maxlength="4" />
		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>							
						<th align="center" width="5%">NO</th>						
						<th align="center" width="20%">TANGGAL</th>												
						<th align="center" >LOKASI / KETERANGAN</th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>							
							<td align="center"><?php echo $i ?></td>							
							<td align="center"><?php echo $val['date'] ?></td>
							<td align="left"><?php echo $val['decription'] ?></td>						
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
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
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popupModal.php' ?>	
