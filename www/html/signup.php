<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

//セッション開始
session_start();

//ログイン状態の確認、ログインされていればホームページへ移動
if(is_logined() === true){
  redirect_to(HOME_URL);
}

//トークンの生成
$token = get_csrf_token();

include_once VIEW_PATH . 'signup_view.php';



