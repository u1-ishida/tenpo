<?php
/**
 * メール送信
 *
 * /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/cake sendmail test -app /var/www/vhosts/nagase-personalcare.com/httpdocs/app
 */
class SendMailShell extends AppShell {

	public function test() {

		echo "test()";
		error_log("SendMailShell Test", 3, "/var/www/vhosts/nagase-personalcare.com/httpdocs/app/tmp/logs/send_mail.log");

	}

}
?>
