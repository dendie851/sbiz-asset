<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'indexRead.php' ?>

<h1>LAPORAN LOKASI ASSET</h1>

<fieldset>
	<legend><b>INFORMASI</b></legend>
	<form action="index.php" method="post">
		<table width="100%">
			<tr>
				<td width="14%">LOKASI</td>
				<td>
					<b>: <?php echo $locationId == 'x' ? 'SEMUA' : $dataLocation[$locationId] ?></b>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
<p></p>
<?php if (mysql_num_rows($dataResult) < 1): ?>
	<div class="warning">
		<h3><?php echo message::getMsg('emptySuccess') ?></h3>
	</div>
<?php else: ?>
	<form action="editSave.php" method="post">
		<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword'] ?>" size="1" maxlength="4" />
		<div id="tbl">
			<table width="100%" border="1">
				<thead>
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="25%">LOKASI</th>
						<th align="center" width="13%">KODE ASSET</th>
						<th align="center" width="15%">NAMA ASSET</th>
						<th align="center" width="8%">JML</th>
						<th align="center">NO SERI ASSET</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1 : 1 ?>
					<?php $locationIdDump = '' ?>
					<?php include '../../lib/connection.php'; ?>
					<?php while ($val = mysqli_fetch_array($dataResult)): ?>
						<tr>
							<?php if ($val['location_id'] == $locationIdDump): ?>
								<td align="left" colspan="2">&nbsp;</td>
							<?php else: ?>
								<?php $locationIdDump = $val['location_id'] ?>
								<td align="center">
									<?php echo $i ?>
								</td>
								<td align="left">
									<?php echo $dataLocation[$val['location_id']] ?>
									<p>
										<small><?php echo $val['location_alias'] ?></small>
									<p>
								</td>
								<?php $i++; ?>
							<?php endif; ?>
							<td align="center" valign="top">
								<?php echo $val['code'] ?>
							</td>
							<td align="center" valign="top">
								<?php echo $val['asset_name'] ?><br />
								<small>(<?php echo $val['category_name'] ?>)</small>
							</td>
							<td align="center">
								<?php echo $val['jml'] ?>
							</td>
							<td align="left">
								<?php
								$query = "select no_serries, cond												  
											from asset_series as ase
											  where 1=1
												and ase.is_delete = '0'
												and ase.is_remove = '0'
												and asset_id = '{$val['asset_id']}'
												and location_id = '{$val['location_id']}'
											  order by no_serries";

								$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
								?>
								<small>
									<?php while ($valAssetSerires = mysqli_fetch_array($tmp)): ?>
										<?php echo $val['code'] ?>-<?php echo $valAssetSerires['no_serries'] ?>
										(<?php if ($valAssetSerires['cond'] == '0'): ?>R<?php endif; ?><?php if ($valAssetSerires['cond'] == '1'): ?>B<?php endif; ?><?php if ($valAssetSerires['cond'] == '2'): ?>SB<?php endif; ?>),
									<?php endwhile; ?>
								</small>
							</td>
						</tr>
					<?php endwhile; ?>
					<?php include '../../lib/connection-close.php'; ?>
				<tbody>
			</table>
		</div>
	</form>
<?php endif; ?>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>