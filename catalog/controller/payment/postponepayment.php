<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerPaymentPostponepayment extends Controller {
    private $code = 'postponepayment';

    public function index() {
        $data['button_confirm'] = $this->language->get('button_confirm');

        $data['text_loading'] = $this->language->get('text_loading');

        $data['continue'] = $this->url->link('checkout/success');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/'.$this->code.'.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/'.$this->code.'.tpl', $data);
        } else {
            return $this->load->view('default/template/payment/'.$this->code.'.tpl', $data);
        }
    }

    public function confirm() {
        if ($this->session->data['payment_method']['code'] == $this->code) {
            $this->load->model('checkout/order');

            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get($this->code . '_order_status_id'));

            $this->load->controller('checkout/success');
        }
    }
}
