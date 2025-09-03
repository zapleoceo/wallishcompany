<?php
class ControllerShippingnovaposhta extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('shipping/novaposhta');

	  $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('novaposhta', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

        // установка языковых переменных
        $data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_none'] = $this->language->get('text_none');

        $data['entry_tax'] = $this->language->get('entry_tax');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $data['entry_delivery_order'] = $this->language->get('entry_delivery_order');
        $data['entry_delivery_price'] = $this->language->get('entry_delivery_price');
        $data['entry_delivery_insurance'] = $this->language->get('entry_delivery_insurance');
        $data['entry_delivery_nal'] = $this->language->get('entry_delivery_nal');
        $data['entry_min_total_for_free_delivery'] = $this->language->get('entry_min_total_for_free_delivery');
		
        $data['entry_delivery_order_help'] = $this->language->get('entry_delivery_order_help');
        $data['entry_delivery_price_help'] = $this->language->get('entry_delivery_price_help');
        $data['entry_delivery_insurance_help'] = $this->language->get('entry_delivery_insurance_help');
        $data['entry_delivery_nal_help'] = $this->language->get('entry_delivery_nal_help');
        $data['entry_min_total_for_free_delivery_help'] = $this->language->get('entry_min_total_for_free_delivery_help');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // хлебные крошки
        $data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/novaposhta', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

        // ссылки для кнопок Сохранить и Отменить
        $data['action'] = $this->url->link('shipping/novaposhta', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['novaposhta_min_total_for_free_delivery'])) {
            $data['novaposhta_min_total_for_free_delivery'] = $this->request->post['novaposhta_min_total_for_free_delivery'];
        } else {
            $data['novaposhta_min_total_for_free_delivery'] = $this->config->get('novaposhta_min_total_for_free_delivery');
        }

        if (isset($this->request->post['novaposhta_delivery_order'])) {
            $data['novaposhta_delivery_order'] = $this->request->post['novaposhta_delivery_order'];
        } else {
            $data['novaposhta_delivery_order'] = $this->config->get('novaposhta_delivery_order');
        }

        if (isset($this->request->post['novaposhta_delivery_price'])) {
            $data['novaposhta_delivery_price'] = $this->request->post['novaposhta_delivery_price'];
        } else {
            $data['novaposhta_delivery_price'] = $this->config->get('novaposhta_delivery_price');
        }

        if (isset($this->request->post['novaposhta_delivery_insurance'])) {
            $data['novaposhta_delivery_insurance'] = $this->request->post['novaposhta_delivery_insurance'];
        } else {
            $data['novaposhta_delivery_insurance'] = $this->config->get('novaposhta_delivery_insurance');
        }

        if (isset($this->request->post['novaposhta_delivery_nal'])) {
            $data['novaposhta_delivery_nal'] = $this->request->post['novaposhta_delivery_nal'];
        } else {
            $data['novaposhta_delivery_nal'] = $this->config->get('novaposhta_delivery_nal');
        }

        if (isset($this->request->post['novaposhta_geo_zone_id'])) {
            $data['novaposhta_geo_zone_id'] = $this->request->post['novaposhta_geo_zone_id'];
        } else {
            $data['novaposhta_geo_zone_id'] = $this->config->get('novaposhta_geo_zone_id');
        }

        if (isset($this->request->post['novaposhta_status'])) {
            $data['novaposhta_status'] = $this->request->post['novaposhta_status'];
        } else {
            $data['novaposhta_status'] = $this->config->get('novaposhta_status');
        }

        if (isset($this->request->post['novaposhta_sort_order'])) {
            $data['novaposhta_sort_order'] = $this->request->post['novaposhta_sort_order'];
        } else {
            $data['novaposhta_sort_order'] = $this->config->get('novaposhta_sort_order');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $template = 'shipping/novaposhta.tpl';
        
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/novaposhta.tpl', $data, $this->config->get('config_compression')));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'shipping/novaposhta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>