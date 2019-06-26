<?php
session_start();
require('./dbconnect.php');

if (!empty($_POST)) {
    if ($_POST['email'] !== '' && $_POST['password'] !== '') {
        $login = $db->prepare('SELECT * FROM wonder_members WHERE email=? AND password=?');
        $login->execute(array(
            $_POST['email'],
            sha1($_POST['password'])
        ));
        $member = $login->fetch();

        if ($member) {
            $_SESSION['id'] = $member['id'];
            $_SESSION['time'] = time();
            header('Location: index.php');
            exit();
        }else {
            $error['login'] = 'failed';
        }
    } 
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<h1 class="navbar-brand">wonder</h1>
</nav>
</header>
 <!-- <video id="bg-video" src="video/Pexels Videos 2043551.mp4" poster="video/askyfullofstarsmp4.jpg" autoplay loop></video> -->
<div class="index-wrap">
<div class="text-center mt-5">
<h1 class="" style="font-family: 'Pacifico', cursive;">Log-In</h1>
<p class="font-weight-bold mt-1" >please log in using your Email & Password</p>
<p class="">入会手続きがまだの方はこちらからどうぞ。</p>
<a href="join/" class="btn btn-info">入会手続きをする</a>
</div> 

<div class="text-center mt-3">
<form action="" method="post">
<div class="form-group row mr-1 ml-2">
<label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg text-warning font-weight-bold">Email</label>
<div class="col-sm-10">
    <input type="email" name="email" class="form-control form-control-lg" id="colFormLabelLg" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['email']);?>" required>
</div>
<?php if($error['login'] === 'failed'):?>
    <p class="col-sm-10">ログインに失敗しました。正しくご記入ください</p>
<?php endif; ?>
</div><br>

<div class="form-group row mr-1 ml-2">
<label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg text-info font-weight-bold">Password</label>
<div class="col-sm-10">
    <input type="password" name="password" size="35" maxlength="255" class="form-control form-control-lg" id="colFormLabelLg" value="<?php echo htmlspecialchars($_POST['password']);?>" required>
</div>
</div>

<input type="submit" class="btn btn-warning text-white btn-large mx-auto d-block mb-3" value="ログインする"><br>
</form>
</div>
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>