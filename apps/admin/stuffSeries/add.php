<?php ob_start(); ?>
<?php include 'addRead.php' ?>

<h1>TAMBAH ASSET SERI</h1>
<hr />
<form action="addSave.php" method="post">
	<input type="hidden" name="assetId" value="<?php echo $_REQUEST['assetId'] ?>" />
	<table width="100%">
		<tr>
			<td width="20%" valign="top">ASSET</td>
			<td><b><?php echo strtoupper($dataAsset['name']) ?></b></td>
		</tr>
		<tr>
			<td valign="top">NOMOR SERI</td>
			<td>
				<b><?php echo strtoupper($dataAsset['code']) ?>-</b>
				<input name="noSeries" type="text"
					value="<?php echo isset($_POST['noSeries']) ? $_POST['noSeries'] : $assetSeriesCodeSugest ?>"
					size="4" maxlength="5" />
				<small>Kode Asset Seri harus 5 digit</small>
				<div style="color:red"><?php echo isset($msgError['noSeries']) ? $msgError['noSeries'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">NOMOR PEMBELIAN</td>
			<td>
				<input name="noPurchase" type="text"
					value="<?php echo isset($_POST['noPurchase']) ? $_POST['noPurchase'] : '' ?>" />
				<div style="color:red"><?php echo isset($msgError['noPurchase']) ? $msgError['noPurchase'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">LOKASI</td>
			<td>
				<select name="locationId" style="width:245px">
					<?php foreach ($dataLocation as $val): ?>
						<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['locationId']) ? $_REQUEST['locationId'] : (isset($data['locationId']) ? $data['locationId'] : '')) ? 'selected' : '' ?>>
							<?php echo $val['name'] ?>
						</option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">SUMBER DANA</td>
			<td>
				<select name="fundId">
					<?php while ($val = mysqli_fetch_array($dataFund)): ?>
						<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['fundId']) ? $_REQUEST['fundId'] : (isset($data['fundId']) ? $data['fundId'] : '')) ? 'selected' : '' ?>>
							<?php echo $val['name'] ?>
						</option>
					<?php endwhile; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">DEPARTEMEN</td>
			<td>
				<select name="departementId">
					<?php while ($val = mysqli_fetch_array($dataDepartement)): ?>
						<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['departementId']) ? $_REQUEST['departementId'] : (isset($data['departementId']) ? $data['departementId'] : '')) ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
					<?php endwhile; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">MERK / JUDUL</td>
			<td>
				<input name="merk" type="text" value="<?php echo isset($_POST['merk']) ? $_POST['merk'] : '' ?>" />
				<div style="color:red"><?php echo isset($msgError['merk']) ? $msgError['merk'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">HARGA BELI</td>
			<td>
				<input name="priceBuy" type="text"
					value="<?php echo isset($_POST['priceBuy']) ? $_POST['priceBuy'] : '' ?>" size="7" />
				<div style="color:red"><?php echo isset($msgError['priceBuy']) ? $msgError['priceBuy'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">HARGA SEKARANG</td>
			<td>
				<input name="price" type="text" value="<?php echo isset($_POST['price']) ? $_POST['price'] : '' ?>"
					size="7" />
				<div style="color:red"><?php echo isset($msgError['price']) ? $msgError['price'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">HARGA MINIMUM</td>
			<td>
				<input name="priceMin" type="text"
					value="<?php echo isset($_POST['priceMin']) ? $_POST['priceMin'] : '' ?>" size="7" />
				<div style="color:red"><?php echo isset($msgError['priceMin']) ? $msgError['priceMin'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">NILAI PENYUSUTAN</td>
			<td>
				<input name="depriciation" type="text"
					value="<?php echo isset($_POST['depriciation']) ? $_POST['depriciation'] : '' ?>" size="7" /> /
				Tahun
				<div style="color:red"><?php echo isset($msgError['depriciation']) ? $msgError['depriciation'] : '' ?>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top">KONDISI</td>
			<td>
				<select name="condition" style="width:155px">
					<option value="0" <?php echo (isset($_POST['condition']) && $_POST['condition'] == '0') ? 'selected' : '' ?>>RUSAK</option>
					<option value="1" <?php echo (isset($_POST['condition']) && $_POST['condition'] == '1') ? 'selected' : '' ?>>BAIK</option>
					<option value="2" <?php echo (isset($_POST['condition']) && $_POST['condition'] == '2') ? 'selected' : '' ?>>SETENGAH BAIK</option>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">TANGGAL BELI</td>
			<td valign="top">
				<input name="dateBuy" readonly id="dateBuy" type="text"
					value="<?php echo isset($_POST['dateBuy']) ? $_POST['dateBuy'] : '' ?>" />
				<input type="button" value="KOSONGKAN" onclick="document.getElementById('dateBuy').value=''" />
				<div style="color:red"><?php echo isset($msgError['dateBuy']) ? $msgError['dateBuy'] : '' ?></div>
			</td>
		</tr>
	</table>
	<hr />
	<input type="submit" value="SIMPAN" />
	<input type="button" value="BATAL" onclick="window.location='index.php?id=<?php echo $_REQUEST['assetId'] ?>'" />
</form>

<script type="text/javascript">
	$(document).ready(function () {
		$(function () {
			$("#dateBuy").datepicker({
				dateFormat: 'dd/mm/yy',
				changeMonth: true,
				changeYear: true,
				yearRange: '-20y:+0y'
			});
			<?php $tmp = strlen(trim($_REQUEST['dateBuy'])) == 0 ? '' : explode('/', $_REQUEST['dateBuy']) ?>
			$("#dateBuy").datepicker("setDate", <?php if (is_array($tmp)): ?> new Date(<?php echo ($tmp[2]) ?>, <?php echo ($tmp[1] - 1) ?>, <?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
		});
	});

</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>