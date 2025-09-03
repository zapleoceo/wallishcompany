<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutCart extends Controller {
	
	public function index() {

		$this->load->language( 'checkout/cart' );

		$this->document->setTitle( $this->language->get( 'heading_title' ) );

		if ( isset( $this->session->data['payment_address'] ) ) {
			unset( $this->session->data['payment_address'] );
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link( 'common/home' ),
			'text' => $this->language->get( 'text_home' )
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link( 'checkout/cart' ),
			'text' => $this->language->get( 'heading_title' )
		);

		$this->document->addScript( STYLE_PATH . 'js/cart.js' . CSSJS );

		if ( $this->cart->hasProducts() || ! empty( $this->session->data['vouchers'] ) ) {
			$data['heading_title'] = $this->language->get( 'heading_title' );

			$data['text_recurring_item'] = $this->language->get( 'text_recurring_item' );
			$data['text_next']           = $this->language->get( 'text_next' );
			$data['text_next_choice']    = $this->language->get( 'text_next_choice' );

			$data['column_image']    = $this->language->get( 'column_image' );
			$data['column_name']     = $this->language->get( 'column_name' );
			$data['column_model']    = $this->language->get( 'column_model' );
			$data['column_quantity'] = $this->language->get( 'column_quantity' );
			$data['column_price']    = $this->language->get( 'column_price' );
			$data['column_total']    = $this->language->get( 'column_total' );

			$data['button_update']     = $this->language->get( 'button_update' );
			$data['button_remove']     = $this->language->get( 'button_remove' );
			$data['button_shopping']   = $this->language->get( 'button_shopping' );
			$data['button_checkout']   = $this->language->get( 'button_checkout' );
			$data['text_steps_more']   = $this->language->get( 'text_steps_more' );
			$data['text_continue_bay'] = $this->language->get( 'text_continue_bay' );
			$data['topmenu']           = $this->load->controller( 'checkout/cart/getmenu', 'cart' );
			$data['link_step_2']       = $this->url->link( 'checkout/checkout', '', true );
			$data['link_catalog']      = rtrim( $this->url->link( 'product/category', '' . '&category_id=' . 69 ) ) . '/';


			if ( ! $this->cart->hasStock() && ( ! $this->config->get( 'config_stock_checkout' ) || $this->config->get( 'config_stock_warning' ) ) ) {
				$data['error_warning'] = $this->language->get( 'error_stock' );
			} elseif ( isset( $this->session->data['error'] ) ) {
				$data['error_warning'] = $this->session->data['error'];

				unset( $this->session->data['error'] );
			} else {
				$data['error_warning'] = '';
			}

			if ( $this->config->get( 'config_customer_price' ) && ! $this->customer->isLogged() ) {
				$data['attention'] = sprintf( $this->language->get( 'text_login' ), $this->url->link( 'account/login' ), $this->url->link( 'account/register' ) );
			} else {
				$data['attention'] = '';
			}

			if ( isset( $this->session->data['success'] ) ) {
				$data['success'] = $this->session->data['success'];

				unset( $this->session->data['success'] );
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link( 'checkout/cart/edit', '', true );

			if ( $this->config->get( 'config_cart_weight' ) ) {
				$data['weight'] = $this->weight->format( $this->cart->getWeight(), $this->config->get( 'config_weight_class_id' ), $this->language->get( 'decimal_point' ), $this->language->get( 'thousand_point' ) );
			} else {
				$data['weight'] = '';
			}

			$this->load->model( 'tool/image' );
			$this->load->model( 'tool/upload' );

			$this->load->model( 'catalog/product' );
			$this->load->model( 'catalog/category' );

			$data['products'] = array();

			$products = $this->cart->getProducts();
			
//			echo '<pre>';
//			var_dump($products);
//			echo '</pre>';
			foreach ( $products as $product ) {
				$product_total = 0;

				foreach ( $products as $product_2 ) {
					if ( $product_2['product_id'] == $product['product_id'] ) {
						$product_total += $product_2['quantity'];
					}
				}

				if ( $product['minimum'] > $product_total ) {
					$data['error_warning'] = sprintf( $this->language->get( 'error_minimum' ), $product['name'], $product['minimum'] );
				}

				if ( $product['image'] ) {
					$image = $this->model_tool_image->resize( $product['image'], $this->config->get( 'config_image_cart_width' ), $this->config->get( 'config_image_cart_height' ) );
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ( $product['option'] as $option ) {
					if ( $option['type'] != 'file' ) {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode( $option['value'] );

						if ( $upload_info ) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => ( utf8_strlen( $value ) > 20 ? utf8_substr( $value, 0, 20 ) . '..' : $value )
					);
				}

				// Display prices
				if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || ! $this->config->get( 'config_customer_price' ) ) {
					$price = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) );
				} else {
					$price = false;
				}

				// Display prices
				if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || ! $this->config->get( 'config_customer_price' ) ) {
					$total = $this->currency->format( $this->tax->calculate( $product['price'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) * $product['quantity'] );
				} else {
					$total = false;
				}

				$recurring = '';

				if ( $product['recurring'] ) {
					$frequencies = array(
						'day'        => $this->language->get( 'text_day' ),
						'week'       => $this->language->get( 'text_week' ),
						'semi_month' => $this->language->get( 'text_semi_month' ),
						'month'      => $this->language->get( 'text_month' ),
						'year'       => $this->language->get( 'text_year' ),
					);

					if ( $product['recurring']['trial'] ) {
						$recurring = sprintf( $this->language->get( 'text_trial_description' ), $this->currency->format( $this->tax->calculate( $product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) ), $product['recurring']['trial_cycle'], $frequencies[ $product['recurring']['trial_frequency'] ], $product['recurring']['trial_duration'] ) . ' ';
					}

					if ( $product['recurring']['duration'] ) {
						$recurring .= sprintf( $this->language->get( 'text_payment_description' ), $this->currency->format( $this->tax->calculate( $product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) ), $product['recurring']['cycle'], $frequencies[ $product['recurring']['frequency'] ], $product['recurring']['duration'] );
					} else {
						$recurring .= sprintf( $this->language->get( 'text_payment_cancel' ), $this->currency->format( $this->tax->calculate( $product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get( 'config_tax' ) ) ), $product['recurring']['cycle'], $frequencies[ $product['recurring']['frequency'] ], $product['recurring']['duration'] );
					}
				}


				// get category
				$product_categories = $this->model_catalog_product->getCategories( $product['product_id'] );
				$main_category_id   = 0;
				if ( ! empty( $product_categories ) ) {
					foreach ( $product_categories as $pcat ) {
						if ( $pcat['main_category'] == 1 ) {
							$main_category_id = $pcat['category_id'];
						}
					}

					if ( empty( $main_category_id ) ) {
						foreach ( $product_categories as $pcat ) {
							if ( $pcat['main_category'] != 1 ) {
								$main_category_id = $pcat['category_id'];
							}
						}
					}
				}

				$category      = '';
				$category_href = '';
				if ( $main_category_id ) {
					$category      = $this->model_catalog_category->getCategory( $main_category_id );
					$category_href = $this->url->link( 'product/category', 'path=' . $category['category_id'] );
					$category      = $category['name'];
				}
				// get category


				$data['products'][] = array(
					'cart_id'       => $product['cart_id'],
					'thumb'         => $image,
					'name'          => $product['name'],
					'model'         => $product['model'],
					'option'        => $option_data,
					'recurring'     => $recurring,
					'category'      => $category,
					'category_href' => $category_href,
					'quantity'      => $product['quantity'],
					'stock'         => $product['stock'] ? true : ! ( ! $this->config->get( 'config_stock_checkout' ) || $this->config->get( 'config_stock_warning' ) ),
					'reward'        => ( $product['reward'] ? sprintf( $this->language->get( 'text_points' ), $product['reward'] ) : '' ),
					'price'         => $price,
					'total'         => $total,
					'href'          => $this->url->link( 'product/product', 'product_id=' . $product['product_id'] ),

					'minimum' => $product['minimum'],
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if ( ! empty( $this->session->data['vouchers'] ) ) {
				foreach ( $this->session->data['vouchers'] as $key => $voucher ) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format( $voucher['amount'] ),
						'remove'      => $this->url->link( 'checkout/cart', 'remove=' . $key )
					);
				}
			}

			// Totals
			$this->load->model( 'extension/extension' );

			$total_data = array();
			$total      = 0;
			$taxes      = $this->cart->getTaxes();

			// Display prices
			if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || ! $this->config->get( 'config_customer_price' ) ) {
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

				$sort_order = array();

				foreach ( $total_data as $key => $value ) {
					$sort_order[ $key ] = $value['sort_order'];
				}

				array_multisort( $sort_order, SORT_ASC, $total_data );

				$total_data = $this->load->controller( 'module/custmer_group_by_summ/productsAddSale', $total_data );
			}

			$data['totals'] = array();

			foreach ( $total_data as $total ) {
//			    var_dump($total);
				$data['totals'][] = array(
					'title'   => $total['title'],
					'percent' => isset( $total['percent'] ) ? $total['percent'] : 0,
					'code'    => $total['code'],
					'text'    => $this->currency->format( $total['value'] )
				);
			}
//			var_dump($data["totals"]);  //  TODO remove
			$data['continue'] = $this->url->link( 'common/home' );

			$data['checkout'] = $this->url->link( 'checkout/checkout', '', 'SSL' );

			$this->load->model( 'extension/extension' );

			$data['checkout_buttons'] = array();

			$files = glob( DIR_APPLICATION . '/controller/total/*.php' );

			if ( $files ) {
				foreach ( $files as $file ) {
					$extension          = basename( $file, '.php' );
					$data[ $extension ] = $this->load->controller( 'total/' . $extension );
				}
			}

			$data['column_left']    = $this->load->controller( 'common/column_left' );
			$data['column_right']   = $this->load->controller( 'common/column_right' );
			$data['content_top']    = $this->load->controller( 'common/content_top' );
			$data['content_bottom'] = $this->load->controller( 'common/content_bottom' );
			$data['footer']         = $this->load->controller( 'common/footer', array( 'nosubscribe' => 1 ) );
			$data['header']         = $this->load->controller( 'common/header' );

			// min order
			$minOrder                     = (int) $this->config->get( 'config_fax' );
			$total                        = $this->getTotal();
//            var_dump($total);

            $data['disable_order']        = ( $total < $minOrder ) ? true : false;
			$data['min_order_str']        = $this->currency->format( $minOrder );
			$data['min_order_str_adding'] = $this->currency->format( $minOrder - $total );

			$data['text_min_summ_order'] = $this->language->get( 'text_min_summ_order' );
			$data['text_adding']         = $this->language->get( 'text_adding' );
			$data['text_to_order']       = $this->language->get( 'text_to_order' );
			// @end min order

            $data['text_check_cart']     = $this->language->get( 'text_check_cart' );

            if ($this->customer->isLogged()) {
                $data['attention_trigger'] = 1;
            } else {
                $data['attention_trigger'] = 0;
            }

			$data['text_not_order']       = $this->language->get( 'text_not_order' );
			$data['text_column_category'] = $this->language->get( 'text_column_category' );
			if ( isset($_POST['ajaxForm'])) {
				$this->response->setOutput( $this->load->view( 'default/template/checkout/cart-part.tpl', $data ) );
			} else if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/template/checkout/cart.tpl' ) ) {
				$this->response->setOutput( $this->load->view( $this->config->get( 'config_template' ) . '/template/checkout/cart.tpl', $data ) );
			} else {
				$this->response->setOutput( $this->load->view( 'default/template/checkout/cart.tpl', $data ) );
			}
		} else {
			$data['heading_title'] = $this->language->get( 'heading_title' );

			$data['text_error'] = $this->language->get( 'text_empty' );

			$data['button_continue'] = $this->language->get( 'button_continue' );

			$data['continue'] = $this->url->link( 'common/home' );

			unset( $this->session->data['success'] );

			$data['column_left']    = $this->load->controller( 'common/column_left' );
			$data['column_right']   = $this->load->controller( 'common/column_right' );
			$data['content_top']    = $this->load->controller( 'common/content_top' );
			$data['content_bottom'] = $this->load->controller( 'common/content_bottom' );
			$data['footer']         = $this->load->controller( 'common/footer' );
			$data['header']         = $this->load->controller( 'common/header' );

			if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/template/error/not_found.tpl' ) ) {
				$this->response->setOutput( $this->load->view( $this->config->get( 'config_template' ) . '/template/error/not_found.tpl', $data ) );
			} else {
				$this->response->setOutput( $this->load->view( 'default/template/error/not_found.tpl', $data ) );
			}
		}
	}

	protected function getTotal() {
		// Totals
		$this->load->model( 'extension/extension' );

		$total_data = array();
		$total      = 0;
		$taxes      = $this->cart->getTaxes();

		// Display prices
		// if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || ! $this->config->get( 'config_customer_price' ) ) {
		// 	$sort_order = array();

		// 	$results = $this->model_extension_extension->getExtensions( 'total' );

		// 	foreach ( $results as $key => $value ) {
		// 		$sort_order[ $key ] = $this->config->get( $value['code'] . '_sort_order' );
		// 	}

		// 	array_multisort( $sort_order, SORT_ASC, $results );

		// 	foreach ( $results as $result ) {
		// 		if ( $this->config->get( $result['code'] . '_status' ) ) {
		// 			$this->load->model( 'total/' . $result['code'] );

		// 			$this->{'model_total_' . $result['code']}->getTotal( $total_data, $total, $taxes );
		// 		}
		// 	}

		// 	$sort_order = array();

		// 	foreach ( $total_data as $key => $value ) {
		// 		$sort_order[ $key ] = $value['sort_order'];
		// 	}

		// 	array_multisort( $sort_order, SORT_ASC, $total_data );
		// }

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

		return (int) $total;
	}

	public function getmenu( $active ) {
		$this->load->language( 'checkout/cart' );

		$data['text_steps_cart']    = $this->language->get( 'text_steps_cart' );
		$data['text_steps_login']   = $this->language->get( 'text_steps_login' );
		$data['text_steps_shiping'] = $this->language->get( 'text_steps_shiping' );
		$data['text_steps_pay']     = $this->language->get( 'text_steps_pay' );

		$data['link_step_1'] = $this->url->link( 'checkout/cart', '', true );
		$data['link_step_2'] = $this->url->link( 'checkout/checkout', '', true );
		$data['link_step_3'] = $this->url->link( 'checkout/checkout', 'step=3', true );
		$data['link_step_4'] = $this->url->link( 'checkout/checkout', 'step=4', true );

		$data['active'] = $active;

		return $this->load->view( $this->config->get( 'config_template' ) . '/template/checkout/top_menu.tpl', $data );
	}

	public function add() {
		$this->load->language( 'checkout/cart' );

		$json = array();

		if ( isset( $this->request->post['product_id'] ) ) {
			$product_id = (int) $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model( 'catalog/product' );

		$product_info = $this->model_catalog_product->getProduct( $product_id );
		/*$product_data = $this->load->controller('module/custmer_group_by_summ/getPrices', array($product_id => $product_info));

		$product_info['price'] = (isset($product_data[$product_id]) && (int)$product_data[$product_id]['price'] > 0) ? $product_data[$product_id]['price'] : $product_info['price'];*/

		if ( $product_info ) {
			if ( isset( $this->request->post['quantity'] ) && ( (int) $this->request->post['quantity'] >= $product_info['minimum'] ) ) {
				$quantity = (int) $this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}

			if ( isset( $this->request->post['option'] ) ) {
				$option = array_filter( $this->request->post['option'] );
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions( $this->request->post['product_id'] );

			foreach ( $product_options as $product_option ) {
				if ( $product_option['required'] && empty( $option[ $product_option['product_option_id'] ] ) ) {
					$json['error']['option'][ $product_option['product_option_id'] ] = sprintf( $this->language->get( 'error_required' ), $product_option['name'] );
				}
			}

			if ( isset( $this->request->post['recurring_id'] ) ) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles( $product_info['product_id'] );

			if ( $recurrings ) {
				$recurring_ids = array();

				foreach ( $recurrings as $recurring ) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if ( ! in_array( $recurring_id, $recurring_ids ) ) {
					$json['error']['recurring'] = $this->language->get( 'error_recurring_required' );
				}
			}

			if ( ! $json ) {
				$this->cart->add( $this->request->post['product_id'], $quantity, $option, $recurring_id );

				$json['success'] = sprintf( $this->language->get( 'text_success' ), $this->url->link( 'product/product', 'product_id=' . $this->request->post['product_id'] ), $product_info['name'], $this->url->link( 'checkout/cart' ) );

				// Unset all shipping and payment methods
				unset( $this->session->data['shipping_method'] );
				unset( $this->session->data['shipping_methods'] );
				unset( $this->session->data['payment_method'] );
				unset( $this->session->data['payment_methods'] );

				// Totals
				$this->load->model( 'extension/extension' );

				$total_data = array();
				$total      = 0;
				$taxes      = $this->cart->getTaxes();

				// Display prices
				if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || ! $this->config->get( 'config_customer_price' ) ) {
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

					$sort_order = array();

					foreach ( $total_data as $key => $value ) {
						$sort_order[ $key ] = $value['sort_order'];
					}

					array_multisort( $sort_order, SORT_ASC, $total_data );
				}

				$total_str     = $this->currency->format( $total );
				$total_str     = str_replace( '.00', '', $total_str );
				$json['total'] = array( $total, $total_str );

			} else {
				$json['redirect'] = str_replace( '&amp;', '&', $this->url->link( 'product/product', 'product_id=' . $this->request->post['product_id'] ) );
			}
		}

		$this->response->addHeader( 'Content-Type: application/json' );
		$this->response->setOutput( json_encode( $json ) );
	}

	public function editCart() {

		$this->load->language( 'checkout/cart' );

		$json = array();

		// Update
		if ( ! empty( $this->request->post['quantity'] ) ) {

			$this->cart->update( $this->request->post['key'], $this->request->post['quantity'] );
			unset( $this->session->data['shipping_method'] );
			unset( $this->session->data['shipping_methods'] );
			unset( $this->session->data['payment_method'] );
			unset( $this->session->data['payment_methods'] );
			unset( $this->session->data['reward'] );

		}
//		var_dump($this);
//		die();
		$total     = $this->getTotal();
		$total_str = $this->currency->format( $total );
		$total_str = str_replace( '.00', '', $total_str );


		$json['total'] = sprintf( $this->currency->format( $this->cart->getTotal() ) );
//		$json['subtotal'] = $this->cart->getTotal($json['total'],$this->cart->getTaxes());
		$json = array(
			'ok'    => true,
			'total' => array( $total, $total_str ),
			'html'  => $this->index()
		);
		$this->response->addHeader( 'Content-Type: application/json' );
		$this->response->setOutput( json_encode( $json ) );
	}

	public function edit() {
		$this->load->language( 'checkout/cart' );


		// Update
		if ( ! empty( $this->request->post['quantity'] ) && ! isset( $this->request->post['key'] ) ) {


			foreach ( $this->request->post['quantity'] as $key => $value ) {
				$this->cart->update( $key, $value );
			}

			if ( isset( $this->request->post['top'] ) && $this->request->post['top'] == 1 ) {
				$this->response->redirect( $_SERVER['HTTP_REFERER'] );
			}

			unset( $this->session->data['shipping_method'] );
			unset( $this->session->data['shipping_methods'] );
			unset( $this->session->data['payment_method'] );
			unset( $this->session->data['payment_methods'] );
			unset( $this->session->data['reward'] );
		}

		if ( isset( $this->request->post['quantity'] ) && isset( $this->request->post['key'] ) ) {
			$this->cart->update( (int) $this->request->post['key'], (int) $this->request->post['quantity'] );

			$json          = array();
			$total         = $this->getTotal();
			$total_str     = $this->currency->format( $total );
			$total_str     = str_replace( '.00', '', $total_str );
			$json['total'] = array( $total, $total_str );

			$this->response->addHeader( 'Content-Type: application/json' );
			$this->response->setOutput( json_encode( $json ) );

			return;
		}


		$this->response->redirect( $this->url->link( 'checkout/cart' ) );
	}

	public function remove() {
		$this->load->language( 'checkout/cart' );

		$json = array();

		// Remove
		if ( isset( $this->request->post['key'] ) ) {
			$this->cart->remove( $this->request->post['key'] );

			unset( $this->session->data['vouchers'][ $this->request->post['key'] ] );

			$this->session->data['success'] = $this->language->get( 'text_remove' );

			unset( $this->session->data['shipping_method'] );
			unset( $this->session->data['shipping_methods'] );
			unset( $this->session->data['payment_method'] );
			unset( $this->session->data['payment_methods'] );
			unset( $this->session->data['reward'] );

			// Totals
			$this->load->model( 'extension/extension' );

			$total_data = array();
			$total      = 0;
			$taxes      = $this->cart->getTaxes();

			// Display prices
			if ( ( $this->config->get( 'config_customer_price' ) && $this->customer->isLogged() ) || ! $this->config->get( 'config_customer_price' ) ) {
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

				$sort_order = array();

				foreach ( $total_data as $key => $value ) {
					$sort_order[ $key ] = $value['sort_order'];
				}

				array_multisort( $sort_order, SORT_ASC, $total_data );
			}
			$total_str     = $this->currency->format( $total );
			$total_str     = str_replace( '.00', '', $total_str );
			$json['total'] = array( $total, $total_str );
		}

		$this->response->addHeader( 'Content-Type: application/json' );
		$this->response->setOutput( json_encode( $json ) );
	}
}