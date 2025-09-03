<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt


class ControllerAccountLogin extends Controller {
	private $error = array();
	private $validate_phone = '';
	private $guest_name = '';

	private $uk_country_id = UKCOUNTRYID;

	public function index() {

		$this->load->model( 'account/customer' );

		// adding
		$this->document->addScript( STYLE_PATH . 'js/jquery.validate.min.js' . CSSJS );
		$this->document->addScript( STYLE_PATH . 'js/signin.js' . CSSJS );

		$sect = isset( $this->request->post['sect'] ) ? $this->request->post['sect'] : '';

		// Login override for admin users
		if ( ! empty( $this->request->get['token'] ) ) {
			$this->customer->logout();
			$this->cart->clear();

			unset( $this->session->data['order_id'] );
			unset( $this->session->data['payment_address'] );
			unset( $this->session->data['payment_method'] );
			unset( $this->session->data['payment_methods'] );
			unset( $this->session->data['shipping_address'] );
			unset( $this->session->data['shipping_method'] );
			unset( $this->session->data['shipping_methods'] );
			unset( $this->session->data['comment'] );
			unset( $this->session->data['coupon'] );
			unset( $this->session->data['reward'] );
			unset( $this->session->data['voucher'] );
			unset( $this->session->data['vouchers'] );

			$customer_info = $this->model_account_customer->getCustomerByToken( $this->request->get['token'] );

			if ( $customer_info && $this->customer->login( $customer_info['email'], '', true ) ) {
				// Default Addresses
				$this->load->model( 'account/address' );

				if ( $this->config->get( 'config_tax_customer' ) == 'payment' ) {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress( $this->customer->getAddressId() );
				}

				if ( $this->config->get( 'config_tax_customer' ) == 'shipping' ) {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress( $this->customer->getAddressId() );
				}


				$this->response->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
			}
		}

		if ( $this->customer->isLogged() ) {
			$this->response->redirect( $this->url->link( 'account/account', '', 'SSL' ) );
		}

		$this->load->language( 'account/login' );
		$this->document->setTitle( $this->language->get( 'heading_title' ) );
		$this->document->setRobots( 'noindex,follow' );

		unset( $this->session->data['error_checkout_register'] );
		unset( $this->session->data['error_checkout_login'] );

		// login
		if ( $sect == 'login' && ( $this->request->server['REQUEST_METHOD'] == 'POST' ) ) {
			if ( $this->validate() ) {
				// Trigger customer pre login event
				$this->event->trigger( 'pre.customer.login' );

				// Unset guest
				unset( $this->session->data['guest'] );

				// Default Shipping Address
				$this->load->model( 'account/address' );

				if ( $this->config->get( 'config_tax_customer' ) == 'payment' ) {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress( $this->customer->getAddressId() );
				}

				if ( $this->config->get( 'config_tax_customer' ) == 'shipping' ) {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress( $this->customer->getAddressId() );
				}

				// Wishlist
				if ( isset( $this->session->data['wishlist'] ) && is_array( $this->session->data['wishlist'] ) ) {
					$this->load->model( 'account/wishlist' );

					foreach ( $this->session->data['wishlist'] as $key => $product_id ) {
						$this->model_account_wishlist->addWishlist( $product_id );

						unset( $this->session->data['wishlist'][ $key ] );
					}
				}

				// Add to activity log
				$this->load->model( 'account/activity' );

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);

				$this->model_account_activity->addActivity( 'login', $activity_data );

				// Trigger customer post login event
				$this->event->trigger( 'post.customer.login' );

				if ( isset( $this->request->post['return'] ) && $this->request->post['return'] == 1 ) {
					$json = array( 'ok' => true, 'redirect' => $this->url->link( 'checkout/cart' ) );
					die( json_encode( $json ) );
				}

				$json = array( 'ok' => true, 'redirect' => $this->url->link( 'account/account' ) );
				die( json_encode( $json ) );


				/* // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
				 if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
					 $this->response->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
				 } else {
					 $this->response->redirect($this->url->link('account/account', '', 'SSL'));
				 }*/

			} else {

				$json = array( 'ok' => false, 'error' => $this->error );
				die( json_encode( $json ) );

				/*
				if (isset($this->request->post['return']) && $this->request->post['return'] == 1) {
					$this->session->data['error_checkout_login'] = $this->error;
					$this->response->redirect($this->url->link('checkout/checkout', '&sect=login'));
				}*/
			}
		}

		// Guest
		if ( $sect == 'guest' && ( $this->request->server['REQUEST_METHOD'] == 'POST' ) ) {

			if ( $this->validate_guest() ) {

				if ( ! empty( $this->customer_info ) ) {

					$this->customer->login( $this->customer_info['email'], true, true );

					$json = array( 'ok' => true, 'redirect' => $this->url->link( 'checkout/checkout' ) );

					die( json_encode( $json ) );

				} else {
					//$pref = uniqid();

					/*$post = array(
						'firstname' => 'quest',
						'email' => $pref . time() . '@quest.tmp',
						'lastname' => '',
						'telephone' => $this->validate_phone,
						'address_1' => '',
						'address_2' => $this->validate_phone,
						'password' => md5($pref . time() . time()),
						'zone_id' => 0,
						'country_id' => 0
					);

					$customer_id = $this->model_account_customer->addCustomerMin($post, true, true);
					$this->customer->login($post['email'], $post['password']);

					unset($this->session->data['guest']);

					// Add to activity log
					$this->load->model('account/activity');

					$activity_data = array(
						'customer_id' => $customer_id,
						'name' => 'quest'
					);*/

					//$this->model_account_activity->addActivity('quest_register', $activity_data);
					$this->session->data['guest'] = 1;

					$this->session->data['shipping_address'] = [
						'address_id'   => 0,
						'firstname'    => $this->guest_name,
						'lastname'     => '',
						'company'      => '',
						'address_1'    => $this->validate_phone,
						'address_2'    => '',
						'postcode'     => '',
						'city'         => '',
						'zone_id'      => 4,
						'zone'         => '',
						'zone_code'    => '',
						'country_id'   => 0,
						'country'      => '',
						'iso_code_2'   => '',
						'iso_code_3'   => '',
						'custom_field' => array( 'sendcompany' => 0, 'state' => '', 'shipping_type' => '' ),
					];
					$this->session->data['payment_address']  = [
						'address_id'   => 0,
						'firstname'    => $this->guest_name,
						'lastname'     => '',
						'company'      => '',
						'address_1'    => $this->validate_phone,
						'address_2'    => '',
						'postcode'     => '',
						'city'         => '',
						'zone_id'      => 4,
						'zone'         => '',
						'zone_code'    => '',
						'country_id'   => 0,
						'country'      => '',
						'iso_code_2'   => '',
						'iso_code_3'   => '',
						'custom_field' => array( 'sendcompany' => 0, 'state' => '', 'shipping_type' => '' ),
					];


					$this->setPaymentMethods();

					$this->session->data['shipping_method'] = $this->session->data['payment_method'] = $this->session->data['payment_methods']['postponepayment'];

					$this->load->controller( 'checkout/confirm/index', true );


					$json = array( 'ok' => true, 'redirect' => $this->url->link( 'checkout/confirm/result' ) );
					die( json_encode( $json ) );
				}

			} else {

				$json = array( 'ok' => false, 'error' => $this->error );
				die( json_encode( $json ) );
			}
		}


		// Register
		$this->load->language( 'account/register' );

		$this->document->addScript( STYLE_PATH . 'js/jquery.inputmask.bundle.js' . CSSJS );
		//$data['login_link'] = $this->url->link('account/login', '', 'SSL');

		$this->load->model( 'account/customer' );

		if ( $sect == 'register' && ( $this->request->server['REQUEST_METHOD'] == 'POST' ) ) {

			if ( $this->validate_register() ) {

				$customer_id = $this->model_account_customer->addCustomerMin( $this->request->post, false, true );

				// Clear any previous login attempts for unregistered accounts.
				$this->model_account_customer->deleteLoginAttempts( $this->request->post['email'] );

				$this->customer->login( $this->request->post['email'], $this->request->post['password'] );

				unset( $this->session->data['guest'] );

				// Add to activity log
				$this->load->model( 'account/activity' );

				$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $this->request->post['firstname'] . ' ' . $this->request->post['lastname']
				);

				$this->model_account_activity->addActivity( 'register', $activity_data );


				if ( isset( $this->request->post['return'] ) && $this->request->post['return'] == 1 ) {
					$json = array( 'ok' => true, 'redirect' => $this->url->link( 'checkout/checkout' ) );
					die( json_encode( $json ) );
				}

				$this->session->data['register_true'] = 1;

				$json = array( 'ok' => true, 'redirect' => $this->url->link( 'account/account' ) );
				die( json_encode( $json ) );


			} else {

				$json = array( 'ok' => false, 'error' => $this->error );
				die( json_encode( $json ) );


				/*if (isset($this->request->post['return']) && $this->request->post['return'] == 1) {
					$this->session->data['error_checkout_register'] = $this->error;
					$this->response->redirect($this->url->link('checkout/checkout', '&sect=register'));
				}*/
			}
		}

		$this->load->language( 'account/login' );

		$data['breadcrumbs']   = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get( 'text_home' ),
			'href' => $this->url->link( 'common/home' )
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get( 'heading_title' ),
			'href' => ''
		);

		$data['text_account'] = $this->language->get( 'text_account' );
		$data['text_login']   = $this->language->get( 'text_login' );

		$data['breadcrumbs2']   = array();
		$data['breadcrumbs2'][] = array(
			'text' => $this->language->get( 'text_home' ),
			'href' => $this->url->link( 'common/home' )
		);

		$data['breadcrumbs2'][] = array(
			'text' => $this->language->get( 'text_register' ),
			'href' => ''
		);

		$data['heading_title'] = $this->language->get( 'heading_title' );

		$this->document->setRobots( 'noindex,follow' );

		$data['text_new_customer']            = $this->language->get( 'text_new_customer' );
		$data['text_register']                = $this->language->get( 'text_register' );
		$data['text_register_account']        = $this->language->get( 'text_register_account' );
		$data['text_returning_customer']      = $this->language->get( 'text_returning_customer' );
		$data['text_i_am_returning_customer'] = $this->language->get( 'text_i_am_returning_customer' );
		$data['text_forgotten']               = $this->language->get( 'text_forgotten' );

		$data['entry_email']    = $this->language->get( 'entry_email' );
		$data['entry_password'] = $this->language->get( 'entry_password' );

		$data['button_continue'] = $this->language->get( 'button_continue' );
		$data['button_login']    = $this->language->get( 'button_login' );

		if ( isset( $this->error['warning'] ) ) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action']    = $this->url->link( 'account/login', '', 'SSL' );
		$data['register']  = $this->url->link( 'account/register', '', 'SSL' );
		$data['forgotten'] = $this->url->link( 'account/forgotten', '', 'SSL' );

		// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if ( isset( $this->request->post['redirect'] ) && ( strpos( $this->request->post['redirect'], $this->config->get( 'config_url' ) ) !== false || strpos( $this->request->post['redirect'], $this->config->get( 'config_ssl' ) ) !== false ) ) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif ( isset( $this->session->data['redirect'] ) ) {
			$data['redirect'] = $this->session->data['redirect'];

			unset( $this->session->data['redirect'] );
		} else {
			$data['redirect'] = '';
		}

		if ( isset( $this->session->data['success'] ) ) {
			$data['success'] = $this->session->data['success'];

			unset( $this->session->data['success'] );
		} else {
			$data['success'] = '';
		}

		if ( isset( $this->request->post['email'] ) ) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if ( isset( $this->request->post['password'] ) ) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}


		// register
		$this->load->language( 'account/register' );

		$data['reg_heading_title'] = $this->language->get( 'heading_title' );

		$data['reg_text_account_already'] = sprintf( $this->language->get( 'text_account_already' ), $this->url->link( 'account/login', '', 'SSL' ) );
		$data['reg_text_account']         = $this->language->get( 'text_account' );
		$data['reg_text_register']        = $this->language->get( 'text_register' );
		$data['reg_text_your_details']    = $this->language->get( 'text_your_details' );
		$data['reg_text_your_address']    = $this->language->get( 'text_your_address' );
		$data['reg_text_your_password']   = $this->language->get( 'text_your_password' );
		$data['reg_text_newsletter']      = $this->language->get( 'text_newsletter' );
		$data['reg_text_yes']             = $this->language->get( 'text_yes' );
		$data['reg_text_no']              = $this->language->get( 'text_no' );
		$data['reg_text_select']          = $this->language->get( 'text_select' );
		$data['reg_text_none']            = $this->language->get( 'text_none' );
		$data['reg_text_loading']         = $this->language->get( 'text_loading' );
		$data['reg_text_head_info']       = $this->language->get( 'text_head_info' );


		$data['reg_entry_customer_group'] = $this->language->get( 'entry_customer_group' );
		$data['reg_entry_firstname']      = $this->language->get( 'entry_firstname' );
		$data['reg_entry_lastname']       = $this->language->get( 'entry_lastname' );
		$data['reg_entry_email']          = $this->language->get( 'entry_email' );
		$data['reg_entry_telephone']      = $this->language->get( 'entry_telephone' );
		$data['reg_entry_fax']            = $this->language->get( 'entry_fax' );
		$data['reg_entry_company']        = $this->language->get( 'entry_company' );
		$data['reg_entry_address_1']      = $this->language->get( 'entry_address_1' );
		$data['reg_entry_address_2']      = $this->language->get( 'entry_address_2' );
		$data['reg_entry_postcode']       = $this->language->get( 'entry_postcode' );
		$data['reg_entry_city']           = $this->language->get( 'entry_city' );
		$data['reg_entry_country']        = $this->language->get( 'entry_country' );
		$data['reg_entry_zone']           = $this->language->get( 'entry_zone' );
		$data['reg_entry_newsletter']     = $this->language->get( 'entry_newsletter' );
		$data['reg_entry_password']       = $this->language->get( 'entry_password' );
		$data['reg_entry_confirm']        = $this->language->get( 'entry_confirm' );

		$data['reg_button_continue'] = $this->language->get( 'button_continue' );
		$data['reg_button_upload']   = $this->language->get( 'button_upload' );

		if ( isset( $this->error['warning'] ) ) {
			$data['reg_error_warning'] = $this->error['warning'];
		} else {
			$data['reg_error_warning'] = '';
		}

		if ( isset( $this->error['firstname'] ) ) {
			$data['reg_error_firstname'] = $this->error['firstname'];
		} else {
			$data['reg_error_firstname'] = '';
		}

		if ( isset( $this->error['lastname'] ) ) {
			$data['reg_error_lastname'] = $this->error['lastname'];
		} else {
			$data['reg_error_lastname'] = '';
		}

		if ( isset( $this->error['email'] ) ) {
			$data['reg_error_email'] = $this->error['email'];
		} else {
			$data['reg_error_email'] = '';
		}

		if ( isset( $this->error['telephone'] ) ) {
			$data['reg_error_telephone'] = $this->error['telephone'];
		} else {
			$data['reg_error_telephone'] = '';
		}

		if ( isset( $this->error['address_1'] ) ) {
			$data['reg_error_address_1'] = $this->error['address_1'];
		} else {
			$data['reg_error_address_1'] = '';
		}

		if ( isset( $this->error['city'] ) ) {
			$data['reg_error_city'] = $this->error['city'];
		} else {
			$data['reg_error_city'] = '';
		}

		if ( isset( $this->error['postcode'] ) ) {
			$data['reg_error_postcode'] = $this->error['postcode'];
		} else {
			$data['reg_error_postcode'] = '';
		}

		if ( isset( $this->error['country'] ) ) {
			$data['reg_error_country'] = $this->error['country'];
		} else {
			$data['reg_error_country'] = '';
		}

		if ( isset( $this->error['zone'] ) ) {
			$data['reg_error_zone'] = $this->error['zone'];
		} else {
			$data['reg_error_zone'] = '';
		}

		if ( isset( $this->error['custom_field'] ) ) {
			$data['reg_error_custom_field'] = $this->error['custom_field'];
		} else {
			$data['reg_error_custom_field'] = array();
		}

		if ( isset( $this->error['password'] ) ) {
			$data['reg_error_password'] = $this->error['password'];
		} else {
			$data['reg_error_password'] = '';
		}

		if ( isset( $this->error['confirm'] ) ) {
			$data['reg_error_confirm'] = $this->error['confirm'];
		} else {
			$data['reg_error_confirm'] = '';
		}

		$data['reg_action'] = $this->url->link( 'account/register', '', 'SSL' );

		$data['reg_customer_groups'] = array();

		if ( is_array( $this->config->get( 'config_customer_group_display' ) ) ) {
			$this->load->model( 'account/customer_group' );

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ( $customer_groups as $customer_group ) {
				if ( in_array( $customer_group['customer_group_id'], $this->config->get( 'config_customer_group_display' ) ) ) {
					$data['reg_customer_groups'][] = $customer_group;
				}
			}
		}

		if ( isset( $this->request->post['customer_group_id'] ) ) {
			$data['reg_customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$data['reg_customer_group_id'] = $this->config->get( 'config_customer_group_id' );
		}

		if ( isset( $this->request->post['firstname'] ) ) {
			$data['reg_firstname'] = $this->request->post['firstname'];
		} else {
			$data['reg_firstname'] = '';
		}

		if ( isset( $this->request->post['lastname'] ) ) {
			$data['reg_lastname'] = $this->request->post['lastname'];
		} else {
			$data['reg_lastname'] = '';
		}

		if ( isset( $this->request->post['email'] ) ) {
			$data['reg_email'] = $this->request->post['email'];
		} else {
			$data['reg_email'] = '';
		}

		if ( isset( $this->request->post['telephone'] ) ) {
			$data['reg_telephone'] = $this->request->post['telephone'];
		} else {
			$data['reg_telephone'] = '';
		}

		if ( isset( $this->request->post['fax'] ) ) {
			$data['reg_fax'] = $this->request->post['fax'];
		} else {
			$data['reg_fax'] = '';
		}

		if ( isset( $this->request->post['company'] ) ) {
			$data['reg_company'] = $this->request->post['company'];
		} else {
			$data['reg_company'] = '';
		}

		if ( isset( $this->request->post['address_1'] ) ) {
			$data['reg_address_1'] = $this->request->post['address_1'];
		} else {
			$data['reg_address_1'] = '';
		}

		if ( isset( $this->request->post['address_2'] ) ) {
			$data['reg_address_2'] = $this->request->post['address_2'];
		} else {
			$data['reg_address_2'] = '';
		}

		if ( isset( $this->request->post['postcode'] ) ) {
			$data['reg_postcode'] = $this->request->post['postcode'];
		} elseif ( isset( $this->session->data['shipping_address']['postcode'] ) ) {
			$data['reg_postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['reg_postcode'] = '';
		}

		if ( isset( $this->request->post['city'] ) ) {
			$data['reg_city'] = $this->request->post['city'];
		} else {
			$data['reg_city'] = '';
		}

		if ( isset( $this->request->post['country_id'] ) ) {
			$data['reg_country_id'] = (int) $this->request->post['country_id'];
		} elseif ( isset( $this->session->data['shipping_address']['country_id'] ) ) {
			$data['reg_country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['reg_country_id'] = $this->config->get( 'config_country_id' );
		}

		if ( isset( $this->request->post['zone_id'] ) ) {
			$data['reg_zone_id'] = (int) $this->request->post['zone_id'];
		} elseif ( isset( $this->session->data['shipping_address']['zone_id'] ) ) {
			$data['reg_zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['reg_zone_id'] = '';
		}

		$this->load->model( 'localisation/country' );

		$data['reg_countries'] = $this->model_localisation_country->getCountries();

		// Custom Fields
		$this->load->model( 'account/custom_field' );

		$data['reg_custom_fields'] = $this->model_account_custom_field->getCustomFields();

		if ( isset( $this->request->post['custom_field'] ) ) {
			if ( isset( $this->request->post['custom_field']['account'] ) ) {
				$account_custom_field = $this->request->post['custom_field']['account'];
			} else {
				$account_custom_field = array();
			}

			if ( isset( $this->request->post['custom_field']['address'] ) ) {
				$address_custom_field = $this->request->post['custom_field']['address'];
			} else {
				$address_custom_field = array();
			}

			$data['reg_register_custom_field'] = $account_custom_field + $address_custom_field;
		} else {
			$data['reg_register_custom_field'] = array();
		}

		if ( isset( $this->request->post['password'] ) ) {
			$data['reg_password'] = $this->request->post['password'];
		} else {
			$data['reg_password'] = '';
		}

		if ( isset( $this->request->post['confirm'] ) ) {
			$data['reg_confirm'] = $this->request->post['confirm'];
		} else {
			$data['reg_confirm'] = '';
		}

		if ( isset( $this->request->post['newsletter'] ) ) {
			$data['reg_newsletter'] = $this->request->post['newsletter'];
		} else {
			$data['reg_newsletter'] = '';
		}

		// Captcha
		if ( $this->config->get( $this->config->get( 'config_captcha' ) . '_status' ) && in_array( 'register', (array) $this->config->get( 'config_captcha_page' ) ) ) {
			$data['reg_captcha'] = $this->load->controller( 'captcha/' . $this->config->get( 'config_captcha' ), $this->error );
		} else {
			$data['reg_captcha'] = '';
		}

		if ( $this->config->get( 'config_account_id' ) ) {
			$this->load->model( 'catalog/information' );

			$information_info = $this->model_catalog_information->getInformation( $this->config->get( 'config_account_id' ) );

			if ( $information_info ) {
				$data['reg_text_agree'] = sprintf( $this->language->get( 'text_agree' ), $this->url->link( 'information/information/agree', 'information_id=' . $this->config->get( 'config_account_id' ), 'SSL' ), $information_info['title'], $information_info['title'] );
			} else {
				$data['reg_text_agree'] = '';
			}
		} else {
			$data['reg_text_agree'] = '';
		}

		if ( isset( $this->request->post['agree'] ) ) {
			$data['reg_agree'] = $this->request->post['agree'];
		} else {
			$data['reg_agree'] = false;
		}


		$data['column_left']    = $this->load->controller( 'common/column_left' );
		$data['column_right']   = $this->load->controller( 'common/column_right' );
		$data['content_top']    = $this->load->controller( 'common/content_top' );
		$data['content_bottom'] = $this->load->controller( 'common/content_bottom' );
		$data['footer']         = $this->load->controller( 'common/footer' );
		$data['header']         = $this->load->controller( 'common/header' );

		if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/template/account/login.tpl' ) ) {
			$this->response->setOutput( $this->load->view( $this->config->get( 'config_template' ) . '/template/account/login.tpl', $data ) );
		} else {
			$this->response->setOutput( $this->load->view( 'default/template/account/login.tpl', $data ) );
		}
	}

	public function setPaymentMethods() {

		// Totals
		$total_data = array();
		$total      = 0;
		$taxes      = $this->cart->getTaxes();


		$this->load->model( 'extension/extension' );

		$sort_order = array();

		$results = $this->model_extension_extension->getExtensions( 'total' );

		foreach ( $results as $key => $value ) {
			$sort_order[ $key ] = $this->config->get( $value['code'] . '_sort_order' );
		}

		array_multisort( $sort_order, SORT_ASC, $results );
		
		foreach ( $results as $result ) {
			if ( $this->config->get( $result['code'] . '_status' ) ) {
				$this->load->model( 'total/' . $result['code'] );

				$this->{'model_total_' . $result['code']}->getTotal( $total_data, $total, $taxes );
			}
		}

		// Payment Methods
		$method_data = array();

		$this->load->model( 'extension/extension' );

		$results = $this->model_extension_extension->getExtensions( 'payment' );

		$recurring = $this->cart->hasRecurringProducts();

		foreach ( $results as $result ) {
			if ( $this->config->get( $result['code'] . '_status' ) ) {
				$this->load->model( 'payment/' . $result['code'] );

				$method = $this->{'model_payment_' . $result['code']}->getMethod( $this->session->data['payment_address'], $total );

				if ( $method ) {
					if ( $recurring ) {
						if ( method_exists( $this->{'model_payment_' . $result['code']}, 'recurringPayments' ) && $this->{'model_payment_' . $result['code']}->recurringPayments() ) {
							$method_data[ $result['code'] ] = $method;
						}
					} else {
						$method_data[ $result['code'] ] = $method;
					}
				}
			}
		}

		$sort_order = array();

		foreach ( $method_data as $key => $value ) {
			$sort_order[ $key ] = $value['sort_order'];
		}

		array_multisort( $sort_order, SORT_ASC, $method_data );

		$this->session->data['payment_methods'] = $method_data;
	}


	private function validate_register() {
		if ( ( utf8_strlen( trim( $this->request->post['firstname'] ) ) < 1 ) || ( utf8_strlen( trim( $this->request->post['firstname'] ) ) > 32 ) ) {
			$this->error['firstname'] = $this->language->get( 'error_firstname' );
		}

		if ( ( utf8_strlen( trim( $this->request->post['lastname'] ) ) < 1 ) || ( utf8_strlen( trim( $this->request->post['lastname'] ) ) > 32 ) ) {
			$this->error['lastname'] = $this->language->get( 'error_lastname' );
		}

		if ( ( utf8_strlen( $this->request->post['email'] ) > 96 ) || ! preg_match( '/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'] ) ) {
			$this->error['email'] = $this->language->get( 'error_email' );
		}

		if ( $this->model_account_customer->getTotalCustomersByEmail( $this->request->post['email'] ) ) {
			$this->error['warning'] = $this->language->get( 'error_exists' );
		}

		if ( ( utf8_strlen( $this->request->post['telephone'] ) < 3 ) || ( utf8_strlen( $this->request->post['telephone'] ) > 32 ) ) {
			$this->error['telephone'] = $this->language->get( 'error_telephone' );
		}

		/*if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}*/

		/*if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}*/

		//$this->load->model('localisation/country');

		//$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		/*if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}*/

		/*if ($this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}*/

		/*if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
			$this->error['zone'] = $this->language->get('error_zone');
		}*/

		// Customer Group
		/*if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}*/

		// Custom field validation
		/*$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
				$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
			}
		}

		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		// Agree to terms
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}*/

		return ! $this->error;
	}

	protected function validate() {
		$this->event->trigger( 'pre.customer.login' );

		// Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts( $this->request->post['email'] );

		if ( $login_info && ( $login_info['total'] >= $this->config->get( 'config_login_attempts' ) ) && strtotime( '-1 hour' ) < strtotime( $login_info['date_modified'] ) ) {
			$this->error['warning'] = $this->language->get( 'error_attempts' );
		}

		// Check if customer has been approved.
		/*$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info) {
			$this->error['warning'] = $this->language->get('error_approved');
		}*/

		if ( ! $this->error ) {
			if ( ! $this->customer->login( $this->request->post['email'], $this->request->post['password'] ) ) {
				$this->error['warning'] = $this->language->get( 'error_login' );

				$this->model_account_customer->addLoginAttempt( $this->request->post['email'] );
			} else {
				$this->model_account_customer->deleteLoginAttempts( $this->request->post['email'] );
			}
		}

		return ! $this->error;
	}

	private function validate_phone( $phone ) {
		return $phone;
	}
	private function validate_name( $name ) {
		return $name;
	}

	private $customer_info = [];

	protected function validate_guest() {

		if ( ! isset( $this->request->post['telephone'] ) ) {
			$this->error['telephone'] = $this->language->get( 'error_telephone_login' );
		}

		$phone          = $this->validate_phone( $this->request->post['telephone'] );
		$get_guest_name = $this->validate_name($this->request->post['guest_name']);
		if ( empty( $phone ) ) {
			$this->error['telephone'] = $this->language->get( 'error_telephone_incorrect' );
		}
		$this->guest_name     = $get_guest_name;
		$this->validate_phone = $phone;

		// Check if customer has been approved.
//        $customer_info = $this->model_account_customer->getCustomerByTelephone($phone); // HV-38

		if ( ! empty( $customer_info ) ) {
			$this->customer_info = $customer_info;
		}
		// elseif($customer_info) {
		//     $this->error['warning'] = $this->language->get('error_telephone_is_user');
		// }


		return ! $this->error;
	}
}
