<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

<?php include 'detailRead.php' ?>

<h1>DETAIL PENYUSUTAN</h1>
<fieldset>
	<legend><b>INFORMASI</b></legend>
	<table width="100%">
		<tr>
			<td width="20%">Tahun Penyusutan</td>
			<td width="20%"><b>:
					<?php echo $dataInfo['year'] ?>
				</b></td>
			<td width="15%" valign="top">Keterangan</td>
			<td rowspan="2"><b>
					<?php echo $dataInfo['description'] ?>
				</b></td>
		</tr>
		<tr>
			<td>Eksekusi Penyusutan</td>
			<td><b>:
					<?php echo $dataInfo['date_name'] ?>
				</b></td>
			<td></td>
		</tr>
	</table>
</fieldset>

<br />
<table width="100%">
	<tr>
		<td align="right"><input type="button" onclick="window.location='index.php'" value="KEMBALI" /></td>
	</tr>
</table>
<br />

<?php if (mysql_num_rows($dataCategory) < 1): ?>
	<div class="warning">
		<h3>
			<?php echo message::getMsg('emptySuccess') ?>
		</h3>
	</div>
<?php else: ?>
	<table width="100%" border="0">
		<tbody>
			<?php $i = 1; ?>
			<?php $assetGrandNilai = 0; ?>

			<?php while ($val = mysqli_fetch_array($dataCategory)): ?>
				<?php include '../../lib/connection.php'; ?>
				<?php
				$query = "select sum((select count(ase.id) 
											  from asset_series as ase 
											  where ase.asset_id = asset.id 
											  and ase.is_delete = '0' 
											  and ase.is_remove = '0'
											  )) as jml
							from asset
							where asset.is_delete = '0'
								and asset.category_id = '{$val['id']}'
							group by asset.category_id";


				$tmpCount = mysqli_query($con, $query) or die(mysqli_error($con));
				$dataCountCategoryAsset = mysqli_fetch_array($tmpCount);
				?>
				<?php if ($dataCountCategoryAsset['jml'] > 0): ?>
					<?php
					$query = "select id,name,code,foto, foto_thumb, 
									(select count(id) as jml from asset_series as ase where ase.asset_id = asset.id and ase.is_delete = '0' and ase.is_remove = '0' $where) as jml
								from asset
								where is_delete = '0'
									and category_id = '{$val['id']}'
								order by name";
					$dataAsset = mysqli_query($con, $query) or die(mysqli_error($con));

					?>
					<tr>
						<td width="2%" valign="top">
							<?php echo $i ?>.
						</td>
						<td valign="top"><b>
								<?php echo $val['name'] ?>
							</b><br />
							<p style="padding-left:15px">
								<?php $j = 1; ?>
								<?php if (mysql_num_rows($dataAsset) > 0): ?>
								<div id="tbl">
									<table width="100%" border="1">
										<thead>
											<tr>
												<th width="20%" align="left">NAMA</th>
												<th width="12%" align="center">KODE</th>
												<th width="15%" align="center"><small>PENYUSUTAN PERTAHUN</small></th>
												<th width="15%" align="center"><small>PENYUSUTAN PERBULAN</small></th>
											</tr>
											<thead>
												<?php $assetTotal = 0 ?>
												<?php $assetNilai = 0 ?>
												<?php while ($valAsset = mysqli_fetch_array($dataAsset)): ?>
													<?php if ($valAsset['jml'] > 0): ?>
														<?php
														$query = "select sum(adh.depriciation) as jml
																from asset_depriciation_history as adh
																inner join asset_series as a		
																  on a.id = adh.asset_series_id
																   and is_delete = '0'
																   and is_remove = '0'	
																where a.asset_id = '{$valAsset['id']}'
																  and adh.asset_depriciation_id = '$depriciationId'";

														$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
														$dataAssetDepriciation = mysqli_fetch_array($tmp);
														?>
														<tr>
															<td align="left">
																<?php if (strlen($valAsset['foto_thumb']) > 0): ?>
																	<a href="../asset/foto/<?php echo $valAsset['foto'] ?>" class="lightbox"
																		title="<?php echo $valAsset['name'] ?>">
																		<?php echo $i . '.' . $j ?>
																		<?php echo $valAsset['name'] ?>
																	</a>
																<?php else: ?>
																	<?php echo $i . '.' . $j ?>
																	<?php echo $valAsset['name'] ?>
																<?php endif; ?>
															</td>
															<td align="center"> <b>
																	<?php echo $valAsset['code'] ?>
																</b></td>
															<td align="center">
																<div class="button">
																	<a data-title="DETAIL PENYUSUTAN" data-width="750" data-height="550"
																		href="detailAssetSeries.php?depriciationId=<?php echo $depriciationId ?>&assetId=<?php echo $valAsset['id'] ?>">
																		<?php echo number_format($dataAssetDepriciation['jml'], 0, '', '.') ?>
																	</a>
																</div>
																<?php $assetNilai = $assetNilai + $dataAssetDepriciation['jml'] ?>
															</td>
															<td align="center">
																<?php echo number_format($dataAssetDepriciation['jml'] / 12, 0, '', '.') ?>/bulan
															</td>
														</tr>
														<?php $j++; ?>
													<?php endif; ?>
												<?php endwhile; ?>
												<thead>
													<tr>
														<th width="25%" align="left">&nbsp;</th>
														<th width="15%" align="center">&nbsp;</th>
														<th align="left">
															<?php echo number_format($assetNilai, 0, '', '.') ?>
														</th>
														<th width="15%" align="center">&nbsp;</th>
													</tr>
													<thead>
									</table>
									<?php $assetGrandNilai = $assetGrandNilai + $assetNilai ?>

									<?php $assetNilai = 0 ?>
								<?php else: ?>
									<div class="warning" style="padding:1px; margin:1px">
										<h6>TIDAK ADA ASSET</h6>
									</div>
								<?php endif; ?>
							</div>
							</p>
						</td>
					</tr>
					<?php $i++; ?>

				<?php endif; ?>
				<?php include '../../lib/connection-close.php'; ?>

				<?php $assetGrandNilai = $assetGrandNilai + $assetNilai ?>
			<?php endwhile; ?>
			<tr>
				<td></td>
				<td>
					<div id="tbl">
						<table width="100%" border="1">
							<thead>
								<tr>
									<th width="37%" align="left" colspan="2">GRAND TOTAL</th>
									<th width="19%" align="left" colspan="2">&nbsp;</th>
									<th align="left">
										<?php echo number_format($assetGrandNilai, 0, '', '.') ?>
									</th>
								</tr>
								<thead>
						</table>
					</div>
				</td>
			</tr>
		<tbody>
	</table>
<?php endif; ?>

<script type="text/javascript">

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