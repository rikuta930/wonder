<?php
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
    if (strlen($_POST['password']) < 4) {
    $error['password'] = 'length';
    }

    $fileName = $_FILES['image']['name'];
    if (!empty($fileName)) {
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'jpeg' && $ext!= 'gif' && $ext != 'png') {
        $error['image'] = 'type';
        }
    }

    //アカウントの重複をチェック
    if(empty($error)) {
        $member = $db->prepare('SELECT COUNT(*) AS cnt FROM wonder_members WHERE email=?');
        $member->execute(array($_POST['email']));
        $record = $member->fetch();
        if($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }
    
    if (empty($error)) {
        $image = date('YmdHis') . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
        $_SESSION['join'] = $_POST;
        $_SESSION['join']['image'] = $image;
        header("Location: check.php");
        exit();
    }
}

if($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>会員登録</title>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<h1 class="navbar-brand">wonder</h1>
</nav>
</header>

<div class="text-center">
<h1 class="mt-3">会員登録</h1>
<p>次のフォームに必要事項をご記入ください。</p>
</div>

<div class="text-center mt-3">
<form action="" method="post"enctype="multipart/form-data">
    <div class="form-group row mr-1">
        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">学年</label>
        <div class="col-sm-10">
            <input type="text" name="year" class="form-control form-control-lg" id="colFormLabelLg" value="<?php print(htmlspecialchars($_POST['year'], ENT_QUOTES)); ?>" required>
        </div>
    </div><br>

    <div class="form-grounp row mr-1 mb-5">
        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">学籍番号</label>
        <div class="col-sm-10">
            <input type="text" name="school_num" class="form-control form-control-lg" id="colFormLabelLg" value="<?php print(htmlspecialchars($_POST['school_num'], ENT_QUOTES)); ?>" required>
        </div>
    </div>
    <div class="form-grounp row mr-1 mb-5">
        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">名前</label>
        <div class="col-sm-10">
            <input type="text" name="name"   class="form-control form-control-lg" id="colFormLabelLg" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" required>
        </div>
    </div>
    <div class="form-grounp row mr-1 mb-5">
        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">メールアドレス</label>
        <div class="col-sm-10">
            <input type="email" name="email" class="form-control form-control-lg" id="colFormLabelLg" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" required>
    <?php if ($error['email'] === 'duplicate'):?>
        <p>指定されたメールアドレスは、すでに登録されています。</p>
    <?php endif; ?>
        </div>
    </div>

    <div class="form-grounp row mr-1 mb-5">
        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">パスワード</label>
        <div class="col-sm-10">  
            <input type="password" name="password" size="10" maxLength="20" class="form-control form-control-lg" id="colFormLabelLg" value=<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES));?>>
    <?php if ($error['password'] === 'length'):?>
            <p>パスワードは4文字以上で入力してください。</p>
    <?php endif;?>
        </div>
    </div>
    <div class="form-grounp row mr-1 mb-5">
        <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">使用できるプログラミング言語/フレームワーク</label>
        <div class="col-sm-10">
            <input type="text" name="skill" class="form-control form-control-lg" id="colFormLabelLg" value="<?php print(htmlspecialchars($_POST['skill'], ENT_QUOTES));?>" required>
        </div>
    </div>

    <div class="form-grounp row mr-1 mb-5">
    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">アイコン</label>
    <div class="col-sm-10">
            <input type="file" name="image" size="35" required>
<?php if (!empty($error['image'] === 'type')):?>
    <p>* 写真などは「.gif」、「.jpg」、「.jpeg」、「.png」の画像を指定してください。</p>
<?php endif;?>

<?php if (!empty($error)):?>
    <p>恐れ入りますが、画像を改めて指定してください。</p>
<?php endif; ?>
    </div>
    </div>
<input type="submit" class="btn btn-success btn-large mx-auto d-block mb-3" value="入力内容を確認する">
</form>
</div>

<div class="p-3 mb-2 bg-light text-dark">
<p class="float-right">
Copyright © 2019 Rikuta Hiratsuka All Rights Reserved.
</p>
</div>
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>