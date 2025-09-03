<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutPaymentAddress extends Controller {
    private $uk_country_id = 192;
    private $samoviv_adress_id = 0;

	public function index() {
		$this->load->language('checkout/checkout');

		$data['text_address_existing'] = $this->language->get('text_address_existing');
		$data['text_address_new'] = $this->language->get('text_address_new');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
        $data['entry_edit'] = $this->language->get('entry_edit');



        $data['entry_comment_order'] = $this->language->get('entry_comment_order');
        $data['text_get_order_address'] = $this->language->get('text_get_order_address');
        $data['entry_send_name_company'] = $this->language->get('entry_send_name_company');
        $data['entry_address_title'] = $this->language->get('entry_address_title');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_address_default'] = $this->language->get('entry_address_default');
        $data['entry_save'] = $this->language->get('entry_save');
        $data['entry_address_add_new'] = $this->language->get('entry_address_add_new');
        $data['entry_information'] = $this->language->get('entry_information');
        $data['entry_zipcode'] = $this->language->get('entry_zipcode');
        $data['entry_region'] = $this->language->get('entry_region');
        $data['entry_delivery_kiev_free'] = $this->language->get('entry_delivery_kiev_free');
        $data['entry_delivery_np_free'] = $this->language->get('entry_delivery_np_free');
        $data['entry_zone_option'] = $this->language->get('entry_zone_option');
        $data['entry_city_option'] = $this->language->get('entry_city_option');
        $data['entry_np_option_default'] = $this->language->get('entry_np_option_default');
        $data['entry_np_num'] = $this->language->get('entry_np_num');
        $data['entry_next'] = $this->language->get('entry_next');

        $data['text_delivery_ukraine'] = $this->language->get('text_delivery_ukraine');
        $data['text_delivery_other_internacional'] = $this->language->get('text_delivery_other_internacional');
        $data['text_delivery_to_np'] = $this->language->get('text_delivery_to_np');
        $data['text_delivery_to_kiev'] = $this->language->get('text_delivery_to_kiev');
        $data['text_delivery_to_samovivoz'] = $this->language->get('text_delivery_to_samovivoz');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

        $data['next_step'] = $this->url->link('checkout/payment_address/save', '', 'SSL');

		if (isset($this->session->data['payment_address']['address_id'])) {
			$data['address_id'] = $this->session->data['payment_address']['address_id'];
		} else {
			$data['address_id'] = $this->customer->getAddressId();
		}

		$this->load->model('account/address');

        $data['addresses'] = array();
        $data['default_adress'] = array();
        $data['uk_country_id'] = $this->uk_country_id;

        //$data['default_adress_id'] = $this->customer->getAddressId();

		$results = $this->model_account_address->getAddresses();
        foreach ($results as $result) {
            $format = "{country} / {city} / {address_1}";

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}',
                '{country_id}'
            );

            $country = !empty($result['country_id']) ? $this->model_account_address->getCountry($result['country_id']) : '';

            $locations_info = !empty($result['country_id']) ? $this->model_account_address->getLocCity($result['country_id'], $result['city']) : '';

            $replace = array(
                'firstname' => $result['firstname'],
                'lastname'  => $result['lastname'],
                'company'   => $result['company'],
                'address_1' => $result['address_1'],
                'address_2' => $result['address_2'],
                'city'      => $result['city'],
                'postcode'  => $result['postcode'],
                'zone'      => $result['zone'],
                'zone_code' => $result['zone_code'],
                'country'   => empty($country) ? '' : $country['name'],
                'country_id'   => $result['country_id']
            );

            $set = array(
                'address_id' => $result['address_id'],
                'data' => $result,
                'loc_info' => $locations_info,
                'default' => $this->customer->getAddressId() == $result['address_id'] ? 1 : 0,
                'address'    =>  trim(str_replace($find, $replace, $format)),
                'country' => $country,
                'custom_field' => $result['custom_field']
            );


            if ($result['address_id'] == $data['address_id']) {
                $data['default_adress'] = $set;
            }

            if ($this->uk_country_id == $result['country_id']) {
                if (isset($set['custom_field']['shipping_type'])) {
                    $data['addresses']['uk'][$set['custom_field']['shipping_type']][] = $set;
                }
            } else {
                $data['addresses']['inter'][] = $set;
            }
        }

        $store_address = json_decode($this->config->get('config_address'));

        foreach ($store_address as $key => $value) {
            if($this->language->get('code') == $key) {
                $data['store_address'] = $value;
            }
        }

        $data['action_city_search'] = $this->url->link('account/address/getcity', '', 'SSL');
        $data['url_card_save'] = $this->url->link('account/address/save', '', 'SSL');
        $data['url_get_np_adress'] = $this->url->link('account/address/getnpadress', '', 'SSL');
        $data['url_get_cities'] = $this->url->link('account/address/getcities', '', 'SSL');

        $data['comment'] = isset($this->session->data['payment_comment']) ? $this->session->data['payment_comment'] : '';


        // Shipping Methods
        $method_data = array();

        $this->load->model('extension/extension');

        $results = $this->model_extension_extension->getExtensions('shipping');

        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
                $this->load->model('shipping/' . $result['code']);

                $quote = $this->{'model_shipping_' . $result['code']}->getQuote(1);

                if ($quote) {
                    $method_data[$result['code']] = array(
                        'title'      => $quote['title'],
                        'quote'      => $quote['quote'],
                        'sort_order' => $quote['sort_order'],
                        'error'      => $quote['error']
                    );
                }
            }
        }

        $sort_order = array();

        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $method_data);
        $data['shipping_methods'] = $this->session->data['shipping_methods'] = $method_data;
        $data['countries'] = $this->model_account_address->getCountries($data['uk_country_id']);
        $data['regions'] = $this->model_account_address->getRegions();


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

		//$data['countries'] = $this->model_localisation_country->getCountries();

		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		if (isset($this->session->data['payment_address']['custom_field'])) {
			$data['payment_address_custom_field'] = $this->session->data['payment_address']['custom_field'];
		} else {
			$data['payment_address_custom_field'] = array();
		}

		if (isset($this->session->data['payment_address'])) {
            $pay_address = $this->session->data['payment_address'];

            $country = !empty($pay_address['country_id']) ? $this->model_account_address->getCountry($pay_address['country_id']) : '';

            $locations_info = !empty($pay_address['city']) ? $this->model_account_address->getLocCity($pay_address['country_id'], $pay_address['city']) : '';

            $pay_address['loc_info'] = $locations_info;
            $pay_address['country'] = $country;
            $data['default_adress'] = $pay_address;
        }

        $data['customer_phone'] = $this->customer->getTelephone();
        $data['customer_firstname'] = $this->customer->getFirstName();
        $data['customer_is_guest'] = $this->customer->isQuest();
        $data['customer_lastname'] = $this->customer->getLastName();


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_address.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/checkout/payment_address.tpl', $data);
		} else {
			return $this->load->view('default/template/checkout/payment_address.tpl', $data);
		}
	}

	private function setShippingMethods() {
        // Shipping Methods
        $method_data = array();

        $this->load->model('extension/extension');

        $results = $this->model_extension_extension->getExtensions('shipping');

        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
                $this->load->model('shipping/' . $result['code']);

                $quote = $this->{'model_shipping_' . $result['code']}->getQuote(1);

                if ($quote) {
                    $method_data[$result['code']] = array(
                        'title'      => $quote['title'],
                        'quote'      => $quote['quote'],
                        'sort_order' => $quote['sort_order'],
                        'error'      => $quote['error']
                    );
                }
            }
        }

        $sort_order = array();

        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $method_data);
        return $this->session->data['shipping_methods'] = $method_data;
    }

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();
		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

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

				break;
			}
		}

		//print_r($this->request->post);exit();

		$address_id = (int)$this->request->post['address_id'];
		$shipping_type = $this->request->post['shipping_type'];

        $this->session->data['payment_comment'] = isset($this->request->post['comment']) ? $this->request->post['comment'] : '';

        /*if ($shipping_type != 'pickup.pickup' && empty($address_id) && $this->customer->isQuest() == 0) {
            $json['ok'] = false;
            $json['error_address_id'] = 1;
        }*/

        if (!$json) {
            // Default Payment Address
            $this->load->model('account/address');

            if ($shipping_type) {
                $shipping_type_parts = explode('.', $shipping_type);
                $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping_type_parts[0]]['quote'][$shipping_type_parts[1]];
            }

            if (empty($address_id)) {

                    $this->session->data['shipping_address'] = $this->session->data['payment_address'] = [
                        'address_id' => 0,
                        'firstname' => $this->customer->getFirstName(),
                        'lastname' => $this->customer->getLastName(),
                        'company' => '',
                        'address_1' => '',
                        'address_2' => $this->customer->getTelephone(),
                        'postcode' => '',
                        'city' => '',
                        'zone_id' => 4,
                        'zone' => '',
                        'zone_code' => '',
                        'country_id' => 0,
                        'country' => '',
                        'iso_code_2' => '',
                        'iso_code_3' => '',
                        'custom_field' => array('sendcompany' => 0, 'state' => '', 'shipping_type' => $shipping_type),
                    ];
                
            } else {
                $this->session->data['shipping_address'] = $this->session->data['payment_address'] = $this->model_account_address->getAddress($address_id);


            }


            //unset($this->session->data['payment_method']);
            //unset($this->session->data['payment_methods']);

            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
            );

            $this->model_account_activity->addActivity('address_add', $activity_data);

            $json['ok'] = true;
        }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}