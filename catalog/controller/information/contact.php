<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerInformationContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/contact');

		// adding
		$this->document->addScript(STYLE_PATH . 'js/jquery.validate.min.js' . CSSJS);

		$this->document->addScript(STYLE_PATH . 'js/contacts.js' . CSSJS);
		$this->document->addScript('https://maps.googleapis.com/maps/api/js?key=AIzaSyC60qIk-UCTOArJEn7y7f_X7QJvZ_q9npk'); //AIzaSyDum53ni7B-Evuxi7pqmSY8S8KMpGTo-Jc
		$this->document->addScript(STYLE_PATH . 'js/map.js' . CSSJS);

		$this->document->setTitle($this->language->get('heading_title'));

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {

		    if ($this->validate()) {
                $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                $message = '<br><strong>Имя:</strong>' . $this->request->post['cl_name'] . "\n";
                $message .= '<br><strong>Email:</strong> ' . $this->request->post['cl_email'] . "\n";
                $message .= '<br><strong>Телефон:</strong> ' . $this->request->post['cl_phone'] . "\n";
                $message .= '<br><strong>Сообщение:</strong> ' . $this->request->post['cl_enquiry'] . "\n";

                $mail->setTo($this->config->get('config_email'));
                $mail->setFrom($this->request->post['cl_email']);
                $mail->setSender(html_entity_decode($this->request->post['cl_name'], ENT_QUOTES, 'UTF-8'));
                $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['cl_name']), ENT_QUOTES, 'UTF-8'));
                $mail->setText($message);
                $mail->send();

                // save messages
                $this->load->model('setting/setting');
                $data = array(
                    'message' => $message,
                    'to' => $this->config->get('config_email'),
                    'from' => $this->request->post['cl_email']
                );

                $this->model_setting_setting->editSetting('messages_' . time(), $data);
                // @end save message

                $json = array('ok' => true);
                //die(json_encode($json));
                //$this->response->addHeader('Content-Type: application/json');
                //$this->response->setOutput(json_encode($json));
                $this->response->redirect($this->url->link('information/contact/success'));

            } else {
                $json = array('ok' => false, 'error' => $this->error);
                //$this->response->addHeader('Content-Type: application/json');
                //$this->response->setOutput(json_encode($json));
		        //die(json_encode($json));
                $this->response->redirect($this->url->link('information/contact'));
            }

			//$this->response->redirect($this->url->link('information/contact'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_location'] = $this->language->get('text_location');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_open'] = $this->language->get('text_open');
		$data['text_open2'] = $this->language->get('text_open2');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['text_el_email'] = $this->language->get('text_el_email');
		$data['text_contact_info'] = $this->language->get('text_contact_info');
		$data['text_send_message'] = $this->language->get('text_send_message');
		

		$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

        if (isset($this->error['phone'])) {
            $data['error_phone'] = $this->error['phone'];
        } else {
            $data['error_phone'] = '';
        }

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/contact', '', 'SSL');

		$this->load->model('tool/image');

		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
		} else {
			$data['image'] = false;
		}

        $data['telephone'] = $this->config->get('config_telephone');
        $data['email_contact'] = $this->config->get('config_email');

		$data['store'] = $this->config->get('config_name');
		$data['geocode'] = $this->config->get('config_geocode');
		$data['geocode_hl'] = $this->config->get('config_language');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['fax'] = $this->config->get('config_fax');
		$data['comment'] = $this->config->get('config_comment');

        $tmp = json_decode($this->config->get('config_address'), true);
        foreach ($tmp as $key => $value) {
            if($this->language->get('code') == $key) {
                $data['address'] = $value;
            }
        }

        $tmpOpen = $this->config->get('config_open');
        foreach ($tmpOpen as $key => $value) {
            if($this->language->get('code') == $key) {
                $data['open'] = $value;
            }
        }
        $tmpOpen = $this->config->get('config_open2');
        foreach ($tmpOpen as $key => $value) {
            if($this->language->get('code') == $key) {
                $data['open2'] = $value;
            }
        }
		$data['locations'] = array();

		$this->load->model('localisation/location');

		foreach((array)$this->config->get('config_location') as $location_id) {
			$location_info = $this->model_localisation_location->getLocation($location_id);

			if ($location_info) {
				if ($location_info['image']) {
					$image = $this->model_tool_image->resize($location_info['image'], $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
				} else {
					$image = false;
				}

				$data['locations'][] = array(
					'location_id' => $location_info['location_id'],
					'name'        => $location_info['name'],
					'address'     => nl2br($location_info['address']),
					'geocode'     => $location_info['geocode'],
					'telephone'   => $location_info['telephone'],
					'fax'         => $location_info['fax'],
					'image'       => $image,
					'open'        => nl2br($location_info['open']),
					'comment'     => $location_info['comment']
				);
			}
		}

		if (isset($this->request->post['cl_name'])) {
			$data['name'] = $this->request->post['cl_name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['cl_email'])) {
			$data['email'] = $this->request->post['cl_email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

        if (isset($this->request->post['cl_phone'])) {
            $data['phone'] = $this->request->post['cl_phone'];
        } else {
            $data['phone'] = $this->customer->getTelephone();
        }

		if (isset($this->request->post['cl_enquiry'])) {
			$data['enquiry'] = $this->request->post['cl_enquiry'];
		} else {
			$data['enquiry'] = '';
		}

        if (isset($this->request->post['contact_status'])) {
            $data['contact_status'] = $this->request->post['contact_status'];
        } else {
            $data['contact_status'] = '';
        }

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer', array('nosubscribe' => 0 ));
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/contact.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/contact.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/contact.tpl', $data));
		}
	}

	protected function validate() {
		if ((utf8_strlen($this->request->post['cl_name']) < 3) || (utf8_strlen($this->request->post['cl_name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['cl_email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['cl_enquiry']) < 10) || (utf8_strlen($this->request->post['cl_enquiry']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

        if ((utf8_strlen($this->request->post['contact_status']) > 0)) {
            $this->error['contact_status'] = $this->language->get('error_captcha');
        }

        if ((utf8_strlen($this->request->post['cl_phone']) < 3) || (utf8_strlen($this->request->post['cl_phone']) > 11)) {
            $this->error['phone'] = $this->language->get('error_phone');
        }

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}

	public function success() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}
}
