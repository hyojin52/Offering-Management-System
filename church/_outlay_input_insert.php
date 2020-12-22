<?
  require_once "./inc/dbconn.php";
  include "./inc/_main_top.html";
?>

<?
  global $conn;

  $sql = "INSERT INTO outlay_input (osc_id, oi_cost, oi_date)
          VALUES (".$_POST['item_subid'].", ".$_POST['item_amount'].", '".$_POST['item_date']."')";

  $result = $conn->query($sql);
  if ($result){
?>
    <script>
      alert('저장되었습니다.');
      window.location.href = "http://ubinet2018.dothome.co.kr/church/main.php?menu_type='_outlay_input.php'";
    </script>
<?
} else{
    echo "<script>alert('저장 실패 : ".mysqli_error($conn)."');</script>";
}
?>

<body></body>

<? include "./inc/_main_bottom.html"; ?>
