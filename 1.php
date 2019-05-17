<?php

include 'connect.php';
include 'jdf.php';

$personal_code = 1;

if (isset($_GET['submit'])) {
  $personal_code = $_GET['personal_code'];
}

$stmt = $conn->prepare("SELECT * FROM tbl WHERE personal_code=$personal_code");
$stmt->execute();
$data = $stmt->fetchAll();
?>
 <head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head> 
<form action="">
<input type="text" method="get" name="personal_code">
<input type="submit" name="submit">
</form>
 <table style="width:100%; ">
  <tr style="background-color: #4CAF50; color: white;">
    <th>ردیف</th>
    <th>شماره پرسنلی</th>
    <th>تاریخ</th>
    <th>ساعت</th>
  </tr>
  <?php
  $count = 1;
  $dateToShowOld=0;
foreach ($data as $row) {
    ?>
  <tr style="text-align:center">
    <td>
      <?php echo $count; ?>
    </td>
    <td>
    <?php
      $personalCodeToShow = $row['personal_code'];
      echo $personalCodeToShow;
    ?>
    </td>

    <td>
    <?php
      $dateToShow = jdate('Y/m/d', strtotime($row['date']));
      
      if($dateToShow==$dateToShowOld)
      echo '<span style="color:red">'.$dateToShow.'</span>';
      else
      echo '<span style="color:blue">'.$dateToShow.'</span>';

    ?>
    </td>
    
    <td>
    <?php
      $re = '/(\s.*)/m';
      $str = $row['date'];

      $s = preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

      $timeToShow = $matches[0][0];

      if($timeToShow <= 13)
      echo '<span style="color:blue">'.$timeToShow.'</span>';
      if($timeToShow > 13)
      echo '<span style="color:red">'.$timeToShow.'</span>';

    ?>
    </td>

  </tr>

  <?php
  $dateToShowOld = $dateToShow;
  $count++;
}
?>
</table>