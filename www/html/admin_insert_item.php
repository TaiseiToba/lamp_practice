<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//セッション開始
session_start();

//ログイン状態の確認、ログインされていなければログインページへ移動
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//$tokenにpostで送られてきたtokenを代入
$token = get_post('token');

//$tokenの中身が空ならログインページへ移動
if(is_valid_csrf_token($token) === false){
  redirect_to(LOGIN_URL);
}

//トークン削除
unset($_SESSION["csrf_token"]);

//データベースへ接続
$db = get_db_connect();

//ログイン中のユーザーの情報を取得
$user = get_login_user($db);

//ログイン中のユーザーが管理者か判別、管理者以外ならログインぺージへ移動
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//postで送られてきたname,price,status,stockの値を変数に代入
$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');

//imageを変数に代入
$image = get_file('image');

//商品の登録
if(regist_item($db, $name, $price, $stock, $status, $image)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}


redirect_to(ADMIN_URL);