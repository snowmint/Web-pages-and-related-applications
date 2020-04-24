<?php
function connect2db($dbhost, $dbuser, $dbpwd, $dbname) {
    $dsn = "mysql:host=$dbhost;dbname=$dbname";
    try {
        $db_conn = new PDO($dsn, $dbuser, $dbpwd);
    }
    catch (PDOException $e) {
        echo $e->getMessage();
        die ("錯誤: 無法連接到資料庫");
    }
    $db_conn->query("SET NAMES UTF8");
    return $db_conn;
}

function updatedb($updatestr, $conn_id) {
    try {
        $result = $conn_id->query($updatestr); 
    } catch (PDOException $e) {
        echo $e->getMessage();
        die ("資料庫異動失敗，請重試，若問題仍在，請通知管理單位。");
    }
    return $result;
}
function querydb($querystr, $conn_id) {
    try {
        $result = $conn_id->query($querystr);
    } catch (PDOException $e) {
        die ("資料庫查詢失敗，請重試，若問題仍在，請通知管理單位。");
    }
    $rs = array();
    if ($result) $rs = $result->fetchall(); //使用 asociative array ，以欄位名稱作為索引
    return $rs;
}

function sql_limit($count, $offset) { //第一筆是編號 0
    return " LIMIT $offset,$count ";//count 等於你要抓幾筆
}

function newid($db) {
    return $db->lastInsertId();;
}

function xssfix($InString) {
    return htmlspecialchars($InString); //跟安全有關，可以藏一些奇怪的 code，把別人
}
//有時候資料需要同時寫入不同的資料表。
//ex: 例如一堂課可能有多個老師

?>
