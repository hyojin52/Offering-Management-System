<?	
	require_once "dbconn.php";

	$mode = $_POST['mode'];

	/*login.php*/	
	function isLogin($id, $pass){
		global $conn;

		if($pass == NULL) $pass='';
		$sql = "SELECT * FROM tbl_user WHERE UUid='".$id."' AND UPwd = '".$pass."'";
		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	

		if($rowcount > 0) 
			echo "LOGIN";
		else
			echo "ERROR";
	}

	if($mode == "logincheck"){
		$id = $_POST['uid'];
		$pass = $_POST['passwd'];
		isLogin($id, $pass);
	}


	// valid data 체크하는 공통 함수
	function getValidData($val){
		$value = "No data";
		if($val != NULL) $value = $val;
		return $value;
	}

	// main1에서 PCS 데이터 체크하는 함수
	function getPCSData($PCS){
	if($PCS == '0'){
		$PCS = "정상";
		return $PCS;
	}
	else if($PCS == '1'){
		$PCS = "이상";
		return $PCS;
	}
	else{
		$PCS = "No Data";
		return $PCS;
	}
	}

	//main화면 0
	function getTotalInfo0(){
		global $conn;

		$sql ="SELECT Gname, PVSize, BatSize FROM tbl_group";

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
	
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
		}
		else {
			//put the value to the data
 			$itemdata= $result->fetch_assoc();

			$data[0] = getValidData($itemdata['Gname']);
			$data[1] = getValidData($itemdata['PVSize']);
			$data[2] = getValidData($itemdata['BatSize']);
			$result->free();
		} 		

		//$conn->close();

		return $data;
	}

	// main화면 1
	function getTotalInfo1(){
		global $conn;

		$sql ="SELECT dc.DT, dc.PV_SumPower, dc.ESS_SumPower, ec.AI3, ec.AI4, ec.AI5, pc.PS, pc.Poprstat, bc.ChgPower, bc.SOC
				FROM tbl_dpm dc
				JOIN tbl_emu ec ON dc.gno = ec.gno
				JOIN tbl_pcs pc ON dc.gno = pc.gno
				JOIN tbl_bmsrack bc ON dc.gno = bc.gno
				WHERE bc.Rno = 1
				ORDER BY dc.DT DESC;"; 
			/*"SELECT dc.DT, dc.PV_SumPower, dc.ESS_SumPower, ec.AI3, ec.AI4, ec.AI5, pc.PS, pc.Poprstat, bc.ChgPower, bc.SOC
				FROM tbl_dpm dc
				JOIN tbl_emu ec ON dc.gno = ec.gno
				JOIN tbl_pcs pc ON dc.gno = pc.gno
				JOIN tbl_bmsrack bc ON dc.gno = bc.gno
				WHERE bc.Rno = 0;";*/

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
	
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
			$data[3] = "";
			$data[4] = "";
			$data[5] = "";
			$data[6] = "";
			$data[7] = "";
			$data[8] = "";
			$data[9] = "";
		}
		else {
			//put the value to the data
 			$itemdata= $result->fetch_assoc();

			$data[0] = getValidData($itemdata['DT']);
			$data[1] = getValidData($itemdata['PV_SumPower']);
			$data[2] = getValidData($itemdata['ESS_SumPower']);
			$data[3] = getValidData($itemdata['AI3']);
			$data[4] = getValidData($itemdata['AI4']);
			$data[5] = getValidData($itemdata['AI5']);
			$data[6] = getPCSData($itemdata['PS']);
			$data[7] = getValidData($itemdata['Poprstat']);
			$data[8] = getValidData($itemdata['SOC']);
			$data[9] = getValidData($itemdata['ChgPower']);
			$result->free();
		} 		

		//$conn->close();

		return $data;
	}
	
	// main화면 2
	function getTotalInfo2(){
		global $conn;

		$sql = "SELECT dh.DT, dh.PV_SumPower, dh.ESS_SumPower
				FROM tbl_dpm dh
				WHERE date_format(dh.DT,'%Y-%m-%d %H') = date_format(date_sub(now(), INTERVAL 1 DAY),'%Y-%m-%d %H')
				ORDER BY dh.DT DESC limit 1;";

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
		
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
		}
		else {
			$itemdata= $result->fetch_assoc();

			// put the value to the data
			$data[0] = getValidData($itemdata['DT']);
			$data[1] = getValidData($itemdata['PV_SumPower']);
			$data[2] = getValidData($itemdata['ESS_SumPower']);
		}

		//$conn->close();

		return $data;
	}

	// main화면 3 - 전일 발전, 충전, 방전량
	function getTotalInfo3(){
		global $conn;

		$sql = "SELECT DT, PV_SumOut, ESS_SumOut, ESS_SumRcv
				FROM tbl_dpm
				WHERE date_format('2018-05-28 00:00:00', '%Y-%m-%d %00:%00:%00')
				<= DT
				AND date_format('2018-05-28 00:00:00', '%Y-%m-%d %23:%59:%59')
				>= DT
				ORDER BY DT DESC limit 1;";//임의의 날짜로 맞춘 query 

		/*$sql = "SELECT DT, PV_SumOut, ESS_SumOut, ESS_SumRcv
				FROM tbl_dpm
				WHERE date_format(date_sub(now(), interval 1 day),'%Y-%m-%d %00:%00:%00')
				<= DT
				AND date_format(date_sub(now(), interval 1 day),'%Y-%m-%d %23:%59:%59')
				>= DT
				ORDER BY DT DESC limit 1;";*/

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
		
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
			$data[3] = "";
		}
		else {
			$itemdata= $result->fetch_assoc();

			// put the value to the data
			$data[0] = getValidData($itemdata['DT']);
			$data[1] = getValidData($itemdata['PV_SumOut']);
			$data[2] = getValidData($itemdata['ESS_SumRcv']);
			$data[3] = getValidData($itemdata['ESS_SumOut']);
		}

		//$conn->close();

		return $data;
	}

	// main화면 4 - 당일  발전, 충전, 방전량
	function getTotalInfo4(){
		global $conn;

		$sql = "SELECT DT, PV_SumOut, ESS_SumOut, ESS_SumRcv
				FROM tbl_dpm
				WHERE date_format('2018-05-28 00:00:00', '%Y-%m-%d %00:%00:%00') <= DT 
				AND date_format('2018-05-28 00:00:00', '%Y-%m-%d %23:%59:%59') >= DT
				ORDER BY DT DESC limit 1;";//임의의 날짜로 맞춘 query 

		/*$sql = "SELECT DT, PV_SumOut, ESS_SumOut, ESS_SumRcv
				FROM tbl_dpm
				WHERE date_format(now(),'%Y-%m-%d %00:%00:%00') <= DT 
				AND date_format(now(),'%Y-%m-%d %23:%59:%59') >= DT
				ORDER BY DT DESC limit 1;";*/

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
		
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
			$data[3] = "";
		}
		else {
			$itemdata= $result->fetch_assoc();

			// put the value to the data
			$data[0] = getValidData($itemdata['DT']);
			$data[1] = getValidData($itemdata['PV_SumOut']);
			$data[2] = getValidData($itemdata['ESS_SumRcv']);
			$data[3] = getValidData($itemdata['ESS_SumOut']);
		}

		//$conn->close();

		return $data;
	}

	// main화면 5 - 당월 발전, 충전, 방전량
	function getTotalInfo5(){
		global $conn;

		$sql = "SELECT DT, ROUND(SUM(PV_SumOut),1) as PV_SumOut, ROUND(SUM(ESS_SumOut),1) as ESS_SumOut, ROUND(SUM(ESS_SumRcv),1) as ESS_SumRcv
				FROM tbl_dpm
				WHERE date_format('2018-05-01', '%Y-%m') = date_format(DT,'%Y-%m')
				GROUP BY PV_SumOut, ESS_SumOut, ESS_SumRcv;";

		/*$sql = "SELECT DT, ROUND(SUM(PV_SumOut),1) as PV_SumOut, ROUND(SUM(ESS_SumOut),1) as ESS_SumOut, ROUND(SUM(ESS_SumRcv),1) as ESS_SumRcv
					FROM tbl_dpm
					WHERE date_format(now(), '%Y-%m') = date_format(DT,'%Y-%m')
					GROUP BY PV_SumOut, ESS_SumOut, ESS_SumRcv;";*/

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
		
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
			$data[3] = "";
		}
		else {
			$itemdata= $result->fetch_assoc();

			// put the value to the data
			$data[0] = getValidData($itemdata['DT']);
			$data[1] = getValidData($itemdata['PV_SumOut']);
			$data[2] = getValidData($itemdata['ESS_SumRcv']);
			$data[3] = getValidData($itemdata['ESS_SumOut']);
		}

		//$conn->close();

		return $data;
	}

	// main화면 6 - 누적 발전, 충전, 방전량
	function getTotalInfo6(){
		global $conn;

		$sql = "SELECT ROUND(SUM(PV_SumOut), 1) AS PV_SumOut, ROUND(SUM(ESS_SumOut), 1) AS ESS_SumOut, ROUND(SUM(ESS_SumRcv), 1) AS ESS_SumRcv
				FROM tbl_dpm;";

		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	
		
		if($rowcount == 0){
			$data[0] = "";
			$data[1] = "";
			$data[2] = "";
		}
		else {
			$itemdata= $result->fetch_assoc();

			// put the value to the data
			$data[0] = getValidData($itemdata['PV_SumOut']);
			$data[1] = getValidData($itemdata['ESS_SumRcv']);
			$data[2] = getValidData($itemdata['ESS_SumOut']);
		}

		//$conn->close();

		return $data;
	}

	// sub2(계통도 페이지) - 태양광 발전량, PCS, 배터리 충방전량
	function getSystemInfo(){
		global $conn;

		$sql = "SELECT dc.DT, dc.PV_SumPower, dc.ESS_SumPower, pc.SumYP
				FROM tbl_dpm dc
				JOIN tbl_pcs pc ON dc.gno = pc.gno
				JOIN tbl_bmsrack bc ON dc.gno = bc.gno
				WHERE bc.Rno = 0
				ORDER BY dc.DT DESC;"; 
			
		/*"SELECT dc.DT, dc.PV_SumPower, dc.ESS_SumPower, pc.SumYP
				FROM tbl_dpm dc
				JOIN tbl_pcs pc ON dc.gno = pc.gno
				JOIN tbl_bmsrack bc ON dc.gno = bc.gno
				WHERE bc.Rno = 0;";*/
	
		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	

		if($rowcount == 0){
			$data[0] = "데이터없음";
			$data[1] = "데이터없음";
			$data[2] = "데이터없음";
		}
		else{
			$itemdata= $result->fetch_assoc();
			//put the value to the data
			$data[0] = getValidData($itemdata['PV_SumPower']);
			$data[1] = getValidData($itemdata['ESS_SumPower']);
			$data[2] = getValidData($itemdata['SumYP']);
		}

		$result->free();

		//$conn->close();

		return $data;
	}


	// sub3(트렌드 페이지)
	function getTrendInfo(){	
		$now = date("Y-m-d");
		getDayInfo("2017-05-02"); //change
		getMonthInfo("2017-05-02"); //change
		
	}

	// sub3(트렌드 페이지) - 일별 트렌드
	function getDayInfo($date){
		global $conn;
		
		$dayDate = explode("-", $date);
			
		$sql = "SELECT date_format(DT,'%Y-%m-%d %H') as DT, PV_Out, ROUND(sum(ESS_Out + ESS_Rcv),1) AS ESS
				FROM sinsung
				WHERE date_format('".$date."','%Y-%m-%d') = date_format(DT,'%Y-%m-%d')
				GROUP BY date_format(DT,'%Y-%m-%d %H')
				ORDER BY DT ASC;";
			
		/*"SELECT date_format(DT,'%Y-%m-%d %H') as DT, PV_SumPower, ESS_SumPower
				FROM sinsung
				WHERE date_format('".$date."','%Y-%m-%d') = date_format(DT,'%Y-%m-%d')
				GROUP BY date_format(DT,'%Y-%m-%d %H')
				ORDER BY DT ASC";*/
		
		$result = $conn->query($sql);
		$rowcount = $result->num_rows;	

		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['DT'])."|";
			$data .= getValidData($itemdata['PV_Out'])."|";
			$data .= getValidData($itemdata['ESS'])."@";
		}


		$dayTrend = explode("@", $data);

		for($i = 0; $i < count($dayTrend) -1; $i++) {
			$s_dayTrend = explode("|", $dayTrend[$i]);

			$day = explode(" ", $s_dayTrend[0]);
			$PV_Out[$i] = $s_dayTrend[1];
			$ESS[$i] = $s_dayTrend[2];
		}
		
		echo 
		"<script>	
			var config1 = {
				type: 'line',
				data: {
					labels: ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
					datasets: [{
						label: '태양광 발전량',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [
							$PV_Out[0], $PV_Out[1], $PV_Out[2], $PV_Out[3], $PV_Out[4], $PV_Out[5], $PV_Out[6], $PV_Out[7], $PV_Out[8], $PV_Out[9], $PV_Out[10], $PV_Out[11], $PV_Out[12], $PV_Out[13], $PV_Out[14], $PV_Out[15], $PV_Out[16], $PV_Out[17], $PV_Out[18], $PV_Out[19], $PV_Out[20], $PV_Out[21], $PV_Out[22], $PV_Out[23]
						],
						fill: false,
					}, {
						label: '배터리 충,방전량',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [
							$ESS[0], $ESS[1], $ESS[2], $ESS[3], $ESS[4], $ESS[5], $ESS[6], $ESS[7], $ESS[8], $ESS[9], $ESS[10], $ESS[11], $ESS[12], $ESS[13], $ESS[14], $ESS[15], $ESS[16], $ESS[17], $ESS[18], $ESS[19], $ESS[20], $ESS[21], $ESS[22], $ESS[23]
						],
						fill: false,
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: '$dayDate[0]년 $dayDate[1]월 $dayDate[2]일'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Month'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
			};

			function DTGraph(){
				var ctx1 = document.getElementById('dayTrend').getContext('2d');
				window.myLine = new Chart(ctx1, config1);
			};

			DTGraph();

			document.getElementById('day').value = '".$date."';

		</script>";

		$result->free();
		//$conn->close();
	
		if($rowcount == 0)	echo "데이터없음";
		
		return $data;
	}

	// sub3(트렌드 페이지) - 월별 트렌드
	function getMonthInfo($date){
		global $conn;
		
		$monthDate = explode("-", $date);

		$sql = "SELECT date_format(DT,'%Y-%m-%d') as DT, ROUND(sum(PV_Out),1) as PV_Out,
				ROUND(sum(ESS_Out)*-1,1) as ESS_Out, ROUND(sum(ESS_Rcv),1) as ESS_Rcv
				FROM sinsung
				WHERE date_format('".$date."', '%Y-%m') = date_format(DT,'%Y-%m')
				GROUP BY date_format(DT,'%Y-%m-%d')
				ORDER BY DT ASC;";
			/*"SELECT date_format(DT,'%Y-%m-%d') as DT, PV_SumOut as PV_Out, ESS_SumRcv as ESS_Out, ESS_SumOut as ESS_Rcv
				FROM tbl_dpm
				WHERE date_format('".$date."', '%Y-%m') = date_format(DT,'%Y-%m')
				GROUP BY date_format(DT,'%Y-%m-%d')
				ORDER BY DT ASC;";*/
			
	
		$result = $conn->query($sql);
		$rowcount = $result->num_rows;	

		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['DT'])."|";
			$data .= getValidData($itemdata['PV_Out'])."|";
			$data .= getValidData($itemdata['ESS_Out'])."|";
			$data .= getValidData($itemdata['ESS_Rcv'])."@";
		}

		$monthTrend = explode("@", $data);

		for($i = 0; $i < count($monthTrend) -1; $i++) {
			$s_monthTrend = explode("|", $monthTrend[$i]);

			for($j = 0; $j < count($s_monthTrend); $j++){
				$DT = explode("-", $s_monthTrend[0]);
				$year[$j] = $DT[0];
				$month[$j] = $DT[1];
				$date[$j] = $DT[2];
			}

			$PV_Out[$i] = $s_monthTrend[1];
			$ESS_Out[$i] = $s_monthTrend[2];
			$ESS_Rcv[$i] = $s_monthTrend[3];
		}

		$topic = $year[0]."년 ".$month[0]."월";
		
		echo 
		"<script>	
			var config2 = {
				type: 'bar',
				data: {
					labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
					datasets: [{
						label: '태양광 발전량',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [
							$PV_Out[0], $PV_Out[1], $PV_Out[2], $PV_Out[3], $PV_Out[4], $PV_Out[5], $PV_Out[6], $PV_Out[7], $PV_Out[8], $PV_Out[9], $PV_Out[10], $PV_Out[11], $PV_Out[12], $PV_Out[13], $PV_Out[14], $PV_Out[15], $PV_Out[16], $PV_Out[17], $PV_Out[18], $PV_Out[19], $PV_Out[20], $PV_Out[21], $PV_Out[22], $PV_Out[23], $PV_Out[24], $PV_Out[25], $PV_Out[26], $PV_Out[27], $PV_Out[28], $PV_Out[29], $PV_Out[30]
						],
						fill: false,
					}, {
						label: '충전량',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [
							$ESS_Out[0], $ESS_Out[1], $ESS_Out[2], $ESS_Out[3], $ESS_Out[4], $ESS_Out[5], $ESS_Out[6], $ESS_Out[7], $ESS_Out[8], $ESS_Out[9], $ESS_Out[10], $ESS_Out[11], $ESS_Out[12], $ESS_Out[13], $ESS_Out[14], $ESS_Out[15], $ESS_Out[16], $ESS_Out[17], $ESS_Out[18], $ESS_Out[19], $ESS_Out[20], $ESS_Out[21], $ESS_Out[22], $ESS_Out[23], $ESS_Out[24], $ESS_Out[25], $ESS_Out[26], $ESS_Out[27], $ESS_Out[28], $ESS_Out[29], $ESS_Out[30]
						],
						fill: false,
					}, {
						label: '방전량',
						backgroundColor: window.chartColors.green,
						borderColor: window.chartColors.green,
						data: [
							$ESS_Rcv[0], $ESS_Rcv[1], $ESS_Rcv[2], $ESS_Rcv[3], $ESS_Rcv[4], $ESS_Rcv[5], $ESS_Rcv[6], $ESS_Rcv[7], $ESS_Rcv[8], $ESS_Rcv[9], $ESS_Rcv[10], $ESS_Rcv[11], $ESS_Rcv[12], $ESS_Rcv[13], $ESS_Rcv[14], $ESS_Rcv[15], $ESS_Rcv[16], $ESS_Rcv[17], $ESS_Rcv[18], $ESS_Rcv[19], $ESS_Rcv[20], $ESS_Rcv[21], $ESS_Rcv[22], $ESS_Rcv[23], $ESS_Rcv[24], $ESS_Rcv[25], $ESS_Rcv[26], $ESS_Rcv[27], $ESS_Rcv[28], $ESS_Rcv[29], $ESS_Rcv[30]
						],
						fill: false,
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: '".$topic."'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Month'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value'
							}
						}]
					}
				}
			};

			function MTGraph(){
				var ctx2 = document.getElementById('monthTrend').getContext('2d');
				window.myLine = new Chart(ctx2, config2);
			};

			MTGraph();

			document.getElementById('month').value = '".$monthDate[0]."-".$monthDate[1]."';
			
		</script>";

		$result->free();
		//$conn->close();

		if($rowcount == 0)	echo "데이터없음";
	
		return $data;
	}


	// sub4(리포트 페이지) - 시간별, 일별 리포트
	function getReportInfo($date1, $date2){
		global $conn;

		if(!strcmp($_POST['type'], 'time')){// 시간별
		echo 
		"<div id = 'sub4_data_first_div'>
			<ul class='sub4_data_first'>
				<li class='sub4_col1'>일자</li>
				<li class='sub4_col2'>시간</li>
				<li class='sub4_col3'>태양광 발전량</li>
				<li class='sub4_col4'>ESS 충전량</li>	
				<li class='sub4_col5'>ESS 방전량</li>
				<li class='sub4_col6'>누적 충전량</li>
				<li class='sub4_col7'>누적 방전량</li>
				<li class='sub4_col8'>평균 온도</li>
				<li class='sub4_col9'>습도</li>
			</ul>
		</div>";

			$sql = "SELECT date_format(dh.DT,'%Y-%m-%d') AS DT_date, date_format(dh.DT, '%H:%m') AS DT_time,dh.PV_SumOut, dh.ESS_SumOut, dh.ESS_SumRcv, dh.ESS_SumOut, ph.AcmChg, ph.AcmOut, eh.AI3, eh.AI4, eh.AI5
					FROM tbl_dpm dh
					JOIN tbl_pcs ph ON dh.gno = ph.gno
					JOIN tbl_emu eh ON dh.gno = eh.gno
					WHERE dh.DT BETWEEN date_format('2018-05-28', '%Y-%m-%d %H:%m') AND date_format(now(), '%Y-%m-%d %H:%m')
					GROUP BY date_format(dh.DT, '%H')
					ORDER BY dh.DT ASC;";
									
			/*"SELECT date_format(dh.DT,'%Y-%m-%d') AS DT_date, date_format(dh.DT, '%H:%m') AS DT_time, dh.PV_SumOut, dh.ESS_SumOut, dh.ESS_SumRcv, ph.AcmOut, ph.AcmChg, eh.AI3, eh.AI4, eh.AI5
					FROM tbl_dpm dh
					JOIN tbl_pcs ph ON dh.gno = ph.gno
					JOIN tbl_emu eh ON dh.gno = eh.gno
					WHERE dh.DT BETWEEN date_format(".$date1.", '%Y-%m-%d %H:%m') AND date_format(".$date2.", '%Y-%m-%d %H:%m')
					GROUP BY date_format(dh.DT, '%H')
					ORDER BY dh.DT ASC;";*/
		
			$result = $conn->query( $sql);
			$rowcount = $result->num_rows;	

			$data = "";
			while($itemdata= $result->fetch_assoc()){
				//put the value to the data
				$data .= getValidData($itemdata['DT_date'])."|";
				$data .= getValidData($itemdata['DT_time'])."|";
				$data .= getValidData($itemdata['PV_SumOut'])."|";
				$data .= getValidData($itemdata['ESS_SumRcv'])."|";
				$data .= getValidData($itemdata['ESS_SumOut'])."|";
				$data .= getValidData($itemdata['AcmOut'])."|";
				$data .= getValidData($itemdata['AcmChg'])."|";

				$temp1 = getValidData($itemdata['AI3']);
				$temp2 = getValidData($itemdata['AI4']);
				$temp = ($temp1+$temp2)/2;
				$data .= $temp."|";

				$data .= getValidData($itemdata['eh.AI5'])."@";
			}

			$dayReport = explode("@", $data);

			for($i = 0; $i < count($dayReport) -1; $i++) {
				$s_dayReport = explode("|", $dayReport[$i]);
				echo "<ul class = 'sub4_data'>";
				echo "<li class = 'reportContent sub4_col1'>$s_dayReport[0]</li>";
				echo "<li class = 'reportContent sub4_col2'>$s_dayReport[1]</li>";
				echo "<li class = 'reportContent sub4_col3'>$s_dayReport[2]</li>";
				echo "<li class = 'reportContent sub4_col4'>$s_dayReport[3]</li>";
				echo "<li class = 'reportContent sub4_col5'>$s_dayReport[4]</li>";
				echo "<li class = 'reportContent sub4_col6'>$s_dayReport[5]</li>";
				echo "<li class = 'reportContent sub4_col7'>$s_dayReport[6]</li>";
				echo "<li class = 'reportContent sub4_col8'>$s_dayReport[7]</li>";
				echo "<li class = 'reportContent sub4_col9'>$s_dayReport[8]</li>";
				echo "</ul>";
			}
		}
		else if(!strcmp($_POST['type'], 'day')){// 일별
			echo 
			"<div id = 'sub4_data_first_div'>
				<ul class='sub4_data_first'>
					<li class='sub4_col1'>일자</li>
					<li class='sub4_col2'>시간</li>
					<li class='sub4_col3'>태양광 발전량</li>
					<li class='sub4_col4'>ESS 충전량</li>	
					<li class='sub4_col5'>ESS 방전량</li>
					<li class='sub4_col6'>누적 충전량</li>
					<li class='sub4_col7'>누적 방전량</li>
					<li class='sub4_col8'>평균 온도</li>
					<li class='sub4_col9'>습도</li>
				</ul>
			</div>";

			$sql = "SELECT date_format(dh.DT,'%Y-%m-%d') AS DT_date, date_format(dh.DT, '%H:%m') AS DT_time, dh.PV_SumOut, dh.ESS_SumOut, dh.ESS_SumRcv, dh.ESS_SumOut, ph.AcmChg, ph.AcmOut, eh.AI3, eh.AI4, eh.AI5
					FROM tbl_dpm dh
					JOIN tbl_pcs ph ON dh.gno = ph.gno
					JOIN tbl_emu eh ON dh.gno = eh.gno
					WHERE dh.DT BETWEEN date_format('2018-05-28', '%Y-%m-%d %H:%m') AND date_format(now(), '%Y-%m-%d %H:%m')
					GROUP BY date_format(dh.DT, '%H')
					ORDER BY dh.DT ASC;";
				
			/*"SELECT date_format(dh.DT,'%Y-%m-%d') AS DT_date, 
					dh.PV_SumPower, dh.ESS_SumPower, dh.PV_SumRcv,ph.AcmOut, ph.AcmChg, eh.AI3 
					FROM tbl_dpm_hist dh 
					JOIN tbl_pcs_hist ph ON dh.gno = ph.gno
					JOIN tbl_emu_hist eh ON dh.gno = eh.gno
					WHERE dh.DT BETWEEN date_format('".$date1."', '%Y-%m-%d %H:%m') 
					AND date_format('".$date2."', '%Y-%m-%d %H:%m')
					GROUP BY date_format(dh.DT, ‘%d’)
					ORDER BY dh.DT ASC;
					";*/
		
			$result = $conn->query( $sql);
			$rowcount = $result->num_rows;	

			$data = "";
			while($itemdata= $result->fetch_assoc()){
				//put the value to the data
				$data .= getValidData($itemdata['DT_date'])."|";
				$data .= getValidData($itemdata['DT_time'])."|";
				$data .= getValidData($itemdata['PV_SumOut'])."|";
				$data .= getValidData($itemdata['ESS_SumRcv'])."|";
				$data .= getValidData($itemdata['ESS_SumOut'])."|";
				$data .= getValidData($itemdata['AcmOut'])."|";
				$data .= getValidData($itemdata['AcmChg'])."|";

				$temp1 = getValidData($itemdata['AI3']);
				$temp2 = getValidData($itemdata['AI4']);
				$temp = ($temp1+$temp2)/2;
				$data .= $temp."|";

				$data .= getValidData($itemdata['eh.AI5'])."@";
			}

			$dayReport = explode("@", $data);

			for($i = 0; $i < count($dayReport) -1; $i++) {
				$s_dayReport = explode("|", $dayReport[$i]);
				echo "<ul class = 'sub4_data'>";
				echo "<li class = 'reportContent sub4_col1'>$s_dayReport[0]</li>";
				echo "<li class = 'reportContent sub4_col2'>$s_dayReport[1]</li>";
				echo "<li class = 'reportContent sub4_col3'>$s_dayReport[2]</li>";
				echo "<li class = 'reportContent sub4_col4'>$s_dayReport[3]</li>";
				echo "<li class = 'reportContent sub4_col5'>$s_dayReport[4]</li>";
				echo "<li class = 'reportContent sub4_col6'>$s_dayReport[5]</li>";
				echo "<li class = 'reportContent sub4_col7'>$s_dayReport[6]</li>";
				echo "<li class = 'reportContent sub4_col8'>$s_dayReport[7]</li>";
				echo "<li class = 'reportContent sub4_col9'>$s_dayReport[8]</li>";
				echo "</ul>";
			}
		}
		else{// default
			
			echo 
			"<div id = 'sub4_data_first_div'>
				<ul class='sub4_data_first'>
					<li class='sub4_col1'>일자</li>
					<li class='sub4_col2'>시간</li>
					<li class='sub4_col3'>태양광 발전량</li>
					<li class='sub4_col4'>ESS 충전량</li>	
					<li class='sub4_col5'>ESS 방전량</li>
					<li class='sub4_col6'>누적 충전량</li>
					<li class='sub4_col7'>누적 방전량</li>
					<li class='sub4_col8'>평균 온도</li>
					<li class='sub4_col9'>습도</li>
				</ul>
			</div>";

			$sql = "SELECT date_format(dh.DT,'%Y-%m-%d') AS DT_date, date_format(dh.DT, '%H:%m') AS DT_time, dh.PV_SumOut, dh.ESS_SumOut, dh.ESS_SumRcv, dh.ESS_SumOut, ph.AcmChg, ph.AcmOut, eh.AI3, eh.AI4, eh.AI5
					FROM tbl_dpm dh
					JOIN tbl_pcs ph ON dh.gno = ph.gno
					JOIN tbl_emu eh ON dh.gno = eh.gno
					WHERE dh.DT BETWEEN date_format('2018-05-28', '%Y-%m-%d %H:%m') AND date_format(now(), '%Y-%m-%d %H:%m')
					GROUP BY date_format(dh.DT, '%H')
					ORDER BY dh.DT ASC;";
				
			/*"SELECT date_format(dh.DT,'%Y-%m-%d') AS DT_date, 
					dh.PV_SumPower, dh.ESS_SumPower, dh.PV_SumRcv,ph.AcmOut, ph.AcmChg, eh.AI3 
					FROM tbl_dpm_hist dh 
					JOIN tbl_pcs_hist ph ON dh.gno = ph.gno
					JOIN tbl_emu_hist eh ON dh.gno = eh.gno
					WHERE dh.DT BETWEEN date_format('".$date1."', '%Y-%m-%d %H:%m') 
					AND date_format('".$date2."', '%Y-%m-%d %H:%m')
					GROUP BY date_format(dh.DT, ‘%d’)
					ORDER BY dh.DT ASC;
					";*/
		
			$result = $conn->query( $sql);
			$rowcount = $result->num_rows;	

			$data = "";
			while($itemdata= $result->fetch_assoc()){
				//put the value to the data
				$data .= getValidData($itemdata['DT_date'])."|";
				$data .= getValidData($itemdata['DT_time'])."|";
				$data .= getValidData($itemdata['PV_SumOut'])."|";
				$data .= getValidData($itemdata['ESS_SumRcv'])."|";
				$data .= getValidData($itemdata['ESS_SumOut'])."|";
				$data .= getValidData($itemdata['AcmOut'])."|";
				$data .= getValidData($itemdata['AcmChg'])."|";

				$temp1 = getValidData($itemdata['AI3']);
				$temp2 = getValidData($itemdata['AI4']);
				$temp = ($temp1+$temp2)/2;
				$data .= $temp."|";

				$data .= getValidData($itemdata['eh.AI5'])."@";
			}

			$dayReport = explode("@", $data);

			for($i = 0; $i < count($dayReport) -1; $i++) {
				$s_dayReport = explode("|", $dayReport[$i]);
				echo "<ul class = 'sub4_data'>";
				echo "<li class = 'reportContent sub4_col1'>$s_dayReport[0]</li>";
				echo "<li class = 'reportContent sub4_col2'>$s_dayReport[1]</li>";
				echo "<li class = 'reportContent sub4_col3'>$s_dayReport[2]</li>";
				echo "<li class = 'reportContent sub4_col4'>$s_dayReport[3]</li>";
				echo "<li class = 'reportContent sub4_col5'>$s_dayReport[4]</li>";
				echo "<li class = 'reportContent sub4_col6'>$s_dayReport[5]</li>";
				echo "<li class = 'reportContent sub4_col7'>$s_dayReport[6]</li>";
				echo "<li class = 'reportContent sub4_col8'>$s_dayReport[7]</li>";
				echo "<li class = 'reportContent sub4_col9'>$s_dayReport[8]</li>";
				echo "</ul>";
			}
	
		}

		//$result->free();
		//$conn->close();
		
		if($rowcount == 0) echo "데이터 없음";

		//return $data;
	}

	/*function getReportInfo($date1, $date2){ //데이터가 들어있지 않아서 임시로 다른 데이터 넣어놓음
		global $conn;
		
		echo 
		"<div id = 'sub4_data_first_div'>
			<ul class='sub4_data_first'>
				<li class='sub4_col1'>일자</li>
				<li class='sub4_col2'>시간</li>
				<li class='sub4_col3'>태양광 발전량</li>
				<li class='sub4_col4'>ESS 충전량</li>	
				<li class='sub4_col5'>ESS 방전량</li>
				<li class='sub4_col6'>누적 발전량</li>
				<li class='sub4_col7'>누적 충전량</li>
				<li class='sub4_col8'>누적 방전량</li>
				<li class='sub4_col9'>온도</li>
			</ul>
		</div>";

		$sql = "SELECT date_format(DT,'%Y-%m-%d') as DT, ROUND(sum(PV_Out),1) as PV_Out,
				ROUND(sum(ESS_Out)*-1,1) as ESS_Out, ROUND(sum(ESS_Rcv),1) as ESS_Rcv
				FROM sinsung
				WHERE date_format('".$date1."', '%Y-%m') = date_format(DT,'%Y-%m')
				GROUP BY date_format(DT,'%Y-%m-%d')
				ORDER BY DT ASC;";
	
		$result = $conn->query($sql);
		$rowcount = $result->num_rows;	

		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['DT'])."|";
			$data .= getValidData($itemdata['PV_Out'])."|";
			$data .= getValidData($itemdata['ESS_Out'])."|";
			$data .= getValidData($itemdata['ESS_Rcv'])."@";
		}

		$monthTrend = explode("@", $data);

		for($i = 0; $i < count($monthTrend) -1; $i++) {
			$s_monthTrend = explode("|", $monthTrend[$i]);
			
			$DT_date[$i] = $s_monthTrend[0];
			$PV_Out[$i] = $s_monthTrend[1];
			$ESS_Out[$i] = $s_monthTrend[2];
			$ESS_Rcv[$i] = $s_monthTrend[3];

			echo "<ul class = 'sub4_data'>";
			echo "<li class = 'reportContent sub4_col1'>".$DT_date[$i]."</li>";
			echo "<li class = 'reportContent sub4_col2'>".$PV_Out[$i]."</li>";
			echo "<li class = 'reportContent sub4_col3'>".$ESS_Out[$i]."</li>";
			echo "<li class = 'reportContent sub4_col4'>".$ESS_Rcv[$i]."</li>";
			echo "<li class = 'reportContent sub4_col5'>no data</li>";
			echo "<li class = 'reportContent sub4_col6'>no data</li>";
			echo "<li class = 'reportContent sub4_col7'>no data</li>";
			echo "<li class = 'reportContent sub4_col8'>no data</li>";
			echo "<li class = 'reportContent sub4_col9'>no data</li>";
			echo "</ul>";
		}
		
		$result->free();
		//$conn->close();

		echo 
		"<script>
			document.getElementById('search1').value = '".$date1."';
			document.getElementById('search2').value = '".$date2."';
		</script>";

		if($rowcount == 0)	echo "데이터없음";
		return;
	}*/

	// sub5(이벤트 발생 내역)
	function getEventData($result){
		global $conn;

		//$sql ="SELECT DT, Rno, BatPrtFault FROM tbl_bmsrack WHERE Gno = '".$region."'";
		//$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	

		//1|데이터1|200@2|데이터2|300@
		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['DT'])."|";
			$data .= getValidData($itemdata['Rno'])."|";
			$data .= getValidData($itemdata['BatPrtFault'])."@";
		}

		$result->free();

		if($rowcount == 0)	$data = "데이터없음";
		
		$events= explode("@", $data);

		for($i = 0; $i < count($events) -1; $i++) {
			$index = $i+1;
			$s_events = explode("|", $events[$i]);
			echo "<ul class = 'sub5_data1'>";
			echo "<li class = 'sub5_col1'>".$s_events[0]."</li>";
			echo "<li class = 'sub5_col2'>".$s_events[1]."</li>";
			echo "<li class = 'sub5_col3'>".$s_events[2]."</li>";
			echo "<li class = 'sub5_col4'><input type='button' value='검색' class='sub5DetailInfoButton' id='".$index++."' onclick='showEventDetail(\"".$s_events[0]."\", \"".$s_events[1]."\",  \"".$s_events[2]."\");'></li>";
			echo "</ul>";
		}
	}

	// sub6.php(유저관리)
	function getUsers($result){
		global $conn;

		//$sql = "SELECT * FROM tbl_user u JOIN tbl_group g ON u.LocNo = g.Gno";
		//$result = $conn->query( $sql);

		$rowcount = $result->num_rows;	

		//1|데이터1|200@2|데이터2|300@
		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$ulevel = getValidData($itemdata['Ulevel']);
			if ($ulevel == 1) {
				$data .= "owner|";
			} else if ($ulevel == 2) {
				$data .= "user|";
			} else {
				$data .= "Administrator|";
			}
			$data .= getValidData($itemdata['Uuid'])."|";
			$data .= getValidData($itemdata['LocNo'])."|";
			$data .= getValidData($itemdata['UName'])."|";
			$data .= getValidData($itemdata['UTel1'])."|";
			$data .= getValidData($itemdata['LocName'])."|";
			$data .= getValidData($itemdata['BatSize'])."|";
			$data .= getValidData($itemdata['PVSize'])."|";
			$data .= getValidData($itemdata['PCSSize'])."@";
		}

		$result->free();
		//$conn->close();

		if($rowcount == 0)	$data = "데이터없음";
	
		$users= explode("@", $data);

		for($i = 0; $i < count($users) -1; $i++) {
			$s_users = explode("|", $users[$i]);
			echo "<ul class = 'sub6_data1'>";
			echo "<li class = 'sub6_col1'>".$s_users[0]."</li>";
			echo "<li class = 'sub6_col2'>".$s_users[1]."</li>";
			echo "<li class = 'sub6_col3'>".$s_users[2]."</li>";
			echo "<li class = 'sub6_col4'>".$s_users[3]."</li>";
			echo "<li class = 'sub6_col5'>".$s_users[4]."</li>";
			echo "<li class = 'sub6_col6'>".$s_users[5]."</li>";
			echo "<li class = 'sub6_col7'>".$s_users[6]."</li>";
			echo "<li class = 'sub6_col8'>".$s_users[7]."</li>";
			echo "<li class = 'sub6_col9'>".$s_users[8]."</li>";
			echo "<li class = 'sub6_col10'><input type='button' class ='sub6ModifyInfo' name='sub6ModifyInfo' value='수정하기' onclick='modifyInfo(\"".$s_users[1]."\");'></li>";
			echo "</ul>";
		}

		return;
	}

	//sub6.php_유저등록
	function registerUser(){
		global $conn;
		$sql = "SELECT * FROM tbl_user WHERE Uuid = '".$_POST['userInfoId']."'";
		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;

		if($rowcount > 0){
			echo "<script>
					alert('아이디가 이미 존재합니다. 다른 아이디를 입력해주세요.');
					location.href = 'http://ubinet2018.dothome.co.kr/main/sub6.php';
				  </script>";
		}

		$sql = "INSERT INTO tbl_user(Uuid, UPwd, UName, UTel1, Email, crDT, upDT, Ulevel, isSMS, LocNo)
				VALUES('".$_POST['userInfoId']."', '".$_POST['userInfoPw1']."', '".$_POST['userInfoName']."', '".$_POST['userInfoTel']."', '".$_POST['userInfoEmail']."', now(), NULL, '".$_POST['userInfoGroup']."', '".$_POST['userInfoSMS']."', '".$_POST['userInfoLocNo']."')";
		$result = $conn->query( $sql);
		//질문사항
		/*if($result){
			location.reload(true);
			header("location: http://ubinet2018.dothome.co.kr/main/sub6.php");
		}else{
			echo "<scipt>alert('등록에 실패하였습니다. 다시 시도해주세요!');</script>";
		}*/

	}

	// sub7.php(배터리 상태 정보)
	function getBCondition($result){
		global $conn;

		//$sql = "SELECT * FROM tbl_bmsrack WHERE Gno = '".$region."'";
		//$result = $conn->query( $sql);
		
		$rowcount = $result->num_rows;	

		//1|데이터1|200@2|데이터2|300@
		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['Rno'])."|";
			$data .= getValidData($itemdata['DT'])."|";
			$data .= getValidData($itemdata['DCV'])."V|";
			$data .= getValidData($itemdata['DCC'])."A|";
			$data .= getValidData($itemdata['SOC'])."%|";
			$data .= getValidData($itemdata['AvrCLT'])."ºC|";
			$data .= getValidData($itemdata['MaxCLV'])."V|";
			$data .= getValidData($itemdata['MinCLV'])."V|";
			$data .= getValidData($itemdata['AvrCLV'])."V|";
			$data .= getValidData(abs(round($itemdata['MaxCLV'] - $itemdata['MinCLV'], 3))) ."V|";
			$data .= getValidData($itemdata['BatOper'])."@"; //불확실
		}

		$result->free();
		//$conn->close();

		if($rowcount == 0)	$data = "데이터없음";
	
		$bCondition= explode("@", $data);

		for($i = 0; $i < count($bCondition) -1; $i++) {
			$s_bCondition = explode("|", $bCondition[$i]);
			echo "<ul class = 'sub7_data1'>";
			echo "<li class = 'sub7_col1'>".$s_bCondition[0]."</li>";
			echo "<li class = 'sub7_col2'>".$s_bCondition[1]."</li>";
			echo "<li class = 'sub7_col3'>".$s_bCondition[2]."</li>";
			echo "<li class = 'sub7_col4'>".$s_bCondition[3]."</li>";
			echo "<li class = 'sub7_col5'>".$s_bCondition[4]."</li>";
			echo "<li class = 'sub7_col6'>".$s_bCondition[5]."</li>";
			echo "<li class = 'sub7_col7'>".$s_bCondition[6]."</li>";
			echo "<li class = 'sub7_col8'>".$s_bCondition[7]."</li>";
			echo "<li class = 'sub7_col9'>".$s_bCondition[8]."</li>";
			echo "<li class = 'sub7_col10'>".$s_bCondition[9]."</li>";
			echo "<li class = 'sub7_col11'>".$s_bCondition[10]."</li>";
			echo "<li class='sub7_col12'><input type='image' src='/main/img/alam.png' width='14' height='16'></li>";
			echo "<li class='sub7_col13'><input type='button' value='검색' onclick='goToRackDetail(".$s_bCondition[0].")'></li>";
			echo "</ul>";
		}

		return;
	}

	function goToRackDetail($f_rack){
		echo "<form name='detail' method='POST'>";
		echo "<input type='hidden' name= 'rackNum' />";
		echo "</form>";

		echo "<script>";
		echo "document.detail.rackNum.value = ".$f_rack."";
		echo "document.detail.action = '../main/sub8.php'";
		echo "document.detail.submit()";
		echo "</script>";
	}


	// sub8.php(배터리 상세 정보)
	function getBDetail($result){
		global $conn;
		
		/*if ($rack == 6 ) {
			$sql = "SELECT * FROM tbl_bmstray WHERE Gno = '".$region."'";
		} else {
			$sql = "SELECT * FROM tbl_bmstray WHERE Rno= '".$rack."' AND Gno = '".$region."'";
		}
		
		$result = $conn->query( $sql);*/
		$rowcount = $result->num_rows;	

		//1|데이터1|200@2|데이터2|300@
		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['Rno'])."|";
			$data .= getValidData($itemdata['Tno'])."|";
			$data .= getValidData($itemdata['DT'])."|";
			$data .= getValidData($itemdata['CL01'])."V|";
			$data .= getValidData($itemdata['CL02'])."V|";
			$data .= getValidData($itemdata['CL03'])."V|";
			$data .= getValidData($itemdata['CL04'])."V|";
			$data .= getValidData($itemdata['CL05'])."V|";
			$data .= getValidData($itemdata['CL06'])."V|";
			$data .= getValidData($itemdata['CL07'])."V|";
			$data .= getValidData($itemdata['CL08'])."V|";
			$data .= getValidData($itemdata['CL09'])."V|";
			$data .= getValidData($itemdata['CL10'])."V|";
			$data .= getValidData($itemdata['CL11'])."V|";
			$data .= getValidData($itemdata['CL12'])."V|";
			$data .= getValidData($itemdata['CL13'])."V|";
			$data .= getValidData($itemdata['CL14'])."V|";
			$data .= getValidData($itemdata['CL15'])."V|";
			$data .= getValidData($itemdata['CL16'])."V|";
			$data .= getValidData($itemdata['TE01'])."ºC|";
			$data .= getValidData($itemdata['TE02'])."ºC|";
			$data .= getValidData($itemdata['TE03'])."ºC|";
			$data .= getValidData($itemdata['TE04'])."ºC|";
			$data .= getValidData($itemdata['TE05'])."ºC|";
			$data .= getValidData($itemdata['TE06'])."ºC|";
			$data .= getValidData($itemdata['TE07'])."ºC|";
			$data .= getValidData($itemdata['TE08'])."ºC@"; 
		}

		$result->free();
		//$conn->close();

		if($rowcount == 0)	$data = "데이터없음";
	
		$bDetail= explode("@", $data);

		for($i = 0; $i < count($bDetail) -1; $i++) {
			$s_bDetail = explode("|", $bDetail[$i]);
			echo "<ul class = 'sub8_data1'>";
			echo "<li class = 'sub8_col1'>".$s_bDetail[0]."</li>";
			echo "<li class = 'sub8_col2'>".$s_bDetail[1]."</li>";
			echo "<li class = 'sub8_col3'>".$s_bDetail[2]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[3]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[4]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[5]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[6]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[7]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[8]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[9]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[10]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[11]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[12]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[13]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[14]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[15]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[16]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[17]."</li>";
			echo "<li class = 'sub8_col4'>".$s_bDetail[18]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[19]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[20]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[21]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[22]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[23]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[24]."</li>";
			echo "<li class = 'sub8_col5'>".$s_bDetail[25]."</li>";
			echo "<li class = 'sub8_col5' id='sub8_last'>".$s_bDetail[26]."</li>";
			echo "</ul>";
		}

		return;
	}

	//여러 데이터가 있을 때 처리하기
	function getSample(){
		global $conn;

		$sql = "SELECT dc.DT, dc.PV_SumPower, dc.ESS_SumPower, pc.SumYP
				FROM tbl_dpm_curr dc 
				JOIN tbl_pcs_curr pc ON dc.gno = pc.gno
				JOIN tbl_bmsrack_curr bc ON dc.gno = bc.gno
				WHERE bc.Rno = 0;";
	
		$result = $conn->query( $sql);
		$rowcount = $result->num_rows;	

		//1|데이터1|200@2|데이터2|300@
		$data = "";
		while($itemdata= $result->fetch_assoc()){
			//put the value to the data
			$data .= getValidData($itemdata['PV_SumPower'])."|";
			$data .= getValidData($itemdata['ESS_SumPower'])."|";
			$data .= getValidData($itemdata['SumYP'])."@";
		}

		$result->free();
		//$conn->close();

		if($rowcount == 0)	$data[0] = "데이터없음";

		return $data;
	}

?>