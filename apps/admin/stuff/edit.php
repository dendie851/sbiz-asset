<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />
<?php include 'editRead.php' ?>

<h1>EDIT BARANG</h1>
<hr />
<form action="editSave.php" method="post" enctype="multipart/form-data">
	<input name="id" type="hidden" value="<?php echo $data['id'] ?>" />
	<table width="100%">
		<tr>
		<tr>
			<td width="15%">KATEGORI</td>
			<td>
				<select name="categoryId" style="width:140px">
					<option value="x">-- Semua --</option>
					<?php while ($val = mysqli_fetch_array($dataCategory)): ?>
						<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : $data['category_id']) ? 'selected' : '' ?>><?php echo $val['name'] ?>
						</option>
					<?php endwhile; ?>
				</select>
			</td>
		</tr>
		<td valign="top">KODE</td>
		<td>
			<input name="code" type="text" value="<?php echo isset($_POST['code']) ? $_POST['code'] : $data['code'] ?>"
				size="5" maxlength="5" />
			<small>Kode Asset minumum 3 digit</small>
			<div style="color:red"><?php echo isset($msgError['code']) ? $msgError['code'] : '' ?></div>
			<input name="codeOri" type="hidden" value="<?php echo $data['code'] ?>" size="5" maxlength="5" />
		</td>
		</tr>
		<tr>
			<td valign="top">NAMA</td>
			<td>
				<input name="name" type="text"
					value="<?php echo isset($_POST['name']) ? $_POST['name'] : $data['name'] ?>" />
				<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">UKURAN</td>
			<td>
				<input name="size" type="text"
					value="<?php echo isset($_POST['size']) ? $_POST['size'] : $data['size'] ?>" />
				<div style="color:red"><?php echo isset($msgError['size']) ? $msgError['size'] : '' ?></div>
			</td>
		</tr>
		<tr>
			<td valign="top">FOTO</td>
			<td valign="top">
				<input name="foto" type="file">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" rowspan="2">
				<?php if (strlen($data['foto_thumb']) > 0): ?>
					<a href="../asset/foto/<?php echo $data['foto'] ?>" class="lightbox"
						title="<?php echo $data['name'] ?>">
						<image src="../asset/foto/<?php echo $data['foto_thumb'] ?>" border="1" width="100" />
					</a>
				<?php else: ?>
					<image src="../asset/image/no-photo.gif" border="1" width="100" heigth="100" />
				<?php endif; ?>
				<br />
				<input type="checkbox" name="delete[]" value="<?php echo $data['id'] ?>" /> Hapus
			</td>
		</tr>
	</table>
	<hr />
	<input type="submit" value="SIMPAN" />
	<input type="button" value="BATAL" onclick="window.location='index.php'" />
</form>

<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

<script type="text/javascript">
	$(function () {
		$('a.lightbox').lightBox();
	});
</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>