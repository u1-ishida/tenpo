<?php
/**
 * 商品ファイル同期指示API
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */

class ProductDocumentDownloadController extends AppController {

	public function index() {
		$this->log("ProductDocumentDownload start", "info");
		//ヘッダー情報をチェックする
		$check = $this->check_header();
		if ($check) {
			$this->error($check);
		}
		$body = file_get_contents('php://input');
		$data = json_decode($body, true);
		if ($data == NULL) {
			$this->error("illegal json characters");
		}
		if (isset($data['tenpoProductId']) == false) {
			$this->error("tenpoProductId not found");
		}
		if (isset($data['DocumentInfo']) == false) {
			$this->error("DocumentInfo not found");
		}
		$DocumentInfo = $data['DocumentInfo'];
		$c = 0;
		foreach($DocumentInfo as $bean) {
			$c++;
			if (isset($bean['FileId']) == false) {
				$this->error("FileId not found($c)");
			}
			if (isset($bean['FileName']) == false) {
				$this->error("FileName not found($c)");
			}
			if (isset($bean['LastModify']) == false) {
				$this->error("LastModify not found($c)");
			}
			$this->log($bean['FileId'], "debug");
			$this->document_download($data['tenpoProductId'], $bean);
		}
		$this->deleteFile($data['tenpoProductId'], $DocumentInfo);
		$data = array();
		$data['Result'] = "1";
		$data['Message'] = "synchronize success";
		$json_data = json_encode($data);
		echo $json_data;
		$this->log("ProductDocumentDownload normal end", "info");
		exit;
	}

	//エラーを返してログを出力する
	private function error($message) {
		$data = array();
		$data['Result'] = "2";
		$data['Message'] = $message;
		$json_data = json_encode($data);
		echo $json_data;
		$this->log("$message", "error");
		exit;
	}

	//ドキュメントをダウンロードする
	private function document_download($tenpoProductId, $DocumentInfo) {
		$params = array();
		$params['tenpoProductId'] = $tenpoProductId;
		$params['FileId'] = $DocumentInfo['FileId'];
		$data = $this->getProductFile($params);
		if ($data['Result'] != 1) {
			$this->error($data['Message']);
		}
		$file_data = $data['Message'];
		$file_data = base64_decode($file_data);
		extract($DocumentInfo);
		$ext = pathinfo($FileName, PATHINFO_EXTENSION);
		if ($ext == "jpg" || $ext == "png" || $ext == "gif") {
			$path = "product_img";
			$this->saveFile($file_data, $tenpoProductId, "/product_img/", "product_image.$ext", $DocumentInfo['LastModify']);
		} else {
			$path = "product_doc";
			$this->saveFile($file_data, $tenpoProductId, "/product_doc/", $FileName, $DocumentInfo['LastModify']);
		}
	}

	//ファイルを保存する
	private function saveFile($file_data, $tenpoProductId, $dir, $file_name, $LastModify) {

		if ($dir == "/product_doc/") {
			$file_path = PDF_FILESPATH . $tenpoProductId;
		} else {
			$file_path = FILESPATH . $dir . $tenpoProductId;
		}
		//ディレクトリがなければ作成する
		@mkdir($file_path, 0777);
		$file = $file_path . "/" .$file_name;
		//ファイルが存在するか
		if (file_exists($file)) {
			//存在する
			$file_time = filemtime($file);
			$date_time = date("Y/m/d H:i:s", $file_time);
			if ($date_time < $LastModify) {
				//LastModify の日時がWebサーバの更新日より未来
				file_put_contents($file, $file_data);
			}
		} else {
			//存在しない
			file_put_contents($file, $file_data);
		}

	}

	//Webサーバにのみ存在しているファイルは削除する
	private function deleteFile($tenpoProductId, $DocumentInfo) {
		$file_list = array();
		foreach($DocumentInfo as $bean) {
			$file_list[] = $bean['FileName'];
		}
		$file_path = PDF_FILESPATH . $tenpoProductId;
		if (file_exists($file_path) == false) return "";
		$d = dir($file_path);
		if ($d == false) return "";
		$document_list = array();
		while (false !== ($file = $d->read())) {
			if ($file == ".") continue;
			if ($file == "..") continue;
			//このファイルがSFに存在するか
			if ($this->exist_file($file, $file_list) == false) {
				//ないので削除する
				$file_name = $file_path . "/" . $file;
				unlink($file_name);
			}
		}
	}

	//このファイルがSFに存在するか
	private function exist_file($file, $file_list) {
		foreach($file_list as $file_name) {
			if ($file == $file_name) return true;
		}
		return false;
	}

}
