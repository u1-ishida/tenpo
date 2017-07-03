<?php
/**
 * バッチ設定ファイル
 *
 * @since 2016-12-28
 * @author y-oishi@netyear.net
 *
 */
$hostname = php_uname("n");
if (strpos($hostname, "tenpo_prd") !== false) {
	require('/var/www/vhosts/nagase-personalcare.com/httpdocs/app/Config/const.php');
	//ログファイル出力
	define("LOG_FILE", "/var/www/vhosts/nagase-personalcare.com/httpdocs/app/tmp/logs/send_mail.log");
	//エラーメールを送信する
	define("BACTCH_MAIL_FROM", "system");
	define("BACTCH_MAIL_TO", "nagase-personalcare@nagase.co.jp,wtg_tenpo@netyear.net");
} else {
	require('/var/www/vhosts/stg.nagase-personalcare.com/httpdocs/app/Config/const.php');
	//ログファイル出力
	define("LOG_FILE", "/var/www/vhosts/stg.nagase-personalcare.com/httpdocs/app/tmp/logs/send_mail.log");
	//エラーメールを送信する
	define("BACTCH_MAIL_FROM", "system");
	define("BACTCH_MAIL_TO", "y-oishi@netyear.net,wtg_tenpo@netyear.net");
}

?>
