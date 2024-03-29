<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値
$lid=$_POST["lid"];
$lpw=$_POST["lpw"];


//1.  DB接続します
include("kadai_funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
//* PasswordがHash化→条件はlidのみ！！
$stmt = $pdo->prepare(" SELECT * FROM gs_user_table WHERE lid=:lid"); 
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()



//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($lpw, $val["lpw"]);
if($pw){ 
  //$valにIDとPWで検索した結果のデータが入っています。中身が空かどうかで、ログイン成功と失敗の分岐をさせてます。

  //Login成功時
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["name"]      = $val['name'];
  //Login成功時（リダイレクト）
  redirect("kadai_select.php");
}else{
  //Login失敗時(Logoutを経由：リダイレクト)
  redirect("kadai_login.php");
}

exit();


