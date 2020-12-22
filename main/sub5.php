<?
	include "./inc/top.php";

	$region = $_POST['region'];
?>
<link rel = "stylesheet" type="text/css" href="./css/sub5.css">
<link rel = "stylesheet" type="text/css" href="./css/paging.css">

<script>
function showEventDetail(info1, info2, info3){
	$('#sub5DetailInfo').attr('style','visibility:visible');
	$('#sub5DetailInfo1').text(info1);
	$('#sub5DetailInfo2').text(info2);
	$('#sub5DetailInfo3').text(info3);}

function hideEventDetail(){
		$("#sub5DetailInfo").attr('style','visibility:hidden');}

$(document).ready(function(){
	$('.sub5DetailInfoButton').click(function(){
		index = $(this).attr('id'); //Alerts the ID of the button that was clicked.
		index *= 5;
		index += 6;
		index += '%';
		$(".sub5DetailInfo").attr('style', 'top:'+index+';visibility:visible;');
	});
});

</script>


<div id="sub5Wrapper">

	<div id="sub5Menu">
		<nav class="menuList">
			<ul>
				<li class="menuList1" id="selectedMenu"><a href="#">이벤트<span class="sub5Next"><br></span> 발생내역</a></li>
				<li class="menuList2" id="notSelected"><a href="sub6.php">유저<span class="sub5Next"><br></span>관리</a></li>
				<li class="menuList3" id="notSelected"><a href="sub7.php">배터리<span class="sub5Next"><br></span> 상세정보</a></li>
			</ul>
		</nav>
	</div>

	<div id="sub5Chart">

		<div class="sub5SelectRegion">
			<form method="POST" action="">
				<select name="region" id="region">
					<option value="0" selected>설치지역</option>
					<option value="1" <?if ($region == "1") { echo " selected"; } ?>>포항</option>
					<option value="2" <?if ($region == "2") { echo " selected"; } ?>>익산</option>
				</select>
				<input id="search5" type="submit" name="search5"  value="검색">
			</form>
		</div>

		<div class="sub5ChartList">
			<ul class='sub5DataFirst firstBG'>
				<li class='sub5_col1'>일시</li>
				<li class='sub5_col2'>장비명</li>
				<li class='sub5_col3'>이벤트명</li>
				<li class='sub5_col4'>상세정보</li>				
			</ul>

			<div class="sub5ChartListData">
				<?
					if(isset($_POST["search5"])){
						$region = $_POST['region'];
						require_once "./inc/sub5_paging.php";
						getEventData($result);
					} else {
						$region = 0;
						require_once "./inc/sub5_paging.php";
						getEventData($result);
					}
				?>
			</div>
		</div>

		<div class="paging">
			<?php echo $paging ?>
		</div>

		<!--상세 정보-->
		<div id="sub5DetailInfo" class="sub5DetailInfo">
			<span class="sub5DetailInfoClose"><a href="#" onclick="hideEventDetail();"><i class="far fa-window-close"></i></a></span>
			<h2>상세정보</h2>
			<div class="sub5DetailInfoRow">
				<span class="sub5DetailInfoDesc">일시:</span>
				<span id="sub5DetailInfo1" class="sub5DetailInfoData"></span>
			</div>
			<div class="sub5DetailInfoRow">
				<span class="sub5DetailInfoDesc">장비명:</span>
				<span id="sub5DetailInfo2" class="sub5DetailInfoData"></span>
			</div>
			<div class="sub5DetailInfoRow">
				<span class="sub5DetailInfoDesc">이벤트명:</span>
				<span id="sub5DetailInfo3" class="sub5DetailInfoData"></span>
			</div>
			<input type="button" class="sub5DetailInfoConfirm" value="확인" onclick="hideEventDetail();">
		 </div>

	</div>
</div>	