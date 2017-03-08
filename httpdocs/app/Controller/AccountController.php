<?php
/**
 * 会員情報
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class AccountController extends AppController {

	//使用するmodel
	var $uses = array('Account');

	var $session_data = array();

	//会員トップ
	public function index() {
		if ($this->tenpoUserId == false) {
			//ログイン状態ではない
			$this->redirect('/login/index');
			exit;
		}
	}

	//会員登録
	public function create() {
		$mode = $this->params['pass'][0];
		if ($mode == "input") {
			$this->_input();
		} else if ($mode == "confirm") {
			$this->_confirm();
		} else if ($mode == "complete") {
			$this->_complete();
		} else {
			$this->_index();
		}
	}

	//会員情報入力トップ
	private function _index() {
		$this->render('create_index');
	}

	//会員情報入力
	private function _input() {
		$this->session_data = $this->readSession("account_input");
		if ($this->session_data) {
			//セッションにデータがあれば、エラー画面を表示する
			extract($this->request->data['Account']);
			$this->BusinessType = $businesstype;
			$this->Country_Region = $country;
			$this->CountryOther = $othercountry;
			$this->edit_html();
			$this->render('input');
			return;
		}
		$this->clear_error();
		$this->set_data('othercountry_error', '');
		if ($this->request->data['mode'] == "confirm") {
			//確認画面から戻った
			$this->input_back();
			return;
		}
		//各種HTMLの作成
		$this->edit_html();
		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$product_checkbox = $this->make_product_checkbox();
		$this->set_data('product_checkbox', $product_checkbox);

		$this->render('input');
	}

	//エラーはなしの状態に
	private function clear_error() {
		$this->set_data('name_error', '');
		$this->set_data('name1_error', '');
		$this->set_data('name2_error', '');
		$this->set_data('email_error', '');
		$this->set_data('company_error', '');
		$this->set_data('position_error', '');
		$this->set_data('password_error', '');
		$this->set_data('password2_error', '');
		$this->set_data('businesstype_error', '');
		$this->set_data('otherbusinesstype_error', '');
		$this->set_data('country_error', '');
		$this->set_data('tel_error', '');
		$this->set_data('othercountry_error', '');
		$this->set_data('products_error', "");
		$this->set_data('contacttype_error', "");
		$this->set_data('contactdetail_error', "");
	}

	//会員情報入力確認
	private function _confirm() {
		if ($this->request->data['confirm'] == false) {
			//URL直打ちされた
			$this->redirect('/account/create/introduction');
			exit;
		}
		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$this->Account->set($this->request->data);

		if ($this->Account->validates()) {
			$this->log("validates ok");
			$this->set_data("account_data",$this->data['Account']);
			$check = $this->_check_input_data();
			if ($check) {
				//入力画面に戻る
				$this->redirect_create_input();
			} else {
				$this->_confirm_product();
				$this->render('confirm');
			}
		} else {
			$this->log("validates ng");
			$this->_check_validation();
			$check = $this->_check_input_data();
			//入力画面に戻る
			$this->redirect_create_input();
		}
	}

	//入力画面にリダイレクトする
	private function redirect_create_input() {
		$this->session_data['data'] = $this->data;
		$this->saveSession("account_input");
		//このURLにしたい
		$this->redirect('/account/create/input');
	}

	//会員情報入力完了
	private function _complete() {
		if ($this->request->data['complete'] == false) {
			//URL直打ちされた
			$this->redirect('/account/create/introduction');
			exit;
		}
		if ($this->request->data['back']) {
			//戻る
			$this->input_back();
			return;
		}
		$this->_regist_member();
		$this->render('complete');
	}

	//会員登録、確認画面＞戻る＞入力画面
	private function input_back() {
		$this->clear_error();
		$request_data = array();
		$request_data['Account'] = $this->request->data;
		$this->request->data = $request_data;
		$this->Account->set($request_data);

		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$product_checkbox = $this->make_product_checkbox();
		$this->set_data('product_checkbox', $product_checkbox);

		//各種HTMLの作成
		extract($this->request->data['Account']);
		$this->BusinessType = $businesstype;
		$this->Country_Region = $country;
		$this->CountryOther = $othercountry;

		$this->edit_html();
		$this->render('input');
	}

	//検証
	private function _check_validation() {
	    $errors = $this->Account->validationErrors;
		$this->set_data('name_error', '');
		if (isset($errors['name1'])) {
			$this->set_data('name_error', $errors['name1'][0]);
			$this->set_data('name1_error', $errors['name1'][0]);
		}
		if (isset($errors['name2'])) {
			$this->set_data('name_error', $errors['name2'][0]);
			$this->set_data('name2_error', $errors['name2'][0]);
		}
		if (isset($errors['email'])) {
			$this->set_data('email_error', $errors['email'][0]);
		} else {
			$this->set_data('email_error', '');
		}
		if (isset($errors['password'])) {
			$this->set_data('password_error', $errors['password'][0]);
		} else {
			$this->set_data('password_error', '');
		}

		if (isset($errors['password2'])) {
			$this->set_data('password2_error', $errors['password2'][0]);
		} else {
			$this->set_data('password2_error', '');
		}
		if (isset($errors['company'])) {
			$this->set_data('company_error', $errors['company'][0]);
		} else {
			$this->set_data('company_error', '');
		}
		if (isset($errors['position'])) {
			$this->set_data('position_error', $errors['position'][0]);
		} else {
			$this->set_data('position_error', '');
		}
		if (isset($errors['tel'])) {
			$this->set_data('tel_error', $errors['tel'][0]);
		} else {
			$this->set_data('tel_error', '');
		}
	}

	//入力値をチェックする
	private function _check_input_data($mode = "") {
		$error = false;
		$account_data = $this->data['Account'];
		extract($account_data);
		if ($mode != "edit") {
			if ($password != $password2 && $password2 && strlen($password2) >= 8 && $password && strlen($password) >= 8) {
				$this->set_data('password2_error', "Passwords do not match.");
				$error = true;
			}
		}
		//Business Type
		if ($businesstype) {
			$this->BusinessType = $businesstype;
			$this->set_data('businesstype_error', "");
		} else {
			$this->set_data('businesstype_error', "Please select your business type.");
			$error = true;
		}
		$this->set_data('otherbusinesstype_error', "");
		if ($businesstype == "Other") {
			if ($otherbusinesstype == false) {
				$this->set_data('otherbusinesstype_error', "If other is selected, please enter your business type.");
				$error = true;
			} else if (mb_strlen($otherbusinesstype) > 80) {
				$this->set_data('otherbusinesstype_error', "Business type Other must be 80 characters or less.");
				$error = true;
			}
		}
		//国
		if ($country) {
			$this->Country_Region = $country;
			$this->set_data('country_error', "");
		} else {
			$this->set_data('country_error', "Please select your country.");
			$error = true;
		}
		$this->set_data('othercountry_error', "");
		if ($country == "Other") {
			if ($othercountry == false) {
				$this->set_data('othercountry_error', "If other is selected, please enter your country.");
				$error = true;
			} else if (mb_strlen($othercountry) > 80) {
				$this->set_data('othercountry_error', "must be 80 characters or less.");
				$error = true;
			}
		}

		$this->set_data('products_error', "");

		if ($email) {
			$check = $this->check_mail($email);
			if ($check) {
				$this->set_data('email_error', "Please enter your a valid business e-mail address.");
				$error = true;
			} else {
				if ($mode == "edit") {
					if ($email != $this->Email) {
						//メールアドレスは有効か？
						$check = $this->check_mail_effective($email);
						if ($check) {
							$this->set_data('email_error', "e-mail address is not effective.");
							$error = true;
						}
					}
				} else {
					//メールアドレスは有効か？
					$check = $this->check_mail_effective($email);
					if ($check) {
						$this->set_data('email_error', "e-mail address is not effective.");
						$error = true;
					}
				}
			}
		}
		if ($mode != "edit") {
			//問い合わせは１つ入力したら、他は必須である
			$check = $this->check_contact_data();
			if ($check) {
				$error = true;
			}
		}

		//各種HTMLの作成
		$this->edit_html();

		return $error;
	}

	//問い合わせデータ入力チェック
	private function check_contact_data() {
		$error = false;
		$account_data = $this->data['Account'];
		extract($account_data);
		$required = false;
		if ($contacttype) {
			$required = true;
		}
		if ($contactdetail) {
			$required = true;
			if (mb_strlen($contactdetail) > 10000) {
				$this->set_data('contactdetail_error', "Contact detail must be 10000 characters or less.");
				$error = true;
			}
		}
		//会員登録のチェック
		$check = $this->_check_products($required);
		if ($check == "required") {
			$this->set_data('products_error', "Please select products.");
			$error = true;
		} else if ($check == "check") {
			if ($contacttype == false || $contactdetail == false) {
				//商品が選択されているので、他入力されていないのはエラー
				if ($contacttype == false) {
					$this->set_data('contacttype_error', "Please select contact type.");
				}
				if ($contactdetail == false) {
					$this->set_data('contactdetail_error', "Please enter contact detail.");
				}
				$error = true;
			}
		}
		if ($contacttype == false && $contactdetail == true) {
			$this->set_data('contacttype_error', "Please select contact type.");
			$error = true;
		}
		if ($contacttype == true && $contactdetail == false) {
			$this->set_data('contactdetail_error', "Please enter contact detail.");
			$error = true;
		}
		return $error;
	}

	//各種HTMLの作成
	private function edit_html() {
		$bussness_type_option = $this->make_bussness_type_option();
		$this->set_data('bussness_type_option', $bussness_type_option);

		$country_option = $this->make_country_option();
		$this->set_data('country_option', $country_option);

		$businesstypeother_display = "";
		if ($this->BusinessType == "Other") {
			$businesstypeother_display = "style='display: block;'";
		}
		$this->set_data('businesstypeother_display', $businesstypeother_display);

		$countryother_display = "";
		if ($this->Country_Region == "Other") {
			$countryother_display = "style='display: block;'";
		}
		$this->set_data('countryother_display', $countryother_display);
	}

	//選択されたproducts
	private function _confirm_product() {
		$products = "";
		if (isset($this->request->data['product'])) {
			$inquiry = $this->request->data['product'];
			foreach($inquiry as $id => $val) {
				$products .= $this->getProductName($id);
			}
		}
		$this->set_data("products", $products);
	}

	//製品名を取得
	private function getProductName($id) {
		foreach ($this->product_list as $product) {
			$tenpoProductId = $product['tenpoProductId'];
			if ($id == $tenpoProductId) {
				return "<span>". $product['ProductName'] . "</span>\n";
			}
		}
		return "";
	}

	//製品名を取得
	private function getProductNameForMail($id) {
		foreach ($this->product_list as $product) {
			$tenpoProductId = $product['tenpoProductId'];
			if ($id == $tenpoProductId) {
				return $product['ProductName'];
			}
		}
		return "";
	}

	//会員情報変更
	public function edit() {
		if ($this->tenpoUserId == false) {
			//ログイン状態ではない
			$this->redirect('/login/index');
			exit;
		}
		$mode = $this->params['pass'][0];
		if ($mode == "input") {
			$this->edit_input();
		} else if ($mode == "confirm") {
			$this->edit_confirm();
		} else if ($mode == "complete") {
			$this->edit_complete();
		}
	}

	//会員情報変更入力
	private function edit_input() {
		$this->session_data = $this->readSession("account_edit");
		if ($this->session_data) {
			//セッションにデータがあれば、エラー画面を表示する
			extract($this->data['Account']);
			$this->BusinessType = $businesstype;
			$this->Country_Region = $country;
			$this->CountryOther = $othercountry;
			$this->edit_html();
			$this->render('edit_input');
			return;
		}
		$this->set_data('name_error', '');
		$this->set_data('name1_error', '');
		$this->set_data('name2_error', '');
		$this->set_data('email_error', '');
		$this->set_data('company_error', '');
		$this->set_data('businesstype_error', '');
		$this->set_data('otherbusinesstype_error', '');
		$this->set_data('country_error', '');
		$this->set_data('tel_error', '');
		$this->set_data('othercountry_error', '');
		if ($this->request->data['mode'] == "confirm") {
			//確認画面から戻った
			$this->edit_back();
			return;
		}

		$data = array();
		$data['name1'] = $this->FirstName;
		$data['name2'] = $this->LastName;
		$data['email'] = $this->Email;
		$data['company'] = $this->CompanyName;
		$data['businesstype'] = $this->BusinessType;
		$data['otherbusinesstype'] = $this->BusinessTypeOther;
		$data['position'] = $this->ProfessionalTitle;
		$data['tel'] = $this->PhoneNumber;
		$data['country'] = $this->Country_Region;
		$data['othercountry'] = $this->CountryOther;

		//各種HTMLの作成
		$this->edit_html();

		$request_data = array();
		$request_data['Account'] = $data;
		$this->request->data = $request_data;
		$this->Account->set($data);

		$this->render('edit_input');
	}

	//会員情報変更確認
	private function edit_confirm() {
		$this->Session->delete("account_edit");
		if ($this->request->data['confirm'] == false) {
			//URL直打ちされた
			$this->redirect('/account/edit/input');
			exit;
		}
		$this->set_data('password2_error', "");
		$this->Account->set($this->request->data);
		$this->Account->validator()->remove('password');

		if ($this->Account->validates()) {
			$this->set_data("account_data",$this->data['Account']);
			//$this->_check_validation();
			$check = $this->_check_input_data("edit");
			if ($check) {
				//入力画面に戻る
				$this->redirect_edit_input();
			} else {
				$this->render('edit_confirm');
			}
		} else {
			$this->_check_validation();
			$check = $this->_check_input_data("edit");
			//入力画面に戻る
			$this->redirect_edit_input();
		}
	}

	//入力画面にリダイレクトする
	private function redirect_edit_input() {
		$this->session_data['data'] = $this->data;
		$this->saveSession("account_edit");
		//このURLにしたい
		$this->redirect('/account/edit/input');
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

	//メールアドレスの有効性チェック
	//@return false=有効 true=無効(エラー)
	private function check_mail_effective($email) {
		$params = array();
		$params['Email'] = $email;
		$ret_data = $this->isEffectiveEmail($params);
		if ($ret_data == false) return true;
		if ($ret_data['Result'] == 1) {
			//有効である
			if ($ret_data['Effective'] == 1) {
				return false;
			}
		}
		return true;
	}

	//Select products
	private function _check_products($required) {
		$error = false;
		$products_value = "";
		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$product_checkbox = $this->make_product_checkbox();
		$this->set_data('product_checkbox', $product_checkbox);

		if (isset($this->request->data['product'])) {
			$this->set_data('products_error', "");
			$product_data= $this->request->data['product'];
			foreach($product_data as $key => $val) {
				if ($products_value) {
					$products_value .= ",";
				}
				$products_value .= $key;
			}
			if ($required == false) {
				$error = "check";
			}
		} else {
			if ($required) {
				$this->set_data('products_error', "Please select products");
				$error = "required";
			}
		}
		$this->set_data('products_value', $products_value);
		return $error;
	}

	//会員情報変更完了
	private function edit_complete() {
		if ($this->request->data['complete'] == false) {
			//URL直打ちされた
			$this->redirect('/account/edit/input');
			exit;
		}
		$this->_modify_member();
		$this->render('edit_complete');
	}

	//会員変更、確認画面＞戻る＞入力画面
	private function edit_back() {
		$request_data = array();
		$request_data['Account'] = $this->request->data;
		$this->request->data = $request_data;
		$this->Account->set($request_data);
		//各種HTMLの作成
		extract($this->request->data['Account']);
		$this->BusinessType = $businesstype;
		$this->Country_Region = $country;
		$this->CountryOther = $othercountry;

		$this->edit_html();
		$this->render('edit_input');
	}

	//問い合わせメールを送信する
	private function _send_mail($ContactId, $Products, $contacttype, $contactdetail, $UserId) {

		extract($this->request->data);

		//■会員登録
		//ユーザーにメール送信
		$command = "/usr/bin/php /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/Command/send_mail.php $email member_regist > /dev/null &";
		exec($command);
		$this->log("$command", "info");

		//管理者にメール送信
		$mail_country = $country;
		if ($mail_country == "Other") {
			$mail_country = $othercountry;
		}

		$company = escapeshellarg($company);
		$mail_country = escapeshellarg($mail_country);
		$command = "/usr/bin/php /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/Command/send_mail.php " . MAIL_TO . " member_regist_notification $UserId $company $mail_country > /dev/null &";
		system($command);
		$this->log("$command", "info");

		//入力がある場合のみメール送信する
		if ($contactdetail) {
			//■お問い合わせ
			//ユーザーにメール送信
			$command = "/usr/bin/php /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/Command/send_mail.php $email contact_us > /dev/null &";
			exec($command);
			$this->log("$command", "info");

			//問い合わせの内容をファイルに書き込む(メールの内容に記述する為)
			$text = "< Company >\n";
			$text .= $company;
			$text .= "\n\n";
			$text .= "< Country >\n";
			$mail_country = $country;
			if ($mail_country == "Other") {
				$mail_country = $othercountry;
			}
			$text .= $mail_country;

			$this->product_list = $this->getProducts();
			$text .= "\n\n";
			$text .= "< Selected product(s) >\n";
			foreach($Products as $id) {
				$product_name = $this->getProductNameForMail($id);
				$text .= $product_name;
				$text .= "\n";
			}
			$text .= "\n";
			$text .= "< Contact type >\n";
			$text .= $contacttype;
			$text .= "\n\n";
			$text .= "< Contact detail >\n";
			$text .= $contactdetail;
			$file_name = "/var/www/vhosts/nagase-personalcare.com/httpdocs/app/tmp/mail/" . $ContactId . ".txt";
			file_put_contents($file_name, $text);

			//管理者にメール送信
			$command = "/usr/bin/php /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/Command/send_mail.php " . MAIL_TO . " contact_us_notification $email $ContactId > /dev/null &";
			exec($command);
			$this->log("$command", "info");
		}

	}

	//SaleceForce登録
	private function _regist_member() {
		$datetime = date("Y-m-d H:i:s");
		extract($this->request->data);
		$UserInfo = array();
		$UserInfo['tenpoUserId'] = "0";
		$UserInfo['Email'] = $email;
		$UserInfo['Password'] = $password;
		$UserInfo['Salutation'] = "";
		$UserInfo['FirstName'] = $name1;
		$UserInfo['LastName'] = $name2;
		$UserInfo['BusinessType'] = $businesstype;
		$UserInfo['BusinessTypeOther'] = $otherbusinesstype;
		$UserInfo['CompanyName'] = $company;
		$UserInfo['EmployerWebsite'] = "";
		$UserInfo['Department'] = "";
		$UserInfo['ProfessionalTitle'] = $position;
		$UserInfo['PhoneNumber'] = $tel;
		$UserInfo['PhoneExt'] = "";
		$UserInfo['StreetAddress'] = "";
		$UserInfo['City'] = "";
		$UserInfo['State_Province'] = "";
		$UserInfo['PostalCode'] = "";
		$UserInfo['Country_Region'] = $country;
		$UserInfo['CountryOther'] = $othercountry;
		$UserInfo['ProspectorUserFlag'] = "";
		$UserInfo['Status'] = "";
		$UserInfo['ApprovalMail'] = "";
		$UserInfo['RegistDateTime'] = $datetime;
		$UserInfo['ModifyDateTime'] = $datetime;
		$Contact = array();
		$product_list = explode(",",$products_value);
		$Products = array();
		foreach($product_list as $product) {
			$Products[] = $product;
		}
		$Contact['tenpoProductId'] = $Products;
		$Contact['ContactType'] = $contacttype;
		$Contact['ContactDetail'] = $contactdetail;
		$Contact['RegistDateTime'] = $datetime;
		$Contact['ModifyDateTime'] = $datetime;
		$params = array();
		if ($contacttype) {
			$params['Processing'] = "2";  //2：会員情報、問い合わせ登録
		} else {
			$params['Processing'] = "1";  //2：会員登録のみ
		}
		$params['UserInfo'] = $UserInfo;
		$params['Contact'] = $Contact;
		$ret_data = $this->upsertUser($params);

		//会員登録メールを送信する
		$ContactId = $ret_data['tenpoContactId'];
		$UserId = $ret_data['tenpoUserId'];

		$this->_send_mail($ContactId, $Products, $contacttype, $contactdetail, $UserId);
	}

	//会員情報の変更
	private function _modify_member() {
		$datetime = date("Y-m-d H:i:s");
		extract($this->data);
		$UserInfo = array();
		$UserInfo['tenpoUserId'] = $this->tenpoUserId;
		$UserInfo['Email'] = $email;
		$UserInfo['Password'] = "";
		$UserInfo['Salutation'] = "";
		$UserInfo['FirstName'] = $name1;
		$UserInfo['LastName'] = $name2;
		$UserInfo['BusinessType'] = $businesstype;
		$UserInfo['BusinessTypeOther'] = $otherbusinesstype;
		$UserInfo['CompanyName'] = $company;
		$UserInfo['EmployerWebsite'] = "";
		$UserInfo['Department'] = "";
		$UserInfo['ProfessionalTitle'] = $position;
		$UserInfo['PhoneNumber'] = $tel;
		$UserInfo['PhoneExt'] = "";
		$UserInfo['StreetAddress'] = "";
		$UserInfo['City'] = "";
		$UserInfo['State_Province'] = "";
		$UserInfo['PostalCode'] = "";
		$UserInfo['Country_Region'] = $country;
		$UserInfo['CountryOther'] = $othercountry;
		$UserInfo['ProspectorUserFlag'] = "";
		$UserInfo['Status'] = "";
		$UserInfo['ApprovalMail'] = "";
		$UserInfo['RegistDateTime'] = "";
		$UserInfo['ModifyDateTime'] = $datetime;
		$Contact = array();
		$Contact['tenpoProductId'] = "";
		$Contact['ContactType'] = "";
		$Contact['ContactDetail'] = "";
		$Contact['RegistDateTime'] = "";
		$Contact['ModifyDateTime'] = "";
		$params = array();
		$params['Processing'] = "3";  //3：会員情報更新(パスワード以外)
		$params['UserInfo'] = $UserInfo;
		$params['Contact'] = $Contact;
		$ret_data = $this->upsertUser($params);
		if ($ret_data['Result'] == 1) {
			//ログイン、キャッシュ情報を書き換える
			$this->write_login_info($UserInfo);
		}
	}

	//ログイン、キャッシュ情報を書き換える
	private function write_login_info($UserInfo) {
		$user_array = array();
		$user_array['tenpoUserId'] = $UserInfo['tenpoUserId'];
		$user_array['FirstName'] = $UserInfo['FirstName'];
		$user_array['LastName'] = $UserInfo['LastName'];
		$user_array['Email'] = $UserInfo['Email'];
		$user_array['CompanyName'] = $UserInfo['CompanyName'];
		$user_array['BusinessType'] = $UserInfo['BusinessType'];
		$user_array['BusinessTypeOther'] = $UserInfo['BusinessTypeOther'];
		$user_array['ProfessionalTitle'] = $UserInfo['ProfessionalTitle'];
		$user_array['PhoneNumber'] = $UserInfo['PhoneNumber'];
		$user_array['Country_Region'] = $UserInfo['Country_Region'];
		$user_array['CountryOther'] = $UserInfo['CountryOther'];
		$session_id = $this->Session->read('id');
		//ユーザセッションの有効期限を最終アクセスから120分に設定する。
		$expire = date("Y/m/d H:i:s", strtotime(EXPIRE_LOGIN));
		$user_array['expire'] = $expire;
		$json_data = json_encode($user_array);
		Cache::write($session_id, $json_data);
	}

	//パスワード
	public function password() {
		if ($this->tenpoUserId == false) {
			//ログイン状態ではない
			$this->redirect('/login/index');
			exit;
		}
		$mode = $this->params['pass'][0];
		if ($mode == "input") {
			$this->password_input();
		} else if ($mode == "complete") {
			$this->password_complete();
		}
	}

	//パスワード変更入力画面
	private function password_input() {
		$this->session_data = $this->readSession("password");
		if ($this->session_data) {
			//セッションにデータがあれば、エラー画面を表示する
			$this->render('password_input');
			return;
		}
		$this->set_data('password_error', '');
		$this->set_data('password2_error', '');
		$this->render('password_input');
	}

	//パスワード変更完了画面
	private function password_complete() {
		if ($this->request->data['complete'] == false) {
			//URL直打ちされた
			$this->redirect('/account/password/input');
			exit;
		}
		$this->session_data['data'] = $this->data;
		$check = $this->_check_password_data();
		if ($check) {
			$this->saveSession("password");
			$this->redirect('/account/password/input');
		} else {
			$this->_password_salesforce();
			$this->render('password_complete');
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
			} else if (strlen($password2) > 30) {
				$this->set_data('password2_error', "Re-enter Password must be 30 characters or less.");
				$error = true;
			} else if (!preg_match("/^[a-zA-Z0-9!#$%_=+<>\-]+$/", $password2)) {
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
		$params['Email'] = $this->Email;
		$params['Password'] = $password;
		$params['ModifyDateTime'] = $datetime;
		$ret_data = $this->PasswordReset($params);
	}

	//ログアウト
	public function logout() {
		$this->Cookie->write('id', "");
		$this->redirect('/top/index');
	}

	//ビジネスタイプ、optionタグの作成
	private function make_bussness_type_option() {
		$option_list = array(
			'Manufacturer of Formulated Product',
			'Raw Material / Ingredient Supplier',
			'Toll / Contract Manufacturer',
			'Distributor / Broker',
			'Educational Facility',
			'Consulting / Services Company',
			'Research &amp; Development Company',
			'Flavor &amp; Fragrance Company',
		);

		$html = "";
		foreach ($option_list as $value) {
			$html .= "<option value='$value'";
			if ($this->BusinessType == $value) {
				$html .= " selected";
			}
			$html .= ">$value</option>";
		}
		$html .= "<option class='other' value='Other'";
		if ($this->BusinessType == "Other") {
			$html .= " selected";
		}
		$html .= ">Other</option>";
		return $html;
	}

	//国、optionタグの作成
	private function make_country_option() {
		$option_list = array(
			'Albania',
			'Andorra',
			'Argentina',
			'Australia',
			'Austria',
			'Belgium',
			'Brazil',
			'Bulgaria',
			'Canada',
			'China',
			'Colombia',
			'Croatia',
			'Cyprus',
			'Czech',
			'Denmark',
			'Egypt',
			'Finland',
			'France',
			'Germany',
			'Greece',
			'Hungary',
			'Iceland',
			'India',
			'Indonesia',
			'Ireland',
			'Israel',
			'Italy',
			'Japan',
			'Liechtenstein',
			'Lithuania',
			'Luxembourg',
			'Malaysia',
			'Malta',
			'Mexico',
			'Monaco',
			'Montenegro',
			'Myanmar',
			'Netherlands',
			'New Zealand',
			'Norway',
			'Pakistan',
			'Philippines',
			'Poland',
			'Portugal',
			'South Korea',
			'Romania',
			'Russia',
			'San Marino',
			'Singapore',
			'Slovakia',
			'Slovenia',
			'South Africa',
			'Spain',
			'Sri Lanka',
			'Sweden',
			'Switzerland',
			'Thailand',
			'Turkey',
			'Ukraine',
			'UAE',
			'United Kingdom',
			'United States',
			'Viet Nam',
			'Vatican',
			'Taiwan'
		);
		$html = "";
		foreach ($option_list as $value) {
			$html .= "<option value='$value'";
			if ($this->Country_Region == $value) {
				$html .= " selected";
			}
			$html .= ">$value</option>";
		}
		$html .= "<option class='other' value='Other'";
		if ($this->Country_Region == "Other") {
			$html .= " selected";
		}
		$html .= ">Other</option>";
		return $html;
	}

	//商品一覧から商品のチェックボックスを作る
	function make_product_checkbox() {
		$html = "";
		foreach ($this->product_list as $product) {
			$tenpoProductId = $product['tenpoProductId'];
			$ProductName = $product['ProductName'];
			$html .= "<label for='p${tenpoProductId}' class='checkbox inquiry'>";
			$html .= "<input type='checkbox' name='product[$tenpoProductId]' id='p${tenpoProductId}' class='checkbox'";
			$html .= $this->getChecked($tenpoProductId);
			$html .= ">";
			$html .= "<span>$ProductName</span>";
			$html .= "</label>";
			$html .= "\n";
		}
		return $html;
	}

	//チェックボックスにチェックを付けるか？
	private function getChecked($tenpoProductId) {
		if ($this->productid == $tenpoProductId) return " checked";
		if (isset($this->data['product'])) {
			$product_list = $this->data['product'];
			if ($product_list) {
				foreach ($product_list as $id => $val) {
					if ($id == $tenpoProductId) return " checked";
				}
			}
		}
		if (isset($this->data['Account']['products_value'])) {
			$product_list = explode(",", $this->data['Account']['products_value']);
			foreach ($product_list as $id) {
				if ($id == $tenpoProductId) return " checked";
			}
		}
		return "";
	}

	//データを変数とセッション保存用にセットする
	private function set_data($key, $data) {
		$this->set($key, $data);
		//データが多すぎるとセッションに保存されない
		if ($key == "bussness_type_option") return;
		if ($key == "country_option") return;
		$this->session_data[$key] = $data;
	}

	//セッションに保存する
	private function saveSession($key_cookie) {
		$this->Session->write($key_cookie, $this->session_data);
	}

	//セッションを読む
	private function readSession($key_cookie) {
		$data_list = $this->Session->read($key_cookie);
		if ($data_list == false) return false;
		foreach ($data_list as $key => $data) {
			$this->set($key, $data);
			if ($key == "data") {
				$this->data = $data;
			}
		}
		//読んだらセッションを削除する
		$this->Session->delete($key_cookie);
		return $data_list;
	}

}
