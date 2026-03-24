<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1 align="align:center"><center>PUSAT INFORMASI ASSET</b></center></h1>
	<br />

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<?php if(strlen($msgError['id']) > 0) : ?>
	 	<div class="error">
			<h3><?php echo $msgError['id'] ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<form action="index.php" method="post">
			<center>
				<table width="70%" border="0">		
					<tr>
						<td width="30%"><b>NOMOR SERI ASSET</b></td>
						<td>
							<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/>						
							<input type="submit" value=" CARI " name="filter" />
							<b><small>[ <a href="../admin/home/index.php">Login Sebagai Pengguna</a> ]</small></b>	
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><hr /><small>Silakan masukan no seri asset, <br />contoh: 00001-0002 atau 00001/0002 atau 000010002</small></td>
					</tr>
				</table>
			</center>			
		</form>
	</fieldset>
	<p></p>
	<?php if(isset($_REQUEST['keyword'])): ?>
		<?php if(mysql_num_rows($data) < 1) : ?>
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
						<th align="center" width="17%">ASSET</th>						
						<th align="center" width="27%">LOKASI / DANA</th>
						<th align="center" width="17%">MERK / KONDISI</th>
						<th align="center" width="23%">HARGA</th>	
						<th align="center" width="">TGL BELI</th>
					</tr>	
				</thead>
				<tbody>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="left" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td colspan="5" style="border: 0px; padding:0px"><b><small><?php echo $val['asset_name'] ?></small></b><br /></td>
									</tr>	
									<tr>
										<td width="40%" style="border: 0px; padding:0px"><small>No Seri</small></td>
										<td style="border: 0px; padding:0px">
											<b>: <small>
												<?php if(strlen($val['foto']) > 0 ): ?>
													<a href="../admin/asset/foto/<?php echo $val['foto'] ?>" class="lightbox" title="<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>">
														<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>			
													</a>	
												<?php else: ?>
													<?php echo $val['code'] ?>-<?php echo $val['no_serries'] ?>			
												<?php endif; ?>												
											</small>
											</b>	
										</td>														
									</tr>
									<tr>
										<td style="border: 0px; padding:0px"><small>No Beli</small></td>
										<td style="border: 0px; padding:0px"><b>: <small><?php echo $val['no_purchase'] ?> </small></td></b>														
									</tr>
								</table>
							</td>
							<td align="center"  valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="35%" style="border: 0px; padding:0px"><small>Lokasi</small></td>
										<td style="border: 0px; padding:0px"><b>: <small><?php echo $val['location_name'] ?></small></b></td>														
									</tr>
									<tr>
										<td style="border: 0px; padding:0px"><small>Sumber Dana</small></td>
										<td style="border: 0px; padding:0px"><b>: <small><?php echo $val['fund_name'] ?></small></b></td>														
									</tr>
									<tr>
										<td width="18%" style="border: 0px; padding:0px"><small>Departemen</small></td>
										<td style="border: 0px; padding:0px"><b>: <small><?php echo $val['departement_name'] ?></small></b></td>														
									</tr>
								</table>
							</td>
							<td align="center" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="35%" style="border: 0px; padding:0px" valign="top"><small>Kondisi</small></td>										
										<td style="border: 0px; padding:0px">
											<small>
											<b> :
												<?php if($val['cond'] == '0'): ?>
													RUSAK
												<?php endif; ?>		

												<?php if($val['cond'] == '1'): ?>
													BAIK
												<?php endif; ?>		

												<?php if($val['cond'] == '2'): ?>
													SETENGAH BAIK
												<?php endif; ?>		
											</b>			
											</small>
										</td>
									</tr>
									<tr>
										<td style="border: 0px; padding:0px"><small>Merk</small></td>
										<td style="border: 0px; padding:0px"><b>: <small><?php echo $val['merk'] ?></small></b></td>														
									</tr>
								</table>																							
							</td>
							<td align="center" valign="top">
								<table width="100%" style="border: 0px">
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Harga Beli</small></td>										
										<td style="border: 0px; padding:0px">
											<b><small> : <?php echo number_format($val['price_buy'], 0 , '' , '.')  ?></small></b>
										</td>
									</tr>
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Harga Skrg</small></td>										
										<td style="border: 0px; padding:0px">
											<b><small> : <?php echo number_format($val['price'], 0 , '' , '.')  ?></small></b>
										</td>
									</tr>
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Harga Min</small></td>										
										<td style="border: 0px; padding:0px">
											<b><small> : <?php echo number_format($val['price_min'], 0 , '' , '.')  ?></small></b>
										</td>
									</tr>
									<tr>
										<td width="40%" style="border: 0px; padding:0px" valign="top"><small>Penyusutan</small></td>										
										<td style="border: 0px; padding:0px">
											<b><small> : <?php echo number_format($val['depriciation'], 0 , '' , '.')  ?>/Tahun</small></b>
										</td>
									</tr>
								</table>																							
							</td>
							<td valign="top" align="center">
								<small><?php echo $val['date_buy'] ?></small>		
								<div class="button">
									[<a href="history.php?id=<?php echo $val['id'] ?>"  data-title="RIWAYAT ASSET" data-width="600" data-height="550">Riwayat Asset</a>]
								</div>
							</td>	
						</tr>	
					<?php endwhile; ?>
				<tbody>
			</table>
			<?php endif; ?>
	<?php else: ?>
		<div class="info">
			<h3><center>Silakan masukan No Seri Asset</center></h3>
		</div>		
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
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>

<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
