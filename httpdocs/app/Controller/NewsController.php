<?php
/**
 * News
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class NewsController extends AppController {

	public function index() {
	}

	//ニュース詳細ページ
	public function newsid() {
		$newsid = $this->params['pass'][0];
		$this->render($newsid);
	}

}
