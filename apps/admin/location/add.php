<?php ob_start(); ?>
	<h1>TAMBAH LOKASI</h1>
	<hr />
	<form action="addSave.php" method="post" enctype="multipart/form-data">
		<input name="level" type="hidden" value="<?php echo $_REQUEST['level'] ?>"/>			
		<input name="parentId" type="hidden" value="<?php echo $_REQUEST['parentId'] ?>"/>			

		<table width="100%">
			<tr>
				<td valign="top" width="10%">NAMA</td>
				<td>
					<input name="name" type="text" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>"/>			
					<div style="color:red"><?php echo isset($msgError['name']) ? $msgError['name'] : '' ?></div>
				</td>
			</tr>		
			<tr>
				<td valign="top">ALIAS</td>
				<td>
					<input name="aliasa" type="text" value="<?php echo isset($_POST['aliasa']) ? $_POST['aliasa'] : '' ?>"/>			
					<div style="color:red"><?php echo isset($msgError['alias']) ? $msgError['alias'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">LUAS</td>
				<td>
					<input name="size" type="text" value="<?php echo isset($_POST['size']) ? $_POST['size'] : '' ?>"/>			
					<div style="color:red"><?php echo isset($msgError['size']) ? $msgError['size'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">STATUS</td>
				<td>
					<select name="status" style="width:210px">
						<option value="0" <?php echo $_REQUEST['status'] == '0' ? 'selected' : '' ?>>TIDAK DI GUNAKAN</option>
						<option value="1" <?php echo $_REQUEST['status'] == '1' ? 'selected' : '' ?>>DI GUNAKAN</option>
					</select>		
				</td>
			</tr>	
		</table>
		<hr />
		<input type="submit" value="SIMPAN"/>
		<input type="button" value="BATAL" onclick="window.location='index.php?level=<?php echo $_REQUEST['level'] ?>&parentId=<?php echo $_REQUEST['parentId']?>'" />	
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
