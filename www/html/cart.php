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

//トークン生成
$token = get_csrf_token();

//データベースへ接続
$db = get_db_connect();

//ログイン中のユーザーの情報を取得
$user = get_login_user($db);

//ログイン中のユーザーのカート情報を取得
$carts = get_user_carts($db, $user['user_id']);

//カート内の商品の合計金額を計算
$total_price = sum_carts($carts);

include_once VIEW_PATH . 'cart_view.php';