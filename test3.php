<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <style>
        /* 基本樣式 */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }

        /* 頂部導航 */
        .nav {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }

        .nav table {
            width: 100%;
            color: #fff;
        }

        .nav table td {
            padding: 10px;
            text-align: center;
        }

        .nav a {
            color: #73AAD4;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav a:hover {
            background-color: #444;
        }

        /* 表格樣式 */
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
        }

        td {
            padding: 15px;
            text-align: center;
            border: 1px solid #C4CCD1;
            width: 65px;
            height: 65px;
        }

        /* 節假日樣式 */
        .holiday {
            background-color: #E2B077;
            color: white;
        }

        /* 當前日期樣式 */
        .today {
            background-color: #1e88e5;
            color: white;
            font-weight: bold;
        }

        /* 星期幾 */
        .grey-text {
            color: #777;
        }

        /* 輸入區域 */
        .form-container {
            margin: 20px auto;
            text-align: center;
        }

        .form-container input {
            padding: 8px;
            font-size: 16px;
            margin: 0 5px;
            width: 120px;
            border-radius: 4px;
            border: 1px solid #444;
            background-color: #C4CCD1;
            color: #fff;
        }

        .form-container button {
            padding: 8px 16px;
            background-color: #5F91B7;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #84ABCD;
        }

        /* 今天日期信息 */
        .today-info {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }

        /* 動態週數 */
        .week-info {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #64b5f6;
        }
    </style>
</head>
<body>

<?php

// 設定時區為台灣時區
date_default_timezone_set('Asia/Taipei');

// 處理年份和月份的輸入
if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = date("m");
}

if (isset($_GET['year'])) {
    $year = $_GET['year'];
} else {
    $year = date("Y");
}

// 計算前一個月和下一個月
if ($month - 1 < 1) {
    $prevMonth = 12;
    $prevYear = $year - 1;
} else {
    $prevMonth = $month - 1;
    $prevYear = $year;
}

if ($month + 1 > 12) {
    $nextMonth = 1;
    $nextYear = $year + 1;
} else {
    $nextMonth = $month + 1;
    $nextYear = $year;
}

// 台灣固定國定假日（每年都固定的日期）
$holidays = [
    '01-01' => "元旦",
    '02-28' => "和平紀念日",
    '04-04' => "兒童節",
    '04-05' => "清明節",
    '05-01' => "勞動節",
    '10-10' => "國慶日",
];

// 台灣的農曆節日（以農曆日期來顯示，這裡使用簡單的假設日期）
$spDate = [
    '2024-01-25' => "農曆新年",
    '2024-06-10' => "端午節",
    '2024-09-17' => "中秋節",
    '2024-11-07' => "立冬",
    '2024-12-21' => "冬至",
    '2025-02-17' => "農曆新年",
    '2025-06-05' => "端午節",
    '2025-10-01' => "中秋節",
    '2025-11-07' => "立冬",
    '2025-12-21' => "冬至",
];

// 計算前後年份
$prevPrevYear = $year - 2; // 前年
$nextYear = $year + 1;     // 明年

?>

<!-- 顯示導航區域 -->
<div class='nav'>
<table style="width:100%">
    <tr>
        <td style='text-align:left'>
        <a href="">前年</a>
        <a href="test3.php?year=<?=$prevYear;?>&month=<?=$prevMonth;?>">上一個月</a>
        </td>
        <td>
        <?php echo date("{$month}月");?>
        </td>
        <td style='text-align:right'>
        <a href="test3.php?year=<?=$nextYear;?>&month=<?=$nextMonth;?>">下一個月</a>
        <a href="">明年</a>
        </td>
    </tr>
</table>
</div>

<!-- 用戶輸入年/月查詢的表單 -->
<div class="form-container">
    <form action="test3.php" method="get">
        <label for="year">年份：</label>
        <input type="number" id="year" name="year" value="<?= $year ?>" min="1900" max="9999" required>
        <label for="month">月份：</label>
        <input type="number" id="month" name="month" value="<?= $month ?>" min="1" max="12" required>
        <button type="submit">查詢</button>
    </form>
</div>

<!-- 顯示今天的西元年月日與當下時間 -->
<div class="today-info">
    <p>今天是：<a href="test3.php?year=<?=date('Y');?>&month=<?=date('m');?>"><?= date("Y年m月d日"); ?></a></p>
    <p>當前時間：<?php echo date("H:i:s"); ?></p>
</div>

<!-- 顯示當前週數 -->
<div class="week-info">
    <?php
        $week = date("W", strtotime("$year-$month-01"));
        echo "當前是第 {$week} 週";
    ?>
</div>

<!-- 顯示日曆 -->
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
