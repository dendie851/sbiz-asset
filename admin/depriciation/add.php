<?php ob_start(); ?>
	<?php include 'addRead.php' ?>
	<h1>EKSEKUSI PENYUSUTAN</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
			<h5>Jumlah data yang di terkena penyusutan <?php echo $_GET['jumlahData'] ?> data</h5>
		</div>		
	<?php endif ?>

	<hr />
	<form action="addSave.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Anda yakin akan melakukan penyusutan ?')">
		<table width="100%">
			<tr>
				<td width="20%" valign="top">TAHUN PENYUSUTAN</td>
				<td>
					<input size="4" maxlength="4" style="width:45px" name="year" type="text" value="<?php echo isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y') ?>" /> <small>Ex: 2015</small>
					<div style="color:red"><?php echo isset($msgError['year']) ? $msgError['year'] : '' ?></div>
				</td>
			</tr>
			<tr>
				<td valign="top">KETERANGAN</td>
				<td><textarea name="description" style="height:50px; width:250px"></textarea></td>
			</tr>
			<tr>
				<td colspan="2	">
				   <small>Apabila tombol eksekusi ditekan maka seluruh <i>harga sekarang</i> asset akan dikurangin nilai penyusutan tahunan dari masing-masing asset tersebut</small>	
				</td>
			</tr>	
		</table>
		<hr />
		<input type="submit" value="EKSEKUSI"/>
		<input type="button" value="BATAL" onclick="window.location='index.php'" />
	</form>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>


