<div class="input_item">
  <span class="input_desc">수입명:</span>
  <input id="input_item_name_value" name="item_name" type="text" placeholder="기타">
</div>
<div class="blank5"></div>

<div class="input_item">
  <span class="input_desc">금액:</span>
  <input id="input_item_amount_value" name="item_amount" type="number" placeholder="금액(10,000)" min='0' scale='10'>원
</div>
<div class="blank5"></div>

<script>
  //input의 item_name's value 변경하기
  var name = $("#input_type").text();
  $("#input_item_name_value").val(name.substring(1, name.length-1));

  //추가 (+) 버튼 제작
</script>
