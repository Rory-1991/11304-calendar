<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="#">
  <title>萬年曆作業</title>
  <style>
   /*請在這裹撰寫你的CSS*/ 
    table{
        border-collapse:collapse;
        /* background:rgb(<?=rand(50,2250);?>,<?=rand(200,150);?>,<?=rand(200,255);?>); */
        /* 程式碼的部分輸出字串 */
        margin:auto;
        
    }
    td{
        padding:5px 10px;
        text-align: center;
        border:1px solid #999;
        width: 65px;
        

    }
    .holiday{
        background:pink;
        color:#999;
    }
    .grey-text{
        color:#999;
    }
    .today{
        background:blue;
        color:white;
        font-weight:bolder;
    }
    .nav{
        width: 688px;
        margin:auto;
    }
    .nav table td{
        border:0px;
        padding:0;
    }
  </style>
</head>
<body>


<?php
/*請在這裹撰寫你的萬年曆程式碼*/  


if(isset($_GET['month'])){
    $month=$_GET['month'];
}else{
    $month=date("m");
}
if(isset($_GET['year'])){
    $year=$_GET['year'];
    
}else{
    $year=date("Y");
}

if($month-1<1){
    $prevMonth=12;
    $prevYear=$year-1;
}else{
    $prevMonth=$month-1;
    $prevYear=$year;
}

if($month+1>12){
    $nextMonth=1;
    $nextYear=$year+1;
}else{
    $nextMonth=$month+1;
    $nextYear=$year;
}

$spDate=['2024-11-07'=>"立冬",
        '2024-11-22'=>"小雪"];
$holidays = [
    // 每年固定的節日就不需要年份
'01-01' => "元旦",
'02-10' => "農曆新年",
'04-04' => "兒童節",
'04-05' => "清明節",
'05-01' => "勞動節",
'06-10' => "端午節",
'10-10' => "國慶日",
];

?>
<div class='nav'>
<table style="width:100%">
    <tr>
        <td style='text-align:left'>
        <a href="">前年</a>
        <a href="calendar.php?year=<?=$prevYear;?>&month=<?=$prevMonth;?>">上一個月</a>
        </td>
        <td>
        <?php echo date("{$month}月");?>
        </td>
        <td style='text-align:right'>
        <a href="calendar.php?year=<?=$nextYear;?>&month=<?=$nextMonth;?>">下一個月</a>
        <a href="">明年</a>
        </td>
    </tr>
</table>
</div>
    


<table>
<tr>
    <td></td>
    <td>日</td>
    <td>一</td>
    <td>二</td>
    <td>三</td>
    <td>四</td>
    <td>五</td>
    <td>六</td>
</tr>
<?php

$firstDay="{$year}-{$month}-1";
$firstDayTime=strtotime($firstDay);
$firstDayWeek=date("w",$firstDayTime);

for($i=0;$i<6;$i++){
    echo "<tr>";
    echo "<td>";
    echo $i+1;
    echo "</td>";
    for($j=0;$j<7;$j++){
        //echo "<td class='holiday'>";
        $cell=$i*7+$j -$firstDayWeek;
        $theDayTime=strtotime("$cell days".$firstDay);

        //所需樣式css判斷
        $theMonth=(date("m",$theDayTime)==date("m",$firstDayTime))?'':'grey-text';
        $isToday=(date("Y-m-d",$theDayTime)==date("Y-m-d"))?'today':'';
        $w=date("w",$theDayTime);
        $isHoliday=($w==0 || $w==6)?'holiday':'';
        
        echo "<td class='$isHoliday $theMonth $isToday'>";
        echo date("d",$theDayTime);
        if(isset($spDate[date("Y-m-d",$theDayTime)])){
            echo "<br>{$spDate[date("Y-m-d",$theDayTime)]}";
        }
        if(isset($holidays[date("m-d",$theDayTime)])){
            echo "<br>{$holidays[date("m-d",$theDayTime)]}";
              // 每年固定的節日就不需要年份
        }

        echo "</td>";
        
    }
    echo "</tr>";
}



?>
</table>
  

  
</body>
</html>