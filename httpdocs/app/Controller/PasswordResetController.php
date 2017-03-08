<?php
/**
 * パスワード、リセット
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */

class PasswordResetController extends AppController {

	//使用するmodel
	var $uses = array('PasswordReset');

	//暗号化のキー
	var $key = "xB72RDu9P2dW5aYrXxFEm5HrhVgjMNxG";
	var $method = "aes256";
	var $cookie_data = array();

	//About Us ページ
	public function order() {
		$mode = $this->params['pass'][0];
		if ($mode == "input") {
			$this->order_input();
		} else if ($mode == "complete") {
			$this->order_complete();
		}
	}

	public function reset() {
		$mode = $this->params['pass'][0];
		if ($mode == "input") {
			$this->reset_input();
		} else if ($mode == "complete") {
			$this->reset_complete();
		}
	}

	//メールアドレス入力画面
	private function order_input() {
		$this->cookie_data = $this->readCookie("email");
		if ($this->cookie_data) {
			//クッキーにデータがあれば、エラー画面を表示する
			$this->render('order_input');
			return;
		}
		$this->set_data('email_error', '');
		$this->render('order_input');
	}

	//メールアドレス入力完了画面
	private function order_complete() {
		if ($this->request->data['confirm'] == false) {
			//URL直打ちされた
			$this->redirect('/password_reset/order/input');
			exit;
		}
		$this->cookie_data['data'] = $this->data;
		$this->PasswordReset->set($this->request->data);
		if ($this->PasswordReset->validates()) {
			$check = $this->_check_input_data();
			if ($check) {
				$this->saveCookie("email");
				$this->redirect('/password_reset/order/input');
			} else {
				//ユーザーにメール送信
				$email = $this->request->data['PasswordReset']['email'];
				$param = $this->getParam($email);
				$command = "/usr/bin/php /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/Command/send_mail.php $email password_change $param > /dev/null &";
				exec($command);
				$this->log("$command", "info");
				$this->render('order_complete');
			}
		} else {
			$this->_check_validation();
			$this->saveCookie("email");
			$this->redirect('/password_reset/order/input');
		}
	}

	//入力値をチェックする
	private function _check_input_data() {
		$error = false;
		$passwordreset_data = $this->data['PasswordReset'];
		extract($passwordreset_data);
		if ($email) {
			$check = $this->check_mail($email);
			if ($check) {
				$this->set_data('email_error', "Please enter your a valid business e-mail address.");
				$error = true;
			}
		}
		return $error;
	}

	//メールアドレスの有効性チェック
	private function check_mail($email) {
		$check_mail_list = array(
			'@gmail\.com',
			'@aol\.*',
			'@inbox\.ru',
			'@protonmail\.*',
			'@yahoo\.*',
			'@zoho\.com',
			'@list\.ru',
			'@safe-mail\.*',
			'@y7mail\.com',
			'@lycos\.*',
			'@mail\.ua',
			'@openmailbox\.org',
			'@outlook\.*',
			'@inbox\.*',
			'@vivaldi\.net',
			'@opmbx\.org',
			'@hotmail\.*&br@live\.*',
			'@hushmail\.*',
			'@tutanota\.*',
			'@openaliasbox\.org',
			'@icloud\.com',
			'@hush\.*',
			'@tutamail\.com',
			'@invmail\.io',
			'@me\.com',
			'@mac\.hush\.*',
			'@tuta\.io',
			'@contactoffice\.*',
			'@mac\.com',
			'@yandex\.*',
			'@keemail\.me',
			'@facebook\.*',
			'@gmx\.*',
			'@mail\.ru',
			'@scryptmail\.com',
			'@caramail\.*',
			'@bk\.ru',
			'@7nd\.me'
		);

		foreach ($check_mail_list as $mail) {
			if (preg_match("/".$mail."/", $email) == 1) return true;
		}
		return false;
	}

	//検証
	private function _check_validation() {
	    $errors = $this->PasswordReset->validationErrors;
		if (isset($errors['email'])) {
			$this->set_data('email_error', $errors['email'][0]);
		} else {
			$this->set_data('email_error', '');
		}
	}

	//メール本文を作成する
	private function make_body($email) {

		//リセットパラメータを作成する
		$date_time = date("YmdHis");
		$reset_param = $date_time;
		$reset_param .= $email;
		$reset_param .= $date_time;
		$reset_param = openssl_encrypt($reset_param, $this->method, $this->key);
		$decrypt = openssl_decrypt($reset_param, $this->method, $this->key);

		$body = file_get_contents(MAILPATH . "password_change.txt");
		$body = str_replace("[param]", $reset_param, $body);

		return $body;

	}

	//リセットパラメータを取得する
	private function getParam($email) {

		//リセットパラメータを作成する
		$date_time = date("YmdHis");
		$reset_param = $date_time;
		$reset_param .= $email;
		$reset_param .= $date_time;
		$reset_param = openssl_encrypt($reset_param, $this->method, $this->key);

		return $reset_param;

	}

	//パスワード入力画面
	private function reset_input() {
		$this->cookie_data = $this->readCookie("password");
		if ($this->cookie_data) {
			//クッキーにデータがあれば、エラー画面を表示する
			$this->render('reset_input');
			return;
		}
		$email = $this->check_reset_param();
		if ($email == false) {
			$this->render('reset_error');
			return;
		}
		$this->set_data('password_error', '');
		$this->set_data('password2_error', '');
		$this->render('reset_input');
	}

	//パラメータの正当性をチェックする
	//@return メールアドレス=正しい false=不正
	private function check_reset_param() {
		$pass_list = $this->params['pass'];
		$reset_param = "";
		for ($i=1; $i<count($pass_list); $i++) {
			if ($reset_param) {
				$reset_param .= "/";
			}
			$reset_param .= $pass_list[$i];
		}
		$reset_param = str_replace(" ", "+", $reset_param);
		$reset_param = openssl_decrypt($reset_param, $this->method, $this->key);
		$str_len = strlen($reset_param);
		$time1 = substr($reset_param, 0, 14);
		$mail_len = $str_len - 28;
		if ($mail_len <= 0) return false;
		$email = substr($reset_param, 14, $mail_len);
		$time2 = substr($reset_param, 14 + $mail_len);
		if ($time1 != $time2) return false;
		return $email;
	}


	//パスワード入力完了画面
	private function reset_complete() {
		if ($this->request->data['confirm'] == false) {
			//URL直打ちされた
			$this->redirect('/password_reset/order/input');
			exit;
		}
		$check = $this->_check_password_data();
		if ($check) {
			//入力エラー
			$this->saveCookie("password");
			$this->redirect('/password_reset/reset/input');
		} else {
			$this->_password_salesforce();
			$this->render('reset_complete');
		}
	}

	//パスワードの入力チェック
	private function _check_password_data() {
		$error = false;
		$this->set_data('password_error', "");
		$this->set_data('password2_error', "");
		$data = $this->request->data;
		extract($data);
		if ($password == false) {
			$this->set_data('password_error', "Please enter Password.");
			$error = true;
		} else {
			if (strlen($password) < 8) {
				$this->set_data('password_error', "Password must be 8 characters or more.");
				$error = true;
			} else if (strlen($password) > 30) {
				$this->set_data('password_error', "Password must be 30 characters or less.");
				$error = true;
			} else if (!preg_match("/^[a-zA-Z0-9!#$%_=+<>\-]+$/", $password)) {
				$this->set_data('password_error', "The usable character type of password is alphabet, number, and symbol (!#$%-_=+<>)");
				$error = true;
			}
		}
		if ($password2 == false) {
			$this->set_data('password2_error', "Please re-enter Password.");
			$error = true;
		} else {
			if (strlen($password2) < 8) {
				$this->set_data('password2_error', "Re-enter Password must be 8 characters or more.");
				$error = true;
			} else if (strlen($password) > 30) {
				$this->set_data('password2_error', "Re-enter Password must be 30 characters or less.");
				$error = true;
			} else if (!preg_match("/^[a-zA-Z0-9!#$%_=+<>\-]+$/", $password)) {
				$this->set_data('password2_error', "The usable character type of password is alphabet, number, and symbol (!#$%-_=+<>)");
				$error = true;
			}
		}
		if ($password && $password2 && $error == false) {
			if ($password != $password2) {
				$this->set_data('password_error', "Passwords do not match.");
				$this->set_data('password2_error', "Passwords do not match.");
				$error = true;
			}
		}
		return $error;
	}

	//SaleceForceパスワード変更
	private function _password_salesforce() {
		$datetime = date("Y-m-d H:i:s");
		extract($this->request->data);
		$params = array();
		$params['Email'] = "ooishiyasuo@gmail.com";
		$params['Password'] = $password;
		$params['ModifyDateTime'] = $datetime;
		$ret_data = $this->PasswordReset($params);
	}

	//データを変数とクッキー保存用にセットする
	private function set_data($key, $data) {
		$this->set($key, $data);
		$this->cookie_data[$key] = $data;
	}

	//クッキーに保存する
	private function saveCookie($key_cookie) {
		$this->Cookie->write($key_cookie, $this->cookie_data);
	}

	//クッキーを読む
	private function readCookie($key_cookie) {
		$data_list = $this->Cookie->read($key_cookie);
		if ($data_list == false) return false;
		foreach ($data_list as $key => $data) {
			$this->set($key, $data);
			if ($key == "data") {
				$this->data = $data;
			}
		}
		//読んだらクッキーを削除する
		$this->Cookie->delete($key_cookie);
		return $data_list;
	}

}
