<? require_once "./inc/dbconn.php"; ?>

<div class="input_item">
  <span class='input_desc'>종류:</span>
  <select id="outlay_subfield" name='item_subid'>
  <?
    global $conn;

    $sql = "SELECT osc_id, osc_name FROM outlay_subcategory WHERE oc_id=".$_GET['id'];

    $result = $conn->query($sql);
    $rowcount = $result->num_rows;

    //data1|data2|data3@data1|data2|data3@
    $data = "";
    while($itemdata= $result->fetch_assoc()){
      //put the value to the data
      $data .= $itemdata['osc_id']."|";
      $data .= $itemdata['osc_name']."@";
    }

    $re_data = explode("@", $data);

    for($i = 0; $i<count($re_data)-1; $i++){
      $data_list = explode("|", $re_data[$i]);

      echo "<option value='$data_list[0]'>$data_list[1]</option>";
    }
  ?>
  </select>
</div>
<div class="blank5"></div>

<div class="input_item">
  <span class="input_desc">금액:</span>
  <input id="input_item_amount_value" name="item_amount" type="number" placeholder="금액(10,000)" min='0' scale='10'>원
</div>
<div class="blank5"></div>
