<?php
/**
 * ���O�o�͏���
 * 
 * �G���[�ɂȂ����ꍇ�A���O�ɏo�͂��ďI������
 * �s�������������O�ɏo�͂���
 *
 * @since 2016-09-15
 * @author Ooishi Yasuo <y-oishi@netyear.net>
 */
require_once("config.php");

//���̃��O�o��
function info($message) {

	error_log("[INFO] ".date("Y-m-d H:i:s ").$message."\n", 3, LOG_FILE);

}

//�G���[����
function error($message) {

	//�G���[���O���o��
	error_log("[ERROR] ".date("Y-m-d H:i:s ").$message."\n", 3, LOG_FILE);

	//�G���[���[���𑗐M����
	if (ERROR_MAIL == 1) {
		error_mail($message);
	}
	echo $message;
	echo "\n";
	exit;

}

//�G���[���[���𑗐M����
function error_mail($message) {

	$destination = BATCH_MAIL_TO;
	$MAIL_FROM = BATCH_MAIL_FROM;
	$header  = "From: $MAIL_FROM\n";#From
	$header .= "Reply-To: $MAIL_FROM\n";#Reply-To
	$header .= "Return-Path: $MAIL_FROM\n";#Return-Path
	$header .= "MIME-version: 1.0\n";#MIME�w�b�_
	$header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";#�ʏ탁�[��

	$body = date("Y-m-d H:i:s ").$message;
	//$body = mb_convert_encoding($body, "ISO-2022-JP","AUTO");

	error_log($body, 1, $destination, $header);

}

?>
