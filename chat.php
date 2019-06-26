<?php
session_start();
require('./dbconnect.php');

date_default_timezone_set('Asia/Tokyo');
$date = date('Y-m-d H:i:s');

if (isset($_SESSION['id']) && $_SESSION['content_id'] && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $posts = $db->prepare('SELECT * FROM wonder_posts WHERE id=?');
    $posts->execute(array(
        $_SESSION['content_id']
    ));
    $post = $posts->fetch();

     if (!empty($_POST)) {
     $messages = $db->prepare('INSERT INTO wonder_chats (message,member_id,content_id,created) VALUES(?,?,?,?)');
     $messages->execute(array(
     $_POST['message'],
     $_SESSION['id'],
     $post['id'],
     $date
 ));
 }
}

header('Location: index.php');
exit(); 
?>
