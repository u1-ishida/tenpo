<?php
/**
 * 承認メール送信API
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class ApprovalMailSendController extends AppController {

	public function index() {
		$this->log("ApprovalMailSend start", "info");
		//ヘッダー情報をチェックする
		$check = $this->check_header();
		if ($check) {
			$this->error($check);
		}
		$body = file_get_contents('php://input');
		$data = json_decode($body);
		if ($data == NULL) {
			$this->error("illegal json characters");
		}
		if (isset($data->Email) == false) {
			$this->error("Email not found");
		}
		if (isset($data->tenpoUserId) == false) {
			$this->error("tenpoUserId not found");
		}	
		if (isset($data->Type) == false) {
			$this->error("Type not found");
		}
		if ($data->Type != 1 && $data->Type != 2) {
			$this->error("Type is 1 or 2");
		}

		//メール送信
		if ($data->Type == 1) {
			//承認メール
			$title = file_get_contents(MAILPATH . "member_approve_title.txt");
			$body = file_get_contents(MAILPATH . "member_approve.txt");
			$ret = $this->send_mail($data->Email, $title, $body);
		} else {
			//非承認メール
			$title = file_get_contents(MAILPATH . "member_refuse_title.txt");
			$body = file_get_contents(MAILPATH . "member_refuse.txt");
			$ret = $this->send_mail($data->Email, $title, $body);
		}

		$data = array();
		if ($ret) {
			$data['Result'] = "1";
			$data['Message'] = "Send Mail";
		} else {
			$data['Result'] = "2";
			$data['Message'] = "Failed Send Mail";
		}
		$json_data = json_encode($data);
		echo $json_data;
		$this->log("ApprovalMailSend normal end", "info");
		exit;
	}

	//エラー
	private function error($message) {
		$data = array();
		$data['Result'] = "2";
		$data['Message'] = $message;
		$json_data = json_encode($data);
		echo $json_data;
		$this->log("$message", "error");
		exit;
	}

}
