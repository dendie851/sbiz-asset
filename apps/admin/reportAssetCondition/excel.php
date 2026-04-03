<?php ob_start(); ?>
<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=LAPORAN-KONDISI-ASSET.xls");
?>

<?php include 'indexRead.php' ?>

<h1>LAPORAN KONDISI ASSET</h1>

<?php if (mysql_num_rows($dataCategory) < 1): ?>
	<div class="warning">
		<h3><?php echo message::getMsg('emptySuccess') ?></h3>
	</div>
<?php else: ?>
	<table width="100%" border="0">
		<tbody>
			<?php $i = 1; ?>
			<?php $assetGrandTotal = 0; ?>
			<?php $assetGrandNilai = 0; ?>

			<?php while ($val = mysqli_fetch_array($dataCategory)): ?>
				<tr>
					<td width="2%" valign="top"><?php echo $i ?>. </td>
					<td valign="top"><b><?php echo $val['name'] ?></b><br />
						<p style="padding-left:15px">
							<?php include '../../lib/connection.php'; ?>
							<?php
							$query = "select a.id,a.name,a.code,a.foto, a.foto_thumb
										from asset as a
										inner join asset_series as ase
										  on ase.asset_id = a.id
										    and ase.departement_id in ($loginAccessDepartement)
										    and ase.fund_id in ($loginAccessFund)		   	
										where a.is_delete = '0'
											and a.category_id = '{$val['id']}'
										group by a.id		
										order by a.name";
							$dataAsset = mysqli_query($con, $query) or die(mysqli_error($con));
							?>
							<?php $j = 1; ?>
							<?php if (mysql_num_rows($dataAsset) > 0): ?>
							<div id="tbl">
								<table width="100%" border="1">
									<thead>
										<tr>
											<th width="30%" align="left">NAMA</th>
											<th width="20%" align="center">KODE</th>
											<th width="15%" align="center">BAIK</th>
											<th width="20%" align="center">SETENGAH BAIK</th>
											<th align="center">RUSAK</th>
										</tr>
										<thead>
											<?php $assetTotal = 0 ?>
											<?php $assetNilai = 0 ?>
											<?php while ($valAsset = mysqli_fetch_array($dataAsset)): ?>
												<tr>
													<td align="left">
														<?php echo $i . '.' . $j ?> 				<?php echo $valAsset['name'] ?>
													</td>
													<td align="center"> <b><?php echo $valAsset['code'] ?></b></td>
													<td align="center">
														<?php
														$query = "select count(id) as jumlah
																from asset_series as ase
																where ase.is_delete = '0'
																  and ase.is_remove = '0'
																  and cond = '1'	
																  and ase.asset_id = '{$valAsset['id']}'
																  and ase.departement_id in ($loginAccessDepartement)
																  and ase.fund_id in ($loginAccessFund)";
														$tmpJml = mysqli_query($con, $query) or die(mysqli_error($con));
														$dataJml = mysqli_fetch_array($tmpJml);
														?>
														<?php echo $dataJml['jumlah'] ?>
													</td>
													<td align="center">
														<?php
														$query = "select count(id) as jumlah
																from asset_series as ase
																where ase.is_delete = '0'
																  and ase.is_remove = '0'
																  and cond = '2'	
																  and ase.asset_id = '{$valAsset['id']}'
																  and ase.departement_id in ($loginAccessDepartement)
																  and ase.fund_id in ($loginAccessFund)";
														$tmpJml = mysqli_query($con, $query) or die(mysqli_error($con));
														$dataJml = mysqli_fetch_array($tmpJml);
														?>

														<?php echo $dataJml['jumlah'] ?>

													</td>
													<td align="center">
														<?php
														$query = "select count(id) as jumlah
																from asset_series as ase
																where ase.is_delete = '0'
																  and ase.is_remove = '0'
																  and cond = '0'	
																  and ase.asset_id = '{$valAsset['id']}'
																  and ase.departement_id in ($loginAccessDepartement)
																  and ase.fund_id in ($loginAccessFund)";
														$tmpJml = mysqli_query($con, $query) or die(mysqli_error($con));
														$dataJml = mysqli_fetch_array($tmpJml);
														?>

														<?php echo $dataJml['jumlah'] ?>
													</td>
												</tr>
												<?php $j++; ?>
											<?php endwhile; ?>
								</table>
							<?php else: ?>
								<div class="warning" style="padding:1px; margin:1px; border:1px solid black;">
									<h6>TIDAK ADA ASSET</h6>
								</div>
							<?php endif; ?>
						</div>
						<?php include '../../lib/connection-close.php'; ?>
						</p>
					</td>
				</tr>
				<?php $i++; ?>
			<?php endwhile; ?>
		<tbody>
	</table>
<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/print.php' ?>