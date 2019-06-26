<?php 
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
}

$id = uniqid(rand());

if(!empty($_POST)) {
    $statement = $db->prepare('INSERT INTO wonder_members VALUES(?,?,?,?,?,?,?,?)');

    $statement->execute(array(
        $id,
        $_SESSION['join']['year'],
        $_SESSION['join']['school_num'],
        $_SESSION['join']['name'],
        $_SESSION['join']['email'],
        sha1($_SESSION['join']['password']),
        $_SESSION['join']['skill'],
        $_SESSION['join']['image']
    ));
    unset($_SESSION['join']);

    header('Location: thanks.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>
</head>
<body>
<h1>会員登録</h1>
<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
<form action="" method="post">
<input type="hidden" name="action" value="submit" />
<dl>
<dt>学年</dt>
<dd>
    <?php print(htmlspecialchars($_SESSION['join']['year'], ENT_QUOTES));?>
</dd>    

<dt>学籍番号</dt>
<dd>
    <?php print(htmlspecialchars($_SESSION['join']['school_num'], ENT_QUOTES));?>
</dd>    

<dt>名前</dt>
<dd>
    <?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES));?>
</dd>    

<dt>メールアドレス</dt>
<dd>
    <?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES));?>
</dd>    

<dt>パスワード</dt>
<dd>
   【表示されません】 
</dd>    

<dt>スキル</dt>
<dd>
    <?php print(htmlspecialchars($_SESSION['join']['skill'], ENT_QUOTES));?>
</dd>    

<dt>写真など</dt>
<dd>
    <img src="../member_picture/<?php print(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES));?>">
</dd>    
</dl>   
<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する"></div>
</form>
</body>
</html>