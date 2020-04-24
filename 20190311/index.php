<?php
function calculate($operator,$numA,$numB) {
    switch ($operator) {
      case 1 :
        $end = $numA + $numB;
        echo "$numA + $numB = $end&nbsp;&nbsp;&nbsp;\n";
        break;
      case 2 :
        $end = $numA - $numB;
        echo "$numA - $numB = $end&nbsp;&nbsp;&nbsp;\n";
        break;
      case 3 :
        $end = $numA * $numB;
        echo "$numA * $numB = $end&nbsp;&nbsp;&nbsp;\n";
        break;
      default:
        if($numB == 0) {
            echo "<font color='#ff8484'>Divide error... with divide zero!</font>";
        }
        else {
            $end = $numA / $numB;
            echo "$numA / $numB = $end&nbsp;&nbsp;&nbsp;\n";
        }
        break;
    }
     return $end;
}
?>
<html>
    <head>
        <title>PHP Example</title>
        <style>
            input[type=number], select {
              width: 100%;
              padding: 12px 20px;
              margin: 8px 0;
              display: inline-block;
              border: 1px solid #ccc;
              border-radius: 4px;
              box-sizing: border-box;
            }

            input[type=submit] {
              width: 100%;
              background-color: #92b6ef;
              color: white;
              padding: 14px 20px;
              margin: 8px 0;
              border: none;
              border-radius: 4px;
              cursor: pointer;
            }
            
            input[type=submit]:hover {
              background-color: #6a9ded;
            }
            
            select[type=submit] {
              width: 100%;
              background-color: #4CAF50;
              color: white;
              padding: 14px 20px;
              margin: 8px 0;
              border: none;
              border-radius: 4px;
              cursor: pointer;
            }
            
            div {
              border-radius: 5px;
              background-color: #f2f2f2;
              padding: 20px;
            }
        </style>
    </head>
    <div style="margin:10px;">
        <h1><font color="#49729b">Arithmetic : </font></h1>
            <?php
            if (isset($_POST['number1']) && (isset($_POST['number2'])) && (isset($_POST['operator'])))
            {
              $numA = floatval($_POST['number1']);
              $numB = floatval($_POST['number2']);
              $operator =$_POST['operator'];
              $end =  calculate($operator,$numA,$numB);
            ?>
            <form method="post" name="InputForm" action="index.php">
                <!-- 結果：<input type="text" name="number3" value="<?php //echo $end?>">-->
                <br><input type="submit" action="send" value="Clear"><br>
            </form>
            <?php
            }else{
            ?>
                <form method="post" name="InputForm" action="index.php">
                    <label for="fname">First number : </label><br><input type="number" size="20" name="number1" value="">
                    <label for="fname">Operator : </label>
                    <select name="operator" size="1">
                        <option value="1">+</option>
                        <option value="2">-</option>
                        <option value="3">*</option>
                        <option value="4">/</option>
                    </select>
                    <label for="fname">Second number : </label><br><input type="number" size="20" name="number2" value="">
                    <input type="submit" action="send" value="Calculate"><br>
                </form><br>
            <?php
            }
            ?>
    </div>
</html>
<!--===========================================================================================================-->
<!--單引號：單純字串-->
<!--雙引號：將變數顯示之字串-->
<!--
<h2>PHP and HTML</h2>
<div style="text-align:center; font-size:20px; font-weight:bold;">
<?php/*
    for($i = 0; $i < 10; $i++) {
        $Font_size = $i*4 + 20;
        echo "<div style='font-size:36px;  display:inline-block; width:200px; height:100px; line-height: 100px; border: 2px dashed #89b2f4; margin:6px;'>";
        echo $i . "</div>\n";
    }*/
?>
</div>
Last i = <?php //echo $i; ?>
-->