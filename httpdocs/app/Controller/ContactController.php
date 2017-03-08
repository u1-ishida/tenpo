<?php
/**
 * お問い合わせ
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class ContactController extends AppController {

	var $product_list;
	var $productid;
	var $session_data = array();

	//入力画面
	public function input() {
		$this->productid = "";
		if (isset($this->params['pass'][0])) {
			$this->productid = $this->params['pass'][0];
		}
		if ($this->tenpoUserId == false) {
			$this->set("login_error", "");
			$this->set("back", "/contact/input");
			$this->render('/Login/index');
			return;
			//ログイン状態ではない
			$url = '/login/index?back=/contact/input';
			$url .= "&productid=" . $this->productid;
			$this->redirect($url);
			exit;
		}
		$this->session_data = $this->readSession();
		if ($this->session_data) {
			//セッションにデータがあれば、エラー画面を表示する
			return;
		}
		$this->set_data('products_error', "");
		$this->set_data('contacttype_error', "");
		$this->set_data('contactdetail_error', "");
		$this->set_data('contacttype_style', "");
		if (isset($this->request->data['mode'])) {
			if ($this->request->data['mode'] == "confirm") {
				//確認画面から戻った
				$this->input_back();
				return;
			}
		}
		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$product_checkbox = $this->make_product_checkbox();
		$this->set_data('product_checkbox', $product_checkbox);
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
		if (isset($this->data['Contact']['products_value'])) {
			$product_list = explode(",", $this->data['Contact']['products_value']);
			foreach ($product_list as $id) {
				if ($id == $tenpoProductId) return " checked";
			}
		}
		return "";
	}

	//確認画面
	public function confirm() {
		if ($this->tenpoUserId == false) {
			//ログイン状態ではない
			$this->redirect('/login/index');
			exit;
		}
		if ($this->request->data['confirm'] == false) {
			//URL直打ちされた
			$this->redirect('/contact/input');
			exit;
		}
		$this->set_data("contact_data",$this->data['Contact']);
		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$check = $this->_check_input_data();
		if ($check) {
			$product_checkbox = $this->make_product_checkbox();
			$this->set_data('product_checkbox', $product_checkbox);
			//このURLにしたい
			$this->session_data['data'] = $this->data;
			$this->saveSession();
			$this->redirect('/contact/input');
		} else {
			$this->_confirm_product();
			$this->render('confirm');
		}
	}

	//入力値をチェックする
	private function _check_input_data() {
		$error = false;
		$contact_data = $this->data['Contact'];
		extract($contact_data);
		//Contact Type
		if ($contacttype) {
			$this->set_data('contacttype', $contacttype);
			$this->set_data('contacttype_error', "");
			$this->set_data('contacttype_style', "1");
		} else {
			$this->set_data('contacttype_error', "Please select contact type.");
			$this->set_data('contacttype_style', "");
			$error = true;
		}
		if ($contactdetail == false) {
			$this->set_data('contactdetail_error', "Please enter contact detail.");
			$error = true;
		} else if (mb_strlen($contactdetail) > 10000 ) {
			$this->set_data('contactdetail_error', "Contact detail must be 10000 characters or less.");
			$error = true;
		} else {
			$this->set_data('contactdetail', $contactdetail);
			$this->set_data('contactdetail_error', "");
		}
		$check = $this->_check_products();
		if ($check) {
			$error = true;
		}
		return $error;
	}

	//Select products
	private function _check_products() {
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
		} else {
			$this->set_data('products_error', "Please select products.");
			$error = true;
		}
		$this->set_data('products_value', $products_value);
		return $error;
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

	//完了画面
	public function complete() {
		if ($this->tenpoUserId == false) {
			//ログイン状態ではない
			$this->redirect('/login/index');
			exit;
		}
		if ($this->request->data['complete'] == false && $this->request->data['back'] == false) {
			//URL直打ちされた
			$this->redirect('/contact/input');
			exit;
		}
		if ($this->request->data['back']) {
			//戻る
			$this->input_back();
			return;
		}
		$datetime = date("Y-m-d H:i:s");
		extract($this->request->data);
		$params = array();
		$params['tenpoUserId'] = $this->tenpoUserId;
		$product_list = explode(",",$products_value);
		$Products = array();
		foreach($product_list as $product) {
			$Products[] = $product;
		}
		$params['Processing'] = "1";
		$params['tenpoProductId'] = $Products;
		$params['ContactType'] = $contacttype;
		$params['ContactDetail'] = $contactdetail;
		$params['RegistDateTime'] = $datetime;
		$params['ModifyDateTime'] = $datetime;
		$ret_data = $this->upsertContact($params);
		$ContactId = $ret_data['tenpoContactId'];

		//問い合わせメールを送信する
		$this->_send_mail($ContactId, $Products, $contacttype, $contactdetail);
	}

	//問い合わせ、確認画面＞戻る＞入力画面
	private function input_back() {
		$request_data = array();
		$request_data['Contact'] = $this->request->data;
		$this->request->data = $request_data;
		$this->Contact->set($request_data);

		$product_list = $this->getProducts();
		$this->product_list = $this->sort_order($product_list);
		$product_checkbox = $this->make_product_checkbox();
		$this->set_data('product_checkbox', $product_checkbox);
		$this->set_data('contacttype_style', "1");
		$this->render('input');
	}

	//問い合わせメールを送信する
	private function _send_mail($ContactId, $Products, $contacttype, $contactdetail) {

		//ユーザーにメール送信
		$email = $this->Email;
		$command = "/usr/bin/php /var/www/vhosts/nagase-personalcare.com/httpdocs/app/Console/Command/send_mail.php $email contact_us > /dev/null &";
		exec($command);
		$this->log("$command", "info");

		//問い合わせの内容をファイルに書き込む(メールの内容に記述する為)
		$text = "< Company >\n";
		$text .= $this->CompanyName;
		$text .= "\n\n";
		$text .= "< Country >\n";
		$Country = $this->Country_Region;
		if ($Country == "Other") {
			$Country = $this->CountryOther;
		}
		$text .= $Country;
		$this->product_list = $this->getProducts();
		$text .= "\n\n";
		$text  .= "< Selected product(s) >\n";
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

	//データを変数とセッション保存用にセットする
	private function set_data($key, $data) {
		$this->set($key, $data);
		$this->session_data[$key] = $data;
	}

	//セッションに保存する
	private function saveSession() {
		$this->Session->write('contact_data', $this->session_data);
	}

	//セッションを読む
	private function readSession() {
		$data_list = $this->Session->read('contact_data');
		if ($data_list == false) return false;
		foreach ($data_list as $key => $data) {
			$this->set($key, $data);
			if ($key == "data") {
				$this->data = $data;
			}
		}
		//読んだらセッションを削除する
		$this->Session->write('contact_data', "");
		return $data_list;
	}

}
