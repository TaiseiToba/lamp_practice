<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//セッション開始
session_start();

//ログイン状態の確認、ログインされていなければログインページへ移
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//トークンの生成
$token = get_csrf_token();

//データベースへ接続
$db = get_db_connect();

//ログイン中のユーザーの情報を取得
$user = get_login_user($db);

//ログイン中のユーザーが管理者か判別、管理者以外ならログインぺージへ移動
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//全商品のデータ取得
$items = get_all_items($db);
include_once VIEW_PATH . '/admin_view.php';
