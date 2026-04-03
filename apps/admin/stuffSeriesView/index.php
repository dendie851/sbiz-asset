<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'indexRead.php' ?>

<h1>ASSET SERI</h1>

<?php if (isset($_GET['msg'])): ?>
	<div class="info">
		<h3>
			<?php echo message::getMsg($_GET['msg']) ?>
		</h3>
	</div>
<?php endif ?>

<fieldset>
	<legend><b>INFORMASI</b></legend>
	<form action="index.php" method="get">
		<table width="100%">
			<tr>
				<td rowspan="3" valign="top" width="15%">
					<?php if (strlen($dataInfo['foto_thumb']) > 0): ?>
						<a href="../asset/foto/<?php echo $dataInfo['foto'] ?>" class="lightbox"
							title="<?php echo $dataInfo['name'] ?>">
							<image src="../asset/foto/<?php echo $dataInfo['foto_thumb'] ?>" border="1" width="100" />
						</a>
					<?php else: ?>
						<image src="../asset/image/no-photo.gif" border="1" width="100" heigth="100" />
					<?php endif; ?>
				</td>
				<td width="15%" valign="top">KATEGORI</td>
				<td width="20%" valign="top">: <b>
						<?php echo $dataInfo['category_name'] ?>
					</b></td>
				<td width="15%" valign="top">KODE</td>
				<td valign="top">: <b>
						<?php echo $dataInfo['code'] ?>
					</b></td>
			</tr>
			<tr>
				<td valign="top">NAMA</td>
				<td valign="top">: <b>
						<?php echo $dataInfo['name'] ?>
					</b></td>
				<td valign="top">UKURAN</td>
				<td valign="top">: <b>
						<?php echo $dataInfo['size'] ?>
					</b></td>
			</tr>
		</table>
	</form>
</fieldset>
<br />
<table width="100%">
	<tr>
		<td align="right"><input type="button" value="KEMBALI >>" onclick="window.location='../stuffView/index.php'" />
		</td>
	</tr>
</table>
<br />
<?php if (mysql_num_rows($data) < 1): ?>
	<div class="warning">
		<h3>
			<?php echo message::getMsg('emptySuccess') ?>
		</h3>
	</div>
<?php else: ?>
	<form action="editSave.php" method="post">
		<input name="assetId" type="hidden" value="<?php echo $_REQUEST['id'] ?>" size="1" maxlength="4" />
		<div id="tbl">
			<table width="100%" border="1">
				<thead>
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="17%">NOMOR</th>
						<th align="center" width="27%">LOKASI / DANA</th>
						<th align="center" width="17%">MERK / KONDISI</th>
						<th align="center" width="23%">HARGA</th>
						<th align="center" width="">TGL BELI</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1 : 1 ?>
					<?php while ($val = mysqli_fetch_array($data)): ?>
						<tr>
							<td align="center">
								<?php echo $i ?>
								<input name="id[]" type="hidden" value="<?php echo $val['id'] ?>" size="1" maxlength="4" />
							</td>
							<td align="left" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="40%" style="border: 0px; padding:0px"><small>No Seri :</small></td>
										<td style="border: 0px; padding:0px"><b>:
												<small>
													<?php echo $val['code'] ?></b>-
											<?php echo $val['no_serries'] ?>
											</small></b>
										</td>
									</tr>
									<tr>
										<td style="border: 0px; padding:0px"><small>No Beli</small></td>
										<td style="border: 0px; padding:0px"><b>: <small>
													<?php echo $val['no_purchase'] ?>
												</small></td></b>
									</tr>
								</table>
							</td>
							<td align="center" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="35%" style="border: 0px; padding:0px"><small>Lokasi</small></td>
										<td style="border: 0px; padding:0px"><b>:
												<small>
													<?php echo $val['location_name'] ?>
												</small></b></td>
									</tr>
									<tr>
										<td style="border: 0px; padding:0px"><small>Sumber Dana</small></td>
										<td style="border: 0px; padding:0px"><b>:
												<small>
													<?php echo $val['fund_name'] ?>
												</small></b></td>
									</tr>
									<tr>
										<td width="18%" style="border: 0px; padding:0px"><small>Departemen</small></td>
										<td style="border: 0px; padding:0px"><b>:
												<small>
													<?php echo $val['departement_name'] ?>
												</small></b></td>
									</tr>
								</table>
							</td>
							<td align="center" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="35%" style="border: 0px; padding:0px" valign="top"><small>Kondisi</small>
										</td>
										<td style="border: 0px; padding:0px">
											<small>
												<b> :
													<?php if ($val['cond'] == '0'): ?>
														RUSAK
													<?php endif; ?>

													<?php if ($val['cond'] == '1'): ?>
														BAIK
													<?php endif; ?>

													<?php if ($val['cond'] == '2'): ?>
														SETENGAH BAIK
													<?php endif; ?>
												</b>
											</small>
										</td>
									</tr>
									<tr>
										<td style="border: 0px; padding:0px"><small>Merk</small></td>
										<td style="border: 0px; padding:0px"><b>: <small>
													<?php echo $val['merk'] ?>
												</small></b>
										</td>
									</tr>
								</table>
							</td>
							<td align="center" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Harga Beli</small>
										</td>
										<td style="border: 0px; padding:0px">
											<b><small> :
													<?php echo number_format($val['price_buy'], 0, '', '.') ?>
												</small></b>
										</td>
									</tr>
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Harga Skrg</small>
										</td>
										<td style="border: 0px; padding:0px">
											<b><small> :
													<?php echo number_format($val['price'], 0, '', '.') ?>
												</small></b>
										</td>
									</tr>
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Harga Min</small>
										</td>
										<td style="border: 0px; padding:0px">
											<b><small> :
													<?php echo number_format($val['price_min'], 0, '', '.') ?>
												</small></b>
										</td>
									</tr>
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Penyusutan</small>
										</td>
										<td style="border: 0px; padding:0px">
											<b><small> :
													<?php echo number_format($val['depriciation'], 0, '', '.') ?>/Tahun
												</small></b>
										</td>
									</tr>
								</table>
							</td>
							<td valign="top" align="center">
								<small>
									<?php echo $val['date_buy'] ?>
								</small>
							</td>
						</tr>
						<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
		</div>
	</form>
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