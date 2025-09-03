<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonWishList extends Controller {
	public function index() {

        if (isset($_GET['_route_']) && $_GET['_route_'] == 'wishlists/')
            return '';

		$this->load->language('common/wishlist');

		$data = array();

		$data['logged'] = $this->customer->isLogged();

        //$this->load->language('account/wishlist');

        $this->load->model('account/wishlist');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $data['text_title'] = $this->language->get('text_title');
        $data['text_total_wishlist'] = $this->language->get('text_total_wishlist');
        $data['text_go_list_wish'] = $this->language->get('text_go_list_wish');
        $data['text_add_to_cart'] = $this->language->get('text_add_to_cart');
        $data['text_empty_wishlist'] = $this->language->get('text_empty_wishlist');
        $data['text_add_products_wishlist'] = $this->language->get('text_add_products_wishlist');
        $data['text_is_yes_wishlist'] = $this->language->get('text_is_yes_wishlist');
        $data['text_login'] = $this->language->get('text_login');
        $data['text_add_products_wishlist_min'] = $this->language->get('text_add_products_wishlist_min');
        $data['text_katalog'] = $this->language->get('text_katalog');


        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_empty'] = $this->language->get('text_empty');

        $data['column_image'] = $this->language->get('column_image');
        $data['column_name'] = $this->language->get('column_name');
        $data['column_model'] = $this->language->get('column_model');
        $data['column_stock'] = $this->language->get('column_stock');
        $data['column_price'] = $this->language->get('column_price');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['products'] = array();

        $limit = 36;
        $results = $this->model_account_wishlist->getWishlist(0, $limit);
        //$product_total = $this->model_account_wishlist->getTotalWishlist();

        if (empty($this->customer->getId()) && isset($this->session->data['wishlist']) && !empty($this->session->data['wishlist'])) {
            $results = array();
            $wishlist = $this->session->data['wishlist'];
            foreach($wishlist as $wish) {
                $results[] = array('product_id' => $wish);
            }
        }

        foreach ($results as $result) {
            $product_info = $this->model_catalog_product->getProduct($result['product_id']);

            if ($product_info) {
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], 80, 80);
                } else {
                    $image = false;
                }

                if ($product_info['quantity'] <= 0) {
                    $stock = $product_info['stock_status'];
                } elseif ($this->config->get('config_stock_display')) {
                    $stock = $product_info['quantity'];
                } else {
                    $stock = $this->language->get('text_instock');
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                $data['products'][$result['product_id']] = array(
                    'product_id' => $product_info['product_id'],
                    'thumb'      => $image,
                    'name'       => $product_info['name'],
                    'model'      => $product_info['model'],
                    'stock'      => $stock,
                    'price'      => $price,
                    'special'    => $special,
                    'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                    'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']),

                    'new'         => $product_info['new'],
                    'sale'        => $product_info['sale'],
                    'sku'         => $product_info['sku'],
                    'minimum'     => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
                );
            } else {
                $this->model_account_wishlist->deleteWishlist($result['product_id']);
            }
        }

        // if ($data['products'])
        //    $data['products'] = $this->load->controller('module/custmer_group_by_summ/getPrices', $data['products']);


        $data['continue'] = $this->url->link('account/account', '', 'SSL');
        $data['add_cart_products'] = $this->url->link('account/wishlist/add_cart', '', 'SSL');

        $data['total'] = isset($data['products']) ? $this->getTotal($data['products']) : 0;
        $data['total'] = $this->currency->format($data['total']);
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/wishlist.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/wishlist.tpl', $data);
		} else {
			return $this->load->view('default/template/common/wishlist.tpl', $data);
		}
	}

	private function getTotal($products) {
        $total = 0;

        if (!empty($products))
            foreach($products as $p)
                $total += ((int)$p['special'] > 0) ? (int)$p['special'] : (int)$p['price'];

	    return $total;
    }

    public function info() {
        exit( json_encode( array( 'ok' => true, 'html' => $this->index() ) ) );
    }
}
