<?php
/**
 * トップページ
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class TopController extends AppController {

	//トップページ
	public function index() {
		$product_list = $this->getProducts();
		//ソートする
		$product_list = $this->sort_order($product_list);
		//画像の存在チェックをしてimg_srcを生成する
		$this->make_imgsrc($product_list);
		$this->set("product_list", $product_list);
		$this->set("keywordsearch", "");
		$this->select_category();
		$cat01_select = $this->cat01_select();
		$this->set("cat01_select", $cat01_select);
		$cat02_select = $this->cat02_select();
		$this->set("cat02_select", $cat02_select);
	}

}
