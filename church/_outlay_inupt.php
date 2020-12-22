<?
  require_once "./inc/functions.php";
  include "./inc/_main_top.html";
  $date = date("Y-m-d");
?>

  <body>
    <script>
      function openInsert(){
        //click된 버튼 해당하는 타이틀 변경
        $('#input_type').text(event.target.value);
        $('#item_id').val(event.target.dataset.val);

        //click된 버튼 해당하는 입력칸 로드
        var file='income_input_';
        file = file+event.target.dataset.type+'.php';
        $('#user_input_field').load(file);

        //click된 버튼 style 변경 & 다른 버튼들 원래 대로 되돌리기

      }
    </script>

    <div class="title_1">지출입력</div>

    <div id="outlay_field">
      <? getOC(); ?>
    </div>

    <div id="input_field">
      <div id="input_type">지출종류</div>
      <form id="data_form" class="main_form" action="_outlay_input_insert.php" target="_blank" method="post">

        <input type="hidden" name="item_id" id="item_id" value="">

        <div class="input_item">
          <span class="input_desc">날짜:</span>
          <input type="date" name="item_date" value="<?=$date?>">
        </div>

        <div id="user_input_field"></div>

        <p><input type="submit" value="입력"></p>
      </form>
    </div>
  </body>

<? include "./inc/_main_bottom.html";?>
