<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerProductCategory extends Controller {
	public function index() {
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
			$this->document->setRobots('noindex,follow');
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
			$this->document->setRobots('noindex,follow');
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
			$this->document->setRobots('noindex,follow');
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
			$this->document->setRobots('noindex,follow');
		} else {
			$limit = $this->config->get('config_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

        $data['text_category_subtitle'] = '';

		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_catalog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path=' . $path . $url)
					);
				}
			}
		} else {
			$category_id = 0;
		}

        $this->document->addScript(STYLE_PATH . 'js/category.js' . CSSJS);

		$category_info = $this->model_catalog_category->getCategory($category_id);

		// begin: get child category
        $category_children = $this->model_catalog_category->getCategories($category_id);

        foreach ($category_children as $category) {
            $filter_data = array(
                'filter_category_id'  => $category['category_id'],
            );

            $data['category_children'][] = array(
                'category_id' => $category['category_id'],
                'name' => $category['name'] . ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')',
                'thumb' => !empty($category['image']) ? $this->model_tool_image->resize($category['image'], 300, 300) : '',//$this->model_tool_image->resize('placeholder.png', 300, 300)
                'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }

        if (isset($this->request->get['sale']) || isset($this->request->get['new']) || isset($this->request->get['fete']) ) {
            $data['category_children'] = NULL;
        }
        // end: get child category

		// get categories
        $data['sale_cat'] = array(
            'href' => $this->url->link('product/category', 'path=59&sale=1&limit=300'),
            'name' => $this->language->get('sale'),
            'count' => $this->model_catalog_category->getCategoriesTotalSale(59)
        );

		$data['new_cat'] = array(
            'href'  => $this->url->link('product/category', 'path=59&new=1&limit=300'),
            'name'  => $this->language->get('new'),
            'count' => $this->model_catalog_category->getCategoriesTotalNew(59)
        );

        $data['fete_cat'] = array(
            'href'  => $this->url->link('product/category', 'path=59&fete=1&limit=300'),
            'name'  => $this->language->get('fete'),
            'count' => $this->model_catalog_category->getCategoriesTotalFete(59)
        );

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(59);

		foreach ($categories as $category) {

			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {

			$children2_data = array();
			$children2 = $this->model_catalog_category->getCategories($child['category_id']);

				foreach ($children2 as $child2) {

					$children3_data = array();
					$children3 = $this->model_catalog_category->getCategories($child2['category_id']);

						foreach ($children3 as $child3) {

							$filter_data3 = array(
								'filter_category_id'  => $child3['category_id'],
							);

							$children3_data[] = array(
								'category_id' => $child3['category_id'],
								'name'        => $child3['name'],
								'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $child2['category_id']. '_' . $child3['category_id'])
							);


						}

					$filter_data2 = array(
						'filter_category_id'  => $child2['category_id'],
					);

					$children2_data[] = array(
						'category_id' => $child2['category_id'],
						'name'        => $child2['name'],
						'count' => ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data2) . ')' : ''),
						'children'    => $children3_data,
						'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $child2['category_id'])
					);


				}

				$filter_data1 = array(
						'filter_category_id'  => $child['category_id'],
					);

				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name'        => $child['name'],
					'count' => ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data1) . ')' : ''),
					'children'    => $children2_data,
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
				);
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}
		// @ get categories @end

		$user_id = isset($_SESSION['default']['customer_id']) ? $_SESSION['default']['customer_id'] : 0;
		$data['user_wishlist'] = $this->model_catalog_product->getProductWishlistIds($user_id);

		if ($category_info) {

			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			if ($category_info['noindex'] <= 0) {
				$this->document->setRobots('noindex,follow');
			}

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

            $data['text_category_subtitle'] = $this->language->get('text_category_subtitle') . $data['heading_title'];
			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');
			$data['text_add_cart'] = $this->language->get('text_add_cart');
            $data['text_in_backet'] = $this->language->get('text_in_backet');

            $data['text_new'] = $this->language->get('new');
            $data['text_sale'] = $this->language->get('sale');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			$data['text_categories'] = $this->language->get('text_categories');
			$data['text_all_products_page'] = $this->language->get('text_all_products_page');

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			);

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
            } else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare');

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['sale'])) {
				$url .= '&sale=' . $this->request->get['sale'];
			}

			if (isset($this->request->get['new'])) {
				$url .= '&new=' . $this->request->get['new'];
			}

            if (isset($this->request->get['fete'])) {
                $url .= '&fete=' . $this->request->get['fete'];
            }


			$data['products'] = array();

            // 59 is id of main category "Catalog"
            if ($category_id == 59) {
                $filter_sub_category = true;
            } else {
                $filter_sub_category = false;
            }

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'filter_sub_category' => $filter_sub_category,
                'filter_skip_disable' => true,
				'new' => isset($this->request->get['new']) ? 1 : 0,
				'sale' => isset($this->request->get['sale']) ? 1 : 0,
                'fete' => isset($this->request->get['fete']) ? 1 : 0,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

            $data['filter_data_test'] = $filter_data;

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);


			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 300, 300);
                    $image_full = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
				} else {
					$image = ''; //$this->model_tool_image->resize('placeholder.png', 300, 300);
                    $image_full = '';
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}



				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
                    'popup'       => $image_full,
					'name'        => $result['name'],
					'new'         => $result['new'],
					'sale'        => $result['sale'],
                    'fete'        => $result['fete'],
                    'model'       => $this->language->get('codetitle'). $result['model'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path']  . '&product_id=' . $result['product_id'] . $url),
                    'path'        => $this->request->get['path'],
				);

			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['sale'])) {
				$url .= '&sale=' . $this->request->get['sale'];
			}

			if (isset($this->request->get['new'])) {
				$url .= '&new=' . $this->request->get['new'];
			}

            if (isset($this->request->get['fete'])) {
                $url .= '&fete=' . $this->request->get['fete'];
            }

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['limits'] = array();

			//$limits = array_unique(array($this->config->get('config_product_limit'), 16, 32, 64));
			$limits = array(24, 32, 64);

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
				);
			}

			$data['limit_all'] = $this->url->link('product/category', 'path=' . $this->request->get['path']. $url . '&limit=300');
			$data['filter_sale'] = $this->url->link('product/category', 'path=' . $this->request->get['path']. $url . '&sale=1');
			$data['filter_new'] = $this->url->link('product/category', 'path=' . $this->request->get['path']. $url . '&new=1');
            $data['filter_fete'] = $this->url->link('product/category', 'path=' . $this->request->get['path']. $url . '&fete=1');
			$data['filter_sale'] = str_replace(array('&new=1', '?new=1', '&fete=1', '?fete=1'), '', $data['filter_sale']);
			$data['filter_new'] = str_replace(array('&sale=1', '?sale=1', '&fete=1', '?fete=1'), '', $data['filter_new']);
            $data['filter_fete'] = str_replace(array('&sale=1', '?sale=1', '&new=1', '?new=1'), '', $data['filter_fete']);

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['sale'])) {
				$url .= '&sale=' . $this->request->get['sale'];
                $this->document->setTitle($data['sale_cat']['name']);
                $data['heading_title'] = $data['sale_cat']['name'];
			}

			if (isset($this->request->get['new'])) {
				$url .= '&new=' . $this->request->get['new'];
                $this->document->setTitle($data['new_cat']['name']);
                $data['heading_title'] = $data['new_cat']['name'];
			}

            if (isset($this->request->get['fete'])) {
                $url .= '&fete=' . $this->request->get['fete'];
                $this->document->setTitle($data['fete_cat']['name']);
                $data['heading_title'] = $data['fete_cat']['name'];
            }

			$pagination = new Pagination();

			if (defined('NUM_LINKS'))
			    $pagination->num_links = NUM_LINKS;

			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
			if(isset($_GET['page']) && ((int) $_GET['page'] > ceil($pagination->total / $pagination->limit) || in_array((int) $_GET['page'], [0,1]))){
				$new_uri = $_SERVER["REQUEST_URI"];
				$new_uri = explode('?', $new_uri);
				$new_uri = $new_uri[0];
				$new_uri = preg_replace('#\/page-[0-9]+#', '', $new_uri);
				if (in_array((int) $_GET['page'], [0,1])){
					$new_uri = 'http'.(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] ? 's' : '').'://'.$_SERVER["HTTP_HOST"].$new_uri.'/';
				} else {
					$new_uri = 'http'.(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] ? 's' : '').'://'.$_SERVER["HTTP_HOST"].$new_uri.'/?page='.ceil($pagination->total / $pagination->limit);
				}
				header('Location: '.$new_uri);
				exit();
			}
			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], 'SSL'), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], 'SSL'), 'prev');
			} else {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), 'SSL'), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), 'SSL'), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$data['category_id'] = $category_info['category_id'];

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['text_categories'] = $this->language->get('text_categories');
			$data['text_all_products_page'] = $this->language->get('text_all_products_page');


			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function getCategoriesTree() {

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $categories_data = array();

        $categories = $this->model_catalog_category->getCategories(59);


        foreach ($categories as $category) {

            $children_data = array();

            $children = $this->model_catalog_category->getCategories($category['category_id']);

            foreach ($children as $child) {

                $children2_data = array();
                $children2 = $this->model_catalog_category->getCategories($child['category_id']);

                foreach ($children2 as $child2) {

                    $children3_data = array();
                    $children3 = $this->model_catalog_category->getCategories($child2['category_id']);

                    foreach ($children3 as $child3) {

                        $filter_data3 = array(
                            'filter_category_id'  => $child3['category_id'],
                        );

                        $children3_data[] = array(
                            'category_id' => $child3['category_id'],
                            'name'        => $child3['name'],
                            'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $child2['category_id']. '_' . $child3['category_id'])
                        );


                    }

                    $filter_data2 = array(
                        'filter_category_id'  => $child2['category_id'],
                    );

                    $children2_data[] = array(
                        'category_id' => $child2['category_id'],
                        'name'        => $child2['name'],
                        'count' => ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data2) . ')' : ''),
                        'children'    => $children3_data,
                        'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']. '_' . $child2['category_id'])
                    );


                }

                $filter_data1 = array(
                    'filter_category_id'  => $child['category_id'],
                );

                $children_data[] = array(
                    'category_id' => $child['category_id'],
                    'name'        => $child['name'],
                    'count' => ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data1) . ')' : ''),
                    'children'    => $children2_data,
                    'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                );
            }

            $filter_data = array(
                'filter_category_id'  => $category['category_id'],
            );

            $categories_data[] = array(
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'children'    => $children_data,
                'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }
        // @ get categories @end

        return $categories_data;
    }
}
