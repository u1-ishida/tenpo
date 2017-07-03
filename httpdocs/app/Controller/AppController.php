<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

/**
 * 共通関数
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
require_once ( 'PHPMailer/PHPMailerAutoload.php' );

class AppController extends Controller {

	var $components = array('Session', 'Cookie');

	//ログインしているユーザー
	var $tenpoUserId;
	var $Salutation;
	var $FirstName;
	var $LastName;
	var $Email;
	var $CompanyName;
	var $EmployerWebsite;
	var $BusinessType;
	var $BusinessTypeOther;
	var $ProfessionalTitle;
	var $PhoneNumber;
	var $Country_Region;
	var $CountryOther;

	//製品情報のFilter Selection
	var $filter_selection;

	function beforeFilter() {

		// レイアウトをOFFにする
		$this->autoLayout = false;
		//クッキーの設定
		$this->Cookie->name = 'baker_id';
		$this->Cookie->time = 3600;  // または '1 hour'
		$this->Cookie->path = '/';
		$this->Cookie->domain = DOMAIN;
		//$this->Cookie->secure = true;  // セキュアな HTTPS で接続している時のみ発行されます
		$this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
		$this->Cookie->httpOnly = true;

		//ログイン認証
		//クッキーにユーザーIDがあり、キャッシュに情報があれば、ログインしているとみなす
		$session_id = $this->Cookie->read('id');
		$json_data = Cache::read($session_id);
		if ($json_data == false) {
			return;
		}
		//クッキー期限の延長
		//$this->Cookie->write('id', $session_id);
		$data = json_decode($json_data, true);

		//有効期限をチェック
		$expire = $data['expire'];
		if ($expire == false) return;
		$now_time = date("Y/m/d H:i:s");
		if ($now_time > $expire) {
			//期限切れなのでログインできません
			$this->info("login expire $now_time <= $expire");
			return;
		}
		$this->info("login not expire $now_time <= $expire");
		$this->tenpoUserId = $data['tenpoUserId'];
		$this->Salutation = $data['Salutation'];
		$this->FirstName = $data['FirstName'];
		$this->LastName = $data['LastName'];
		$this->Email = $data['Email'];
		$this->CompanyName = $data['CompanyName'];
		$this->EmployerWebsite = $data['EmployerWebsite'];
		$this->BusinessType = $data['BusinessType'];
		$this->BusinessTypeOther = $data['BusinessTypeOther'];
		$this->ProfessionalTitle = $data['ProfessionalTitle'];
		$this->PhoneNumber = $data['PhoneNumber'];
		$this->Country_Region = $data['Country_Region'];
		$this->CountryOther = $data['CountryOther'];

		//ユーザセッションの有効期限を最終アクセスから120分に設定する。
		$expire = date("Y/m/d H:i:s", strtotime(EXPIRE_LOGIN));
		$data['expire'] = $expire;
		$json_data = json_encode($data);
		Cache::write($session_id, $json_data);
	}

	function beforeRender() {
		$this->set("id", $this->tenpoUserId);
		$this->set("FirstName", $this->FirstName);
		$this->set("LastName", $this->LastName);
	}

	//Email有効確認API
	function isEffectiveEmail($array_data) {
		$ret_data = $this->apexrest("isEffectiveEmail/", $array_data);
		return $ret_data;
	}

	//ユーザ情報登録・更新API
	function upsertUser($array_data) {
		$ret_data = $this->apexrest("upsertUser/", $array_data);
		return $ret_data;
	}

	//問い合わせ登録API
	function upsertContact($array_data) {
		$ret_data = $this->apexrest("upsertContact/", $array_data);
		return $ret_data;
	}

	//パスワード再設定API
	function PasswordReset($array_data) {
		$ret_data = $this->apexrest("PasswordReset/", $array_data);
		return $ret_data;
	}

	//（一覧用）商品情報取得API
	function getProducts() {
		//まずは、キャッシュから読み込む
		$json_data = Cache::read("products");
		if ($json_data == false) {
			//キャッシュにデータがない場合APIから取得
			$product_list = $this->getProductFromApi();
		} else {
			//キャッシュからデータを取得
			$ret_data = json_decode($json_data, true);
			//有効期限をチェックする
			$expire = $ret_data['expire'];
			$now_time = date("Y/m/d H:i:s");
			if ($now_time <= $expire) {
				$this->info("products not expire $now_time <= $expire");
				//有効期限内
				if (isset($ret_data['Products'])) {
					$product_list = $ret_data['Products'];
					//tenpoProductIdがあるかどうかチェックする
					$check = $this->check_tenpoProductId($product_list);
					if ($check) {
						$product_list = array();
					}
				}
			} else {
				$this->info("products expire $now_time <= $expire");
				$product_list = array();
			}
			if (isset($product_list) == false) {
				$product_list = array();
			}
			if ($product_list == false) {
				//キャッシュデータが壊れている場合APIから取得
				$product_list = $this->getProductFromApi();
			}
		}
		return $product_list;
	}

	//キャッシュデータが壊れている場合APIから取得
	private function getProductFromApi() {
		$params = array();
		$params['dummy'] = "1";
		$ret_data = $this->apexrest("getProducts/", $params);
		//有効期限(24時間)を追加する
		$expire = date("Y/m/d H:i:s", strtotime(EXPIRE_PRODUCT));
		$ret_data['expire'] = $expire;
		$json_data = json_encode($ret_data);
		//json形式でキャッシュに保存
		Cache::write("products", $json_data);
		if (isset($ret_data['Products'])) {
			$product_list = $ret_data['Products'];
		}
		if (isset($product_list) == false) {
			$product_list = array();
		}
		return $product_list;
	}

	//商品一覧データにtenpoProductIdがあるかチェック
	//@return true=tenpoProductIdがない
	function check_tenpoProductId($product_list) {
		foreach ($product_list as $product) {
			if ($product['tenpoProductId'] == false) {
				//tenpoProductIdがないのでデータは不正である
				return true;
			}
		}
		$this->info("check_tenpoProductId OK");
		return false;
	}

	//SortOrderでソートする
	function sort_order($product_list) {
		$product_list2 = array();
		foreach($product_list as $bean) {
			$key = $bean['SortOrder'];
			$product_list2[$key] = $bean;
		}
		ksort($product_list2);
		return $product_list2;
	}

	//商品ドキュメントダウンロードAPI
	function getProductFile($array_data) {
		$ret_data = $this->apexrest("getProductFile/", $array_data);
		return $ret_data;
	}

	//ログイン
	function saleceforcelogin($array_data) {
		$ret_data = $this->apexrest("login/", $array_data);
		return $ret_data;
	}

	//SalesforceAPI
	private function apexrest($entrypoint, $array_data) {

		// Salesforce との接続
		// 接続情報はConfigに移行
		$client_id = CLIENT_ID;
		$client_secret = CLIENT_SECRET;
		$username = USERNAME;
		$password = PASSWORD;

		$api_connect_url = TOKEN_URL . "?grant_type=password&client_id=".$client_id."&client_secret=".$client_secret."&username=".$username."&password=".$password;

		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $api_connect_url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

		$response = curl_exec($curl);
		$result = json_decode($response, true);
		$access_token = $result['access_token'];

		// APIコール
		$api_base_url = API_BASE_URL;

		$header = array(
 			'Authorization: Bearer '.$access_token,  // 前準備で取得したtokenをヘッダに含める
			'Content-Type: application/json',
		);
		$json_data = json_encode($array_data);
		$this->info($json_data);

		curl_setopt($curl, CURLOPT_URL, $api_base_url . $entrypoint);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data); 
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // リクエストにヘッダーを含める
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
		curl_setopt($curl, CURLOPT_HEADER, true);

		$response = curl_exec($curl);
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE); 
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		if ($entrypoint != "getProductFile/") {
			$this->info($body);
		}
		$result = json_decode($body, true); 
		$body = json_encode($body, true); 
		curl_close($curl);
		return $result;

	}

	//ログの出力
	private function info($message) {
		$this->log("$message", "info");
	}

	//画像の存在チェックをしてimg_srcを生成する
	protected function make_imgsrc(&$product_list) {
		foreach($product_list as $key => $product) {
			$product['imgsrc'] = $this->get_imgsrc($product['tenpoProductId']);
			$product_list[$key] = $product;
		}
	}

	//ファイルが存在すれば<img src="">を作る
	protected function get_imgsrc($tenpoProductId) {
		$imgsrc = "";

		$file_path = FILESPATH . "/product_img/" . $tenpoProductId;
		if (file_exists($file_path) == false) return "";
		$d = dir($file_path);
		if ($d == false) return "";
		while (false !== ($file = $d->read())) {
			if ($file == ".") continue;
			if ($file == "..") continue;
			$imgsrc = "<img src='/files/product_img/$tenpoProductId/$file'>";
		}
		return $imgsrc;
	}

	//メールを送信する
	protected function send_mail($email, $title, $body) {

		$subject = $title;
		$fromname = FROM_NAME;
		$from = MAIL_FROM;
		$smtp_user = SMTP_USER;
		$smtp_password = SMTP_PASSWORD;
		$to = $email;

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
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

	//ヘッダー情報をチェックする
	protected function check_header() {

		$header = getallheaders();
		if (isset($header['X-Signature']) == false) {
			return "X-Signature not found";
		}
		$signature = $header['X-Signature'];
		$body = file_get_contents('php://input');
		$body = hash_hmac("sha256", $body, WEB_CLIENT_SECRET, true);
		$body = base64_encode($body);
		if ($signature != $body) {
			return "Authentication Error";
		}
		return "";
	}

	//商品のカテゴリselect option を作成する
	protected function cat01_select($cat01 = "") {
		$selected = "";
		$optin_list = array();
		$optin_list[] = '<option value="" disabled selected class="placeholder">Select Category</option>';
		if ($cat01 == "function") {
			$selected = "selected";
		} else {
			$selected = "";
		}
		$optin_list[] = "<option id='function' value='function' $selected>Function</option>";

		if ($cat01 == "benefit") {
			$selected = "selected";
		} else {
			$selected = "";
		}
		$optin_list[] = "<option id='benefit' value='benefit' $selected>Benefit</option>";

		if ($cat01 == "application") {
			$selected = "selected";
		} else {
			$selected = "";
		}
		$optin_list[] = "<option id='application' value='application' $selected>Application</option>";

		if ($cat01) {
			$style = " style='color: rgb(0, 0, 0);'";
		} else {
			$style = "";
		}
		$html = "<select id='cat01' name='cat01' onchange='javascript:select_category();'$style>";
		foreach ($optin_list as $option) {
			$html .= $option . "\n";
		}
		$html .= "</select>\n";
		return $html;
	}

	//商品のカテゴリselect option を作成する
	protected function cat02_select($cat01 = "", $cat02 = "") {
		$selected = "";
		$optin_list = array();
		if ($cat01 == "function") {
			$function_category_list = get_function_category_list();
			foreach($function_category_list as $function) {
				if ($cat02 == $function) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$optin_list[] = "<option value='$function' $selected>$function</option>";
			}
		} else if ($cat01 == "benefit") {
			$benefit_category_list = get_benefit_category_list();
			foreach($benefit_category_list as $benefit) {
				if ($cat02 == $benefit) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$optin_list[] = "<option value='$benefit' $selected>$benefit</option>";
			}
		} else if ($cat01 == "application") {
			$application_category_list = get_application_category_list();
			foreach($application_category_list as $application) {
				if ($cat02 == $application) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$optin_list[] = "<option value='$application' $selected>$application</option>";
			}
		} else {
			$optin_list[] = '<option value="" disabled selected class="placeholder">----</option>';
		}
		if ($cat02) {
			$style = " style='color: rgb(0, 0, 0);'";
		} else {
			$style = "";
		}
		$html = "<select id='cat02' name='cat02'$style>\n";
		foreach ($optin_list as $option) {
			$html .= $option . "\n";
		}
		$html .= "</select>\n";
		return $html;
	}

	//カテゴリ選択
	protected function select_category() {
		$function_list = "";
		$function_category_list = get_function_category_list();
		foreach($function_category_list as $function) {
			$function_list .= "\t\t'$function',\n";
		}
		$this->set("function_list", $function_list);

		$benefit_list = "";
		$benefit_category_list = get_benefit_category_list();
		foreach($benefit_category_list as $benefit) {
			$benefit_list .= "\t\t'$benefit',\n";
		}
		$this->set("benefit_list", $benefit_list);

		$application_list = "";
		$application_category_list = get_application_category_list();
		foreach($application_category_list as $application) {
			$application_list .= "\t\t'$application',\n";
		}
		$this->set("application_list", $application_list);
	}

}
