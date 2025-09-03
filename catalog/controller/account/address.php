<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerAccountAddress extends Controller {
	private $error = array();
    private $uk_country_id = UKCOUNTRYID;

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/address');


        $this->document->addScript('https://code.jquery.com/ui/1.12.1/jquery-ui.js');
        $this->document->addStyle('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        $this->document->addScript(STYLE_PATH . 'js/delivery.js' . CSSJS);

		$this->getList();
	}

	public function add() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/address');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_address->addAddress($this->request->post);

			$this->session->data['success'] = $this->language->get('text_add');

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('address_add', $activity_data);

			$this->response->redirect($this->url->link('account/address', '', 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/address');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);

			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->request->get['address_id']);

				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}

			$this->session->data['success'] = $this->language->get('text_edit');

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('address_edit', $activity_data);

			$this->response->redirect($this->url->link('account/address', '', 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/address');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/address');

		if (isset($this->request->get['address_id']) && $this->validateDelete()) {
			$this->model_account_address->deleteAddress($this->request->get['address_id']);

			// Default Shipping Address
			if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
				unset($this->session->data['shipping_address']);
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Default Payment Address
			if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
				unset($this->session->data['payment_address']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
			}

			$this->session->data['success'] = $this->language->get('text_delete');

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('address_delete', $activity_data);

			$this->response->redirect($this->url->link('account/address', '', 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_addresses'),
			'href' => $this->url->link('account/address', '', 'SSL')
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_address_book'] = $this->language->get('text_address_book');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['button_new_address'] = $this->language->get('button_new_address');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_back'] = $this->language->get('button_back');

        $data['text_delivery_ukraine'] = $this->language->get('text_delivery_ukraine');
        $data['text_add_delivery_ukraine'] = $this->language->get('text_add_delivery_ukraine');
        $data['text_delivery_type'] = $this->language->get('text_delivery_type');
        $data['entry_zone_option'] = $this->language->get('entry_zone_option');
        $data['entry_zone'] = $this->language->get('entry_zone');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_address_1'] = $this->language->get('entry_address_1');
        $data['entry_npselect'] = $this->language->get('entry_npselect');
        $data['entry_phone'] = $this->language->get('entry_phone');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['entry_default'] = $this->language->get('entry_default');
        $data['entry_send_company'] = $this->language->get('entry_send_company');
        $data['entry_save'] = $this->language->get('entry_save');
        $data['entry_edit'] = $this->language->get('entry_edit');
        $data['entry_delete'] = $this->language->get('entry_delete');
        $data['entry_default'] = $this->language->get('entry_default');
        $data['text_delivery_other'] = $this->language->get('text_delivery_other');
        $data['text_add_delivery_other'] = $this->language->get('text_add_delivery_other');

        $data['entry_city_option'] = $this->language->get('entry_city_option');
        $data['entry_npselect_option'] = $this->language->get('entry_npselect_option');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_country'] = $this->language->get('entry_country');
        $data['entry_state'] = $this->language->get('entry_state');
        $data['entry_zipcode'] = $this->language->get('entry_zipcode');


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['addresses'] = array();

		$results = $this->model_account_address->getAddresses();

		foreach ($results as $result) {
			/*if ($result['address_format']) {
				$format = $result['address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}*/


            $format = array();
            $company = '';

            if (!empty($result['company']))
                $company = '{company}: ';

            if (!empty($result['country']))
                $format[] = '{country}';

            if (!empty($result['city']))
                $format[] = '{city}';

            if (!empty($result['address_1']))
                $format[] = '{address_1}';

            $format = !empty($format) ? $company . implode($format, ', ') : '';


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
                'update'     => $this->url->link('account/address/edit', 'address_id=' . $result['address_id'], 'SSL'),
				'delete'     => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
			);

            $data['addresses'][] = $set;
		}

		$data['add'] = $this->url->link('account/address/add', '', 'SSL');
		$data['back'] = $this->url->link('account/account', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

        $data['account_menu'] = $this->load->controller('account/account/get_account_menu', 'address');
        $data['action_city_search'] = $this->url->link('account/address/getcity', '', 'SSL');
        $data['url_card_save'] = $this->url->link('account/address/save', '', 'SSL');
        $data['url_card_remove'] = $this->url->link('account/address/remove', '', 'SSL');
        $data['url_card_default'] = $this->url->link('account/address/setdefault', '', 'SSL');
        $data['url_get_np_adress'] = $this->url->link('account/address/getnpadress', '', 'SSL');
        $data['url_get_cities'] = $this->url->link('account/address/getcities', '', 'SSL');

        $data['uk_country_id'] = $this->uk_country_id;
        $data['default_adress_id'] = $this->customer->getAddressId();

        $data['customer_phone'] = $this->customer->getTelephone();
        $data['customer_firstname'] = $this->customer->getFirstName();
        $data['customer_lastname'] = $this->customer->getLastName();


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
                        'title' => $quote['title'],
                        'quote' => $quote['quote'],
                        'sort_order' => $quote['sort_order'],
                        'error' => $quote['error']
                    );
                }
            }
        }

        $sort_order = array();

        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $method_data);

        $data['shipping_methods'] = $method_data;
        $data['countries'] = $this->model_account_address->getCountries($data['uk_country_id']);
        $data['regions'] = $this->model_account_address->getRegions();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/address_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/address_list.tpl', $data));
		}
	}



    public function setdefault() {
        $this->load->language('account/address');

        if (!$this->customer->isLogged()) {
            exit(json_encode(array('ok' => false, 'warning' => $this->language->get('error_is_logging'))));
        }

        $id = isset($this->request->post['id']) ? $this->request->post['id'] : 0;
        if (empty($id))
            exit(json_encode(array('ok' => false)));

        $this->load->model('account/address');

        $this->model_account_address->updateDefaultAdress($id);
    }
    public function getcity() {
        if (!isset($this->request->get['term']))
            exit(json_encode(array('ok' => false)));

	    $search_text = $this->request->get['term'];
	    if (empty($search_text))
	        exit(json_encode(array('ok' => false)));

        $apikey = 'AIzaSyBBvwSrBijo-HYHsgJQI90XQkmNPWJ5Tao';

        $is_uk = isset($this->request->get['uk']) ? (int)$this->request->get['uk'] : 0;
	    $google_url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.urlencode($search_text).'&types=(cities)&language=ru&key=' . $apikey;
	    $google_url_uk = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input='.urlencode($search_text).'&types=(cities)&components=country:ua&language=ru&key=' . $apikey;
	    $gourl = $is_uk ? $google_url_uk : $google_url;

	    $result = file_get_contents($gourl);
        if (empty($result))
            exit(json_encode(array('ok' => false, 'errors')));

        $result = json_decode($result, true);
        if ($result['status'] != 'OK')
            exit(json_encode(array('ok' => false)));

        $response = array();
	    foreach($result['predictions'] as $city) {
	        $city_val = $city['terms'][0]['value'];
	        if (count($city['terms']) > 2) {
                $country_val = $city['terms'][2]['value'];
            } else {
                $country_val = $city['terms'][1]['value'];
            }

	        $response[] = array(
	            'id' => $city['id'],
                'label' => $city['description'],
	            'value' => $city_val,
                'country' => $country_val
            );
        }

        exit(json_encode(array('ok' => true, 'items' => $response)));
    }

    public function getcities() {
        $this->load->language('account/address');

        $this->load->model('account/address');

        if (!$this->customer->isLogged()) {
            exit(json_encode(array('ok' => false, 'warning' => $this->language->get('error_is_logging'))));
        }

        $country_id = isset($this->request->get['country_id']) ? $this->request->get['country_id'] : 0;

        $cities = $this->model_account_address->getCities($country_id);
        if (empty($cities))
            exit(json_encode(array('ok' => false)));

        exit(json_encode(array('ok' => true, 'items' => $cities)));
    }

    protected function validDel($id) {
        if ($this->model_account_address->getTotalAddresses() == 1) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        if ($this->customer->getAddressId() == $id) {
            $this->error['warning'] = $this->language->get('error_default');
        }

        return !$this->error;
    }

    public function getnpadress() {
        $this->load->language('account/address');

        $this->load->model('account/address');

        if (!$this->customer->isLogged()) {
            exit(json_encode(array('ok' => false, 'warning' => $this->language->get('error_is_logging'))));
        }

        $zone_id = isset($this->request->get['zone_id']) ? $this->request->get['zone_id'] : 0;
        if (empty($zone_id))
            exit(json_encode(array('ok' => false)));

        $adreses_np = $this->model_account_address->getNPAdress($zone_id);
        if (empty($adreses_np))
            exit(json_encode(array('ok' => false)));

        exit(json_encode(array('ok' => true, 'items' => $adreses_np)));
	}

    public function remove(){
        $this->load->language('account/address');

        if (!$this->customer->isLogged()) {
            exit(json_encode(array('ok' => false, 'warning' => $this->language->get('error_is_logging'))));
        }

        $id = isset($this->request->post['id']) ? $this->request->post['id'] : 0;
        if (empty($id))
            exit(json_encode(array('ok' => false)));
        $this->load->model('account/address');

        if ($this->validDel($id)) {
            $this->model_account_address->deleteAddress($id);
            exit(json_encode(array('ok' => true)));
	    }

	    $warning = isset($this->error['warning']) ? $this->error['warning'] : '';

        exit(json_encode(array('ok' => false, 'warning' => $warning)));
    }

    public function save(){
        if (!$this->customer->isLogged()) {
            exit(json_encode(array('ok' => false)));
        }

        $id = isset($this->request->post['id']) ? $this->request->post['id'] : 0;
        $type = isset($this->request->post['type']) ? $this->request->post['type'] : false;
        if ($type === false)
            exit(json_encode(array('ok' => false)));

        $country_id = (int)$this->request->post['country'];
        $city = $this->request->post['city'];
        $address = $this->request->post['address'];
        $phone = $this->request->post['phone'];
        $company = isset($this->request->post['company']) ? $this->request->post['company'] : '';
        $firstname = $this->request->post['firstname'];
        $lastname = $this->request->post['lastname'];

        $shipping_type = isset($this->request->post['shipping_type']) ? $this->request->post['shipping_type'] : '';
        $sendcompany = isset($this->request->post['sendcompany']) ? $this->request->post['sendcompany'] : 0;
        $default = isset($this->request->post['default']) ? $this->request->post['default'] : 0;
        $state = isset($this->request->post['state']) ? $this->request->post['state'] : '';
        $zipcode = isset($this->request->post['zipcode']) ? $this->request->post['zipcode'] : '';

        $region_id = isset($this->request->post['region_id']) ? $this->request->post['region_id'] : 0;
        $city_id = isset($this->request->post['city_id']) ? $this->request->post['city_id'] : 0;
        $address_id = isset($this->request->post['address_id']) ? $this->request->post['address_id'] : 0;

        $errors = array();
        if (empty($country_id))
            $errors[] = 'country';

        if (empty($city) || $city == 'none')
            $errors[] = 'city';

        if (empty($address) || $address == 'none')
            $errors[] = 'address';

        if (empty($phone))
            $errors[] = 'phone';

        if ($sendcompany == 1 && empty($company))
            $errors[] = 'company';

        if (empty($firstname))
            $errors[] = 'firstname';

        if (empty($lastname))
            $errors[] = 'lastname';

        if ($type == 1) {
            if (empty($state))
                $errors[] = 'state';

            if (empty($zipcode))
                $errors[] = 'zipcode';
        }

        if ($errors) {
            exit(json_encode(array('ok' => false, 'errors' => $errors)));
        }

        $zone_id = 4;

        $this->load->model('account/address');
        $insertUpdate = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'company' => $company,
            'address_1' => $address,
            'address_2' => $phone,
            'postcode' => $zipcode,
            'city' => $city,
            'zone_id' => $zone_id,
            'country_id' => $country_id,
            'custom_field' => array(
                'sendcompany' => $sendcompany,
                'state' => $state,
                'shipping_type' => $shipping_type,
                'region_id' => $region_id,
                'city_id' => $city_id,
                'address_id' => $address_id
            ),
            'default' => $default,
        );

        if (empty($id)) {
            $address_id = (int)$this->model_account_address->addAddress($insertUpdate);
        } else {
            $this->model_account_address->editAddress($id, $insertUpdate);
            $address_id = (int)$id;
        }


        if (empty($address_id)) {
            $errors[] = 'Error create account adress crash';
            exit(json_encode(array('ok' => false, 'errors' => $errors)));
        }

        // Add to activity log
        $this->load->model('account/activity');

        $activity_data = array(
            'customer_id' => $this->customer->getId(),
            'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
        );

        $this->model_account_activity->addActivity('address_add', $activity_data);

        exit(json_encode(array('ok' => true, 'id' => $address_id)));
    }

	protected function getForm() {
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/address', '', 'SSL')
		);

		if (!isset($this->request->get['address_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_edit_address'),
				'href' => $this->url->link('account/address/add', '', 'SSL')
			);

		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_edit_address'),
				'href' => $this->url->link('account/address/edit', 'address_id=' . $this->request->get['address_id'], 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit_address'] = $this->language->get('text_edit_address');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
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
		$data['entry_default'] = $this->language->get('entry_default');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['custom_field'])) {
			$data['error_custom_field'] = $this->error['custom_field'];
		} else {
			$data['error_custom_field'] = array();
		}
		
		if (!isset($this->request->get['address_id'])) {
			$data['action'] = $this->url->link('account/address/add', '', 'SSL');
		} else {
			$data['action'] = $this->url->link('account/address/edit', 'address_id=' . $this->request->get['address_id'], 'SSL');
		}

		if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($address_info)) {
			$data['firstname'] = $address_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($address_info)) {
			$data['lastname'] = $address_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (!empty($address_info)) {
			$data['company'] = $address_info['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($address_info)) {
			$data['address_1'] = $address_info['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (!empty($address_info)) {
			$data['address_2'] = $address_info['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($address_info)) {
			$data['postcode'] = $address_info['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($address_info)) {
			$data['city'] = $address_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		}  elseif (!empty($address_info)) {
			$data['country_id'] = $address_info['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int)$this->request->post['zone_id'];
		}  elseif (!empty($address_info)) {
			$data['zone_id'] = $address_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		// Custom fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		if (isset($this->request->post['custom_field'])) {
			$data['address_custom_field'] = $this->request->post['custom_field'];
		} elseif (isset($address_info)) {
			$data['address_custom_field'] = $address_info['custom_field'];
		} else {
			$data['address_custom_field'] = array();
		}

		if (isset($this->request->post['default'])) {
			$data['default'] = $this->request->post['default'];
		} elseif (isset($this->request->get['address_id'])) {
			$data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
		} else {
			$data['default'] = false;
		}

		$data['back'] = $this->url->link('account/address', '', 'SSL');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address_form.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/address_form.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/account/address_form.tpl', $data));
		}
	}

	protected function validateForm() {
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

		if ($this->request->post['country_id'] == '' || !is_numeric($this->request->post['country_id'])) {
			$this->error['country'] = $this->language->get('error_country');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		// Custom field validation
		$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		foreach ($custom_fields as $custom_field) {
			if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
				$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if ($this->model_account_address->getTotalAddresses() == 1) {
			$this->error['warning'] = $this->language->get('error_delete');
		}

		if ($this->customer->getAddressId() == $this->request->get['address_id']) {
			$this->error['warning'] = $this->language->get('error_default');
		}

		return !$this->error;
	}

	/* myc cards */
    public function mycards() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->language('account/address');
        $data['account_menu'] = $this->load->controller('account/account/get_account_menu', 'mycards');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addScript(STYLE_PATH . 'js/credit-card.js' . CSSJS);


        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $data['errors'] = isset($this->session->data['cards_errors']) ? $this->session->data['cards_errors'] : array();


        $data['last'] = isset($this->session->data['last_data']) ? $this->session->data['last_data'] : array();

        $data['cards'] = $this->mycards_get();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/mycards.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/account/mycards.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/account/mycards.tpl', $data));
        }
    }

    private function mycards_verify($id, $data) {
        $prefix = 'verify__';
        $secret = 'c54ecfc2dbc40e0cf1576e55ec8c661f989c5337';

        $merchantAccount = 'test_com17';
        $merchantDomainName = 'test.com';
        $orderReference = $prefix . $id;
        $amount = 1;
        $currency = 'UAH';

        $url = 'https://api.wayforpay.com/api';
        $send = array(
            'transactionType' => 'VERIFY',
            'merchantAccount' => $merchantAccount,
            'merchantDomainName' => $merchantDomainName,
            'apiVersion' => '1',
            'orderReference' => $orderReference,
            'amount' => $amount,
            'currency' => $currency,
            'card' => 'Номер карты 16 цифр',
            'expMonth' => '',
            'expYear' => '',
            'cardCvv' => '',
            'cardHolder' => '',
        );

        $string = $merchantAccount.';'.$merchantDomainName.';'.$orderReference.';'.$amount.';'.$currency;

        $merchantSignature = hash_hmac('md5', $string, $secret);
        $send['merchantSignature'] = $merchantSignature;



        // $this->mycards_send($url, $send);
    }

    private function mycards_check_status($row) {
        return;

        $url = 'https://secure.wayforpay.com/verify';
        $data = array('key1' => 'value1', 'key2' => 'value2');
        // $this->mycards_send($url, $data);
    }

    private function mycards_send($url, $data) {
        if (empty($url) || empty($data))
            return false;

        $http = (strpos($url, 'https://') !== false) ? 'https' : 'http';

        $options = array(
            $http => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    private function mycards_get() {
        $sql = "SELECT * FROM " . DB_PREFIX . "cards WHERE customer_id=" . $this->customer->getId();
        $rows = $this->db->query($sql);
        if (empty($rows->num_rows))
            return array();

        foreach($rows->rows as $row) {

            /*if ($row['status'] == 0)
                $this->mycards_check_status($row);*/

            $row['json_data'] = json_encode(array(
                'type' => $row['type'],
                'number' => $row['number'],
                'date' => $row['date'],
                'cvv' => $row['cvv'],
                'name' => $row['name'],
                'lastname' => $row['lastname'],
                'isdefault' => $row['isdefault']
            ));

            $row['number_parts'] = explode(' ', $row['number']);

            $results[$row['id']] = $row;
        }

        return $results;
    }

    public function mycards_save() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->response->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $id = isset($this->request->post['id']) ? (int)$this->request->post['id'] : null;
        $type = isset($this->request->post['type']) ? trim($this->request->post['type']) : null;
        $number = isset($this->request->post['number']) ? trim($this->request->post['number']) : null;
        $date = isset($this->request->post['date']) ? trim($this->request->post['date']) : null;
        $cvv = isset($this->request->post['cvv']) ? trim($this->request->post['cvv']) : null;
        $name = isset($this->request->post['name']) ? trim($this->request->post['name']) : null;
        $lastname = isset($this->request->post['lastname']) ? trim($this->request->post['lastname']) : null;
        $isdefault = isset($this->request->post['isdefault']) ? trim($this->request->post['isdefault']) : 0;

        $validate = array();


        // validate
        if ($type === null || !in_array($type, array('visa', 'master')))
            $validate['type'] = 'error';

        if (empty($number) || strlen($number) != 19)
            $validate['number'] = 'error';

        if ($date === null || strlen($date) != 5)
            $validate['date'] = 'error';

        if ($cvv === null || strlen($cvv) != 3)
            $validate['cvv'] = 'error';

        if ($name === null|| strlen($name) < 3)
            $validate['name'] = 'error';

        if ($lastname === null|| strlen($lastname) < 3)
            $validate['lastname'] = 'error';
        // @end validate


        $this->session->data['cards_errors'] = !empty($validate) ? $validate : 0;

        $this->session->data['last_data'] = $data = array(
            'type' => $type,
            'number' => $number,
            'date' => $date,
            'cvv' => $cvv,
            'name' => $name,
            'lastname' => $lastname,
            'isdefault' => $isdefault,
            'status' => 0
        );


        $numfields = array('cvv', 'status', 'isdefault');


        if (!$validate) {

            foreach($data as $f => $v)
                $set[] = in_array($f, $numfields) ? $f . "=" . (int)$v : $f . "='".$this->db->escape($v)."'";


            if ($isdefault) {
                $sql = "UPDATE " . DB_PREFIX . "cards SET isdefault=0 WHERE customer_id=" . $this->customer->getId();
                $this->db->query($sql);
            }

            if (empty($id)) {
                $sql = "INSERT INTO " . DB_PREFIX . "cards SET " . implode(', ', $set) . ' customer_id=' . $this->customer->getId();
            } else {
                $sql = "UPDATE " . DB_PREFIX . "cards SET " . implode(', ', $set) . " WHERE id=" . $id . ' AND customer_id=' . $this->customer->getId();

                $id = $this->db->getLastId();
            }

            $this->db->query($sql);

            //$this->mycards_verify($id, $data);

            unset($this->session->data['last_data']);
            unset($this->session->data['cards_errors']);
        }

        $this->response->redirect($this->url->link('account/address/mycards', '', 'SSL'));

    }
}
