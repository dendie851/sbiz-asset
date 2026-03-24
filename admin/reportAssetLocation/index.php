<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1>LAPORAN LOKASI ASSET</h1>
	
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
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="post">
			<table width="100%">		
				<tr>
					<td width="14%">LOKASI</td>
					<td>
						<select name="locationId" style="width:245px">
							<option value="x">SEMUA</option>
							<?php foreach($dataLocationCmb as $val): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['locationId']) ? $_REQUEST['locationId'] : $data['locationId']) ? 'selected' : '' ?>><?php echo $val['name'] ?> <?php echo $val['alias'] ?></option>
							<?php endforeach; ?>
						</select>
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
	<?php if(isset($_REQUEST['filter'])): ?>
		<?php if(mysql_num_rows($data) < 1) : ?>
			<div class="warning">
				<h3><?php echo message::getMsg('emptySuccess') ?></h3>
			</div>		
		<?php else: ?>
			<table width="100%">
				<tr>
					<td style="text-align:right">
						<input type="button" onclick="window.open('excel.php?locationId=<?php echo $_REQUEST['locationId'] ?>')" value="PRINT TO EXCEL">
						<input type="button" onclick="window.open('print.php?locationId=<?php echo $_REQUEST['locationId'] ?>')" value="PRINT">
					</td>
				</tr>
			</table>
			<form action="editSave.php" method="post">
				<input name="keyword" type="hidden" value="<?php echo $_REQUEST['keyword']?>" size="1" maxlength="4" />
			<div id="tbl">
				<table width="100%" border="1">
					<thead>			
						<tr>					
							<th align="center" width="5%">NO</th>	
							<th align="center" width="25%">LOKASI</th>							
							<th align="center" width="13%">KODE ASSET</th>							
							<th align="center" width="15%">NAMA ASSET</th>
							<th align="center" width="8%">JML</th>
							<th align="center" >NO SERI ASSET</th>							
						</tr>	
					</thead>
					<tbody>
						<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
						<?php $locationIdDump = '' ?>
						<?php while($val = mysql_fetch_array($data)): ?>
							<tr>	
								<?php if($val['location_id'] == $locationIdDump): ?>
									<td align="left" colspan="2">&nbsp;</td>
								<?php else: ?>
									<?php $locationIdDump =  $val['location_id'] ?>
									<td align="center">
										<?php echo $i ?>
									</td>									
									<td align="left">
										<?php echo $dataLocation[$val['location_id']]?>
										<p>
											<small>[ <a href="#" onclick="window.open('printCard.php?locationId=<?php echo $val['location_id'] ?>')">PRINT KARTU ASSET</a> ]</small><br />
											<small>[ <a href="#" onclick="window.open('printCardExcel.php?locationId=<?php echo $val['location_id'] ?>')">EXPORT KARTU ASSET to Excel</a> ]</small>											
										</p>	
									</td>	
									<?php $i++; ?>
								<?php endif; ?>
								<td align="center" valign="top">
									<?php if(strlen($val['foto']) > 0 ): ?>
										<a href="../asset/foto/<?php echo $val['foto'] ?>" class="lightbox" title="<?php echo $val['code'] ?>">
											<?php echo $val['code'] ?>	
										</a>	
									<?php else: ?>
										<?php echo $val['code'] ?>			
									<?php endif; ?>
								</td>
								<td align="center"  valign="top">		
									<?php echo $val['asset_name'] ?><br />
									<small>(<?php echo $val['category_name'] ?>)</small>
								</td>								
								<td align="center">
									<?php echo $val['jml'] ?>
								</td>									
								<td align="left">
									<?php include '../../lib/connection.php'; ?> 
										<?php
											$query = "select no_serries, cond												  
												from asset_series as ase
												  where 1=1
													and ase.is_delete = '0'
													and ase.is_remove = '0'
													and asset_id = '{$val['asset_id']}'
													and location_id = '{$val['location_id']}'
													and ase.departement_id in ($loginAccessDepartement)
													and ase.fund_id in ($loginAccessFund)		   	
												  order by no_serries";	
												  
											$tmp = mysql_query($query) or die (mysql_error());										
										?>											
									<?php include '../../lib/connection-close.php'; ?>
									<small>
									<?php while($valAssetSerires = mysql_fetch_array($tmp)): ?>
										<?php echo $val['code'] ?>-<?php echo $valAssetSerires['no_serries'] ?> 
										(<?php if($valAssetSerires['cond'] == '0'): ?>R<?php endif; ?><?php if($valAssetSerires['cond'] == '1'): ?>B<?php endif; ?><?php if($valAssetSerires['cond'] == '2'): ?>SB<?php endif; ?>),
									<?php endwhile; ?>
									</small>
								</td>		
							</tr>	
						<?php endwhile; ?>
					<tbody>
				</table>
			</div>				
			</form>
		<?php endif; ?>
	<?php else: ?>
		<div class="info">
			<h3>Silakan memilih lokasi terlebih dahulu</h3>
		</div>		
	<?php endif; ?>		

	<script type="text/javascript">
	$(document).ready(function() {
		$(function() {
				$( "#dateMove" ).datepicker({
					dateFormat : 'dd/mm/yy',
					changeMonth : true,
					changeYear : true,
					yearRange: '-20y:+0y'
				}); 

				$("#dateMove" ).datepicker("setDate",new Date());
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
	$(function() {
		$('a.lightbox').lightBox();
	});
	</script>	
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>	
