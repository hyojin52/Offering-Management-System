<div id="input_table">
  <div id="input_table_title_row", class='input_table_data_row'>
    <div id="input_table_title_no">번호</div>
    <div id="input_table_title_name">이름</div>
    <div id="input_table_title_sum">금액</div>
  </div>

<?
  for($i=1; $i<=50; $i++){
    echo "<div class='input_table_data_row'>
            <div class='input_table_data_no'>$i</div>
            <div class='input_table_data_name'><input type='text' name='item_name$i' placeholder='이름'></div>
            <div class='input_table_data_sum'><input type='number' name='item_amount$i' placeholder='금액(10,000)' min='0' scale='10'></div>
          </div>";
  }
?>
</div>
