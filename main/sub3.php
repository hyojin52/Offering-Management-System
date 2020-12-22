<?	
	include "./inc/top.php";
?>
<script>
	//페이지 로드시 자바스크립트 실행
	window.onload = pageLoad("menu3");
</script>
<link rel = "stylesheet" type="text/css" href="./css/sub3.css">
<div id = "DayTrendWrapper">
	<div class = "HeadWrapper HeadWrapperRelative">
		<h3 class = "trend">일별 트렌드</h3>
		<div class="trendFromAbsolute">
			<form class = "HeadWrapperContent" action="" method="POST">
				<input type="date" name="day" id="day" value="<?php echo date("2017-05-02"); ?>">
				<input type="submit" name="showDay" value="보기">
		</div>
	</div>
	<hr>
	
	<div id = "DayTrendContentWrapper" style="width:75%;">
		<canvas id="dayTrend"></canvas>
	</div>
</div>

<div id = "MonthTrendWrapper">
	<div class = "HeadWrapper HeadWrapperRelative">
		<h3 class = "trend">월간 트렌드</h3>
		<div class="trendFromAbsolute">
				<input type="month" name="month" id="month" value="<?php echo date("2017-05");?>"><!--php echo date("Y-m");?>-->
				<input type="submit" name="showMonth" value="보기">
			</form>
		</div>
	</div>
	<hr>
	<div id = "MonthTrendContentWrapper">
		<canvas id="monthTrend"></canvas>
	</div>
<div>

<?
	//first setting
	getTrendInfo();
?>

<?	
	if(isset($_POST["showMonth"])){
		$firstDay = $_POST['month']."-01";
		getDayInfo($firstDay);
		getMonthInfo($firstDay);
    }
	if(isset($_POST["showDay"])){
		getDayInfo($_POST['day']);
		getMonthInfo($_POST['day']);
    }
?>

<?
	include "./inc/bottom.php";
?>
