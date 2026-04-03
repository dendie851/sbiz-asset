<?php
include '../login/auth.php';
include '../../lib/connection.php';
include '../../lib/message.class.php';

$query = "select id,name
		from fund
		where is_delete = '0'
			and id in ($loginAccessFund)
		order by name";
$dataFund = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select id,name
		from fund
		where is_delete = '0'
			and id in ($loginAccessFund)
		order by name";
$dataItem = mysqli_query($con, $query) or die(mysqli_error($con));

$query = "select ah.id, asset_series_id, date, date_format(date,'%d %M %Y') as format_date, type, decription,ase.no_serries,
			(select a.code from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) no_asset,
			(select a.name from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_name,
			(select a.code from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_id,
			(select a.foto from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_foto,
			(select a.foto_thumb from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id)) asset_foto_thumb,						
			(select name from category as c where c.id = (select a.category_id from asset as a where id = (select ase.asset_id id from asset_series as ase where ase.id = ah.asset_series_id))) category_name
		from asset_history as ah
		inner join asset_series as ase
			on ase.id = ah.asset_series_id
			and ase.departement_id in ($loginAccessDepartement)
		    and ase.fund_id in ($loginAccessFund)
		order by date desc
		limit 0,30 ";

$dataHistory = mysqli_query($con, $query) or die(mysqli_error($con));

include '../../lib/connection-close.php';
?>