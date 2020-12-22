<?
  require_once "./inc/functions.php";
  include "./inc/_main_top.html";
  $date = date("Y-m-d");
?>

  <body>
    <div class="title_1">주간 수입 결의서</div>
    <div class="blank10"></div>

    <div id="search_day">
      <form id="search_day_form" class="income_doc_form" name="i_day_doc_form" method="GET"  action="" target="">

        <input type="hidden" name="menu_type" value="'_income_day_doc.php'">

        <div class="input_item">
          <span class="input_desc">날짜:</span>
          <input type="date" name="item_date" value="<?=$date?>">
          <input type="button" name="submit" value="검색" onclick="newWindow()">
        </div>
        <div class="blank5"></div>

      </form>
    </div>
    <div class="blank10"></div>

    <div id="search_result_field" name="search_result_field">

      <div class="blank5"></div>
      <div class="blank5"></div>

<?
  echo $item_date."<br>";
  if(isset($item_date)){
    echo "2. form submitted";
  }else{
    echo "2. form not submitted";
  }
?>

<?php
  $http_host2 = $_SERVER['HTTP_HOST'];
  $request_uri2 = $_SERVER['REQUEST_URI'];
  $url2 = 'http://' . $http_host2 . $request_uri2;

  echo $url2;
?>
    </div>

    <script>
      //초기 세팅
      $('#user_input_field').load('income_input_general1.php');

      function openInsert(){
        //click된 버튼 해당하는 타이틀 변경
        $('#input_type').text('['+event.target.value+']');
        $('#item_id').val(event.target.dataset.val);

        //click된 버튼 해당하는 입력칸 로드
        var file='income_input_';
        file = file+event.target.dataset.type+'.php';
        $('#user_input_field').load(file);

        //change selected button's css
        changeItem(event.target.dataset.val);
      }
      function changeItem(id){
        // 1) restore previous menu's css
        if($('.offering').hasClass('offering_selected') === true)
          $('.offering').removeClass('offering_selected');

        // 2) change current menu's css
        var element_id = "#offering"+id;
        $(element_id).addClass('offering_selected');
      }

      function newWindow(){
        //i_day_doc_form.action = "_income_day_doc_result.php";
        //i_day_doc_form.target = "_blank";
        window.open('', 'form_result', 'toolbar=0, width=900, height=380, resizable=no, scrollbars=yes');
        i_day_doc_form.action = "_income_day_doc_result.php";
        i_day_doc_form.target = "form_result";
        i_day_doc_form.submit();
      }
    </script>
  </body>

<? include "./inc/_main_bottom.html";?>
