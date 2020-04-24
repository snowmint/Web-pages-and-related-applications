<html>
    <head>
        <meta http-equiv="Content-Type" content="test/html; charset=utf-8" />
        <meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="Parama" content="no-cache">
        <title>index</title>
        <style>
            body {
                /*background: #586b89;*/
                color: #5878aa;
                font-size: 30px;
                /*background-image: linear-gradient(to top, #859bc4 0%, #52729e 100%);*/
                background-image: linear-gradient(-225deg, #E3FDF5 0%, #FFE6FA 100%);
                font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            }
            .box {
              display: inline-block;
              width: 33%;
              height: 190px;
              margin-bottom: 0.5em;
            }
            div.footer {
                height: 30px;
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
                color: #ff6d6d;
                text-decoration: none;
            }

            a:active {
                color: #D2F1B5;
                text-decoration: none;
            }
        </style>
    </head>

    <body>
        <h5  style="text-align:center;" align="center" >Multiplication Table</h5>
        <div style="margin-left: 18%">
            <!--你的選擇：<?php //echo $MySelectName; ?><br>-->
            <?php
                for($i = 1; $i <= 9; $i++) {
                    echo "<div class='box'>";
                    echo "<table style='text-align:right;font-size: 10pt;' align='left'>";
                    for($j = 1; $j <= 9; $j++){
                        echo "<tr'><td>";
                        echo $i.' * '.$j.' = ';
                        $multi = $i*$j;
                        if($multi >= 10) {
                            echo $multi."<br>";
                        }else {
                            echo $multi."<br>";
                        }
                        echo "</td></tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                
                ?>
        </div>
        <div class="footer" style="font-size: 15pt;color: white;font-weight: 200; margin-top: 50px; margin-left: 30px">
        <p style="margin-top: 10px; margin-left: 66px;font-size: 15pt; text-align: center"><a href="index.html">Go back to Home Page</a></p>
    </div>
    </body>
    
</html>
