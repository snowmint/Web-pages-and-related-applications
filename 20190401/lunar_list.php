<?php
function GetLDay($CurDate) { 
    // 國曆農曆對應表
    // 以年為單位，共計12個月之對應資料，每個月共有4個參數
    // 該國曆月1日之農曆月，該國曆月1日之農曆日，該農曆月之天數，下一個農曆月(為處理閏月而加)
    $CalMap = array(
        '2019'=>array(
        1=>array(11, 26, 30, 12), 2=>array(12, 27, 30, 1),
        3=>array( 1, 25, 30, 2),  4=>array( 2, 26, 29, 3),
        5=>array( 3, 27, 30, 4),  6=>array( 4, 28, 29, 5),
        7=>array( 5, 29, 30, 6),  8=>array( 7, 1, 29, 8),
        9=>array( 8, 3, 30, 9),   10=>array( 9, 3, 29, 10),
        11=>array(10, 5, 29, 11),  12=>array( 11, 6, 30, 12)),
        '2020'=>array(
        1=>array(12, 7, 30, 1), 2=>array(1, 8, 29, 2),
        3=>array( 2, 8, 30, 3),  4=>array( 3, 9, 30, 4),
        5=>array( 4, 9, 30, 4),  6=>array( 4, 10, 29, 5),
        7=>array( 5, 11, 30, 6),  8=>array( 6, 12, 29, 7),
        9=>array( 7, 14, 29, 8),   10=>array( 8, 15, 30, 9),
        11=>array(9, 16, 29, 10),  12=>array( 10, 17, 30, 11)),
        '2021'=>array(
        1=>array(11, 18, 29, 12), 2=>array( 12, 20, 29, 1),
        3=>array( 1, 18, 29, 2),  4=>array( 2, 20, 30, 3),
        5=>array( 3, 20, 30, 4),  6=>array( 4, 21, 29, 5),
        7=>array( 5, 22, 30, 6),  8=>array( 6, 23, 29, 7),
        9=>array( 7, 25, 30, 8),   10=>array( 8, 25, 29, 9),
        11=>array(9, 27, 30, 10),  12=>array( 10, 27, 29, 11)),
        '2022'=>array(
        1=>array(11, 29, 30, 1), 2=>array( 1, 1, 30, 1),
        3=>array( 1, 29, 30, 3),  4=>array( 3, 1, 30, 4),
        5=>array( 4, 1, 29, 5),  6=>array( 5, 3, 30, 6),
        7=>array( 6, 3, 30, 7),  8=>array( 7, 4, 29, 8),
        9=>array( 8, 6, 30, 9),   10=>array( 9, 6, 29, 10),
        11=>array(10, 8, 30, 11),  12=>array( 11, 8, 29, 12)),
        '2023'=>array(
        1=>array(12, 10, 30, 1), 2=>array(1, 11, 29, 2),
        3=>array( 2, 10, 30, 2),  4=>array( 2, 11, 29, 3),
        5=>array( 3, 12, 29, 4),  6=>array( 4, 14, 30, 5),
        7=>array( 5, 14, 30, 6),  8=>array( 6, 15, 29, 7),
        9=>array( 7, 17, 30, 8),   10=>array( 8, 17, 30, 9),
        11=>array(9, 18, 29, 10),  12=>array( 10, 19, 30, 11)),
        '2024'=>array(
        1=>array(11, 20, 29, 12), 2=>array(12, 22, 30, 1),
        3=>array( 1, 21, 29, 2),  4=>array( 2, 23, 30, 3),
        5=>array( 3, 23, 29, 4),  6=>array( 4, 25, 29, 5),
        7=>array( 5, 26, 30, 6),  8=>array( 6, 27, 29, 7),
        9=>array( 7, 29, 30, 8),   10=>array( 8, 29, 30, 9),
        11=>array(10, 1, 30, 11),  12=>array( 11, 1, 30, 12)),
        '2025'=>array(
        1=>array(12, 2, 29, 1), 2=>array(1, 4, 30, 2),
        3=>array( 2, 2, 29, 3),  4=>array( 3, 4, 30, 4),
        5=>array( 4, 4, 29, 4),  6=>array( 5, 6, 29, 6),
        7=>array( 6, 7, 30, 6),  8=>array( 6, 8, 29, 7),
        9=>array( 7, 10, 30, 8),   10=>array( 8, 10, 29, 9),
        11=>array(9, 12, 30, 10),  12=>array( 10, 12, 30, 11))
    );
    // 下列陣列設定年度名稱
    // 陣列每列之內容為
    // 該農曆年之起始國曆年月日，該農曆年之結束國曆年月日，該農曆年之名稱
    $LunerYearMap = array(
        array('2019-02-05','2020-01-24','己亥'),
        array('2020-01-25','2021-02-11','庚子'),
        array('2021-02-12','2022-01-31','辛丑')
    );
    $MonthMap = array(1=>'正月', 2=>'二月', 3=>'三月', 4=>'四月', 5=>'五月', 6=>'六月',
     7=>'七月', 8=>'八月', 9=>'九月', 10=>'十月', 11=>'十一月', 12=>'十二月');
    $DayMap = array('','初一','初二','初三','初四','初五','初六','初七','初八','初九',
    '初十','十一','十二','十三','十四','十五','十六','十七','十八','十九',
    '二十','廿一','廿二','廿三','廿四','廿五','廿六','廿七','廿八','廿九','三十');
    $Year = substr($CurDate,0,4);
    $Month = substr($CurDate,5,2);
    if (substr($Month,0,1) == 0) $Month = substr($Month,1);
    $Day = substr($CurDate,8,2);
    if (substr($Day,0,1) == 0) $Day = substr($Day,1);
    $YearOfNextMonth = $Year;
    $NextMonth = $Month + 1;
    if ($NextMonth > 12) {
        $NextMonth = 1;
        $YearOfNextMonth++;
    }
    $YearName = '';
    foreach ($LunerYearMap as $item) {
        if (strcmp($item[0],$CurDate) <= 0 && strcmp($item[1],$CurDate) > 0) {
            $YearName = $item[2];
            break;
        }
    }
    if (!isset($CalMap[$Year])) return '無對應表資料';
    $MonthOfFirstDay = $CalMap[$Year][$Month][0];
    $DayOfFirstDay = $CalMap[$Year][$Month][1];
    $DayInLMonth = $CalMap[$Year][$Month][2];
    $NextLMonth = $CalMap[$Year][$Month][3];
    $RemainDay = $DayInLMonth - $DayOfFirstDay + 1;
    $AnsDay = $Day + $DayOfFirstDay - 1;
    $AnsMonth = $MonthOfFirstDay;
    if ($AnsDay > $DayInLMonth) {
        $AnsDay = $Day - $RemainDay;
        $AnsMonth = $NextLMonth;
    }
    $MonthName = $MonthMap[$AnsMonth];
    $DayName = $DayMap[$AnsDay];
    return "$MonthName$DayName";
}
?>