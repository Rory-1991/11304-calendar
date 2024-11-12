<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
</head>
<body>
<h1>萬年曆</h1>
<style>
    table{
        border-collapse:collapse;
        margin:auto;
    }

    td{
        padding:5px 10px;
        text-align: center;
        border:1px solid #999;
        width:65px;
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
        width:688px;
        margin:auto;
    }
    .nav table td{
        border:0px;
        padding:0;
    }
    .form-container {
        text-align: center;
        margin-top: 20px;
    }
    .today-info {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
    }
</style>

<ul>
    <li>有上一個月下一個月的按鈕</li>
    <li>萬年曆都在同一個頁面同一個檔案</li>
    <li>有前年和來年的按鈕</li>
</ul>

<?php

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

// 計算前年和明年
$prevPrevYear = $year - 2; // 前年
$nextYear = $year + 1;     // 明年

?>

<div class='nav'>
    <table style="width:100%">
        <tr>
            <td style='text-align:left'>
                <a href="test.php?year=<?=$prevPrevYear;?>&month=<?=$month;?>">前年</a>
                <a href="test.php?year=<?=$prevYear;?>&month=<?=$prevMonth;?>">上一個月</a>
            </td>
            <td>
                <?php echo date("{$month}月"); ?>
            </td>
            <td style='text-align:right'>
                <a href="test.php?year=<?=$nextYear;?>&month=<?=$month;?>">明年</a>
                <a href="test.php?year=<?=$nextYear;?>&month=<?=$nextMonth;?>">下一個月</a>
            </td>
        </tr>
    </table>
</div>

<!-- 用戶輸入年/月查詢的表單 -->
<div class="form-container">
    <form action="test.php" method="get">
        <label for="year">年份：</label>
        <input type="number" id="year" name="year" value="<?= $year ?>" min="1900" max="9999" required>
        <label for="month">月份：</label>
        <input type="number" id="month" name="month" value="<?= $month ?>" min="1" max="12" required>
        <button type="submit">查詢</button>
    </form>
</div>

<!-- 顯示今天的西元年月日與當下時間 -->
<div class="today-info">
    <p>今天是：<?php echo date("Y年m月d日"); ?></p>
    <p>當前時間：<?php echo date("H:i:s"); ?></p>
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

// 計算每個月的第一天是星期幾
$firstDay = "{$year}-{$month}-01";
$firstDayTime = strtotime($firstDay);
$firstDayWeek = date("w", $firstDayTime);

// 顯示日曆
for ($i = 0; $i < 6; $i++) {
    echo "<tr>";
    echo "<td>";
    echo $i + 1;
    echo "</td>";
    for ($j = 0; $j < 7; $j++) {
        // 計算日期
        $cell = $i * 7 + $j - $firstDayWeek;
        $theDayTime = strtotime("$cell days" . $firstDay);

        // 需要的樣式：當月日期、今天、假日等
        $theMonth = (date("m", $theDayTime) == date("m", $firstDayTime)) ? '' : 'grey-text';
        $isToday = (date("Y-m-d", $theDayTime) == date("Y-m-d")) ? 'today' : '';
        $w = date("w", $theDayTime);
        $isHoliday = ($w == 0 || $w == 6) ? 'holiday' : '';

        echo "<td class='$isHoliday $theMonth $isToday'>";
        echo date("d", $theDayTime);

        // 顯示農曆節日
        if (isset($spDate[date("Y-m-d", $theDayTime)])) {
            echo "<br>{$spDate[date("Y-m-d", $theDayTime)]}";
        }

        // 顯示國定假日
        if (isset($holidays[date("m-d", $theDayTime)])) {
            echo "<br>{$holidays[date("m-d", $theDayTime)]}";
        }

        echo "</td>";
    }
    echo "</tr>";
}

?>
</table>
</body>
</html>
