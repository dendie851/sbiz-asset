<?php ob_start(); ?>
	<?php include 'indexRead.php' ?>

	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php echo $a ?>
	<h1>HOME</h1>
	<fieldset>
		<legend><b>DASBOARD<b></legend>

		<table width="100%">
			<tr>
				<td width="33%"><hr /><b>NILAI ASSET</b><hr /></td>
				<td width="33%"><hr /><b>JUMLAH ASSET</b><hr /></td>
				<td><hr /><b>KONDISI ASSET</b><hr /></td>
			</tr>
			<tr>
				<td valign="top" style="padding-left:10px">
					<table width="100%">
						<?php while($val = mysql_fetch_array($dataFund)): ?>
							<tr>
								<td width="50%"><b><?php echo $val['name'] ?></td>
								<td align="rigth">: 
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select sum(price) as nilai 
											from asset_series as ase
											  where ase.fund_id = '{$val['id']}' 
											    and ase.is_delete = '0' 
											    and ase.is_remove = '0'
												and ase.departement_id in ($loginAccessDepartement)"; 

										$tmp = mysql_query($query) or die (mysql_error());
										$data = mysql_fetch_array($tmp);	
									?>
									<?php include '../../lib/connection-close.php'; ?>

									<?php echo number_format($data['nilai'], 0 , '' , '.')  ?>
								</td>
							</tr>
						<?php endwhile; ?>	
						<tr>
							<td width="50%"><b>Total Asset</td>
							<td>: 
								<?php include '../../lib/connection.php'; ?>

								<?php 	 
									$query = "select sum(price) as nilai 
										from asset_series as ase
										  where ase.is_delete = '0' 
										    and ase.is_remove = '0'
											and ase.fund_id in ($loginAccessFund)	
											and ase.departement_id in ($loginAccessDepartement)"; 

									$tmp = mysql_query($query) or die (mysql_error());
									$data = mysql_fetch_array($tmp);	
								?>
								<?php include '../../lib/connection-close.php'; ?>

								<?php echo number_format($data['nilai'], 0 , '' , '.')  ?>
							</td>
						</tr>
					</table>
				</td>
				<td valign="top" style="padding-left:10px">
					<table width="100%">
						<?php while($val = mysql_fetch_array($dataItem)): ?>
							<tr>
								<td width="50%"><b><?php echo $val['name'] ?></td>
								<td>:
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select count(id) as nilai 
											from asset_series as ase
											  where ase.fund_id = '{$val['id']}' 
											    and ase.is_delete = '0' 
											    and ase.is_remove = '0'
												and ase.departement_id in ($loginAccessDepartement)"; 

										$tmp = mysql_query($query) or die (mysql_error());
										$data = mysql_fetch_array($tmp);	
									?>
									<?php include '../../lib/connection-close.php'; ?>

									<?php echo number_format($data['nilai'], 0 , '' , '.')  ?> Buah
 								</td>
							</tr>
						<?php endwhile; ?>	
						<tr>
							<td width="50%"><b>Total Asset</td>
							<td>: 
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select count(id) as nilai 
											from asset_series as ase
											  where ase.is_delete = '0' 
											    and ase.is_remove = '0'
												and ase.fund_id in ($loginAccessFund)
												and ase.departement_id in ($loginAccessDepartement)"; 

										$tmp = mysql_query($query) or die (mysql_error());
										$data = mysql_fetch_array($tmp);	
									?>
									<?php include '../../lib/connection-close.php'; ?>

									<?php echo number_format($data['nilai'], 0 , '' , '.')  ?> Buah
							</td>
						</tr>
					</table>
				</td>
				<td valign="top" style="padding-left:10px">
					<table width="100%">
						<tr>
							<td width="50%"><b>BAIK</td>
							<td>: 
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select count(id) as nilai 
											from asset_series as ase
											  where ase.cond = '1' 
											    and ase.is_delete = '0' 
											    and ase.is_remove = '0'
												and ase.fund_id in ($loginAccessFund)
												and ase.departement_id in ($loginAccessDepartement)"; 

										$tmp = mysql_query($query) or die (mysql_error());
										$data = mysql_fetch_array($tmp);	
									?>
									<?php include '../../lib/connection-close.php'; ?>

									<?php echo number_format($data['nilai'], 0 , '' , '.')  ?> Buah
							</td>
						</tr>
						<tr>
							<td width="50%"><b>SETENGAH BAIK</td>
							<td>: 
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select count(id) as nilai 
											from asset_series as ase
											  where ase.cond = '2' 
											    and ase.is_delete = '0' 
											    and ase.is_remove = '0'
												and ase.fund_id in ($loginAccessFund)
												and ase.departement_id in ($loginAccessDepartement)"; 

										$tmp = mysql_query($query) or die (mysql_error());
										$data = mysql_fetch_array($tmp);	
									?>
									<?php include '../../lib/connection-close.php'; ?>

									<?php echo number_format($data['nilai'], 0 , '' , '.')  ?> Buah
							</td>
						</tr>
						<tr>
							<td width="50%"><b>RUSAK</td>
							<td>: 
									<?php include '../../lib/connection.php'; ?>
									<?php 	 
										$query = "select count(id) as nilai 
											from asset_series as ase
											  where ase.cond = '0' 
											    and ase.is_delete = '0' 
											    and ase.is_remove = '0'
												and ase.fund_id in ($loginAccessFund)
												and ase.departement_id in ($loginAccessDepartement)"; 

										$tmp = mysql_query($query) or die (mysql_error());
										$data = mysql_fetch_array($tmp);	
									?>
									<?php include '../../lib/connection-close.php'; ?>

									<?php echo number_format($data['nilai'], 0 , '' , '.')  ?> Buah
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</fieldset>

	<?php if(mysql_num_rows($dataHistory) > 0): ?>
		<p></p>
		<fieldset>
			<legend><b>RIWAYAT 30 AKTIVITAS ASSET TERAKHIR<b></legend>
			<div id="tbl">
				<table width="100%">
					<thead>
						<tr>
							<th width="2%"><b>NO</b></th>
							<th width="20%"><b>TANGGAL</b></th>
							<th width="17%"><b>NO SERI ASSET</b></th>
							<th width="25%"><b>ASSET</b></th>
							<th><b>KETERANGAN</b></th>
						</tr>
					</thead>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($dataHistory)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>						
							<td align="center"><?php echo $val['format_date'] ?></td>						
							<td align="center"><?php echo $val['no_asset'] ?>-<?php echo $val['no_serries'] ?></td>						
							<td align="center">
								<?php if(strlen($val['asset_foto_thumb']) > 0 ): ?>
									<a href="../asset/foto/<?php echo $val['asset_foto'] ?>" class="lightbox" title="<?php echo $val['asset_name'] ?>">
										<?php echo $val['asset_name'] ?><br />
										<small>(<?php echo $val['category_name'] ?>)</small>
									</a>	
								<?php else: ?>
									<?php echo $val['asset_name'] ?><br />
									<small>(<?php echo $val['category_name'] ?>)</small>
								<?php endif; ?>														
							</td>						
							<td><?php echo $val['decription'] ?></td>												
						</tr>
					<?php $i++; ?>
					<?php endwhile; ?>
				</table>
			</div>
		</fieldset>
	<?php endif; ?>

	<script type="text/javascript" src="../asset/js/jquery.lightbox-0.5.min.js"></script>

	<script type="text/javascript">
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
