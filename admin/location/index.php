<?php include 'indexRead.php' ?>

<?php ob_start(); ?>
	<h1>LOKASI</h1>

	<hr />
	<p>
	  <b>LOKASI : </b> 
	  <a href="index.php">Induk</a> 

	  <?php $count = count($dataBreadcums)-1 ?>
	  <?php $breadcumbLevel = 2 ?>	
	  <?php for($j=$count; $j>=0; $j--): ?>
		  >> <a href="index.php?level=<?php echo $breadcumbLevel ?>&parentId=<?php echo $dataBreadcums[$j][0] ?>"><?php echo $dataBreadcums[$j][1] ?></a> 		
	  <?php $breadcumbLevel++ ?>	
	  <?php endfor; ?>			
	</p>
	<hr />
	<br />

	<?php if(isset($_GET['msg'])) : ?>
	 	<div class="<?php echo substr_count($_GET['msg'],'Success') > 0 ? 'info' : 'error' ?>">
			<h3><?php echo message::getMsg($_GET['msg']) ?></h3>
		</div>		
	<?php endif ?>

	<p><input type="button" value="TAMBAH" onclick="window.location='add.php?level=<?php echo $level ?>&parentId=<?php echo $parentId ?>'" /></p>

	<?php if(mysql_num_rows($data) < 1) : ?>
	 	<div class="warning">
			<h3><?php echo message::getMsg('emptySuccess') ?></h3>
		</div>		
	<?php else: ?>
		<div id="tbl">
			<table width="100%">
				<thead>			
					<tr>
						<th align="center" width="5%">NO</th>
						<th align="center" width="25%">NAMA</th>	
						<th align="center" width="25%">LUAS</th>	
						<th align="center" width="15%">STATUS</th>
						<th align="center"></th>
					</tr>	
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php while($val = mysql_fetch_array($data)): ?>
						<tr>
							<td valign="top" align="center"><?php echo $i ?></td>
							<td valign="top">
								<?php echo $val['name'] ?><br />
								<small><?php echo $val['alias'] ?></small>
							</td>	
							<td><?php echo $val['size'] ?></td>
							<td align="center">
							   <?php if($val['status'] == 0): ?>	
								<span style="color:red">TIDAK DIGUNAKAN</span>
							   <?php else: ?>
								DIGUNAKAN
							   <?php endif; ?>				
							</td>			
							<td  valign="top" align="center">
								<?php if($level < 3): ?>
									<input type="button" value="SUB LOKASI" onclick="window.location='index.php?level=<?php echo $level+1 ?>&parentId=<?php echo $val['id'] ?>'" />
								<?php endif; ?>		
								<input type="button" value="EDIT" onclick="window.location='edit.php?id=<?php echo $val['id'] ?>&level=<?php echo $level ?>&parentId=<?php echo $parentId ?>'" />
								<input type="button" value="HAPUS" onclick="confirm('Anda yakin akan menghapus ?') ? window.location='delete.php?id=<?php echo $val['id'] ?>&level=<?php echo $level ?>&parentId=<?php echo $parentId ?>' : false" />
							</td>
						</tr>	
					<?php $i++; ?>
					<?php endwhile; ?>
				<tbody>
			</table>
		</div>
	<?php endif; ?>
<?php $templateContent = ob_get_contents(); ?>
<?php ob_end_clean(); ?>

<?php include '../template/main.php' ?>
