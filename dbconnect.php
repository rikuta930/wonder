<?php
try {
    $db = new PDO("pgsql:dbname=rikuta;host=localhost","rikuta","LLkoO89K");
}catch(PDOExeption $e) {
    print('DB接続エラー:' . $e->getMessage());
}