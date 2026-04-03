<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'indexRead.php' ?>

<h1>ASSET SERI MUSNAH</h1>

<?php if (isset($_GET['msg'])): ?>
	<div class="info">
		<h3>
			<?php echo message::getMsg($_GET['msg']) ?>
		</h3>
	</div>
<?php endif ?>

<?php if (strlen($msgError['id']) > 0): ?>
	<div class="error">
		<h3>
			<?php echo $msgError['id'] ?>
		</h3>
	</div>
<?php endif ?>

<fieldset>
	<legend><b>FILTER</b></legend>
	<form action="index.php" method="post">
		<table width="100%">
			<tr>
				<td width="17%">NOMOR SERI ASSET</td>
				<td>
					<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>"
						style="width:180px" /><br />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="FILTER" name="filter" />
				</td>
			</tr>
		</table>
	</form>
</fieldset>
<p></p>
<?php if (isset($_REQUEST['keyword'])): ?>
	<?php if (mysql_num_rows($data) < 1): ?>
		<div class="warning">
			<h3>
				<?php echo message::getMsg('emptySuccess') ?>
			</h3>
		</div>
	<?php else: ?>
		<form action="editSave.php" method="post">
			<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword'] ?>" size="1" maxlength="4" />
			<input name="assetId" type="hidden" value="<?php echo $_REQUEST['id'] ?>" size="1" maxlength="4" />
			<div id="tbl">
				<table width="100%" border="1">
					<thead>
						<tr>
							<th align="center" width="2%"></th>
							<th align="center" width="5%">NO</th>
							<th align="center" width="20%">NOMOR SERI</th>
							<th align="center" width="50%">NAMA ASSET</th>
							<th align="center">RIWAYAT</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1 : 1 ?>
						<?php while ($val = mysqli_fetch_array($data)): ?>
							<tr>
								<td align="center">
									<input type="checkbox" name="id[]" value="<?php echo $val['id'] ?>" />
								</td>
								<td align="center">
									<?php echo $i ?>
								</td>
								<td align="center" valign="top">
									<?php if (strlen($val['foto']) > 0): ?>
										<a href="../asset/foto/<?php echo $val['foto'] ?>" class="lightbox"
											title="<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>">
											<?php echo $val['code'] ?>-
											<?php echo $val['no_serries'] ?>
										</a>
									<?php else: ?>
										<?php echo $val['code'] ?>-
										<?php echo $val['no_serries'] ?>
									<?php endif; ?>
								</td>
								<td align="center" valign="top">
									<?php echo $val['asset_name'] ?>
									<small>(
										<?php echo $val['category_name'] ?>)
									</small>
								</td>
								<td align="center">
									<div class="button">
										<a href="history.php?id=<?php echo $val['id'] ?>" data-title="RIWAYAT PEMUSNAHAN"
											data-width="600" data-height="550">TAMPILKAN</a>
									</div>
								</td>
							</tr>
							<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>
			<br />
			<hr />
			<fieldset>
				<legend><b>DI AKTIFKAN</b></legend>
				<div class="clear">
					<table width="100%">
						<tr>
							<td width="28%"><b>TGL DI AKTIFKAN KEMBALI</b></td>
							<td>
								<input style="width:110px" name="dateRemove" readonly id="dateRemove" type="text" value="" />
							</td>
						</tr>
						<tr>
							<td width="12%" valign="top"><b>KETERANGAN</b></td>
							<td>
								<textarea name="description" style="width:245px; height:90px"></textarea>
							</td>
						</tr>
						<tr>
							<td width="12%" valign="top"></td>
							<td>
								<input type="submit" value="SIMPAN" />
								<input type="button" value="BATAL" onclick="window.location='../stuff/index.php'" />
							</td>
						</tr>
					</table>
				</div>
				</legend>
			</fieldset>
			<hr />
		</form>
	<?php endif; ?>
<?php else: ?>
	<div class="info">
		<h3>
			<?php echo message::getMsg('searchSuccess') ?>
		</h3>
	</div>
<?php endif; ?>

<script type="text/javascript">
	$(document).ready(function () {
		$(function () {
			$("#dateRemove").datepicker({
				dateFormat: 'dd/mm/yy',
				changeMonth: true,
				changeYear: true,
				yearRange: '-20y:+0y'
			});

			$("#dateRemove").datepicker("setDate", new Date());
		});
	});

	$(function () {
		var iframe = $('<iframe frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
		var dialog = $("<div></div>").append(iframe).appendTo("body").dialog({
			autoOpen: false,
			modal: true,
			resizable: false,
			width: "auto",
			height: "auto",
			close: function () {
				iframe.attr("src", "");
			}
		});
		$(".button a").on("click", function (e) {
			e.preventDefault();
			var src = $(this).attr("href");
			var title = $(this).attr("data-title");
			var width = $(this).attr("data-width");
			var height = $(this).attr("data-height");
			iframe.attr({
				width: +width,
				height: +height,
				src: src
			});
			dialog.dialog("option", "title", title).dialog("open");
		});
	});

</script>

<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

<script type="text/javascript">
	$(function () {
		$('a.lightbox').lightBox();
	});
</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>