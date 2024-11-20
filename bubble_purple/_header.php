<?php 
	require_once('_functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bubble Purple | Dashboard</title>
	<link rel="stylesheet" href="<?=url('_assets/css/style.css')?>">
	<link rel="shortcut icon" href="<?=url('_assets/img/logo/logo.png')?>" type="image/x-icon">
</head>
<body>

	<header>
		<nav>
			<div class="logo">
				<a href="<?=url()?>">
					<img src="<?=url('_assets/img/logo/logo.png')?>" alt="bubble purple Logo">
				</a>
			</div>
			<ul class="nav-menu">
				<li>
					<span id=""><?= ucfirst($_SESSION['master']) ?></span>
					<ul class="dropdown-menu">
						<li><a href="<?=url('about.php')?>">Tentang Kami</a></li>
						<li><a href="<?=url('logout.php')?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<div id="nav-mini">
			<a href="<?=url('')?>" class="link-nav">Riwayat Transaksi</a>
			<a href="<?=url('')?>" class="link-nav">Manage Karyawan</a>
			<a href="<?=url('')?>" class="link-nav">Daftar Paket</a>
		</div>
	</header>