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

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>
	
	<?php if(mysqli_num_rows($data) < 1) : ?>
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
						<th align="center" width="50%">LOKASI / KETERANGAN</th>
						<?php if(in_array($_SESSION['positionId'],array(1,2))): ?>
							<th align="center" ></th>
						<?php endif; ?>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysqli_fetch_array($data)): ?>
						<tr>							
							<td align="center"><?php echo $i ?></td>							
							<td align="center"><?php echo $val['date'] ?></td>
							<td align="center"><?php echo $val['decription'] ?></td>	
							<?php if(in_array($_SESSION['positionId'],array(1,2))): ?>
								<td align="center"><input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?assetId=<?php echo $id ?>&id=<?php echo $val['id'] ?>' : false" /></td>								
							<?php endif; ?>
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
