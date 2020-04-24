<?php
    function isinside($x, $y){
        //relative with (0,0)
        $RetValue = FALSE;
        if($y >= $x*$x*$x) $RetValue = TRUE;
        return $RetValue;
    }
    function randomF($max = 1, $min = 0) {
        srand();
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    function CalArea(){
        $loopcount = 10000;
        $totalIn = 0;
        $totalOut = 0;
        $ans = FALSE;
        for ($i = 0; $i < $loopcount; $i++){
            $ans = isinside(rand(0, 1000000)/1000000, rand(0, 1000000)/1000000);
            if($ans == TRUE) {
                $totalIn++;
            }
            else {
                $totalOut++;
            }
        }
        $Result = $totalIn/$loopcount;
        return $Result;
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
                color: #586b89;
                font-size: 30px;
                /*background-image: linear-gradient(to top, #859bc4 0%, #52729e 100%);*/
                background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
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
            div.footer {
                height: 40px;
                color: #5878aa;
                box-sizing: border-box;
                position: relative;
                bottom: 20px;
                width: 90%;
            }
            a,
            a:link,
            a:visited {
                color: #CCCCCC;
                text-decoration: none;
            }

            a:hover {
                color: #ffb200;
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
            <h2>機率撒點求面積</h2>
            <img style="align:center"src="x3.svg" width="500" height="400">
        </div>
        <div style="text-align:center;margin:20px 0;" align="center">
           <?php
            $three = CalArea();
            echo "y = x^3 線上面積的近似值 = ".$three."<br>";
           ?>
        </div>
        <br>
    </body>
    <div class="footer" style="font-size: 15pt;color: white;font-weight: 200; margin-top: 50px; margin-left: 30px">
        <p style="margin-top: 30px; margin-left: 66px;font-size: 20pt; font-weight: 400; text-align: center"><a href="index.html">Go back to Home Page</a></p>
    </div>
    
</html>
