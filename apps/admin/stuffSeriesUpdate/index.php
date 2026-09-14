<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />
	
	<?php include 'indexRead.php' ?>

	<h1>ASSET SERI PEMBAHARUAN</h1>
	
	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post">
			<table width="100%">		
				<tr>
					<td width="17%">NOMOR SERI ASSET</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
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
	<?php if(isset($_REQUEST['keyword'])): ?>
		<?php if(mysqli_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<form action="editSave.php" method="post">
				<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword']?>" size="1" maxlength="4" />
				<input name="assetId" type="hidden" value="<?php echo $_REQUEST['id']?>" size="1" maxlength="4" />
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>
							<th align="center" width="5%">NO</th>
							<th align="center" width="25%">NAMA / NOMOR</th>						
							<th align="center" width="25%">LOKASI / DANA</th>
							<th align="center" width="17%">MERK / KONDISI</th>
							<th align="center" width="17%">HARGA</th>	
							<th align="center" width="">TGL BELI</th>
						</tr>	
					</thead>
					<tbody>
						<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
						<?php while($val = mysqli_fetch_array($data)): ?>
							<tr>
								<td align="center"><?php echo $i ?>
									<input name="id[]" type="hidden" value="<?php echo $val['id'] ?>" size="1" maxlength="4" />
								</td>
								<td align="center" valign="top">
									<table width="100%" style="border: 0px">
										<tr>
											<td width="28%" style="border: 0px; padding:0px">
												<p>A.Nama / No Seri Asset</p>
												<p>
													<?php if(strlen($val['foto']) > 0 ): ?>
														<a href="../asset/foto/<?php echo $val['foto'] ?>" class="lightbox" title="<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>">
															<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>
														</a>	
													<?php else: ?>
														<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>
													<?php endif; ?>
													 <br />
													<?php echo $val['asset_name'] ?>
													<small>(<?php echo $val['category_name'] ?>)</small>
												</p>											
											</td>
										</tr>		
										<tr>										
											<td style="border: 0px; padding:0px">
											<input style="width: 90px" name="noSeries[]" type="hidden" value="<?php echo $val['no_serries'] ?>" size="5" />
											<p>B. No Pembelian </p>
											<input style="width: 90px" name="noPurchase[]" type="text" value="<?php echo $val['no_purchase'] ?>" size="5" /></td>
										</tr>									
									</table>				
								</td>
								<td align="center"  valign="top">
									<table width="100%" style="border: 0px">
										<tr>
											<td width="28%" style="border: 0px; padding:0px">
											<p>Lokasi</p>
											<select name="locationId[]" style="width:200px">
												<?php foreach($dataLocation as $valLocation): ?>
													<option value="<?php echo $valLocation['id'] ?>" <?php echo $valLocation['id'] == $val['location_id'] ? 'selected' : '' ?>><?php echo $valLocation['name'] ?></option>
												<?php endforeach; ?>
											</select>
											</tr>
										<tr>										
											<td style="border: 0px; padding:0px">
											<p>Sumber Dana</p>
											<select name="fundId[]" style="width:200px">
												<?php foreach($dataFund as $valFund): ?>
													<option value="<?php echo $valFund['id'] ?>" <?php echo $valFund['id'] == $val['fund_id'] ? 'selected' : '' ?>><?php echo $valFund['name'] ?></option>
												<?php endforeach; ?>
											</select>
										</tr>
										<tr>										
											<td style="border: 0px; padding:0px">
											<p>Departemen</p>
											<select name="departementId[]" style="width:200px">
												<?php foreach($dataDepartement as $valDepartement): ?>
													<option value="<?php echo $valDepartement['id'] ?>" <?php echo $valDepartement['id'] == $val['departement_id'] ? 'selected' : '' ?>><?php echo $valDepartement['name'] ?></option>
												<?php endforeach; ?>
											</select>
										</tr>																		
									</table>
								</td>
								<td align="center" valign="top"><table width="100%" style="border: 0px">
										<tr>
											<td width="28%" style="border: 0px; padding:0px" valign="top">
												<p>Kondisi</p>
												<select name="condition[]" style="width:150px">
													<option value="0" <?php echo ($val['cond'] == '0') ? 'selected' : '' ?>>RUSAK</option>
													<option value="1" <?php echo ($val['cond'] == '1') ? 'selected' : '' ?>>BAIK</option>
													<option value="2" <?php echo ($val['cond'] == '2') ? 'selected' : '' ?>>SETENGAH BAIK</option>
												</select>
											</td>			
										</tr>
										<tr>										
											<td style="border: 0px; padding:0px" valign="top">
											<p>Merk</p>
											<input name="merk[]" type="text" value="<?php echo $val['merk'] ?>" size="3" style="width:135px" />
										</tr>									
									</table>																							
								</td>
								<td align="center" valign="top">
									<table width="100%" style="border: 0px">
										<tr>
											<td width="28%" style="border: 0px; padding:0px">
											<p>Harga Beli</p>
												<input name="priceBuy[]" type="text" value="<?php echo $val['price_buy'] ?>" size="3" style="width:75px" />
											</tr>
										<tr>										
											<td style="border: 0px; padding:0px">
											<p>Harga Skrg</p>
											<input name="price[]" type="text" value="<?php echo $val['price'] ?>" size="3" style="width:75px" />		
										</tr>
										<tr>										
											<td style="border: 0px; padding:0px">
											<p>Harga Minimum</p>
											<input name="priceMin[]" type="text" value="<?php echo $val['price_min'] ?>" size="3" style="width:80px" /> <small></small>		
										</tr>									
										<tr>										
											<td style="border: 0px; padding:0px">
											<p>Nilai Penyusutan</p>
											<input name="depriciation[]" type="text" value="<?php echo $val['depriciation'] ?>" size="3" style="width:80px" /> <small>/ Tahun</small>		
										</tr>																		
									</table>	
								</td>
								<td valign="top" align="center">
									<br />
									<input style="width:80px" name="dateBuy[]" readonly id="dateBuy<?php echo $i ?>" type="text" value="<?php echo isset($_POST['dateBuy']) ? $_POST['dateBuy'] : '' ?>" />								
									<script type="text/javascript">
									$(document).ready(function() {
										$(function() {
												$( "#dateBuy<?php echo $i ?>" ).datepicker({
													dateFormat : 'dd/mm/yy',
													changeMonth : true,
													changeYear : true,
													yearRange: '-20y:+0y'
												}); 
												<?php $tmp = explode('-',$val['date_buy']) ?>
												$("#dateBuy<?php echo $i ?>" ).datepicker("setDate", <?php if(is_array($tmp)) : ?> new Date(<?php echo ($tmp[0]) ?>,<?php echo ($tmp[1]-1) ?>,<?php echo $tmp[2] ?>) <?php else: ?> null <?php endif; ?>);
											});	
									});
									</script>		
								</td>	
							</tr>	
						<?php $i++; ?>
						<?php endwhile; ?>
					<tbody>
				</table>
				<br />
				<p>
					<hr />
					<input type="submit" value="SIMPAN" />
					<input type="button" value="BATAL" onclick="window.location='../stuff/index.php'" />
				</p>
			</div>
			</form>
		<?php endif; ?>
	<?php else: ?>
		<div class="info">
			<h3><?php echo message::getMsg('searchSuccess') ?></h3>
		</div>		
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
