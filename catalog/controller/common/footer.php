<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonFooter extends Controller {
	public function index($params = false) {
		$this->load->language('common/footer');

        $data['scripts'] = $this->document->getScripts();
		$data['scripts2'] = $this->document->getScripts('footer');

        $data['scripts'][] = STYLE_PATH . 'js/jquery.inputmask.bundle.js' . CSSJS;
        $data['scripts'][] = STYLE_PATH . 'intelmaska/build/js/intlTelInput.js' . CSSJS;
        $data['scripts'][] = STYLE_PATH . 'intelmaska/examples/js/isValidNumber.js' . CSSJS;

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		
		$data['text_menu'] = $this->language->get('text_menu');
		$data['text_catalog'] = $this->language->get('text_catalog');
		$data['text_subscribe_title'] = $this->language->get('text_subscribe_title');
		$data['text_copyrite'] = $this->language->get('text_copyrite');
		$data['text_our_gift_wrapping'] = $this->language->get('text_our_gift_wrapping');

        $data['text_sps_subscribe'] = $this->language->get('text_sps_subscribe');
        $data['text_you_email'] = $this->language->get('text_you_email');
        $data['text_tosubscribe'] = $this->language->get('text_tosubscribe');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		// custom

        $tmp = $this->config->get('config_address');
		$tmp = json_decode($tmp, true);
        foreach ($tmp as $key => $value) {
            if($this->language->get('code') == $key) {
               $data['store_address'] = $value;
            }
        }
        // Analytics
        $this->load->model('extension/extension');

        $data['analytics'] = array();

        $analytics = $this->model_extension_extension->getExtensions('analytics');

        foreach ($analytics as $analytic) {
            if ($this->config->get($analytic['code'] . '_status')) {
                $data['analytics'][] = $this->load->controller('analytics/' . $analytic['code']);
            }
        }

        $data['telephone'] = $this->config->get('config_telephone');
        $data['email'] = $this->config->get('config_email');

        $data['link_facebook'] = $this->config->get('config_link_facebook');
        $data['link_instagramm'] = $this->config->get('config_link_instagramm');
        $data['link_pinterest'] = $this->config->get('config_link_pinterest');


        if(isset($params['nosubscribe'])) {
            $data['nosubscribe'] = $params['nosubscribe'];
        } else {
            $data['nosubscribe'] = 0;
        }

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}