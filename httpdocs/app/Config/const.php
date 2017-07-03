<?php

if ($_SERVER['SERVER_NAME'] == "www.nagase-personalcare.com" || $_SERVER['SERVER_NAME'] == "nagase-personalcare.com" || strpos(php_uname("n"), "tenpo_prd") !== false ) {

	//ドメイン
	define("DOMAIN", "nagase-personalcare.com");
	//ドキュメントルート
	define("DOCUMENT_ROOT", "/var/www/vhosts/nagase-personalcare.com/httpdocs/");

	//画像、ドキュメントファイルのパス
	define("FILESPATH", DOCUMENT_ROOT . "app/webroot/files");
	define("PDF_FILESPATH", "/var/www/vhosts/nagase-personalcare.com/files/product_doc/");
	define("DOCUMENT_URL", "/files/product_doc/");

	//メール本文のファイルパス
	define("MAILPATH", DOCUMENT_ROOT . "app/View/Emails/text/");

	//Salesforce API 接続先
	define("API_BASE_URL", "https://ap2.force.com/services/apexrest/");

	//トークン接続先		
	define("TOKEN_URL", "https://login.salesforce.com/services/oauth2/token");

	//接続情報
	define("CLIENT_ID", "3MVG9ZL0ppGP5UrDzZexbNY6mUuarksuXAOPQ.2Ti4VVXfv1JZV8VKI_htLzd5Sk0I0YrCqtxw.KUK4WqXk8x");
	define("CLIENT_SECRET", "7318877119550894525");
	define("USERNAME", "nagase-personalcare@nagase.co.jp");
	define("PASSWORD", "nagasepersonalcare1");

	define("WEB_CLIENT_SECRET", "qo68nfwdpg8bcgypthr886eqv7dyj006");

	//***メール関連***
	//メール送信元
	define("MAIL_FROM", "nagase-personalcare1@nagase.co.jp");
	define("FROM_NAME", "NAGASE Personal Care");
	//メール送信先
	//define("MAIL_TO", "wtg_tenpo@netyear.net");
	define("MAIL_TO", "nagase-personalcare@nagase.co.jp");
	define("SMTP_USER", "NAGASEPCWEB@nagase.co.jp");
	define("SMTP_PASSWORD", "nagasepcweb");
	define("MAIL_HOST", "smtp.office365.com");

	//キャッシュサーバー
	define("CACHE_SERVER", "tenpo.9ealup.0001.euc1.cache.amazonaws.com");

	//ログインの有効期限
	define("EXPIRE_LOGIN", "+1 hours");
	//商品情報の有効期限
	define("EXPIRE_PRODUCT", "+1 day");

} else {

	//ドメイン
	define("DOMAIN", "stg.nagase-personalcare.com");
	//ドキュメントルート
	define("DOCUMENT_ROOT", "/var/www/vhosts/stg.nagase-personalcare.com/httpdocs/");

	//画像、ドキュメントファイルのパス
	define("FILESPATH", DOCUMENT_ROOT . "app/webroot/files");
	define("PDF_FILESPATH", "/var/www/vhosts/stg.nagase-personalcare.com/files/product_doc/");
	define("DOCUMENT_URL", "/files/product_doc/");

	//メール本文のファイルパス
	define("MAILPATH", DOCUMENT_ROOT . "app/View/Emails/text/");

	//Salesforce API 接続先
	//define("API_BASE_URL", "https://yushida-developer-edition.ap2.force.com/services/apexrest/");
	define("API_BASE_URL", "https://cs31.force.com/services/apexrest/");

	//トークン接続先
	define("TOKEN_URL", "https://test.salesforce.com/services/oauth2/token");

	//接続情報
	define("CLIENT_ID", "3MVG9Se4BnchkASkMCQz09XkXe_0sJhvHsmdsc_mzYvdSMANZpgT8r_4pS57Y5ltpl5W71W20dnOaDgZo8XBN");
	define("CLIENT_SECRET", "4714043558703686551");
	define("USERNAME", "wtg_tenpo@netyear.net.dev2");
	define("PASSWORD", "tenpodemo01");

	define("WEB_CLIENT_SECRET", "qo68nfwdpg8bcgypthr886eqv7dyj006");

	//***メール関連***
	//メール送信元
	define("MAIL_FROM", "nagase-personalcare1@nagase.co.jp");
	define("FROM_NAME", "NAGASE Personal Care");
	//メール送信先
	//define("MAIL_TO", "wtg_tenpo@netyear.net");
	define("MAIL_TO", "wtg_tenpo@netyear.net,y-oishi@netyear.net");
	define("SMTP_USER", "NAGASEPCWEB@nagase.co.jp");
	define("SMTP_PASSWORD", "nagasepcweb");
	define("MAIL_HOST", "smtp.office365.com");

	//キャッシュサーバー
	define("CACHE_SERVER", "stg-tenpo.9ealup.0001.euc1.cache.amazonaws.com");

	//ログインの有効期限
	define("EXPIRE_LOGIN", "+1 hours");
	//商品情報の有効期限
	define("EXPIRE_PRODUCT", "+1 day");

}

?>

