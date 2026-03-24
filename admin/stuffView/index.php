<?php ob_start(); ?>
	<link rel="stylesheet" type="text/css" media="screen" href="../asset/css/jquery.lightbox-0.5.css" />

	<?php include 'indexRead.php' ?>

	<h1>ASSET</h1>

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="info">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<fieldset>
		<legend><b>FILTER</b></legend>
		<form action="index.php" method="get">
			<table width="100%">
				<tr>
					<td width="15%">KATEGORI</td>
					<td>
						<select name="categoryId" style="width:180px">
							<option value="x">-- Semua --</option>
							<?php while($val = mysql_fetch_array($dataCategory)): ?>
								<option value="<?php echo $val['id'] ?>" <?php echo $val['id'] == (isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : '') ? 'selected' : '' ?>><?php echo $val['name'] ?></option>
							<?php endwhile; ?>
						</select>				
					</td>
				</tr>			
				<tr>
					<td>NAMA BARANG</td>
					<td>
						<input name="keyword" type="text" value="<?php echo $_REQUEST['keyword'] ?>" style="width:180px"/><br />
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
	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%" border="1">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="20%">KODE ASSET</th>						
						<th align="center" width="25%">NAMA ASSET</th>
						<th align="center" width="20%">UKURAN</th>
						<th></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i = isset($_REQUEST['SplitRecord']) ? $_REQUEST['SplitRecord'] + 1  : 1  ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td align="center"><?php echo $i ?></td>
							<td align="center">
								<big><b><?php echo $val['code'] ?></b></big><br />
								<?php if(strlen($val['foto_thumb']) > 0 ): ?>
									<a href="../asset/foto/<?php echo $val['foto'] ?>" class="lightbox" title="<?php echo $val['name'] ?>">
										<image src="../asset/foto/<?php echo $val['foto_thumb'] ?>"  border="1" width="75"/>
									</a>	
								<?php else: ?>
									<image src="../asset/image/no-photo.gif"  border="1" width="75" heigth="75"/>	
								<?php endif; ?>
							</td>
							<td align="center">
								<?php echo $val['name'] ?><br />	
								<small style="font-size:9px; padding-left:5px">(<?php echo $val['category_name'] ?>)</small>	
							</td>
							<td align="center">
								<?php echo $val['size'] ?>
							</td>		
							<td align="center">
								<input type="button" value="NOMOR SERI ASSET" onclick="window.location='../stuffSeriesView/index.php?id=<?php echo $val['id'] ?>'" />							
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
			<p style="text-align:center; padding:10px">
				<?php
					echo $split->splitPage($_GET['SplitLanjut'],array('keyword='.$_REQUEST['keyword'],'status='.$_REQUEST['status'],'categoryId='.$categoryId));
					echo '<br /><br />';
					echo 'Hal <b>',$split->NoPage($_GET['SplitRecord']),'</b> dari <b>',$split->totalPage().'</b>';
				?>
			</p>	
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
