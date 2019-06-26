<?php
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    
    $id = $_REQUEST['id'];

    $messages = $db->prepare('SELECT * FROM wonder_posts WHERE id=?');
    $messages->execute(array($id));
    $message = $messages->fetch();
    
    if($message['member_id'] == $_SESSION['id']) {
        $del = $db->prepare('DELETE FROM wonder_posts WHERE id=?');
        $del->execute(array($id));
    }
}

header('Location: index.php');
exit();
?>