<?php
/*
 * @copyright Copyright (c) 2011 Shilovsky Andrej, Dmitrij (an911@ukr.net)
 */
class ControllerPaymentPrivat24 extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		// $data['action'] = 'https://api.privatbank.ua:9083/p24api/ishop';
		$data['action'] = 'https://api.privatbank.ua/p24api/ishop';
                    
 	        $curr_code = $this->config->get('privat24_currency');
		$eur_order_total = $this->currency->convert($order_info['total'], $order_info['currency_code'], $curr_code);               
		$data['amt'] = $this->currency->format($eur_order_total, $curr_code, $order_info['currency_value'], false);
		$data['ccy'] = $curr_code;
		$data['merchant'] = $this->config->get('privat24_merchant');
		$data['order'] = $this->session->data['order_id'];
		$data['details'] = 'order-id'.$this->session->data['order_id'] . " " . html_entity_decode($this->config->get('config_url'), ENT_QUOTES, 'UTF-8');
		$data['return_url'] = $this->url->link('checkout/success', '', 'SSL');
		$data['server_url'] = $this->url->link('payment/privat24/callback', '', 'SSL');



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/privat24.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/privat24.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/privat24.tpl', $data);
		}
	}


	public function callback() {
                $pass = trim($this->config->get('privat24_password'));
                $signature = sha1(md5(htmlspecialchars_decode($this->request->post['payment'], ENT_QUOTES)  . $pass));
    
                $info = explode('&', htmlspecialchars_decode($this->request->post['payment'], ENT_QUOTES));
                foreach ($info as $value) {
                    $z = explode('=', $value);
                    $data[$z[0]] = $z[1];
                } 

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($data['order']);
        
	   if ($order_info) {
		     $this->model_checkout_order->addOrderHistory($data['order'], $this->config->get('config_order_status_id'));
                     
	      if($signature == $this->request->post['signature'] AND 'ok' == $data["state"]) {
		     $this->model_checkout_order->addOrderHistory($data['order'], $this->config->get('privat24_order_status_id'), '', true);
		    return TRUE;
              } else {
			echo 'ERROR: hash!';
			return 0;
              }
           } else {		
                    echo 'ERROR: order!';
		    return 0;
	   }
		   
	}
 }
?>