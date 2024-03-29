<?php
session_start();
include("kadai_funcs.php");  //funcs.phpを読み込む（関数群）
sschk();//これを入れるとログインチェックができる
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM gs_user_table"); //SQLをセット
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    //以下でリンクの文字列を作成, $r["id"]でidをget通信でdetail.phpに渡しています
    $view .= '<a href="kadai_detail_user.php?id='.h($r["id"]).'">';
    $view .= h($r["id"]).". ".h($r["name"]);
    $view .= '</a>';
    $view .= '<a href="kadai_delete.php?id='.h($r["id"]).'">';
    $view .= '[削除]';
    $view .= '</a>';
    $view .= '<br>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery-2.1.3.min.js"></script>
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
    <div class="test"></div>
</div>
<!-- Main[End] -->
<script>
if (<?=$_SESSION["kanri_flg"]?>==1) {
    $(".navbar-header").html('<a class="navbar-brand" href="kadai_index.php">ブックマーク登録</a><a class="navbar-brand" href="kadai_select.php">ブックマーク表示</a><a class="navbar-brand" href="kadai_index_user.php">ユーザー登録</a><a class="navbar-brand" href="kadai_select_user.php"><b>ユーザー表示</b></a>')
  }else{
    $(".navbar-header").html('<a class="navbar-brand" href="kadai_index.php">ブックマーク登録</a><a class="navbar-brand" href="kadai_select.php">ブックマーク表示</a>')
  }
</script>
</body>
</html>
