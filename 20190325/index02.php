<?php
    session_start();
    if(isset($_POST['remove'])) {
        unset($_SESSION['num']);
        unset($_SESSION['current']);
        unset($_SESSION['submit']);
        unset($_SESSION['remove']);
        unset($_SESSION['guessA']);
    }
    $_SESSION['num']; //0 ~ 9876
    $_SESSION['guessA'];// = array();
    if(empty($_SESSION['guessA'])) $_SESSION['guessA'] = array();
    
    $_SESSION['current'];
    if(isset($_POST['submit']) && isset($_POST['guess'])){
        $_SESSION['current'] = $_POST['guess'];
    }

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
                width: 300px;
                padding: 10px 20px;
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

        </style>
    </head>

    <body>
        <div style="text-align:center;margin:20px 0;" align="center">
            <h3>Guess The Number!</h3>
            <?php //unset($_SESSION);
                if(empty($_SESSION['num']) || !isset($_SESSION['num'])){
                    for($i = 1; $i <= 4; $i++) {
                        $b = rand(0, 9);
                        for($j = 1; $j <= $i; $j++){  //檢查重覆
                            if($b == $_SESSION['num'][$j]){
                                $b = rand(0, 9);  //如果重覆，重新產生亂數
                                $j=0;
                            }
                        }
                       $_SESSION['num'][$i] = $b;
                    }
                }
                else if(!empty($_SESSION['current'])) {
                    if(strlen($_SESSION['current']) != 4) {
                        echo "<font style='color:#ffbfbf;'>Error (strlen != 4), please input again.</font><br>";
                        //if(isset($_POST['submit']) && isset($_POST['guess'])){
                        array_push($_SESSION['guessA'], $_SESSION['current']." "."Error Strlen");
                        //}
                    }
                    else {
                        $error = FALSE;
                        $test_array[] = array();
                        for($i = 0; $i < 10; $i++) {
                            $test_array[$i] = 0;
                        }//echo "Your input : ";
                        for($i = 0; $i < 4; $i++){
                            //echo $_SESSION['current'][$i]." ";
                            $test_array[$_SESSION['current'][$i]] += 1;
                        }//echo "<br>";
                        for($i = 0; $i < 10; $i++) {
                            if($test_array[$i] > 1) $error = TRUE;
                        }
                        if($error == FALSE) {
                            $A = 0;
                            $B = 0;
                            /*for($i = 1; $i <= 4; $i++){
                                echo "(".$_SESSION['num'][$i].", ".$_SESSION['current'][$i-1].") ";
                            }echo "<br>";*/
                            for($i = 1; $i <= 4; $i++){
                                if($_SESSION['num'][$i] == $_SESSION['current'][$i-1]) {
                                    $A++;
                                }
                                for($j = 0; $j < 4; $j++){
                                    if($_SESSION['num'][$i] == $_SESSION['current'][$j] && $i-1 != $j) $B++; 
                                }
                            }
                            if($A == 4) echo "<font style='color:#ffd670'>You Win!</font><br>";
                            //else echo "(". $A ."A, ".$B."B)<br>";
                            array_push($_SESSION['guessA'], $_SESSION['current']." (". $A ."A, ".$B."B)");
                        }
                        else {
                            echo "<font style='color:#ffbfbf;'>Error (repeat number), please input again.</font><br>";
                            array_push($_SESSION['guessA'], $_SESSION['current']." "."Repeat Error");
                        }
                    }
                }
                //echo "---";
                echo "Answer : ";
                if(isset($_SESSION['num'])) {
                    for($i = 1; $i <= 4; $i++){
                        echo $_SESSION['num'][$i]." ";
                    }
                }
            
            ?>
            <form method="post" name="InputForm" action="">
                <input type="text" name="guess" style="margin:20px"><br>
                <input type="submit" class="button" name="submit" value="Submit">&nbsp;&nbsp;
                <input type="submit" class="button" name="remove" value="Restart">
            </form>

            <?php if(!empty($_SESSION['guessA'])){
                foreach(array_reverse($_SESSION['guessA']) as $history) {
                    echo $history ."<br>";
                }
            }?>

        </div>
    </body>

    </html>
