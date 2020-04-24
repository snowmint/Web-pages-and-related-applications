<?php
    session_start();
    /*if(isset($_POST['remove'])) {
        unset($_SESSION['month']);
    }*/
    $_SESSION['year_r'] = 2019;
    $_SESSION['month_r'] = 1;
    //if(isset($_POST['YearSelect'])){
        $_SESSION['year_r'] = 2019;
    //}
    if(isset($_POST['MonthSelect'])){
        $_SESSION['month_r'] = $_POST['MonthSelect'];
    }
    $YearSelect=2019;
    //if(!empty($_POST) && isset($_POST['YearSelect'])) $YearSelect = $_POST['YearSelect'];
    $MonthSelect=1;
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
            div.footer {
                height: 40px;
                color: #5878aa;
                box-sizing: border-box;
                position: relative;
                bottom: 20px;
                width: 90%;
                margin-top: -100px;
            }
            a,
            a:link,
            a:visited {
                color: #CCCCCC;
                text-decoration: none;
            }

            a:hover {
                color: cornflowerblue;
                text-decoration: none;
            }

            a:active {
                color: #D2F1B5;
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <div style="text-align:center;margin:20px 0;" align="center">
            <form method="post" name="NumSelect" onchange="submit();" action="">
                Please choose the Year : 
                <?php
                    $year = 2019 ;
                    echo $year;
                    /*while($year <= 2025){
                        echo '<option value="'.$year.'"';
                        if($year == $YearSelect) echo 'selected'; //鎖定選項
                        echo '>' . $year . '</option>';
                        $year++;
                    }*/
                ?>
                &nbsp;&nbsp;&nbsp;&nbsp;Month : 
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
                $y = 2019;
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
                        <?php 
                            $testd = intval($ShowDate);
                            //echo $testd." ";
                            
                            $arr_new[1] = array("1", "5", "6" ,"12", "13", "20", "26", "27");
                            $arr_new[2]= array("2", "3", "4" ,"5", "6", "7", "8", "9", "10", "16", "17", "24", "28");
                            $arr_new[3] = array("1", "2", "3" ,"9", "10", "16", "17", "23", "24", "30", "31");
                            $arr_new[4]= array("4" ,"5", "6", "7", "13", "14", "20", "21", "27", "28");
                            $arr_new[5] = array("4", "5", "11" ,"12", "18", "19", "25", "26");
                            $arr_new[6]= array("1", "2", "7", "8", "9", "15", "16", "22", "23", "29", "30");
                            $arr_new[7] = array("6", "7", "13" ,"14", "20", "21", "27", "28");
                            $arr_new[8]= array("3", "4" ,"10", "11", "17", "18", "24", "25", "31");
                            $arr_new[9] = array("1", "7", "8" ,"13", "14", "15", "21", "22", "28", "29");
                            $arr_new[10]= array("6", "10", "11" ,"12", "13", "19", "20", "26", "27");
                            $arr_new[11] = array("2", "3", "9" ,"10", "16", "17", "23", "24", "30");
                            $arr_new[12]= array("1", "7", "8" ,"14", "15", "21", "22", "28", "29");
                            //echo $arr_new[1]." ";
                            $now_month = $_SESSION['month_r'];
                            $flag = 0;
                            foreach($arr_new[$now_month] as $pick){
                                if($testd == $pick) $flag = 1;
                            }
                            if($flag == 1) echo "<td style='background-color:#ffc4d8'>";
                            else echo "<td>";
                        ?>
                        
                            <?php
                            echo $ShowDate."<br>";
                            ?>
                            <?php
                            if(isset($_SESSION['year_r']) && isset($_SESSION['month_r']) && $ShowDate != '&nbsp;') {
                                $Iy = 2019;
                                $Im = $_SESSION['month_r'];
                                $Id = intval($ShowDate);
                                $Argument = date('Y-m-d',mktime(1,0,0,$Im,$Id,$Iy));
                                //
                                $LDayName = "";
                                if(intval($Im) == 1) {
                                    if(intval($Id) == 5) {
                                        $LDayName = "小寒";
                                    }
                                    else if(intval($Id) == 20) {
                                        $LDayName = "大寒";
                                    }
                                }
                                if(intval($Im) == 2) {
                                    if(intval($Id) == 4) {
                                        $LDayName = "立春";
                                    }
                                    else if(intval($Id) == 19) {
                                        $LDayName = "雨水";
                                    }
                                }
                                if(intval($Im) == 3) {
                                    if(intval($Id) == 6) {
                                        $LDayName = "驚蟄";
                                    }
                                    else if(intval($Id) == 21) {
                                        $LDayName = "春分";
                                    }
                                }
                                if(intval($Im) == 4) {
                                    if(intval($Id) == 5) {
                                        $LDayName = "清明";
                                    }
                                    else if(intval($Id) == 20) {
                                        $LDayName = "穀雨";
                                    }
                                }
                                if(intval($Im) == 5) {
                                    if(intval($Id) == 6) {
                                        $LDayName = "立夏";
                                    }
                                    else if(intval($Id) == 21) {
                                        $LDayName = "小滿";
                                    }
                                }
                                if(intval($Im) == 6) {
                                    if(intval($Id) == 6) {
                                        $LDayName = "芒種";
                                    }
                                    else if(intval($Id) == 21) {
                                        $LDayName = "夏至";
                                    }
                                }
                                if(intval($Im) == 7) {
                                    if(intval($Id) == 7) {
                                        $LDayName = "小暑";
                                    }
                                    else if(intval($Id) == 23) {
                                        $LDayName = "大暑";
                                    }
                                }
                                if(intval($Im) == 8) {
                                    if(intval($Id) == 8) {
                                        $LDayName = "立秋";
                                    }
                                    else if(intval($Id) == 23) {
                                        $LDayName = "處暑";
                                    }
                                }
                                if(intval($Im) == 9) {
                                    if(intval($Id) == 8) {
                                        $LDayName = "白露";
                                    }
                                    else if(intval($Id) == 23) {
                                        $LDayName = "秋分";
                                    }
                                }
                                if(intval($Im) == 10) {
                                    if(intval($Id) == 8) {
                                        $LDayName = "寒露";
                                    }
                                    else if(intval($Id) == 24) {
                                        $LDayName = "霜降";
                                    }
                                }
                                if(intval($Im) == 11) {
                                    if(intval($Id) == 8) {
                                        $LDayName = "立冬";
                                    }
                                    else if(intval($Id) == 22) {
                                        $LDayName = "小雪";
                                    }
                                }
                                if(intval($Im) == 12) {
                                    if(intval($Id) == 7) {
                                        $LDayName = "小雪";
                                    }
                                    else if(intval($Id) == 22) {
                                        $LDayName = "冬至";
                                    }
                                }
                                echo "<font style='font-size:14px;color:#999;'>".$LDayName."</font>";
                                //$LDayName = GetLDay($Argument);
                                
                            }
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
        <div class="footer" style="font-size: 15pt;color: white;font-weight: 200; margin-top: 80px; margin-left: 30px">
        <p style="margin-top: -5px; margin-left: 66px;font-size: 20pt; font-weight: 400; text-align: center"><a href="index.html">Go back to Home Page</a></p>
    </div>
    </body>
    
</html>
