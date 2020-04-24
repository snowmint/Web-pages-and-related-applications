<?php
    include ("lunar_list.php");
    session_start();
    /*if(isset($_POST['remove'])) {
        unset($_SESSION['month']);
    }*/
    $_SESSION['year_r'];
    $_SESSION['month_r'];
    if(isset($_POST['YearSelect'])){
        $_SESSION['year_r'] = $_POST['YearSelect'];
    }
    if(isset($_POST['MonthSelect'])){
        $_SESSION['month_r'] = $_POST['MonthSelect'];
    }
    $YearSelect='';
    if(!empty($_POST) && isset($_POST['YearSelect'])) $YearSelect = $_POST['YearSelect'];
    $MonthSelect='';
    if(!empty($_POST) && isset($_POST['MonthSelect'])) $MonthSelect = $_POST['MonthSelect'];
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="test/html; charset=utf-8" />
        <meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="Parama" content="no-cache">
        <meta name="viewpoint" content="width=device-width, initial-scale = 1.0,minimum-scale=1.0,maximum-scale=1.6">
        <title>index</title>
        <style>
            body {
                /*background: #586b89;*/
                color: aliceblue;
                font-size: 30px;
                /*background-image: linear-gradient(to top, #859bc4 0%, #52729e 100%);*/
                background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            }

            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                cursor: pointer;
                width: 80px;
                padding: 5px 20px;
                color: #44597a;
                border: none;
                /* 2px solid #006DD9;*/
                border-radius: 5px;
                font-size: 15pt;
                cursor: pointer;
                text-align: center;
                z-index: 20;
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            }

            input[type=text],
            select {
                width: 150px;
                padding: 5px 50px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .button {
                border: none;
                padding: 8px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                -webkit-transition-duration: 0.4s;
                /* Safari */
                transition-duration: 0.4s;
                cursor: pointer;
                background-color: white;
                color: #555555;
                border: 2px solid #DDF1FF;
                border-radius: 10%;
            }

            .button:hover {
                background-color: #888888;
                color: white;
                border: 2px solid #AAAAAA;
            }
            
            table {
              margin-top: 20px;
              background: #fff;
              border-collapse: collapse;
              color: #222;
              font-family: 'PT Sans', sans-serif;
              font-size: 20px;
              width: 600px;/*500px;*/
            }
            th {
              border: 1px solid #eee;
              color: #444;
              line-height: 22px;
              background-color: aliceblue;
              text-align: center;
              width:100px;
              height: 50px;
            }
            td {
              border: 1px solid #eee;
              color: #444;
              line-height: 22px;
              text-align: center;
              width:100px;
              height: 80px;
            }
            tr:first-child td {
              color: #eee;
              font-weight: 700;
              width:100px;
              height: 80px;
            }
        </style>
    </head>

    <body>
        <div style="text-align:center;margin:20px 0;" align="center">
            <form method="post" name="NumSelect" onchange="submit();" action="">
                Please choose the Year : <select name="YearSelect">
                <?php
                    $year = 2019 ;
                    while($year <= 2025){
                        echo '<option value="'.$year.'"';
                        if($year == $YearSelect) echo 'selected'; //鎖定選項
                        echo '>' . $year . '</option>';
                        $year++;
                    }
                ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;Month : 
                <select name="MonthSelect" style="padding: 5px 10px;">
                  <?php
                    $month = 1;
                    for($month=1; $month <= 12; $month++){
                        echo '<option value="'.$month.'"';
                        if($month == $MonthSelect) echo 'selected'; //鎖定選項
                        echo '>' . $month . '</option>';
                    }
                    ?>
                </select>
            </form>
            <?php
                if(!empty($_SESSION['year_r']) && !empty($_SESSION['month_r'])) echo $_SESSION['year_r']." / ".$_SESSION['month_r'];
                $m = intval($MonthSelect);
                $y = intval($YearSelect);
                $arrMonth = array();
                for($i = 0; $i < 6; $i++) {
                    for($j = 0; $j < 7; $j++) {
                        $arrMonth[$i][$j] = '';
                    }
                }
                $FirstDate = 1;
                $NextMonth = $m+1;
                $CheckYear = $y;
                if($NextMonth == 13) {
                    $NextMonth = 1;
                    $CheckYear++;
                }
                $LastDate = date('d', mktime(0, 0, 0, $NextMonth, 0, $CheckYear));
                $Row = 0;
                for($d = 1; $d <= $LastDate; $d++) {
                    $Day = date('w', mktime(0, 0, 0, $m, $d, $y));//'w' = 0~6 = sun ~ sat
                    if($Day == 0 && $d > 1) $Row++;
                    $arrMonth[$Row][$Day] = $d;
                }
            ?><br>
                <table border="1" align="center" width="350">
                    <tr>
                        <th width="50">日</th>
                        <th width="50">一</th>
                        <th width="50">二</th>
                        <th width="50">三</th>
                        <th width="50">四</th>
                        <th width="50">五</th>
                        <th width="50">六</th>
                    </tr>
                    <?php
                    for($i = 0; $i < 6; $i++) {
                        if($i > 2 && empty($arrMonth[$i][0])) continue;//不顯示最後空行
                    ?>
                        <tr align="center">
                        <?php
                        for($j = 0; $j < 7; $j++) {
                            $ShowDate = $arrMonth[$i][$j];
                            if(empty($ShowDate)) $ShowDate = '&nbsp;';
                        ?>
                        <td>
                            <?php echo $ShowDate."<br>"; ?>
                            <?php
                            if(isset($_SESSION['year_r']) && isset($_SESSION['month_r']) && $ShowDate != '&nbsp;') {
                                $Iy = intval($_SESSION['year_r']);
                                $Im = intval($_SESSION['month_r']);
                                $Id = intval($ShowDate);
                                $Argument = date('Y-m-d',mktime(1,0,0,$Im,$Id,$Iy));
                                $LDayName = GetLDay($Argument);
                                echo "<font style='font-size:14px;color:#999;'>".$LDayName."</font>";
                            }
                            ?>
                            <?php
                            /*if(isset($_SESSION['year_r']) && isset($_SESSION['month_r']) && $ShowDate != '&nbsp;') {
                                $Iy = intval($_SESSION['year_r']);
                                $Im = intval($_SESSION['month_r']);
                                $Id = intval($ShowDate);
                                echo $Iy." ".$Im." ".$id;
                                $temp = new Lunar();
                                $res = $temp->convertSolarToLunar($Iy, $Im, $Id);
                                echo $res;
                            }*/
                            ?>
                        </td>
                        <?php
                        }
                        ?>
                        </tr>
                    <?php
                    }
                    ?>
            </table>
        </div>
    </body>
</html>
