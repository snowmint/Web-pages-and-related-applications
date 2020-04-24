<?php
    $MySelect='';
    if(!empty($_POST) && isset($_POST['MySelect'])) $MySelect = $_POST['MySelect'];
    
    $Num = array('one'=>'1', 'two'=>'2', 'three'=>'3', 'four'=>'4', 'five'=>'5', 'six'=>'6', 'seven'=>'7', 'eight'=>'8', 'nine'=>'9');
    //Selection for use
    $NumSelection = array();
    foreach($Num as $nid=>$NumName) $NumSelection[$nid] = '';

    $MySelectName = '';
    if(!empty($MySelect) && isset($Num["$MySelect"])) $MySelectName = $Num["$MySelect"]; //只能用雙引號
?>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="test/html; charset=utf-8" />
        <meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="Parama" content="no-cache">
        <title>index</title>
        <style>
            body {
                /*background: #586b89;*/
                color: aliceblue;
                font-size: 30px;
                background-image: linear-gradient(to top, #859bc4 0%, #52729e 100%);
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            }

            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                cursor: pointer;
                width: 200px;
                padding: 10px 90px;
                color: #44597a;
                border: none;/* 2px solid #006DD9;*/
                border-radius: 5px;
                font-size: 15pt;
                cursor: pointer;
                text-align: center;
                z-index: 20;
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            }

        </style>
    </head>

    <body>
        <div style="text-align:center;margin:20px 0;" align="center">
            <!--九九乘法表-->
            <h2>Multiplication Table</h2>
            <form method="post" name="NumSelect" onchange="submit();" action="">
                <select name="MySelect">
                    <option value="Selection">-</option>
                    <?php
                    foreach($Num as $nid=>$NumName){
                        echo '<option value="'.$nid.'"';
                        if($MySelect == $nid) echo 'selected'; //鎖定選項
                        echo '>' . $NumName . '</option>';
                    }
                    ?>
                </select>
                <!--<input type="submit" name="Send" value="送出">-->
            </form>
        </div>
        <?php
            if(!empty($MySelectName)) {
        ?>
            <div style="text-align:center;margin:30px 0;">
                <!--你的選擇：<?php echo $MySelectName; ?><br>-->
                <?php
                        echo "<table style='text-align:right;font-size: 20pt;' align='center'>";
                        
                        foreach($Num as $nid){
                            echo "<tr'><td style='padding:8px;'>";
                            echo $MySelectName.' * '.$nid.' = ';
                            $multi = $MySelectName*$nid;
                            if($multi >= 10) {
                                echo $multi."<br>";
                            }else {
                                echo $multi."<br>";
                            }
                            echo "</td></tr>";
                        }
                        echo "</table>";
                    ?>
            </div>
            <?php } ?>
    </body>

    </html>
