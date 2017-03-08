<?php
/**
 * ログイン
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class LoginController extends AppController {

	//ログインフォーム
	public function index() {
		$login_error = $this->Cookie->read("login_error");
		$this->set("login_error", $login_error);
		$this->Cookie->delete("login_error");
		$data = $this->request->query;
		$back = "";
		if (isset($data['back'])) {
			$back = $data['back'];
		}
		$this->set("back", $back);

		$productid = "";
		if (isset($data['productid'])) {
			$productid = $data['productid'];
		}
		$this->set("productid", $productid);
	}

	//ログイン実行
	public function login() {
		$data = $this->request->data;
		extract($data);
		if ($back) {
			$this->Cookie->write('back_url', $back);
		} else {
			$info = parse_url($_SERVER['HTTP_REFERER']);
		}
		//ログイン
		$this->Cookie->delete("login_error");
		$user_array = $this->_get_login_info();
		if ($user_array == false) {
			$this->Cookie->write('login_error', "Input content is incorrect. please confirm.");
			$this->redirect('/login/');
			return;
		}
		extract($user_array);
		if ($Result != 1) {
			$this->Cookie->write('login_error', "Input content is incorrect. please confirm.");
			$this->redirect('/login/');
			return;
		}
		//ログイン
		$microtime = microtime();
		$array = explode(" ", $microtime);
		$session_id = $array[1];
		$session_id .= rand();
		//セッションIDをクッキーに保存
		$this->Cookie->write('id', $session_id);
		$session_id = $this->Cookie->read('id');
		//ユーザセッションの有効期限を最終アクセスから120分に設定する。
		$expire = date("Y/m/d H:i:s", strtotime(EXPIRE_LOGIN));
		$user_array['expire'] = $expire;
		$json_data = json_encode($user_array);
		Cache::write($session_id, $json_data);
		$back_url = $this->Cookie->read('back_url');
		if ($back_url) {
			$this->redirect($back_url);
		} else {
			$this->redirect('/top/index');
		}
	}

	//入力データをチェックし、入っていればログインAPIを実行する
	private function _get_login_info() {
		$data = $this->request->data;
		extract($data);
		if ($id == false) return false;
		if ($password == false) return false;

		$params = array();
		$params['Email'] = $id;
		$params['Password'] = $password;
		$ret_data = $this->saleceforcelogin($params);
		return $ret_data;
	}

	//パスワードを忘れた
	public function password_reset() {
		$mode = $this->params['pass'][0];
		if ($mode == "input") {
			$this->_input();
		} else if ($mode == "complete") {
			$this->_complete();
		}
	}

	//メールアドレス入力画面
	private function _input() {
		$this->render('password_reset_input');
	}

	//メールアドレス入力完了画面
	private function _complete() {
		$this->render('password_reset_complete');
	}

}
