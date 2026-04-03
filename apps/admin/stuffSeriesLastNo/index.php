<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'indexRead.php' ?>

<h1>INFORMASI NOMOR SERI</h1>


<?php if (mysql_num_rows($dataCategory) < 1): ?>
	<div class="warning">
		<h3><?php echo message::getMsg('emptySuccess') ?></h3>
	</div>
<?php else: ?>
	<table width="100%" border="0">
		<tbody>
			<?php $i = 1; ?>
			<?php $assetGrandTotal = 0; ?>
			<?php $assetGrandNilai = 0; ?>

			<?php while ($val = mysqli_fetch_array($dataCategory)): ?>
				<tr>
					<td width="2%" valign="top"><?php echo $i ?>. </td>
					<td valign="top"><b><?php echo $val['name'] ?></b><br />
						<p style="padding-left:15px">
							<?php include '../../lib/connection.php'; ?>
							<?php
							$query = "select id,name,code,foto, foto_thumb, 
											(select count(id) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as jml,
											(select sum(price) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai											
										from asset
										where is_delete = '0'
											and category_id = '{$val['id']}'
										order by name";
							$dataAsset = mysqli_query($con, $query) or die(mysqli_error($con));
							?>
							<?php $j = 1; ?>
							<?php if (mysql_num_rows($dataAsset) > 0): ?>
							<div id="tbl">
								<table width="100%" border="1">
									<thead>
										<tr>
											<th width="30%" align="left">NAMA</th>
											<th width="20%" align="left">KODE</th>
											<th width="" align="center">NOMOR SERI TERAKHIR</th>
										</tr>
										<thead>
											<?php $assetTotal = 0 ?>
											<?php $assetNilai = 0 ?>
											<?php while ($valAsset = mysqli_fetch_array($dataAsset)): ?>
												<tr>
													<td align="left">
														<?php if (strlen($valAsset['foto_thumb']) > 0): ?>
															<a href="../asset/foto/<?php echo $valAsset['foto'] ?>" class="lightbox"
																title="<?php echo $valAsset['name'] ?>">
																<?php echo $i . '.' . $j ?> 					<?php echo $valAsset['name'] ?>
															</a>
														<?php else: ?>
															<?php echo $i . '.' . $j ?> 					<?php echo $valAsset['name'] ?>
														<?php endif; ?>
													</td>
													<td align="center"><b><?php echo $valAsset['code'] ?></b></td>
													<td align="center">
														<?php
														$query = "select max(no_serries) as no_serries
																from asset_series
																where is_delete = '0'
																	and asset_id = '{$valAsset['id']}'
																limit 0,1 ";
														$tmpAssetSerries = mysqli_query($con, $query) or die(mysqli_error($con));
														$dataAssetSerries = mysqli_fetch_array($tmpAssetSerries);
														?>
														<b><?php echo $valAsset['code'] . '-' . $dataAssetSerries['no_serries'] ?></b>
													</td>
												</tr>
												<?php $j++; ?>
											<?php endwhile; ?>
								</table>
							<?php endif; ?>
						</div>
						<?php include '../../lib/connection-close.php'; ?>
						</p>
					</td>
				</tr>
				<?php $i++; ?>

			<?php endwhile; ?>
		<tbody>
	</table>
<?php endif; ?>

<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

<script type="text/javascript">
	$(function () {
		$('a.lightbox').lightBox();
	});
</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>