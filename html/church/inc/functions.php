<?
	require_once "dbconn.php";

	//수입 카테고리 불러오기
  function getIC(){
    global $conn;

    $sql = "SELECT ic_id, ic_name, ic_desc2 FROM income_category";

    $result = $conn->query( $sql);
    $rowcount = $result->num_rows;

    $data = "";
    while($itemdata= $result->fetch_assoc()){
      //put the value to the data(data1|data2|data3@data1|data2|data3@)
      $data .= $itemdata['ic_name']."|";
			$data .= $itemdata['ic_id']."|";
      $data .= $itemdata['ic_desc2']."@";
    }

		$re_data = explode("@", $data);

		$switch=0;
		for($i = 0; $i<count($re_data)-1; $i++){
			$data_list = explode("|", $re_data[$i]);

			echo "<input type='button' class='offering' id='offering$data_list[1]' value='$data_list[0]', data-val='$data_list[1]', data-type='$data_list[2]' onclick='openInsert()'>";

			if($switch == 0)
				echo "<script>$('#offering1').addClass('offering_selected');</script>";
			$switch++;

			if($switch %5 == 0){echo "<div></div>";}
			//if($switch == 7){echo "<div class='blank'></div>";}
		}

    if($rowcount == 0)	$data[0] = "데이터없음";
  }

	//지출 카테고리 불러오기
	function getOC(){
		global $conn;

    $sql = "SELECT oc_id, oc_name FROM outlay_category";
		//echo $sql."</br>";

    $result = $conn->query( $sql);
    $rowcount = $result->num_rows;

    $data = "";
    while($itemdata= $result->fetch_assoc()){
      //put the value to the data(data1|data2|data3@data1|data2|data3@)
      $data .= $itemdata['oc_name']."|";
			$data .= $itemdata['oc_id']."@";
    }

		$re_data = explode("@", $data);

		$switch=0;
		for($i = 0; $i<count($re_data)-1; $i++){
			$data_list = explode("|", $re_data[$i]);

			echo "<input type='button' name='outlay' class='outlay' id='outlay$data_list[1]' value='$data_list[0]', data-val='$data_list[1]', onclick='openSubCategory()'>";

			if($switch == 0)
				echo "<script>$('#outlay1').addClass('outlay_selected');</script>";
			$switch++;

		}

    if($rowcount == 0)	$data[0] = "데이터없음";

	}



class OC{
	//지출 서브 카테고리 불러오기
	function getSubOC(){
		echo "called";
		//echo "<script>alert('CLICKED!');</script>";
	}
}

$OC = new OC();

	/*login.php
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


	//데이터 한 개
	function getTotalInfo0(){
    global $conn;

    $sql ="";

    $result = $conn->query( $sql);
    $rowcount = $result->num_rows;

    if($rowcount == 0){
      $data[0] = "";
      $data[1] = "";
    }
    else {
      //put the value to the data
      $itemdata= $result->fetch_assoc();

      $data[0] = getValidData($itemdata['ic_id']);
      $data[1] = getValidData($itemdata['ic_name']);
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
*/
?>
