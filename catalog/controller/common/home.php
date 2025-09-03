<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}
        $this->load->language('common/home');

        $data['text_view_other_big']  = $this->language->get('text_view_other_big');
        $data['text_go_catalog_big']  = $this->language->get('text_go_catalog_big');
        $data['text_view_other']  = $this->language->get('text_view_other');
        $data['text_view_product_category']  = $this->language->get('text_view_product_category');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

        $data['text_2'] = $this->load->controller('blog/article/get', array('article_id' => 129));

        // $data['text_2']['image_min'] = $this->model_tool_image->resize($data['text_2']['image'], 130, 130);
        $data['text_2']['image'] = $this->model_tool_image->resize($data['text_2']['image'], 1470, 150);

        $data['text_3'] = $this->load->controller('blog/article/get', array('article_id' => 131));

        $data['language_code']        = $this->language->get( 'code' );

        $data['banner_second'] = $this->load->controller( 'module/banner/get', array( 'banner_id' => 10 ) );
        $data['banner_second_en'] = $this->load->controller( 'module/banner/get', array( 'banner_id' => 11 ) );
        $data['banner_second_uk'] = $this->load->controller( 'module/banner/get', array( 'banner_id' => 13 ) );

        // begin: get child category
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $category_children = $this->model_catalog_category->getCategories(59);

        foreach ($category_children as $category) {
            $filter_data = array(
                'filter_category_id'  => $category['category_id'],
            );

            $data['category_children'][] = array(
                'category_id' => $category['category_id'],
                'name' => $category['name'] . ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')',
                'thumb' => !empty($category['image']) ? $this->model_tool_image->resize($category['image'], 300, 300) : '',//$this->model_tool_image->resize('placeholder.png', 300, 300)
                'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }
        // end: get child category


        $data['text_3']['url'] = rtrim( $this->url->link('product/category', '' . '&category_id=' . 69) ).'/';

        $data['text_4'] = $this->load->controller('blog/article/get', array('article_id' => 127));
        $data['text_4']['image'] = $this->model_tool_image->resize($data['text_4']['image'], 540, 554);


       	$data['text_5'] = $this->load->controller('blog/article/get', array('article_id' => 130));
        $data['text_6'] = $this->load->controller('blog/article/get', array('article_id' => 128));

        $data['text_7'] = $this->load->controller('blog/article/get', array('article_id' => 132));

        $data['newsroom'] = $this->load->controller('blog/article/getcategory', array('category_id' => 73, 'limit' => 5));

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}