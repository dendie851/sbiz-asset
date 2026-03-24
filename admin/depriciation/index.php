<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1>PENYUSUTAN ASSET</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
			<h5>Jumlah data yang terkena pembatalan penyusutan <?php echo $_GET['jumlahData'] ?> data</h5>
		</div>		
	<?php endif ?>

	<?php if($_SESSION['positionId'] != '3'): ?>	
		<p><input type="button" value="LAKUKAN PENYUSUTAN ASSET" onclick="window.location='add.php'" /></p>
	<?php endif; ?>	

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="15%">TAHUN</th>						
						<th align="center" width="40%">KETERANGAN</th>
						<th align="center" width="20%"><small>EKSEKUSI PENYUSUTAN</small></th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center"><?php echo $val['year'] ?></td>
							<td align="center"><?php echo $val['description'] ?></td>
							<td align="center"><?php echo $val['date_name'] ?></td>
							<td align="center">
								<a href="detail.php?id=<?php echo $val['id'] ?>">DETAIL</a>
								<?php if($_SESSION['positionId'] != '3'): ?>
									<input type="button" value="BATALKAN" onclick="confirm('Anda yakin akan membatalkan ?') ? window.location='cancel.php?id=<?php echo $val['id'] ?>' : false" />
								<?php endif; ?>
							</td>
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
		</div>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
