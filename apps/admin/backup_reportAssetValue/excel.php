<?php ob_start(); ?>
<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=LAPORAN-ASSET.xls");
?>

<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'indexRead.php' ?>

<h1>LAPORAN NILAI & JUMLAH ASSET</h1>
<hr />

<?php if (isset($_GET['msg'])): ?>
	<div class="info">
		<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
	</div>
<?php endif ?>
<form action="index.php" method="post">
	<table width="100%">
		<tr>
			<td align="left" width="20%"> SUMBER DANA </td>
			<td><b>: <?php echo $fundId == 'x' ? 'SEMUA' : $printDataFund['name'] ?></b></td>
		</tr>
		<tr>
			<td align="left" width=""> REFERENSI HARGA </td>
			<td><b>:
					<?php echo $fundId == 'x' ? 'SEMUA' : ($_REQUEST['referencePrice'] == '0' ? 'Harga Sekarang' : ' Beli') ?>
				</b></td>
		</tr>
		<tr>
			<td align="left" width=""> DEPARTEMEN </td>
			<td><b>: <?php echo $departementId == 'x' ? 'SEMUA' : $printDataDepartement['name'] ?></b></td>
		</tr>
		<tr>
			<td align="left" width=""> KONDISI </td>
			<td>
				<b>:
					<?php echo substr_count($condition, '0') > 0 ? 'Rusak, ' : '' ?>
					<?php echo substr_count($condition, '1') > 0 ? 'Baik,' : '' ?>
					<?php echo substr_count($condition, '2') > 0 ? 'Setengah Baik' : '' ?>
				</b>
			</td>
		</tr>
		<tr>
			<td valign="top">KATEGORI ASSET</td>
			<td align="top"><b>:
					<?php
					if ($dataCategoryInfo) {
						while ($row = mysql_fetch_array($dataCategoryInfo)) {
							echo $row['name'] . ',';
						}
					} else {
						echo "SEMUA";
					}
					?></b>
			</td>
		</tr>
		<tr>
			<td valign="top">TGL BELI MULAI DARI</td>
			<td>: <b><?php echo $_REQUEST['dateBuy'] ?></b></td>
		</tr>
	</table>
</form>
<hr />
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
			<?php include '../../lib/connection.php'; ?>
			<?php while ($val = mysql_fetch_array($dataCategory)): ?>
				<?php
				$query = "select sum((select count(ase.id) 
											  from asset_series as ase 
											  where ase.asset_id = asset.id 
											  and ase.is_delete = '0' 
											  and ase.is_remove = '0'
											  $where
											  )) as jml
							from asset
							where asset.is_delete = '0'
								and asset.category_id = '{$val['id']}'
							group by asset.category_id";


				$tmpCount = mysql_query($query) or die(mysql_error());
				$dataCountCategoryAsset = mysql_fetch_array($tmpCount);
				?>
				<?php if ($dataCountCategoryAsset['jml'] > 0): ?>
					<?php
					/*
					$query = "select id,name,code,foto, foto_thumb, 
						(select count(id) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as jml,
						(select sum(price) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai,											
						(select sum(price_buy) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai_buy											
					from asset
					where is_delete = '0'
						and category_id = '{$val['id']}'
					order by name";	
					$dataAsset = mysql_query($query) or die (mysql_error());
					*/

					$query = "select a.id,name,code,foto, foto_thumb, 
									(   select count(ase.id) as jml 
										from asset_series as ase 									
										inner join asset_history as ah
										on ah.asset_series_id = ase.id
										  and ah.type = '0'
										  and ah.date >= '$dateBuy'
										where ase.asset_id = a.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as jml,
									(select sum(price) as jml 
									 from asset_series as ase 
										inner join asset_history as ah
										on ah.asset_series_id = ase.id
										  and ah.type = '0'
										  and ah.date >= '$dateBuy'									 
									 where ase.asset_id = a.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai,											
									(select sum(price_buy) as jml 
									 from asset_series as ase 
										inner join asset_history as ah
										on ah.asset_series_id = ase.id
										  and ah.type = '0'
										  and ah.date >= '$dateBuy'									 
									 where ase.asset_id = a.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as nilai_buy											
								from asset as a
								where is_delete = '0'
									and category_id = '{$val['id']}'
								order by name";
					$dataAsset = mysql_query($query) or die(mysql_error());
					?>
					<tr>
						<td width="2%" valign="top"><?php echo $i ?>. </td>
						<td valign="top"><b><?php echo $val['name'] ?></b><br />
							<p style="padding-left:15px">
								<?php $j = 1; ?>
								<?php if (mysql_num_rows($dataAsset) > 0): ?>
								<div id="tbl">
									<table width="100%" border="1">
										<thead>
											<tr>
												<th width="30%" align="left">NAMA</th>
												<th width="15%" align="center">KODE</th>
												<th width="15%" align="center">JUMLAH</th>
												<th align="left">NILAI</th>
											</tr>
											<thead>
												<?php $assetTotal = 0 ?>
												<?php $assetNilai = 0 ?>
												<?php while ($valAsset = mysql_fetch_array($dataAsset)): ?>
													<?php if ($valAsset['jml'] > 0): ?>
														<tr>
															<td align="left">
																<?php if (strlen($valAsset['foto_thumb']) > 0): ?>
																	<?php echo $i . '.' . $j ?> 							<?php echo $valAsset['name'] ?>
																<?php else: ?>
																	<?php echo $i . '.' . $j ?> 							<?php echo $valAsset['name'] ?>
																<?php endif; ?>
															</td>
															<td align="center"> <b>'<?php echo $valAsset['code'] ?>'</b></td>
															<td align="center">
																<?php echo $valAsset['jml'] ?>
																<?php $assetTotal = $assetTotal + $valAsset['jml'] ?>
															</td>
															<td align="center">
																<?php if ($referencePrice == 0): ?>
																	<?php echo number_format($valAsset['nilai'], 0, '', '.') . ',-' ?>
																	<?php $assetNilai = $assetNilai + $valAsset['nilai'] ?>
																<?php else: ?>
																	<?php echo number_format($valAsset['nilai_buy'], 0, '', '.') . ',-' ?>
																	<?php $assetNilai = $assetNilai + $valAsset['nilai_buy'] ?>
																<?php endif; ?>
															</td>
														</tr>
														<?php $j++; ?>
													<?php endif; ?>
												<?php endwhile; ?>
												<thead>
													<tr>
														<th width="25%" align="left">&nbsp;</th>
														<th width="15%" align="center">&nbsp;</th>
														<th width="15%" align="center"><?php echo $assetTotal ?></th>
														<th align="center"><?php echo number_format($assetNilai, 0, '', '.') . ',-' ?>
														</th>
													</tr>
													<thead>
									</table>
									<?php $assetGrandTotal = $assetGrandTotal + $assetTotal ?>
									<?php $assetGrandNilai = $assetGrandNilai + $assetNilai ?>

									<?php $assetTotal = 0 ?>
									<?php $assetNilai = 0 ?>
								<?php else: ?>
									<div class="warning" style="padding:1px; margin:1px">
										<h6>TIDAK ADA ASSET</h6>
									</div>
								<?php endif; ?>
							</div>
							</p>
						</td>
					</tr>
					<?php $i++; ?>

				<?php endif; ?>

				<?php $assetGrandTotal = $assetGrandTotal + $assetTotal ?>
				<?php $assetGrandNilai = $assetGrandNilai + $assetNilai ?>
			<?php endwhile; ?>
			<?php include '../../lib/connection-close.php'; ?>

			<tr>
				<td></td>
				<td>
					<div id="tbl">
						<table width="100%" border="1">
							<thead>
								<tr>
									<th width="45%" align="left" colspan="2">GRAND TOTAL</th>
									<th width="15%" align="center"><?php echo $assetGrandTotal ?></th>
									<th align="center"><?php echo number_format($assetGrandNilai, 0, '', '.') . ',-' ?></th>
								</tr>
								<thead>
						</table>
					</div>
				</td>
			</tr>
		<tbody>
	</table>
<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>