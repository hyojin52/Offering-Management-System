<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>교회 회계 프로그램</title>
</head>

<body>
  <div class="title_1">수입 지출 보고서</div>

  <table id="income">
    <tr class="row1">
      <th>
        <td>수입</td>
      </th>
    </tr>
    <tr class="row2">
        <td class="item">항목</td>
        <td class="monthly">월계</td>
        <td class="sub_total">소계</td>
        <td class="cumulative">누계</td>
    </tr>
    <tr><!--추가)자동 출력-->
      <td class="item">십일조</td>
      <td class="monthly"></td>
      <td class="sub_total"></td>
      <td class="cumulative"></td>
    </tr>
  </table>

  <table id="outlay">
    <tr class="row1">
      <th>
        <td>지출</td>
      </th>
    </tr>
    <tr class="row2">
      <td class="item" colspan="2">항목</td>
      <td class="monthly">월계</td>
      <td class="sub_total">소계</td>
      <td class="cumulative">누계</td>
    </tr>
    <tr><!--추가)자동 출력-->
      <td class="item" >관리</td><!--추가) rowspan=""-->
      <td class="sub_item">항목</td>
      <td class="monthly"></td>
      <td class="sub_total"></td>
      <td class="cumulative"></td>
    </tr>
  </table>

  <div ></div>

</body>
</html>
