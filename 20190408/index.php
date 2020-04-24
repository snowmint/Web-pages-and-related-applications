<?php
    header('Content-Type: text/html; charset=utf-8');
    $servername = "i4010.cse.ttu.edu.tw";
    $username = "ui3a11";
    $password = "tdhudinm0437";
    $dbname = "I4010_9608";
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8;"; //*charset=utf8;
    $Conn = new PDO($dsn, $username, $password);
    $RS = $Conn->query('SELECT * FROM contact');
    //$Conn->query("SET NAMES UTF8") in dbfunc.php connect2db update query sql_limit
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="test/html; charset=utf-8" />
        <meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
        <meta http-equiv="Parama" content="no-cache">
    </head>
    <body>
       <?php
        foreach($RS as $row) {
            echo $row['id'].' ==> '.$row['name'].'<br>';
        }
        ?>
    </body>
</html>
