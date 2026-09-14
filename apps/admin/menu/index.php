<?php include '../menu/indexRead.php' ?>
<hr />
<table width="100%">
	<tr>
		<td width="<?php echo substr($_SESSION['loginPrivilage'],6,1) == '1' ? '70%' : '75%' ?>" valign="top">
			<div id="smoothmenu" class="ddsmoothmenu">						    		
				<ul>
					<?php if(substr($_SESSION['loginPrivilage'],0,1) == '1'): ?>
						<li><a href="../home/index.php">Home</a></li>								
					<?php endif; ?>	
					<?php if(substr($_SESSION['loginPrivilage'],1,1) == '1'): ?>
					<li>
						<a href="#">Referensi</a>
						<ul>
							<li><a href="../fund/index.php">Sumber Dana</a></li>										
							<li><a href="../location/index.php">Lokasi</a></li>	
							<li><a	 href="../departement/index.php">Departemen</a></li>											
						</ul>
					</li>		
					<?php endif; ?>

					<?php if(substr($_SESSION['loginPrivilage'],2,1) == '1'): ?>
					<li>
						<a href="#">Asset</a>
						<ul>
							<li><a href="../stuffView/index.php">Asset</a></li>									
							<li><a href="../depriciation/index.php">Penyusutan</a></li>								
							<li><a href="../stuffSeriesHistory/index.php">Riwayat</a></li>
						</ul>			
					</li>
					<?php endif; ?>


					<?php if(substr($_SESSION['loginPrivilage'],3,1) == '1'): ?>					
					<li>
						<a href="#">Asset</a>
						<ul>
							<li><a href="../category/index.php">Kategori</a></li>										
							<li><a href="../stuff/index.php">Asset</a></li>	
							<li><a href="../depriciation/index.php">Penyusutan</a></li>								
						</ul>
					</li>
					<?php endif; ?>

					<?php if(substr($_SESSION['loginPrivilage'],4,1) == '1'): ?>					
					<li>
						<a href="#">Asset Seri</a>
						<ul>
							<li><a href="../stuffSeriesUpdate/index.php">Pembaharuan</a></li>
							<li><a href="../stuffSeriesMove/index.php">Pemindahan</a></li>							
							<li><a href="../stuffSeriesRepair/index.php">Perbaikan</a></li>														
							<li><a href="#">Pemusnahan</a>
								<ul>
									<li><a href="../stuffSeriesActive/index.php">Asset Aktif</a></li>							
									<li><a href="../stuffSeriesRemove/index.php">Asset Musnah</a></li>										
								</ul>
							</li>
							<li><a href="../stuffSeriesHistory/index.php">Riwayat</a></li>
							<li><a href="../stuffSeriesLastNo/index.php">Info Nomor seri</a></li>							
						</ul>
					</li>							
					<?php endif; ?>

					<?php if(substr($_SESSION['loginPrivilage'],5,1) == '1'): ?>					
					<li>	
						<a href="#">Laporan</a>
						<ul>
							<li><a href="../reportAssetValue/index.php">Nilai & Jumlah Asset</a></li>	
							<li><a href="../reportAssetLocation/index.php">Lokasi Asset</a></li>
							<!--
							<li><a href="../reportAssetFund/index.php">Sumber Dana Asset</a></li>
							-->
							<li><a href="../reportAssetCondition/index.php">Kondisi Asset</a></li>								
							<li><a href="../reportAssetTransaction/index.php">Asset Transaksi</a></li>								
						</ul>
					</li>	
					<?php endif; ?>		
				</ul>
			</div>
		</td>	
		<td valign="top">
			<div class="ddsmoothmenu">						    		
				<ul>
					<?php if(substr($_SESSION['loginPrivilage'],6,1) == '1'): ?>
						<li><a href="../member/index.php">Member</a></li>		
					<?php endif; ?>
					<?php if(substr($_SESSION['loginPrivilage'],7,1) == '1'): ?>					
						<li><a href="../changePassword/edit.php">Ubah Password</a></li>																
					<?php endif; ?>
					<?php if(substr($_SESSION['loginPrivilage'],8,1) == '1'): ?>					
						<li><a href="../login/signout.php">Logout</a></li>
					<?php endif; ?>			
				</ul>
			</div>
		</td>
	</tr>
</table>
<hr />
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

