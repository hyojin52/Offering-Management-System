<?
	require_once "./inc/functions.php";

	$data0 = getTotalInfo0();
?>
<script>
    function pageLoad(id){document.getElementById(id).style.backgroundColor="rgb(176,216,141)";}
</script>

<html>
	<head>
		<title>ENERGUARD SYSTEM</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
		<link rel = "stylesheet" type="text/css" href="./css/main.css?v=1.0">
<!-- 		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script> -->
		<script src="./js/Chart.js"></script>
	    <script src="./js/util.js"></script>
	    <script src="./js/chart.bundle.js"></script>
		<script src="./js/jquery-3.3.1.js"></script>
	</head>

	<body>
		<div class="box">
			<!--box_menu-->
			<div class="box_menu">
				<div class="mainTitle">
					<img src="./img/EnerGuard_Green.png" class="logo">
					<p class="company"> | <?=$data0[0]?></p>
				</div>

				<div class="menu">
				<ul> 
					<li id="menu1"><a href="./main.php"><i class="fa fa-home"></i>메인</a></li>
					<li id="menu2"><a href="./sub2.php"><i class="fa fa-chart-pie"></i> 계통도</a></li>
					<li id="menu3"><a href="./sub3.php"><i class="fa fa-chart-line"></i> 트렌드</a></li>
					<li id="menu4"><a href="./sub4.php"><i class="fa fa-file-alt"></i> 리포트</a></li>
				</ul>
				</div>
			 </div>
