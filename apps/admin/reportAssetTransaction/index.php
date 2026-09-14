<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<h1>ASSET TRANSAKSI</h1>
	<fieldset>
		<legend><b>FILTER<b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="20%">DARI TANGGAL </td>
					<td>
						<input type="text" name="dateFrom" id="dateFrom" value="" readonly />
					</td>
				</tr>
				<tr>
					<td>SAMPAI TANGGAL</td>
					<td>
						<input type="text" name="dateTo" id="dateTo" value="" readonly />
					</td>
				</tr>
				<tr>
					<td>TIPE</td>
					<td>
						<select name="type" style="width:155px">
							<option value="x" <?php echo $_REQUEST['type'] == 'x' ? 'selected' : '' ?>>Semua</option>
							<option value="0" <?php echo $_REQUEST['type'] == '0' ? 'selected' : '' ?>>Pembelian</option>
							<option value="1" <?php echo $_REQUEST['type'] == '1' ? 'selected' : '' ?>>Perbaikan</Pembelian>
							<option value="2" <?php echo $_REQUEST['type'] == '2' ? 'selected' : '' ?>>Pemindahan</option>
							<option value="3" <?php echo $_REQUEST['type'] == '3' ? 'selected' : '' ?>>Pemusnahan</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="FILTER" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
	<p></p>

	<?php if(!isset($_REQUEST['dateFrom'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg('filterData') ?></h3>
		</div>		
	<?php else: ?>
		<?php if(mysqli_num_rows($dataHistory) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
		<p style="text-align:right">
			<input type="button" value="PRINT" onclick="window.open('print.php?type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
			<input type="button" value="EXPORT KE EXCEL" onclick="window.open('excel.php?type=<?php echo $_REQUEST['type'] ?>&dateFrom=<?php echo urlencode($_REQUEST['dateFrom']) ?>&dateTo=<?php echo urlencode($_REQUEST['dateTo']) ?>')" />
		</p>	

		<div id="tbl">
			<table width="100%">
				<thead>
					<tr>
						<th width="2%"><b>NO</b></th>
						<th width="18%"><b>TANGGAL</b></th>
						<th width="21%"><b>NO SERI ASSET</b></th>
						<th width="23%"><b>ASSET</b></th>
						<th><b>KETERANGAN</b></th>
					</tr>
				</thead>
				<?php $i=1; ?>
				<?php while($val = mysqli_fetch_array($dataHistory)): ?>
					<tr>
						<td align="center"><?php echo $i ?></td>						
						<td align="center"><?php echo $val['format_date'] ?></td>						
						<td align="center">
							<?php echo $val['no_asset'] ?>-<?php echo $val['no_serries'] ?><br />
							<small><?php echo $dataLocation[$val['location_id']] ?></small>
						</td>						
						<td align="center">
							<?php if(strlen($val['asset_foto_thumb']) > 0 ): ?>
								<a href="../asset/foto/<?php echo $val['asset_foto'] ?>" class="lightbox" title="<?php echo $val['asset_name'] ?>">
									<?php echo $val['asset_name'] ?><br />
									<small>(<?php echo $val['category_name'] ?>)</small><br />
								</a>	
							<?php else: ?>
								<?php echo $val['asset_name'] ?><br />
								<small>(<?php echo $val['category_name'] ?>)</small><br />
							<?php endif; ?>														
						</td>						
						<td><?php echo $val['decription'] ?></td>												
					</tr>
				<?php $i++; ?>
				<?php endwhile; ?>
			</table>
		<?php endif; ?>
	<?php endif; ?>			

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>

	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateFrom" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-100y:c+nn',
					maxDate: '0d',
				}); 
				<?php $tmp = strlen(trim($_REQUEST['dateFrom'])) == 0 ?  '' : explode('/',$_REQUEST['dateFrom']) ?>
				$("#dateFrom" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});


		$(function() {
				$( "#dateTo" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-100y:c+nn',
					maxDate: '0d',
				});

				<?php $tmp = strlen(trim($_REQUEST['dateTo'])) == 0 ?  '' : explode('/',$_REQUEST['dateTo']) ?>
				$("#dateTo" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[2]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[0] ?>) <?php else: ?> null <?php endif; ?>);
			});
	});

	</script>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
