<?php
/**
 * 商品一覧
 *
 * @since 2016-12-15
 * @author y-oishi@netyear.net
 */
class ProductController extends AppController {

	//商品一覧ページ
	public function index() {
		$product_list = $this->getProducts();
		//ソートする
		$product_list = $this->sort_order($product_list);
		//画像の存在チェックをしてimg_srcを生成する
		$this->make_imgsrc($product_list);
		$this->set("product_list", $product_list);
		$this->set("keywordsearch", "");
		$this->set("change_tab", "");
		$this->select_category();
		$cat01_select = $this->cat01_select();
		$this->set("cat01_select", $cat01_select);
		$cat02_select = $this->cat02_select();
		$this->set("cat02_select", $cat02_select);
	}

	//キャッシュをクリアする
	public function cache_clear() {
		Cache::write("products", "");
		echo "cache_clear";
		exit;
	}

	//検索結果
	public function find() {
		$this->set("change_tab", "");
		$cat01 = "";
		$data = $this->request->data;
		extract($data);
		$product_list = $this->getProducts();
		//画像の存在チェックをしてimg_srcを生成する
		$this->make_imgsrc($product_list);
		if ($keywordsearchbtn == "Search") {
			$product_list = $this->_find_keyword($product_list, $keywordsearch);
		} else if ($categorysearchbtn == "Search") {
			$product_list = $this->_find_category($product_list, $cat01, $cat02);
			$this->set("change_tab", "<script>$(document).ready( function(){ChangeTab('selection');});</script>");
		}
		$this->set("product_list", $product_list);
		$this->set("keywordsearch", $keywordsearch);
		$this->select_category();
		$cat01_select = $this->cat01_select($cat01);
		$this->set("cat01_select", $cat01_select);
		$cat02_select = $this->cat02_select($cat01, $cat02);
		$this->set("cat02_select", $cat02_select);
		$this->render('index');
	}

	//キーワードで検索する
	private function _find_keyword($product_list, $keywordsearch) {
		$find_list = array();
		if ($keywordsearch == false) {
			return $find_list;
		}
		foreach($product_list as $product) {
			$keywordsearch = mb_convert_kana($keywordsearch, 's');
			$keyword_list = preg_split('/[\s]+/', $keywordsearch, -1, PREG_SPLIT_NO_EMPTY);
			foreach ($keyword_list as $keyword) {
				$finded = $this->_search_keyword($product, $keyword);
				if ($finded == false) {
					break;
				}
			}
			if ($finded) {
				$find_list[] = $product;
			}
		}
		return $find_list;
	}

	//商品詳細にキーワードがあるか？
	//@return true=見つかった false=見つからなかった
	private function _search_keyword($product, $keywordsearch) {
		if (stripos($product['ProductName'], $keywordsearch) !== false) return true;
		if (stripos($product['INCIName'], $keywordsearch) !== false) return true;
		if (stripos($product['ProductDescription'], $keywordsearch) !== false) return true;
		if ($this->_search_keyword_array($product['Function'], $keywordsearch)) return true;
		if ($this->_search_keyword_array($product['Application'], $keywordsearch)) return true;
		if ($this->_search_keyword_array($product['Benefit'], $keywordsearch)) return true;
		if ($this->_search_keyword_array($product['Ceretification'], $keywordsearch)) return true;
		return false;
	}

	//商品詳細にキーワードがあるか？
	//@return true=見つかった false=見つからなかった
	private function _search_keyword_array($product_array, $keywordsearch) {
		foreach ($product_array as $value) {
			if (stripos($value, $keywordsearch) !== false) return true;
		}
		return false;
	}

	//カテゴリーで検索する
	private function _find_category($product_list, $cat01, $cat02) {
		$find_list = array();
		if ($cat01 == false || $cat02 == false) {
			return $find_list;
		}
		foreach($product_list as $product) {
			$finded = $this->_search_category($product, $cat01, $cat02);
			if ($finded) {
				$find_list[] = $product;
			}
		}
		return $find_list;
	}

	//商品詳細にそのカテゴリーがあるか？
	//@return true=見つかった false=見つからなかった
	private function _search_category($product, $cat01, $cat02) {
		$data_list = array();
		if ($cat01 == "function") {
			if (isset($product['Function'])) {
				$data_list = $product['Function'];
			}
		} else if ($cat01 == "benefit") {
			if (isset($product['Benefit'])) {
				$data_list = $product['Benefit'];
			}
		} else if ($cat01 == "application") {
			if (isset($product['Application'])) {
				$data_list = $product['Application'];
			}
		}
		foreach($data_list as $data) {
			if ($data == $cat02) return true;
		}
		return false;
	}

	//商品詳細ページ
	public function productid() {
		$productid = $this->params['pass'][0];
		if ($productid == "search") {
			//検索
			$this->find();
			return;
		} else if ($productid == "cache_clear") {
			$this->cache_clear();
		}
		$product_list = $this->getProducts();
		//画像の存在チェックをしてimg_srcを生成する
		$this->make_imgsrc($product_list);
		//ソートする
		$product_list = $this->sort_order($product_list);
		$this->set("product_list", $product_list);
		$product = $this->_getProduct($product_list, $productid);
		if ($product == false) {
			$this->redirect('/product/');
			return;
		}
		//強調文字
		$product = $this->emphasize($product);
		//INCI Name<span>編集
		$product = $this->span($product);
		//AvailableListOfCosmeticStudies
		$this->studies($product);
		//ドキュメント
		$this->documents($product);
		$this->set("product", $product);
		$this->set("keywordsearch", "");
		$this->select_category();
		$cat01_select = $this->cat01_select();
		$this->set("cat01_select", $cat01_select);
		$cat02_select = $this->cat02_select();
		$this->set("cat02_select", $cat02_select);
		$back_url = $_SERVER['REQUEST_URI'];
		$this->set("back_url", $back_url);
	}

	//ドキュメント
	private function documents($product) {
		$tenpoProductId = $product['tenpoProductId'];
		$file_path = PDF_FILESPATH . $tenpoProductId;
		if (file_exists($file_path) == false) return "";
		$d = dir($file_path);
		if ($d == false) return "";
		$document_list = array();
		while (false !== ($file = $d->read())) {
			if ($file == ".") continue;
			if ($file == "..") continue;
			$bean = array();
			$bean['file_name'] = $file;
			//$bean['url'] = DOCUMENT_URL . $tenpoProductId . "/" . $file;
			$bean['url'] = "/pdf/" . $tenpoProductId . "/" . $file;
			$document_list[$file] = $bean;
		}
		ksort($document_list);
		$this->set("document_list", $document_list);
	}

	//AvailableListOfCosmeticStudies
	private function studies($product) {
		$studies = $product['AvailableListOfCosmeticStudies'];
		$studies_list = explode("\n", $studies);
		$this->set("studies_list", $studies_list);
	}

	//強調する
	private function emphasize($product) {
		$emphasize_list = $product['ProductDescriptionEmphasisWord'];
		$ProductDescription = $product['ProductDescription'];
		foreach($emphasize_list as $bean) {
			$change_text = "<strong>$bean</strong>";
			$ProductDescription = str_replace($bean, $change_text, $ProductDescription);
		}
		$product['ProductDescription'] = $ProductDescription;
		return $product;
	}

	//<span></span>編集する
	private function span($product) {
		$INCIName = $product['INCIName'];
		$data_list = explode(",", $INCIName);
		$INCIName = "";
		foreach($data_list as $data) {
			$INCIName .= "<span>" . trim($data) . "</span>";
		}
		$product['INCIName'] = $INCIName;
		return $product;
	}

	//商品全体からこの商品を取得する
	private function _getProduct($product_list, $productid) {
		foreach($product_list as $product) {
			if ($product['tenpoProductId'] == $productid) {
				return $product;
			}
		}
		return "";
	}

}
