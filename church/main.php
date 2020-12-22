<?
  require_once "./inc/functions.php";
  include "./inc/_main_top.html";

  if($_GET[menu_type] == '') $_GET[menu_type] = '_income_input.php';
?>

<body>
  <div id="main_board">
    <div id="main_left_board">
      <div class="main_left_board_item main_left_board_item_selected" id="menu_income"><a href="#" onclick="openPage('_income_input.php')">수입 입력</a></div>
      <div class="main_left_board_item" id="menu_outlay"><a href="#" onclick="openPage('_outlay_input.php')">지출 입력</a></div>
      <div class="main_left_board_item" id="menu_income_doc"><a href="#" onclick="openPage('_income_doc.php')">수입 결의서</a></div>
      <div class="main_left_board_item" id="menu_outlay_doc"><a href="#" onclick="openPage('_outlay_doc.php')">지출 결의서</a></div>
    </div>
    <div id="main_right_board">
      hello, world!
    </div>

  </div>

  <script>
    window.onload = function pageLoad(){
      //selected menu
      openPage('<?=$_GET['menu_type']?>');
    };

    function openPage(file){// loading file
      $("#main_right_board").load(file);
      chagngeMenu(file);
    }

    function chagngeMenu(item){// changing menu's css
      // 1) restore previous menu's css
      if($('.main_left_board_item').hasClass('main_left_board_item_selected') === true)
        $('.main_left_board_item').removeClass('main_left_board_item_selected');

      // 2) change current menu's css
      var element = item.split('_');
      var element_id = '#menu_'+element[1];
      $(element_id).addClass('main_left_board_item_selected');
    }
  </script>
</body>

<? include "./inc/_main_bottom.html";?>
