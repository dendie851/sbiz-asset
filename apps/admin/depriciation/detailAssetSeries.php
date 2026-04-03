<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'detailAssetSeriesRead.php' ?>

<?php if (mysql_num_rows($data) < 1): ?>
	<div class="warning">
		<h3>
			<?php echo message::getMsg('emptySuccess') ?>
		</h3>
	</div>
<?php else: ?>
	<div id="tbl">
		<table width="100%" border="0">
			<tbody>
				<?php $i = 1; ?>
				<?php $assetGrandNilai = 0; ?>
				<tr>
					<th width="5%">NO</th>
					<th width="15%"><small>NO SERI ASSET</small></th>
					<th width="15%"><small>HARGA BELI</small></th>
					<th width="15%"><small>HARGA SEKARANG</small></th>
					<th width="15%"><small>HARGA MINIMUM</small></th>
					<th width="20%"><small>PENYUSUTAN PERTAHUN</small></th>
					<th width=""><small>PENYUSUTAN PERBULAN</small></th>
				</tr>
				<?php while ($row = mysqli_fetch_array($data)): ?>
					<tr>
						<td align="center">
							<?php echo $i ?>
						</td>
						<td align="center">
							<?php echo $row['asset_code'] . '-' . $row['no_serries'] ?>
						</td>
						<td align="center">
							<?php echo number_format($row['price_buy'], 0, '', '.') ?>
						</td>
						<td align="center">
							<?php echo number_format($row['price'], 0, '', '.') ?>
						</td>
						<td align="center">
							<?php echo number_format($row['price_min'], 0, '', '.') ?>
						</td>
						<td align="center">
							<?php echo number_format($row['depriciation'], 0, '', '.') ?>
						</td>
						<td align="center">
							<?php echo number_format($row['depriciation'] / 12, 0, '', '.') ?>/bulan
						</td>
					</tr>
					<?php $i++ ?>
				<?php endwhile; ?>
			<tbody>
		</table>
	</div>
<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/popupModal.php' ?>