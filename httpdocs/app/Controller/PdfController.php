<?php
/**
 * PDFダウンロード
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class PdfController extends AppController {

	public function productid() {
		if ($this->tenpoUserId == false) {
			//ログインしていないとダウンロードできない
			$this->render('/Errors/error400');
			return;
		}
		$productid = $this->params['pass'][0];
		$filename = $this->params['pass'][1];

		$file = PDF_FILESPATH;
		$file .= $productid;
		$file .= "/";
		$file .= $filename;
		if (file_exists($file) == false) {
			//echo $file;
			exit;
		}

		header("Content-Type: application/pdf");
		readfile($file);
		exit;
	}

}
