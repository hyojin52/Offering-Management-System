<?
  require_once "./inc/functions.php";
  include "./inc/_main_top.html";
  $date = date("Y-m-d");
?>

  <body>
    <div class="title_1">지출입력</div>
    <div class="blank10"></div>

    <div id="outlay_field">
      <? getOC(); ?>
    </div>
    <div class="blank10"></div>


    <div id="input_field">
      <div id="input_type" class="title_2">[관리]</div>
      <div class="blank10"></div>

      <form id="data_form" class="main_form" action="_outlay_input_insert.php" method="post">

        <input type="hidden" name="item_id" id="item_id" value="1">
        <input type="hidden" name="menu_type" value="_outlay_input.php">

        <div class="input_item">
          <span class="input_desc">날짜:</span>
          <input type="date" name="item_date" value="<?=$date?>">
        </div>
        <div class="blank5"></div>

        <div id="user_input_field"></div>
        <div class="blank5"></div>

        <p><input type="submit" value="입력"></p>
      </form>
    </div>

    <script>
      //초기 설정
      $('#user_input_field').load('outlay_input_all.php?id="1"');

      function openSubCategory(){
        //click된 버튼 해당하는 타이틀 변경
        $('#input_type').text('['+event.target.value+']');
        $('#item_id').val(event.target.dataset.val);

        //click된 버튼 해당하는 입력칸 로드
        var file='outlay_input_all.php?id="'+event.target.dataset.val+'"';
        $('#user_input_field').load(file);

        //change selected button's css
        changeItem(event.target.dataset.val);
      }
      function changeItem(id){
        // 1) restore previous menu's css
        if($('.outlay').hasClass('outlay_selected') === true)
          $('.outlay').removeClass('outlay_selected');

        // 2) change current menu's css
        var element_id = "#outlay"+id;
        $(element_id).addClass('outlay_selected');
      }

    </script>
  </body>

<? include "./inc/_main_bottom.html";?>
