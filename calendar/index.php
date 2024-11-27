<?php
date_default_timezone_set('Asia/Taipei'); // 設定台灣時區
$currentYear = date('Y');
$currentMonth = date('n');

$year = isset($_GET['year']) ? intval($_GET['year']) : $currentYear;
$month = isset($_GET['month']) ? intval($_GET['month']) : $currentMonth;

function getCalendar($year, $month) {
    $firstDayOfMonth = strtotime("$year-$month-1");
    $daysInMonth = date('t', $firstDayOfMonth);
    $startDay = date('w', $firstDayOfMonth);

    $calendar = [];
    for ($i = 0; $i < $startDay; $i++) {
        $calendar[] = '';
    }
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $calendar[] = $day;
    }
    return $calendar;
}

$calendar = getCalendar($year, $month);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calendar-container">
        <header>
            <h1><?= $year ?> 年 <?= $month ?> 月</h1>
            <p>現在時間：<?= date('Y-m-d H:i:s') ?></p>
            <div class="controls">
                <button onclick="navigate(-12)">上一年</button>
                <button onclick="navigate(-1)">上一月</button>
                <button onclick="navigate(1)">下一月</button>
                <button onclick="navigate(12)">下一年</button>
            </div>
            <div>
                <input type="number" id="yearInput" placeholder="輸入年份" min="1980" max="2050">
                <input type="number" id="monthInput" placeholder="月份" min="1" max="12">
                <button onclick="searchCalendar()">搜尋</button>
            </div>
            <div class="range-selector">
                <label for="yearRange">快速選擇年份:</label>
                <input type="range" id="yearRange" min="1980" max="2050" value="<?= $year ?>" onchange="updateRange(this.value)">
                <span id="rangeValue"><?= $year ?></span>
            </div>

        </header>
        <table>
            <thead>
                <tr>
                    <th>日</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                    <th>六</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $week = [];
                foreach ($calendar as $day) {
                    $week[] = $day;
                    if (count($week) == 7) {
                        echo '<tr>' . implode('', array_map(fn($d) => "<td>$d</td>", $week)) . '</tr>';
                        $week = [];
                    }
                }
                if ($week) {
                    echo '<tr>' . implode('', array_map(fn($d) => "<td>$d</td>", $week)) . '</tr>';
                }
                ?>
            </tbody>
        </table>
        <footer>
            <p>天氣：<span id="weatherIcon"></span><span id="weatherText"></span></p>
        </footer>
    </div>
    <script src="script.js"></script>
</body>
</html>
