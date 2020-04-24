<?php
    $Fruit = array('Apple'=>'蘋果', 'Orange'=>'橘子', 'Banana'=>'香蕉');

    $MealType = array('m'=>'葷', 'v'=>'素');
    $SportType = array('basketball'=>'籃球', 'football'=>'足球', 'baseball'=>'棒球', 'tennis'=>'網球');
    
    $SportSelection = array();
    foreach($SportType as $sid=>$SportName) $SportSelection[$sid] = '';

    //$SportSelection = array('basketball'=>'', 'football'=>'', 'baseball'=>'');


    $MyMeal = '';
    $MySelect='';
    $MySelectName = '';
    $MySportSel = array();

    if(!empty($_POST)) {
        if(isset($_POST['MySelect']))$MySelect = $_POST['MySelect'];
        if(isset($_POST['MyMeal']))$MyMeal = $_POST['MyMeal'];
        if(isset($_POST['MySport']))$MyMeal = $_POST['MySport'];
    }
    if(!empty($MySelect) && isset($Fruit["$MySelect"])) $MySelectName = $Fruit["$MySelect"]; //只能用雙引號or完全不用引號

    $MealSelection = array('m'=>'', 'v'=>'');
    if($MyMeal == 'm') $MealSelection['m'] = ' checked';//跟前面雙引號隔開
    if($MyMeal == 'v') $MealSelection['v'] = ' checked';
    
    foreach($MySportSel as $sportid) {
        $SportSelection["$sportid"] = ' checked';
    }

    //print_r($_POST);
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="test/html; charset=utf-8"/>
        <meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="Parama" content="no-cache">
        <title>index</title>
    </head>
    <body>
        <div style="text-align:center;margin:20px 0;">
            喜歡的水果問卷<br><br>
            <form method="post" name="FruitSelect" action="index.php">
                <select name="MySelect" onchange="submit();"> <!--onchange 立即送出--> 
                    <option value="Selection">請選擇</option>
                    <?php
                    foreach($Fruit as $fid=>$FruitName){
                        echo '<option value="'.$fid.'"';
                        if($MySelect == $fid) echo 'selected'; //鎖定選項
                        echo '>' . $FruitName . '</option>';
                    }
                    ?>
                </select><br><br>
                <?php foreach($MealType as $mid => $MealName) {?>
                    <input type="radio" name="MyMeal" value="<?php echo $mid; ?>"<?php echo $MealSelection["$mid"]?>> <?php echo $MealName; ?> &nbsp;&nbsp;
                <?php } ?><br><br>
                <?php foreach($SportType as $sid=>$SportName) { ?>
                    <input type="checkbox" name="MySport[]" value="<?php echo $sid;?>"<?php echo $SportSelection["$sid"];?>><?php echo $SportName ?>
                <?php } ?>
                
                <br><br>
                <input type="submit" name="Send" value="送出">
            </form>
        </div>
        <?php
            if(!empty($MySelectName)) {
        ?>
                <div style="text-align:center;margin:30px 0;">
                    你的選擇：<?php echo $MySelectName; ?><br>
                </div>
        <?php } ?>
        
    </body>
</html>