<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutGuest extends Controller {
	
	public function index() {
		
		$this->load->language('checkout/checkout');

		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_your_details'] = $this->language->get('text_your_details');
		$data['text_your_account'] = $this->language->get('text_your_account');
		$data['text_your_address'] = $this->language->get('text_your_address');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_shipping'] = $this->language->get('entry_shipping');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		$data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$data['customer_groups'][] = $customer_group;
				}
			}
		}

		if (isset($this->session->data['guest']['customer_group_id'])) {
			$data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		if (isset($this->session->data['guest']['firstname'])) {
			$data['firstname'] = $this->session->data['guest']['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->session->data['guest']['lastname'])) {
			$data['lastname'] = $this->session->data['guest']['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->session->data['guest']['email'])) {
			$data['email'] = $this->session->data['guest']['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->session->data['guest']['telephone'])) {
			$data['telephone'] = $this->session->data['guest']['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->session->data['guest']['fax'])) {
			$data['fax'] = $this->session->data['guest']['fax'];
		} else {
			$data['fax'] = '';
		}

		if (isset($this->session->data['payment_address']['company'])) {
			$data['company'] = $this->session->data['payment_address']['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->session->data['payment_address']['address_1'])) {
			$data['address_1'] = $this->session->data['payment_address']['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->session->data['payment_address']['address_2'])) {
			$data['address_2'] = $this->session->data['payment_address']['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->session->data['payment_address']['postcode'])) {
			$data['postcode'] = $this->session->data['payment_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->session->data['payment_address']['city'])) {
			$data['city'] = $this->session->data['payment_address']['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->session->data['payment_address']['country_id'])) {
			$data['country_id'] = $this->session->data['payment_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->session->data['payment_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['payment_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/zone');

		$data['zones'] = $this->model_localisation_zone->getZonesByCountryId($data['country_id']);

		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($data['customer_group_id']);

		if (isset($this->session->data['guest']['custom_field']['account'])) {
			$data['guest_custom_field'] = $this->session->data['guest']['custom_field']['account'];
		} else {
			$data['guest_custom_field'] = array();
		}

		if (isset($this->session->data['guest']['custom_field']['address'])) {
			$data['address_custom_field'] = $this->session->data['guest']['custom_field']['address'];
		} else {
			$data['address_custom_field'] = array();
		}

		$data['shipping_required'] = $this->cart->hasShipping();

		if (isset($this->session->data['guest']['shipping_address'])) {
			$data['shipping_address'] = $this->session->data['guest']['shipping_address'];
		} else {
			$data['shipping_address'] = true;
		}



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/guest.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/guest.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/guest.tpl', $data));
		}
	}

	public function save() {
		
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');
			}
		}

		if (!$json) {
			if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}

			if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
				$json['error']['lastname'] = $this->language->get('error_lastname');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$json['error']['email'] = $this->language->get('error_email');
			}

			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$json['error']['telephone'] = $this->language->get('error_telephone');
			}

			if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
				$json['error']['address_1'] = $this->language->get('error_address_1');
			}

			if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
				$json['error']['city'] = $this->language->get('error_city');
			}

			$this->load->model('localisation/country');

			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

			if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
				$json['error']['postcode'] = $this->language->get('error_postcode');
			}

			if ($this->request->post['country_id'] == '') {
				$json['error']['country'] = $this->language->get('error_country');
			}

			if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
				$json['error']['zone'] = $this->language->get('error_zone');
			}

			// Customer Group
			if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
				$customer_group_id = $this->request->post['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}

			// Custom field validation
			$this->load->model('account/custom_field');

			$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
					$json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
				}
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

				if ($captcha) {
					$json['error']['captcha'] = $captcha;
				}
			}
		}

		if (!$json) {
			// Логируем данные перед сохранением в сессию
			$log_file = DIR_LOGS . 'guest_data.log';
			$timestamp = date('Y-m-d H:i:s');
			$log_entry = "[{$timestamp}] GUEST_DATA_SAVE | POST_DATA: " . json_encode($this->request->post, JSON_UNESCAPED_UNICODE) . "\n";
			file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
			
			$this->session->data['account'] = 'guest';

			$this->session->data['guest']['customer_group_id'] = $customer_group_id;
			$this->session->data['guest']['firstname'] = $this->request->post['firstname'];
			$this->session->data['guest']['lastname'] = $this->request->post['lastname'];
			$this->session->data['guest']['email'] = $this->request->post['email'];
			$this->session->data['guest']['telephone'] = $this->request->post['telephone'];
			$this->session->data['guest']['fax'] = $this->request->post['fax'];

			if (isset($this->request->post['custom_field']['account'])) {
				$this->session->data['guest']['custom_field'] = $this->request->post['custom_field']['account'];
			} else {
				$this->session->data['guest']['custom_field'] = array();
			}

			$this->session->data['payment_address']['firstname'] = $this->request->post['firstname'];
			$this->session->data['payment_address']['lastname'] = $this->request->post['lastname'];
			$this->session->data['payment_address']['company'] = $this->request->post['company'];
			$this->session->data['payment_address']['address_1'] = $this->request->post['address_1'];
			$this->session->data['payment_address']['address_2'] = $this->request->post['address_2'];
			$this->session->data['payment_address']['postcode'] = $this->request->post['postcode'];
			$this->session->data['payment_address']['city'] = $this->request->post['city'];
			$this->session->data['guest']['shipping_address'] = $this->request->post['shipping_address'];
			$this->session->data['payment_address']['country_id'] = $this->request->post['country_id'];
			$this->session->data['payment_address']['zone_id'] = $this->request->post['zone_id'];

			$this->load->model('localisation/country');

			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

			if ($country_info) {
				$this->session->data['payment_address']['country'] = $country_info['name'];
				$this->session->data['payment_address']['iso_code_2'] = $country_info['iso_code_2'];
				$this->session->data['payment_address']['iso_code_3'] = $country_info['iso_code_3'];
				$this->session->data['payment_address']['address_format'] = $country_info['address_format'];
			} else {
				$this->session->data['payment_address']['country'] = '';
				$this->session->data['payment_address']['iso_code_2'] = '';
				$this->session->data['payment_address']['iso_code_3'] = '';
				$this->session->data['payment_address']['address_format'] = '';
			}

			$this->load->model('localisation/zone');

			$zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);

			if ($zone_info) {
				$this->session->data['payment_address']['zone'] = $zone_info['name'];
				$this->session->data['payment_address']['zone_code'] = $zone_info['code'];
			} else {
				$this->session->data['payment_address']['zone'] = '';
				$this->session->data['payment_address']['zone_code'] = '';
			}

			if (isset($this->request->post['custom_field']['address'])) {
				$this->session->data['guest']['custom_field'] = $this->request->post['custom_field']['address'];
			} else {
				$this->session->data['guest']['custom_field'] = array();
			}

			$this->session->data['shipping_address']['firstname'] = $this->request->post['firstname'];
			$this->session->data['shipping_address']['lastname'] = $this->request->post['lastname'];
			$this->session->data['shipping_address']['company'] = $this->request->post['company'];
			$this->session->data['shipping_address']['address_1'] = $this->request->post['address_1'];
			$this->session->data['shipping_address']['address_2'] = $this->request->post['address_2'];
			$this->session->data['shipping_address']['postcode'] = $this->request->post['postcode'];
			$this->session->data['shipping_address']['city'] = $this->request->post['city'];
			$this->session->data['shipping_address']['country_id'] = $this->request->post['country_id'];
			$this->session->data['shipping_address']['zone_id'] = $this->request->post['zone_id'];

			if ($country_info) {
				$this->session->data['shipping_address']['country'] = $country_info['name'];
				$this->session->data['shipping_address']['iso_code_2'] = $country_info['iso_code_2'];
				$this->session->data['shipping_address']['iso_code_3'] = $country_info['iso_code_3'];
				$this->session->data['shipping_address']['address_format'] = $country_info['address_format'];
			} else {
				$this->session->data['shipping_address']['country'] = '';
				$this->session->data['shipping_address']['iso_code_2'] = '';
				$this->session->data['shipping_address']['iso_code_3'] = '';
				$this->session->data['shipping_address']['address_format'] = '';
			}

			if ($zone_info) {
				$this->session->data['shipping_address']['zone'] = $zone_info['name'];
				$this->session->data['shipping_address']['zone_code'] = $zone_info['code'];
			} else {
				$this->session->data['shipping_address']['zone'] = '';
				$this->session->data['shipping_address']['zone_code'] = '';
			}

		}

		// Логируем данные после сохранения в сессию
		$log_file = DIR_LOGS . 'guest_data.log';
		$timestamp = date('Y-m-d H:i:s');
		$log_entry = "[{$timestamp}] GUEST_SESSION_SAVED | SESSION_DATA: " . json_encode(array(
			'guest' => $this->session->data['guest'],
			'payment_address' => $this->session->data['payment_address'],
			'shipping_address' => $this->session->data['shipping_address']
		), JSON_UNESCAPED_UNICODE) . "\n";
		file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
