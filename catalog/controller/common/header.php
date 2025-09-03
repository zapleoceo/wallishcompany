<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonHeader extends Controller {
	public function index() {

		if ( $this->request->server['HTTPS'] ) {
			$server = $this->config->get( 'config_ssl' );
		} else {
			$server = $this->config->get( 'config_url' );
		}

		if ( is_file( DIR_IMAGE . $this->config->get( 'config_icon' ) ) ) {
			$this->document->addLink( $server . 'image/' . $this->config->get( 'config_icon' ), 'icon' );
		}

		$data['title'] = $this->document->getTitle();

		$data['base']        = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords']    = $this->document->getKeywords();
		$data['links']       = $this->document->getLinks();
		$data['robots']      = $this->document->getRobots();
		$data['styles']      = $this->document->getStyles();
		$data['scripts']     = $this->document->getScripts();
		$data['lang']        = $this->language->get( 'code' );
		$data['direction']   = $this->language->get( 'direction' );

		$data['name'] = $this->config->get( 'config_name' );

		if ( is_file( DIR_IMAGE . $this->config->get( 'config_logo' ) ) ) {
			$data['logo'] = $server . 'image/' . $this->config->get( 'config_logo' );
		} else {
			$data['logo'] = '';
		}

		$this->load->language( 'common/header' );
        $data['og_image'] = $this->document->getOgImage();

		$data['js_translation'] = $this->language->get( 'arr_js_translation' );

		$data['text_home'] = $this->language->get( 'text_home' );

		// Wishlist
		if ( $this->customer->isLogged() ) {
			$this->load->model( 'account/wishlist' );

			$data['text_wishlist'] = sprintf( $this->language->get( 'text_wishlist' ), $this->model_account_wishlist->getTotalWishlist() );
		} else {
			$data['text_wishlist'] = sprintf( $this->language->get( 'text_wishlist' ), ( isset( $this->session->data['wishlist'] ) ? count( $this->session->data['wishlist'] ) : 0 ) );
		}

		$data['text_shopping_cart'] = $this->language->get( 'text_shopping_cart' );
		$data['text_logged']        = sprintf( $this->language->get( 'text_logged' ), $this->url->link( 'account/account', '', 'SSL' ), $this->customer->getFirstName(), $this->url->link( 'account/logout', '', 'SSL' ) );

		$data['text_account']      = $this->language->get( 'text_account' );
		$data['text_register']     = $this->language->get( 'text_register' );
		$data['text_login']        = $this->language->get( 'text_login' );
		$data['text_order']        = $this->language->get( 'text_order' );
		$data['text_transaction']  = $this->language->get( 'text_transaction' );
		$data['text_download']     = $this->language->get( 'text_download' );
		$data['text_logout']       = $this->language->get( 'text_logout' );
		$data['text_checkout']     = $this->language->get( 'text_checkout' );
		$data['text_category']     = $this->language->get( 'text_category' );
		$data['text_all']          = $this->language->get( 'text_all' );
		$data['text_account_user'] = $this->language->get( 'text_account_user' );


		$data['home']          = $this->url->link( 'common/home' );
		$data['wishlist']      = $this->url->link( 'account/wishlist', '', 'SSL' );
		$data['logged']        = $this->customer->isLogged();
		$data['account']       = $this->url->link( 'account/account', '', 'SSL' );
		$data['register']      = $this->url->link( 'account/register', '', 'SSL' );
		$data['login']         = $this->url->link( 'account/login', '', 'SSL' );
		$data['order']         = $this->url->link( 'account/order', '', 'SSL' );
		$data['transaction']   = $this->url->link( 'account/transaction', '', 'SSL' );
		$data['download']      = $this->url->link( 'account/download', '', 'SSL' );
		$data['logout']        = $this->url->link( 'account/logout', '', 'SSL' );
		$data['shopping_cart'] = $this->url->link( 'checkout/cart' );

		$data['link_facebook']   = $this->config->get( 'config_link_facebook' );
		$data['link_instagramm'] = $this->config->get( 'config_link_instagramm' );
		$data['link_pinterest']  = $this->config->get( 'config_link_pinterest' );


		$data['checkout']  = $this->url->link( 'checkout/checkout', '', 'SSL' );
		$data['contact']   = $this->url->link( 'information/contact' );
		$data['telephone'] = $this->config->get( 'config_telephone' );
		$data['login']     = $this->url->link( 'account/account' );

		$status = true;

		if ( isset( $this->request->server['HTTP_USER_AGENT'] ) ) {
			$robots = explode( "\n", str_replace( array(
				"\r\n",
				"\r"
			), "\n", trim( $this->config->get( 'config_robots' ) ) ) );

			foreach ( $robots as $robot ) {
				if ( $robot && strpos( $this->request->server['HTTP_USER_AGENT'], trim( $robot ) ) !== false ) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model( 'design/menu' );
		$this->load->model( 'catalog/category' );
		$this->load->model( 'catalog/product' );

        $data['catalog_cat'] = $this->url->link('category/category', 'category_id=59');
        $catalog_cat_info = $this->model_catalog_category->getCategory(59);
        $data['text_catalog_cat'] = $catalog_cat_info['name'] ?? '';

        $data['sale_cat'] = array(
            'href' => $this->url->link('product/category', 'path=59&sale=1&limit=500'),
            'name' => $this->language->get('sale'),
            'count' => $this->model_catalog_category->getCategoriesTotalSale(59)
        );

        $data['new_cat'] = array(
            'href'  => $this->url->link('product/category', 'path=59&new=1&limit=500'),
            'name'  => $this->language->get('new'),
            'count' => $this->model_catalog_category->getCategoriesTotalNew(59)
        );

        $data['fete_cat'] = array(
            'href'  => $this->url->link('product/category', 'path=59&fete=1&limit=500'),
            'name'  => $this->language->get('fete'),
            'count' => $this->model_catalog_category->getCategoriesTotalFete(59),
            'disable' => 0
        );

		$data['categories'] = array();

		if ( $this->config->get( 'configmenu_menu' ) ) {
			$menus      = $this->model_design_menu->getMenus();
			$menu_child = $this->model_design_menu->getChildMenus();

			foreach ( $menus as $id => $menu ) {
				$children_data = array();

				foreach ( $menu_child as $child_id => $child_menu ) {
					if ( ( $menu['menu_id'] != $child_menu['menu_id'] ) or ! is_numeric( $child_id ) ) {
						continue;
					}

					$child_name = '';

					if ( ( $menu['menu_type'] == 'category' ) and ( $child_menu['menu_type'] == 'category' ) ) {
						$filter_data = array(
							'filter_category_id'  => $child_menu['link'],
							'filter_sub_category' => true
						);

						$child_name = ( $this->config->get( 'config_product_count' ) ? ' (' . $this->model_catalog_product->getTotalProducts( $filter_data ) . ')' : '' );
					}

					$children_data[] = array(
						'name' => $child_menu['name'] . $child_name,
						'href' => $this->getMenuLink( $menu, $child_menu )
					);
				}

				$data['categories'][] = array(
					'name'     => $menu['name'],
					'children' => $children_data,
					'column'   => $menu['columns'] ? $menu['columns'] : 1,
					'href'     => $this->getMenuLink( $menu )
				);
			}

		} else {

			$categories = $this->model_catalog_category->getCategories( 59 );

			foreach ( $categories as $category ) {
				//if ( $category['top'] ) {
					// Level 2
					$children_data = array();

					$children = $this->model_catalog_category->getCategories( $category['category_id'] );

					foreach ( $children as $child ) {
						$filter_data = array(
							'filter_category_id'  => $child['category_id'],
							'filter_sub_category' => true
						);

						$children_data[] = array(
							'name' => $child['name'] . ( $this->config->get( 'config_product_count' ) ? ' (' . $this->model_catalog_product->getTotalProducts( $filter_data ) . ')' : '' ),
							'href' => $this->url->link( 'product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] )
						);
					}

                    $filter_data = array(
                        'filter_category_id'  => $category['category_id'],
                    );

					// Level 1
					$data['categories'][] = array(
						'name'     => $category['name'] . ( $this->config->get( 'config_product_count' ) ? ' (' . $this->model_catalog_product->getTotalProducts( $filter_data ) . ')' : '' ),
						'children' => $children_data,
						'column'   => $category['column'] ? $category['column'] : 1,
						'href'     => $this->url->link( 'product/category', 'path=' . $category['category_id'] )
					);
				//}
			}

		}

		$data['language']  = $this->load->controller( 'common/language' );
		$data['currency']  = $this->load->controller( 'common/currency' );
		$data['cart_link'] = $this->url->link( 'checkout/cart', '', true );
		if ( $this->config->get( 'configblog_blog_menu' ) ) {
			$data['menu'] = $this->load->controller( 'blog/menu' );
		} else {
			$data['menu'] = '';
		}
		$data['search']   = $this->load->controller( 'common/search' );
		$data['cart']     = $this->load->controller( 'common/cart' );
		$data['wishlist'] = $this->load->controller( 'common/wishlist' );
		// For page specific css
		if ( isset( $this->request->get['route'] ) ) {
			if ( isset( $this->request->get['product_id'] ) ) {
				$class = '-' . $this->request->get['product_id'];
			} elseif ( isset( $this->request->get['path'] ) ) {
				$class = '-' . $this->request->get['path'];
			} elseif ( isset( $this->request->get['manufacturer_id'] ) ) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace( '/', '-', $this->request->get['route'] ) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		$data['text_other_view'] = $this->language->get( 'text_other_view' );
		$data['text_go_shop'] = $this->language->get( 'text_go_shop' );
		$data['text_tootop']     = $this->language->get( 'text_tootop' );

		$data['top_block_text_1'] = $this->language->get( 'top_block_text_1' );
		$data['top_block_text_2'] = $this->language->get( 'top_block_text_2' );
		$data['top_block_text_3'] = $this->language->get( 'top_block_text_3' );
		$data['top_block_link']	  = $this->url->link('information/information', 'information_id=16', true);

		$data['email']          = $this->config->get( 'config_email' );
		$data['banner_home']    = $this->load->controller( 'module/banner/get', array( 'banner_id' => 7 ) );
		$data['banner_home_en'] = $this->load->controller( 'module/banner/get', array( 'banner_id' => 9 ) );
        $data['banner_home_uk'] = $this->load->controller( 'module/banner/get', array( 'banner_id' => 12 ) );

		$data['text_1']    = $this->load->controller( 'blog/article/get', array( 'article_id' => 130 ) );
		$data['text_menu'] = $this->language->get( 'text_menu' );

		$data['total_cart'] = $this->getTotal();

		$this->load->language( 'account/account' );

		$data['user_heading_title']      = $this->language->get( 'heading_title' );
		$data['user_text_my_account']    = $this->language->get( 'text_my_account' );
		$data['user_text_my_orders']     = $this->language->get( 'text_my_orders' );
		$data['user_text_my_newsletter'] = $this->language->get( 'text_my_newsletter' );
		$data['user_text_edit']          = $this->language->get( 'text_edit' );
		$data['user_text_password']      = $this->language->get( 'text_password' );
		$data['user_text_address']       = $this->language->get( 'text_address' );
		$data['user_text_wishlist']      = $this->language->get( 'text_wishlist' );
		$data['user_text_order']         = $this->language->get( 'text_order' );
		$data['user_text_download']      = $this->language->get( 'text_download' );
		$data['user_text_reward']        = $this->language->get( 'text_reward' );
		$data['user_text_return']        = $this->language->get( 'text_return' );
		$data['user_text_transaction']   = $this->language->get( 'text_transaction' );
		$data['user_text_newsletter']    = $this->language->get( 'text_newsletter' );
		$data['user_text_recurring']     = $this->language->get( 'text_recurring' );
		$data['user_text_mycards']       = $this->language->get( 'text_mycards' );
		$data['user_text_logout']        = $this->language->get( 'text_logout' );


		$data['user_logout']      = $this->url->link( 'account/logout', '', 'SSL' );
		$data['user_edit']        = $this->url->link( 'account/account', '', 'SSL' );
		$data['user_password']    = $this->url->link( 'account/password', '', 'SSL' );
		$data['user_address']     = $this->url->link( 'account/address', '', 'SSL' );
		$data['user_wishlist']    = $this->url->link( 'account/wishlist' );
		$data['user_order']       = $this->url->link( 'account/order', '', 'SSL' );
		$data['user_download']    = $this->url->link( 'account/download', '', 'SSL' );
		$data['user_return']      = $this->url->link( 'account/return', '', 'SSL' );
		$data['user_transaction'] = $this->url->link( 'account/transaction', '', 'SSL' );
		$data['user_newsletter']  = $this->url->link( 'account/newsletter', '', 'SSL' );
		$data['user_recurring']   = $this->url->link( 'account/recurring', '', 'SSL' );
		$data['user_mycards']     = $this->url->link( 'account/address/mycards', '', 'SSL' );

		$data['logged'] = $this->customer->isLogged();


		if ( file_exists( DIR_TEMPLATE . $this->config->get( 'config_template' ) . '/template/common/header.tpl' ) ) {
			return $this->load->view( $this->config->get( 'config_template' ) . '/template/common/header.tpl', $data );
		} else {
			return $this->load->view( 'default/template/common/header.tpl', $data );
		}
	}

	public function getMenuLink( $parent, $child = null ) {
		if ( $this->config->get( 'configmenu_menu' ) ) {
			$item = empty( $child ) ? $parent : $child;

			switch ( $item['menu_type'] ) {
				case 'category':
					$route = 'product/category';

					if ( ! empty( $child ) ) {
						$args = 'path=' . $parent['link'] . '_' . $item['link'];
					} else {
						$args = 'path=' . $item['link'];
					}
					break;
				case 'product':
					$route = 'product/product';
					$args  = 'product_id=' . $item['link'];
					break;
				case 'manufacturer':
					$route = 'product/manufacturer/info';
					$args  = 'manufacturer_id=' . $item['link'];
					break;
				case 'information':
					$route = 'information/information';
					$args  = 'information_id=' . $item['link'];
					break;
				default:
					$tmp = explode( '&', str_replace( 'index.php?route=', '', $item['link'] ) );

					if ( ! empty( $tmp ) ) {
						$route = $tmp[0];
						unset( $tmp[0] );
						$args = ( ! empty( $tmp ) ) ? implode( '&', $tmp ) : '';
					} else {
						$route = $item['link'];
						$args  = '';
					}

					break;
			}

			$check     = stripos( $item['link'], 'http' );
			$checkbase = strpos( $item['link'], '/' );
			if ( $check === 0 || $checkbase === 0 ) {
				$link = $item['link'];
			} else {
				$link = $this->url->link( $route, $args );
			}

			return $link;
		}
	}

	protected function getTotal() {
		$this->load->language( 'common/cart' );

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

		$total_str = str_replace( '.00', '', $this->currency->format( $total ) );

		return array( $total, $total_str );
	}
}
