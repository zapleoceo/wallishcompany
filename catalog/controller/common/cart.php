<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonCart extends Controller {
	public function index() {

        if (isset($_GET['_route_']) && $_GET['_route_'] == 'cart/')
            return '';

		$this->load->language('common/cart');

		// Totals
		$this->load->model('extension/extension');

		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			$sort_order = array();
			
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $total_data);
			
			$total_data = $this->load->controller('module/custmer_group_by_summ/productsAddSale', $total_data);
		}

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_remove'] = $this->language->get('button_remove');
        $data['column_name'] = $this->language->get('column_name');

        $data['column_quantity'] = $this->language->get('column_quantity');
        $data['column_total'] = $this->language->get('column_total');
        $data['column_price'] = $this->language->get('column_price');

        $data['button_update'] = $this->language->get('button_update');
        $data['button_remove'] = $this->language->get('button_remove');
        $data['button_shopping'] = $this->language->get('button_shopping');
        $data['button_checkout'] = $this->language->get('button_checkout');

        $data['text_steps_more'] = $this->language->get('text_steps_more');
        $data['text_continue_bay'] = $this->language->get('text_continue_bay');

        $data['topmenu'] = $this->load->controller('checkout/cart/getmenu', 'cart');

        $data['link_step_2'] = $this->url->link('checkout/cart', '', true);

        $data['link_catalog'] = rtrim( $this->url->link('product/category', '' . '&category_id=' . 69) ).'/';


        $this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], 120, 120);
			} else {
				$image = '';
			}

			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}

			$data['products'][] = array(
			    'product_id' => $product['product_id'],
				'cart_id'   => $product['cart_id'],
				'thumb'     => $image,
				'minimum' => $product['minimum'],
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
				'quantity'  => $product['quantity'],
				'price'     => $price,
				'total'     => $total,
				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}

		// Gift Voucher
		$data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}

		$data['totals'] = array();

		foreach ($total_data as $result) {
			$data['totals'][] = array(
				'title' => $result['title'],
                'percent' => isset($result['percent']) ? $result['percent'] : 0,
                'code' => $result['code'],
				'text'  => $this->currency->format($result['value']),
			);
		}

        $data['action'] = $this->url->link('checkout/cart/edit', '', true);

        // min order
        $minOrder = (int)$this->config->get('config_fax');
		$total = $this->getTotal();
        $data['disable_order'] = ($total < $minOrder) ? true : false;
        $data['min_order_str'] = str_replace('.00', '', $this->currency->format($minOrder));
        $data['min_order_str_adding'] = str_replace('.00', '', $this->currency->format($minOrder - $total));

        $data['text_min_summ_order'] = $this->language->get('text_min_summ_order');
        $data['text_adding'] = $this->language->get('text_adding');
        $data['text_to_order'] = $this->language->get('text_to_order');
        // @end min order

        $data['text_gocatalog'] = $this->language->get('text_gocatalog');
        $data['text_zapolni_ee'] = $this->language->get('text_zapolni_ee');
        $data['text_pustaya_korzina'] = $this->language->get('text_pustaya_korzina');
        $data['text_oformit_zakaz'] = $this->language->get('text_oformit_zakaz');
        $data['text_continue_buy'] = $this->language->get('text_continue_buy');
        $data['text_backet_title'] = $this->language->get('text_backet_title');

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['catalog_link'] = rtrim( $this->url->link('product/category', '' . '&category_id=' . 69) ).'/';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/cart.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/cart.tpl', $data);
		} else {
			return $this->load->view('default/template/common/cart.tpl', $data);
		}
	}

	public function info() {
        $total = $this->getTotal();
        $total_str = $this->currency->format($total);
        $total_str = str_replace('.00', '', $total_str);

        $json = array(
            'ok' => true,
            'total' => array($total, $total_str),
            'html' => $this->index()
        );

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
	}

    protected function getTotal(){
        // Totals
        $this->load->model('extension/extension');

        $total_data = array();
        $total = 0;
        $taxes = $this->cart->getTaxes();

        // Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}

			$sort_order = array();
			
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $total_data);
			
			$total_data = $this->load->controller('module/custmer_group_by_summ/productsAddSale', $total_data);
		}

		if (count($total_data)) {
			foreach ($total_data as $value) {
				if ($value['code'] == 'sub_total') {
					$total = $value['value'];
				}
			}
		}

        return (int)$total;
    }
}
