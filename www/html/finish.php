<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

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

//ログイン中のユーザーのカート情報を取得
$carts = get_user_carts($db, $user['user_id']);

//商品の決済
if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 

//カート内の商品の合計金額計算
$total_price = sum_carts($carts);

include_once '../view/finish_view.php';