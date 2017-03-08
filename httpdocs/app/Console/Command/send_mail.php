<?php
/**
 * メール送信
 *
 * @since 2016-12-28
 * @author y-oishi@netyear.net
 */
require('PHPMailer/PHPMailerAutoload.php');
require('/var/www/vhosts/nagase-personalcare.com/httpdocs/app/Config/const.php');

require('config.php');
require('errorlog.php');

//第一パラメータに送信先メールアドレス
$email = $argv[1];
//第二パラメータにメールの種類(メール内容のファイル名)
$email_body_file = $argv[2];
$param1 = $argv[3];
$param2 = $argv[4];
$param3 = $argv[5];

if ($email == false || $email_body_file == false) {
	print_r($argv);
	error("argv not difine.");
}
if ($email_body_file == "member_regist_notification") {
	if ($param1 == false || $param2 == false || $param3 == false) {
		error("member_regist_notification argv shortage. id[$param1] company[$param2] country[$param3]");
	}
}
if ($email_body_file == "password_change") {
	if ($param1 == false) {
		error("password_change argv shortage.");
	}
}
if ($email_body_file == "contact_us_notification") {
	if ($param1 == false) {
		error("password_change argv shortage.");
	}
}

//本文のファイルを読み込む
$file_path = MAILPATH . $email_body_file . ".txt";
if (file_exists($file_path) == false) {
	error("file not exist ($file_path).");
}
$body = file_get_contents($file_path);

//タイトルのファイルを読み込む
$file_path = MAILPATH .$email_body_file . "_title.txt";
if (file_exists($file_path) == false) {
	error("file not exist ($file_path).");
}
$title = file_get_contents($file_path);

//メールの本文を作成する
if ($email_body_file == "member_regist_notification") {
	$body = str_replace("[UserId]", $param1, $body);
	$body = str_replace("[Company]", $param2, $body);
	$body = str_replace("[Country]", $param3, $body);
} else if ($email_body_file == "password_change") {
	$body = str_replace("[param]", $param1, $body);
} else if ($email_body_file == "contact_us_notification") {
	$body = str_replace("[ContactId]", $param2, $body);
	$file_name = "/var/www/vhosts/nagase-personalcare.com/httpdocs/app/tmp/mail/" . $param2 . ".txt";
	$body .= "\n";
	$body .= @file_get_contents($file_name);
}

//メールを送信する
$ret = send_mail($email, $title, $body);
if ($ret == false) {
	//メール送信に失敗したのでログを出力して管理者にメール通知する
	send_error_mail($email, $title, $body);
	$message = "$email $email_body_file $param1 $param2";
	error($message);
}
$message = "$email $email_body_file $param1 $param2";
info($message);

//メールを送信する
function send_mail($email, $title, $body) {

	$subject = $title;
	$fromname = FROM_NAME;
	$from = MAIL_FROM;
	$smtp_user = SMTP_USER;
	$smtp_password = SMTP_PASSWORD;
	$to = $email;

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;
	$mail->CharSet = 'utf-8';
	$mail->SMTPSecure = 'tls';
	$mail->Host = MAIL_HOST;
	$mail->Port = 587;
	$mail->IsHTML(false);
	$mail->Username = $smtp_user;
	$mail->Password = $smtp_password;
	$mail->SetFrom($smtp_user);
	$mail->From     = $from;
	$mail->Subject = $subject;
	$mail->Body = $body;
	$to_list = explode(",", $to);
	foreach($to_list as $address) {
		$mail->AddAddress($address);
	}

	if( !$mail -> Send() ){
		//送信失敗
		return false;
	} else {
		//送信成功
		return true;
	}

}

//エラーメールを送信する
function send_error_mail($email, $title, $mail_body) {

	$MAIL_FROM = BACTCH_MAIL_FROM;

    $header  = "From: $MAIL_FROM\n";#From
    $header .= "Reply-To: $MAIL_FROM\n";#Reply-To
    $header .= "Return-Path: $MAIL_FROM\n";#Return-Path
    $header .= "MIME-version: 1.0\n";#MIMEヘッダ
    $header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";#通常メール

	//本文のファイルを読み込む
	$file_path = MAILPATH . "mail_error.txt";
	if (file_exists($file_path) == false) {
		error("file not exist ($file_path).");
	}
	$body = file_get_contents($file_path);
	$body = str_replace("[email]", $email, $body);
	$body = str_replace("[title]", $title, $body);
	$body = str_replace("[body]", $mail_body, $body);

	//タイトルのファイルを読み込む
	$file_path = MAILPATH ."mail_error_title.txt";
	if (file_exists($file_path) == false) {
		error("file not exist ($file_path).");
	}
	$sub = file_get_contents($file_path);

	mb_language("ja");
	$sub = mb_convert_encoding($sub, "ISO-2022-JP","AUTO");
	$body = mb_convert_encoding($body, "ISO-2022-JP","AUTO");


	$mail_to = BACTCH_MAIL_TO;
	mb_send_mail($mail_to, $sub, $body, $header);

}
?>
