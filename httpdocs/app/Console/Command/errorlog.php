<?php
/**
 * ログ出力処理
 * 
 * エラーになった場合、ログに出力して終了する
 * 行った処理をログに出力する
 *
 * @since 2016-09-15
 * @author Ooishi Yasuo <y-oishi@netyear.net>
 */
require_once("config.php");

//情報のログ出力
function info($message) {

	error_log("[INFO] ".date("Y-m-d H:i:s ").$message."\n", 3, LOG_FILE);

}

//エラー処理
function error($message) {

	//エラーログを出力
	error_log("[ERROR] ".date("Y-m-d H:i:s ").$message."\n", 3, LOG_FILE);

	//エラーメールを送信する
	if (ERROR_MAIL == 1) {
		error_mail($message);
	}
	echo $message;
	echo "\n";
	exit;

}

//エラーメールを送信する
function error_mail($message) {

	$destination = BATCH_MAIL_TO;
	$MAIL_FROM = BATCH_MAIL_FROM;
	$header  = "From: $MAIL_FROM\n";#From
	$header .= "Reply-To: $MAIL_FROM\n";#Reply-To
	$header .= "Return-Path: $MAIL_FROM\n";#Return-Path
	$header .= "MIME-version: 1.0\n";#MIMEヘッダ
	$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";#通常メール

	$body = date("Y-m-d H:i:s ").$message;
	//$body = mb_convert_encoding($body, "ISO-2022-JP","AUTO");

	error_log($body, 1, $destination, $header);

}

?>
