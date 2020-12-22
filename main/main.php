<?
	require_once "./inc/top.php";
?>

<!--query로부터 받아오기-->
<? 
	$data0 = getTotalInfo0();
	$data1 = getTotalInfo1();
	$data2 = getTotalInfo2();
	$data3 = getTotalInfo3();
	$data4 = getTotalInfo4();
	$data5 = getTotalInfo5();
	$data6 = getTotalInfo6();
?>
<? echo "
	<SCRIPT LANGUAGE='JavaScript'>
	
		//페이지 로드시 자바스크립트 실행
		window.onload = pageLoad('menu1');

		function showChart(id, data){
			var ctx = document.getElementById(id);
			// And for a doughnut chart
			var myDoughnutChart = new Chart(ctx, {
				type: 'doughnut',
				data: data,
				options: {
					rotation: 1 * Math.PI,
					circumference: 1 * Math.PI
				}
			});
		}
		function pieChart1(){
			var data = {
				labels: ['발전량'],
				datasets: [
				{
					data: [$data1[1],$data0[1]-$data1[1]],
					backgroundColor: [
					'#5072b0',
					'#a8b9d8']
				}]
			};
			showChart('generation', data);
		}

		function pieChart2(){
			var data = {
				labels: ['충전량'],
				datasets: [
				{
					data: [$data1[2],$data0[2]-$data1[2]],
					backgroundColor: [
					'#72a053',
					'#b9d0a9']
				}]
			};
			showChart('charge', data);
		}

		function pieChart3(){
			var data = {
				labels: ['방전량'],
				datasets: [
				{
					data: [$data1[2],$data0[2]-$data1[2]],
					backgroundColor: [
					'#f2a101',
					'#f9d080']
				}]
			};
			showChart('discharge', data);
		}

		function setWidth(id, val, length){
			var width = 0;
			if(val != 0){width = length*(val/100);} 
			width = width+'px'; 
			//window.alert('width: '+width);
			document.getElementById(id).style.width = width;
		}

		function setValue(id, val, total){
			var value;
			value = 100*(val/total); 
			value = value + '%';
			//alert('value: '+value);
			$('#id').text(value);
		}

		function addZero(i) {
			if (i < 10) {
				i = '0' + i;
			}
			return i;
		}

		setInterval(
			function getTime() {
				var d = new Date();
				var x = document.getElementById('localTime');
				var h = addZero(d.getHours());
				var m = addZero(d.getMinutes());
				var s = addZero(d.getSeconds());

				if (h < 12)	x.innerHTML = h + ':' + m + ':' + s+'am';
				else	 x.innerHTML = h + ':' + m + ':' + s+'pm';
			}
		, 1000);

	</SCRIPT>" 
?>

			<div class="getDataTime">
				<i class="fas fa-retweet" style="color:black;"></i>&nbsp;데이터 수신 시간 : <?=$data1[0]?>
			</div>
			<div class="box_content">
				<!--효진 left-->
				<div class="containerLeft">
					<div class="title content">
						<h2 class="subTitle">운전 정보</h2>
						<hr>
					</div>
					<div class="notESS content">
						<div class="time content">
							<div class="time01"><i class="fa fa-clock fa-3x"></i></div>
							<div class="time02">
								<h4>&nbsp;&nbsp;&nbsp;
									<?php 
										echo date("Y-m-d");
										echo "<br>";
									?>
								</h4>	
								<h2>
									<!--<?php 
										date_default_timezone_set("Korea/Seoul");
										echo date("h:i:sa");
									?>-->
									<p id="localTime"></p>
								</h2>
							</div>
						</div>

						<div class="capacity content">
							<h4><i class="fas fa-arrow-circle-right"></i>&nbsp;설치용량 <span class="right"><?=$data0[2]?>kw</span></h4>
						</div>

						<div class="PMS content">
							<h4><i class="fas fa-arrow-circle-right"></i>&nbsp;PMS 통신 <span class="right green"><?=$data1[6]?></span></h4>
						</div>

						<div class="PCS content">
							<h4><i class="fas fa-arrow-circle-right"></i>&nbsp;PCS 통신 <span class="right green"><?=$data1[7]?></span></h4>
						</div>
					</div>

					<div class="ESS content">
						<h4><i class="fas fa-arrow-circle-right"></i>&nbsp;ESS </h4>
						<ul>
							<li>
								<i class="fa fa-caret-down"></i>&nbsp;일 누적 충전량<span id="ESS_AccumCharge" class="right bold"><?=$data1[9];?>Kw</span>
								<div class="ESS_AccumChargeWrapper">
									<div class="ESS_AccumChargeRelative">
										<div id="ESS_AccumChargeAbsolute01" class="ESS_AccumChargeAbsolute01"></div>
										<div 
										id="ESS_AccumChargeAbsolute02" class="ESS_AccumChargeAbsolute02"></div>
									</div>
									<div class="ESS_LRWrapper">
										<div class="ESS_Left">0</div>
										<div class="ESS_Right"><?=$data0[2]?></div>
										<div class="ESS_Right">&#8251;&nbsp;전일 동시간대 <span class="ESSyellow"><?php echo "181.0kW";?></span></div>
									</div>
								</div>
							</li>
							<li>
								<i class="fa fa-caret-down"></i>&nbsp;배터리 SOC
								<div class="ESS_BatteryWrapper">
									<div class="ESS_BatteryRelative">
										<div id="ESS_BatteryAbsolute01" class="ESS_BatteryAbsolute01"></div>
										<div id="ESS_BatteryAbsolute02" class="ESS_BatteryAbsolute02"><?=$data1[8];?></div>
										<div class="ESS_BatteryAbsolute03"></div>
									</div>
								</div>
							</li>

							<li>
								<table class="weather content">
									<tr>
										<th>온도 #1</th>
										<th>온도 #2</th>
										<th>습도</th>
									</tr>
									<tr>
										<td><i class="fas fa-thermometer-empty"></i>&nbsp;<?=$data1[3]?>&#176;C</td>
										<td><i class="fas fa-thermometer-empty"></i>&nbsp;<?=$data1[4]?>&#176;C</td>
										<td><i class="fas fa-tint"></i>&nbsp;<?=$data1[5]?>%</td>
									</tr>
								</table>
							</li>
						</ul>
					</div>
				</div>

				<div class="containerRight">

					<!--경진 right-->
					<div class="realWrapper">
						<div class="real1">
							<h3 class="subTitle">실시간 발전량</h3>
							<hr style="background-color:#5072b0;">
							<canvas id="generation" width="100"  height="50"></canvas>
							
							<p class="result"><span style="color:#5072b0"><?=$data1[1]?></span>&nbspkW<p>
							<p class="before"><span class="gray">전일 동시간대</span>&nbsp<span class="yellow"><?=$data2[1]?>kW</span><p>

						</div>

						<div class="real2">
							<h3 class="subTitle">실시간 충전량</h3>
							<hr style="background-color:#72a053;">
							<canvas id="charge" width="100" height="50"></canvas>
							
							<p class="result"><span style="color:#72a053"><?=$data1[2]?></span>&nbspkW<p>
							<p class="before"><span class="gray">전일 동시간대</span>&nbsp<span class="yellow"><?=$data2[2]?>kW</span><p>
						</div>

						<div class="real3">
							<h3 class="subTitle">실시간 방전량</h3>
							<hr style="background-color:#f9d080;">
							<canvas id="discharge" width="100" height="50"></canvas>
							<p class="result"><span style="color:#f2a101"><?=$data1[2]?></span>&nbspkW<p>
							<p class="before"><span class="gray">전일 동시간대</span>&nbsp<span class="yellow"><?=$data2[2]?>kW</span><p>
						</div>
					</div>
					

					<!--혜영 bottom-->
					<div class = "performanceWrapper">	
						<div class = "performance"> 
							<h3 class="subTitle">운전 실적</h3>
							<hr style="background-color:#424242;">
						</div>
						
						<div class = "performanceContentWrapper">
							<div class = "PC2">
								<div class = "PC2-1">
									<img src ="./img/solar-panel.png" alt="solar_panel" width = "100px" height = "100px">
								</div>
								
								<div class = "PC2-2">
									<table class="PCtable">
										<tr>
											<th>전일 발전량</th>
											<td><?=$data3[1]?> kW</td>
										</tr>
										<tr>
											<th>당일 발전량</th>
											<td><?=$data4[1]?> kW</td>
										</tr>
										<tr>
											<th>당월 발전량</th>
											<td><?=$data5[1]?> MW</td>
										</tr>
										<tr>
											<th>누적 발전량</th>
											<td><?=$data6[0]?> MW</td>
										</tr>
									</table>
								</div>

							</div>

							<div class = "PC3">
								<div class = "PC3-1">
									<img src ="./img/charge.png" alt="charge" width = "100px" height = "100px">
								</div>
								
								<div class = "PC3-2">
									<table class="PCtable">
										<tr>
											<th>전일 충전량</th>
											<td><?=$data3[2]?> kW</td>
										</tr>
										<tr>
											<th>당일 충전량</th>
											<td><?=$data4[2]?> kW</td>
										</tr>
										<tr>
											<th>당월 충전량</th>
											<td><?=$data5[2]?> MW</td>
										</tr>
										<tr>
											<th>누적 충전량</th>
											<td><?=$data6[1]?> MW</td>
										</tr>
									</table>
								</div>
							</div>	

							<div class = "PC4">
								<div class = "PC4-1">
									<img src ="./img/discharge.png" alt="discharge" width = "100px" height = "100px">
								</div>
								
								<div class = "PC4-2">
									<table class="PCtable">
										<tr>
											<th>전일 방전량</th>
											<td><?=$data3[3]?> kW</td>
										</tr>
										<tr>
											<th>당일 방전량</th>
											<td><?=$data4[3]?> kW</td>
										</tr>
										<tr>
											<th>당월 방전량</th>
											<td><?=$data5[3]?> MW</td>
										</tr>
										<tr>
											<th>누적 방전량</th>
											<td><?=$data6[2]?> MW</td>
										</tr>
									</table>
								</div>
							</div>	
						</div>
					</div>
<?
	include "./inc/bottom.php";
?>
<SCRIPT>
//<!--
	pieChart1();
	pieChart2();
	pieChart3();
	
	
	var value = $('#ESS_AccumCharge').text().split("Kw");
	setWidth('ESS_AccumChargeAbsolute01', value[0], 200);

	if($('#ESS_AccumCharge').text() == 0){
		value = 0;
	}else{
		value = $('#ESS_AccumCharge').text();}
	setValue('ESS_AccumChargeAbsolute02', value, 430);//$('#ESS_AccumCharge').val()==0? 0:$('#ESS_AccumCharge').val()

	setWidth('ESS_BatteryAbsolute01', $('#ESS_BatteryAbsolute02').text(), 160);
	//setValue('ESS_BatteryAbsolute01', soc[0].innerHTML, 100);
//-->
</SCRIPT>