<?
  require_once "./inc/dbconn.php";
  include "./inc/_main_top.html";
?>

<?
  global $conn;

  if($_POST['item_name']!='') {//하나만 입력할때
    $sql = "INSERT INTO income_input (ic_id, ii_name, ii_cost, ii_date)
            VALUES (".$_POST['item_id'].", '".$_POST['item_name']."', ".$_POST['item_amount'].", '".$_POST['item_date']."')";

    $result = $conn->query($sql);
    if ($result){
?>
      <script>
        alert('저장되었습니다.');
        window.location.href = "http://ubinet2018.dothome.co.kr/church/main.php?menu_type='_income_input.php'";
      </script>
<?
    } else{
      echo "<script>alert('저장 실패 : ".mysqli_error($conn)."');</script>";
    }
  } else {//여러개 입력할 때
    $base_index1='item_name';
    $base_index2='item_amount';
    for($i=1; $i<=50; $i++){
      $index1 = $base_index1.$i;
      $index2 = $base_index2.$i;
      if($_POST[$index1] == '' || $_POST[$index2] == '') continue;
      else{
        $sql = "INSERT INTO income_input (ic_id, ii_name, ii_cost, ii_date)
                VALUES (".$_POST['item_id'].", '".$_POST[$index1]."', ".$_POST[$index2].",'".$_POST['item_date']."')";

        $result = $conn->query($sql);
        if (!$result)
          echo "<script>
                  alert('".$_POST[$index1]." 저장 실패 : ".mysqli_error($conn)."');
                </script>";
      }
    }
?>
    <script>
      alert('저장되었습니다.');
      window.location.href = "http://ubinet2018.dothome.co.kr/church/main.php?menu_type='_income_input.php'";
    </script>
<?
  }
?>

<body></body>

<? include "./inc/_main_bottom.html"; ?>
