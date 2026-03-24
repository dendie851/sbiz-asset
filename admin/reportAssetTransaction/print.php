<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<link rel="stylesheet" type="text/css" media="screen" href="../css/print.css" />

	<?php echo $a ?>
	<h1>ASSET TRANSAKSI</h1>
	<fieldset>
		<legend><b>INFORMASI<b></legend>
		<form action="index.php" method="get">
		<table width="100%">
			<tr>
				<td width="20%">DARI TANGGAL </td>
				<td width="25%"> : <?php echo date("j M Y", strtotime($dateFrom)) ?></td>
				<td>TIPE</td>
				<td> :
					<?php if($_REQUEST['type'] == 'x'): ?>
						SEMUA
					<?php endif; ?>

					<?php if($_REQUEST['type'] == '0'): ?>
						PEMBELIAN
					<?php endif; ?>

					<?php if($_REQUEST['type'] == '1'): ?>
						PERBAIKAN
					<?php endif; ?>

					<?php if($_REQUEST['type'] == '2'): ?>
						PEMINDAHAN
					<?php endif; ?>

					<?php if($_REQUEST['type'] == '3'): ?>
						PEMUSNAHAN
					<?php endif; ?>
				</td>
			<tr>
				<td>SAMPAI TANGGAL</td>
				<td> : <?php echo date("j M Y", strtotime($dateTo)) ?></td>
				<td></td>				
				<td></td>
			</tr>
		</table>
		</form>
	</fieldset>
	<p></p>

	<?php if(mysql_num_rows($dataHistory) < 1) : ?>
		<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>

	<div id="tbl">
		<table width="100%" border="1">
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
			<?php while($val = mysql_fetch_array($dataHistory)): ?>
				<tr>
					<td align="center"><?php echo $i ?></td>						
					<td align="center"><?php echo $val['format_date'] ?></td>						
					<td align="center">
						<?php echo $val['no_asset'] ?>-<?php echo $val['no_serries'] ?><br />
						<small><?php echo $dataLocation[$val['location_id']] ?></small>
					</td>						
					<td align="center">
						<?php echo $val['asset_name'] ?><br />
						<small>(<?php echo $val['category_name'] ?>)</small><br />
					</td>						
					<td><?php echo $val['decription'] ?></td>												
				</tr>
			<?php $i++; ?>
			<?php endwhile; ?>
		</table>
	<?php endif; ?>			
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>	
