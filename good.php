<?php
session_start();
require('./dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $members = $db->prepare('SELECT * FROM wonder_members WHERE id=?');
    $members->execute(array(
        $_SESSION['id']
    ));
    $member = $members->fetch();
    
    $accounts = $db->prepare('SELECT * FROM wonder_goods WHERE member_id=? AND content_id=?');
    $accounts->execute(array(
        $member['id'],
        $_REQUEST['id']
    ));
    $account = $accounts->fetch();
    
    if (!empty($_REQUEST['id'])) {
        if (empty($account)) {
            $id = uniqid(rand());
            $goods = $db->prepare('INSERT INTO wonder_goods VALUES(?,?,?)');
            $goods->execute(array(
                $id,
                $member['id'],
                $_REQUEST['id']
            ));
            header('Location: index.php');
        } else {
            $res = $db->prepare('DELETE FROM wonder_goods WHERE member_id=? AND content_id=?');
            $res->execute(array(
                $member['id'],
                $_REQUEST['id']
            ));
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
}
?>