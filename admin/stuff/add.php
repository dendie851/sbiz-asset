<?php ob_start(); ?>
	<?php include 'addRead.php' ?>

	<h1>TAMBAH ASSET</h1>
	<hr />
	<form action="addSave.php" method="post" enctype="multipart/form-data" >
		<table width="100%">
			<tr>
				<tr>
					<td width="15%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:140px">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
				</tr>				
				<td valign="top">KODE</td>
				<td>
					<input name="code" type="text" value="<?php echo isset($_POST['code']) ? $_POST['code'] : $assetCodeSugest ?>" size="5" maxlength="5" />
					<small>Kode Asset harus 5 digit</small>
					<div style="color:red"><?php echo isset($msgError['code']) ? $msgError['code'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">NAMA</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">UKURAN</td>
				<td>
					<input name="size" type="text" value="<?php echo isset($_POST['size']) ? $_POST['size'] : '' ?>" />
					<div style="color:red"><?php echo isset($msgError['size']) ? $msgError['size'] : '' ?></div>					
				</td>
			</tr>
			<tr> 
				<td>FOTO</td>
				<td><input name="foto" type="file" ></td>
			</tr>
		</table>
		<hr />
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
