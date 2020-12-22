<?
	include "./inc/top.php";
	$type = $_POST['type'];
?>

<link rel = "stylesheet" type="text/css" href="./css/sub4.css">
<script>
	//페이지 로드시 자바스크립트 실행
	window.onload = pageLoad("menu4");

	//시간별, 일별, 월별에 따른 데이터 선택하기
	function showTime(){
		document.getElementById('selectTime').style.display = "inline-block";
		document.getElementById('selectMonth').style.display = "none";
		document.getElementById('selectDay').style.display = "none";
	};
	function showDay(){
		document.getElementById('selectTime').style.display = "none";
		document.getElementById('selectMonth').style.display = "none";
		document.getElementById('selectDay').style.display = "inline-block";
		
	};
	function showMonth(){
		document.getElementById('selectTime').style.display = "none";
		document.getElementById('selectMonth').style.display = "inline-block";
		document.getElementById('selectDay').style.display = "none";
	};

</script>

<div id = "OperatingReportWrapper">
	<div id = "OperatingHeadRelative">
		<div id ="OperatingHead">
			<h3 id = "report">운영 리포트</h3>
		</div>
		<div id = "OperatingHeadAbsolute1">
			<input type="button" id = "excel" value="엑셀 추출" onclick="location.href = './inc/export_excel.php';">
		</div>
	</div>
	<hr id = "sub4_hr">
	
	<div id = "OperatingReportContentWrapper">	
		<div id = "selectWrapper">
			<form id = "select1" method="POST" action="">
				<div id="ORCselect1Content">
					<input type="radio" name="type" onclick = "showTime()" value="time" checked> 시간별
					<input type="radio" name="type" onclick = "showDay()" value="day" <? if($type == 'day') echo " checked"; ?>> 일별
					<input type="radio" name="type" onclick = "showMonth()" value="month" <? if($type == 'month') echo " checked"; ?>> 월별	
				</div>
			
				<div id = "ORCselect2Content">
					<h4> 검색 일자 :
						<div id="selectTime">
							<input type="datetime-local" name="date1" id="search1" 
							value="<?php echo '2018-05-24T11:42';?>">-
							<input type="datetime-local" name="date2" id="search2" 
							value="<?php echo '2018-05-24T11:42';?>">
							<input type="submit" name="searchTime" value="검색">
						</div>
						<div id="selectDay">
							<input type="date" name="date1" id="search1"
							value="<?php echo '2018-05-24';?>">-
							<input type="date" name="date2" id="search2"
							value="<?php echo '2018-05-24';?>">
							<input type="submit" name="searchDay" value="검색">
						</div>
						<div id="selectMonth">
							<input type="month" name="date1" id="search1"
							value="<?php echo '2018-05';?>">-
							<input type="month" name="date2" id="search2"
							value="<?php echo '2018-05';?>">
							<input type="submit" name="searchMonth" value="검색">
						</div>
					</h4>
				</div>
			</form>

			
		</div>
	
	
		<div class="report_chart">

			<div class="report_list">

				<? 

						if(isset($_POST["searchTime"])){
							getReportInfo($_POST['date1'], $_POST['date2']);
						} 
						else if(isset($_POST["searchDay"])){
							getReportInfo($_POST['date1'], $_POST['date2']);
						}
						else if(isset($_POST["searchMonth"])){
							getReportInfo($_POST['date1'], $_POST['date2']);
						}
						else{
							getReportInfo("2018-05-24T11:42", "2018-05-24T11:42");
						}
					
				?>
				
			</div>
		</div> <!-- report chart -->		
	</div> <!-- OperatingReportContentWrapper -->
</div> <!-- OperatingReportWrapper -->


<?
	include "./inc/bottom.php";
?>