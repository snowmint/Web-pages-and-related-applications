<?php
    function isinside($x, $y){
        //relative with (0,0)
        $RetValue = FALSE;
        if($x*$x+$y*$y <= 1) $RetValue = TRUE;
        return $RetValue;
    }
    function isinside2($x, $y){
        //relative with (0,0)
        $RetValue = FALSE;
        if($y <= (-2*$x)+1) $RetValue = TRUE;
        return $RetValue;
    }
    function randomF($max = 1, $min = 0) {
        srand();
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    function CalPI(){
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
        $Result = 4*($totalIn/$loopcount);
        return $Result;
    }
    function CalTriangle(){ //0.25
        $loopcount = 10000;
        $totalIn = 0;
        $totalOut = 0;
        $ans = FALSE;
        for ($i = 0; $i < $loopcount; $i++){
            $ans = isinside2(rand(0, 1000000)/1000000, rand(0, 1000000)/1000000);
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
           <?php
            $pi = CalPI();
            echo "PI 的近似值 = ".$pi."<br>";
            $tri = CalTriangle();
            echo "y = -2x+1 線下面積的近似值 = ".$tri."<br>";
           ?>
        </div>
    </body>
</html>
