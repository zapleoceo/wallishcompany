<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerReportSaleOrder extends Controller {
	public function index() {
		$this->load->language('report/sale_order');

		$this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript(STYLE_PATH . 'js/Chart.bundle.js');
        $this->document->addScript(STYLE_PATH . 'js/html2canvas.js');


		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
		}

		if (isset($this->request->get['filter_group'])) {
			$filter_group = $this->request->get['filter_group'];
		} else {
			$filter_group = 'week';
		}

        if (isset($this->request->get['result_type'])) {
            $result_type = $this->request->get['result_type'];
        } else {
            $result_type = 'summ';
        }

        if (isset($this->request->get['gopdf'])) {
            $ispdf = $this->request->get['gopdf'];
        } else {
            $ispdf = 0;
        }


		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

        if (isset($this->request->post['topdf']) && $this->request->post['topdf'] == 1) {

            $rows = $this->request->post['rows'];
            $html = array();
            foreach($rows as $row)
                $html[] = '<img src="'.$row.'"/>';

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML(implode('<br>', $html));
            $mpdf->Output('report_' .time(). '.pdf', 'D');
            exit();
        }



		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('report/sale');

		$data['orders'] = array();

		$filter_data = array(
			'filter_date_start'	     => $filter_date_start,
			'filter_date_end'	     => $filter_date_end,
			'filter_group'           => $filter_group,
			'filter_order_status_id' => $filter_order_status_id,
			//'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
			//'limit'                  => $this->config->get('config_limit_admin')
		);

		$order_total = $this->model_report_sale->getTotalOrders($filter_data);
		$results = $this->model_report_sale->getOrders($filter_data);

        $data['orders'] = $this->prepareResults($results);
        $data['order_result_text'] = $this->render_string_desc($filter_data);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');

		$data['column_date_start'] = $this->language->get('column_date_start');
		$data['column_date_end'] = $this->language->get('column_date_end');
		$data['column_orders'] = $this->language->get('column_orders');
		$data['column_products'] = $this->language->get('column_products');
		$data['column_tax'] = $this->language->get('column_tax');
		$data['column_total'] = $this->language->get('column_total');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_group'] = $this->language->get('entry_group');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['groups'] = array();

        $data['groups'][] = array(
            'text'  => $this->language->get('text_period'),
            'value' => 'period',
        );

		$data['groups'][] = array(
			'text'  => $this->language->get('text_year'),
			'value' => 'year',
		);

		$data['groups'][] = array(
			'text'  => $this->language->get('text_month'),
			'value' => 'month',
		);

		$data['groups'][] = array(
			'text'  => $this->language->get('text_week'),
			'value' => 'week',
		);

		$data['groups'][] = array(
			'text'  => $this->language->get('text_day'),
			'value' => 'day',
		);

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}


		/*$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		*/
        $data['pagination'] = '';
        $data['results'] = '';

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_group'] = $filter_group;
		$data['filter_order_status_id'] = $filter_order_status_id;

        $data['result_type'] = $result_type;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/sale_order.tpl', $data));
	}

    private function prepareResults($results) {

        $filter_group = isset($this->request->get['filter_group']) ? $this->request->get['filter_group'] : 'week';

        $result_type = isset($this->request->get['result_type']) ? $this->request->get['result_type'] : 'summ';
        $orders = array();


        $orders_ids = array_column($results, 'order_id');

        $products_orders = $this->model_report_sale->getProductsIdsByOrdersIds($orders_ids);
        $products_orders_arr = array();
        $response = array();

        if (empty($products_orders))
            return false;

        $data = array('titles' => array(), 'data' => array());

        // prices Range
        if ($result_type == 'orders_total') {

            $range_prices = $this->load->controller('module/custmer_group_by_summ/getRanges');
            $totals_custom = array();
            if ($range_prices) {
                foreach($range_prices as $rp)
                    $totals_custom[$rp['index']] = array($rp['min'], $rp['max']);
            }

            /*$totals_custom = array(
                1 => array(0, 999),
                2 => array(1000, 1999),
                3 => array(2000, 2999),
                4 => array(3000, 3999),
                5 => array(4000, 4999),
            );*/

            $response = array();
            foreach ($totals_custom as $ctId => $ctotal) {

                foreach($results as $res) {
                    if ($res['total'] >= $ctotal[0] && $res['total'] <= $ctotal[1]) {
                        //if (!isset($response[$ctId]['orders']))
                        //    $response[$ctId]['orders'] = 0;

                        $response[$ctId]['category']['name'] = $ctotal[0] .'-'. $ctotal[1];
                        $response[$ctId]['ords'][$res['order_id']] = $res;

                        //$response[$ctId]['orders'] += $res['total'];
                    }
                }
            }

            $data['titles'] = $this->getTitlesOrderTotal($filter_group, $response);
            $data['data'] = $this->getDataOrderTotal($filter_group, $response);

            $data['chart'] = array();
            if (!empty($this->titlesDate)) {
                foreach($this->titlesDate as $tkey => $tval) {
                    $data['chart']['labels'][] = $tval;

                    if (isset($data['data']['first'][$tkey])) {
                        $data['chart']['data'][] = $data['data']['first'][$tkey];
                    } else {
                        $data['chart']['data'][] = 0;
                    }
                }
            }

            return $data;
        }

        foreach ($products_orders as $porder)
            $products_orders_arr[$porder['order_id']][$porder['product_id']] = $porder;

        $products_ids = array_column($products_orders, 'product_id');
        $categories_products = $this->model_report_sale->getCategoriesIdsByProductsIds($products_ids);
        $categories_products_arr = [];
        foreach ($categories_products as $ct)
            $categories_products_arr[$ct['product_id']] = $ct['category_id'];

        $categories_ids = array_column($categories_products, 'category_id');


        $this->load->model('catalog/category');
        $categories = $this->model_catalog_category->getCategories(array('filter_ids' => $categories_ids));
        $categories_arr = [];
        foreach ($categories as $category)
            $categories_arr[$category['category_id']] = $category;


        array_unshift($categories_arr, array('category_id' => 0, 'name' => 'Без категории'));
        $response = array();
        foreach ($categories_arr as $category) {

            foreach ($results as $result) {
                if (!isset($products_orders_arr[$result['order_id']]))
                    continue;

                $prods = $products_orders_arr[$result['order_id']];


                foreach ($prods as $prod) {

                    $category_id = (int)isset($categories_products_arr[$prod['product_id']]) ? $categories_products_arr[$prod['product_id']] : 0;

                    if ($category_id != $category['category_id'])
                        continue;

                    $response[$category_id]['category'] = $category;
                    $response[$category_id]['ords'][$result['order_id']]['products'][$prod['product_id']] = $prod;
                    $response[$category_id]['ords'][$result['order_id']]['products'][$prod['product_id']]['order'] = $result;

                }
            }
        }

        $data['titles'] = $this->getTitles($filter_group, $result_type, $response);
        $resdata = $this->getData($filter_group, $result_type, $response);
        $data['data'] = $resdata[1];

        $data['chart'] = array();
        if (!empty($this->titlesDate)) {
            foreach($this->titlesDate as $tkey => $tval) {
                $data['chart']['labels'][] = $tval;

                if (isset($resdata[0]['first'][$tkey])) {
                    $data['chart']['data'][] = $resdata[0]['first'][$tkey];
                } else {
                    $data['chart']['data'][] = 0;
                }
            }
        }

        return  $data;
    }

    private $titlesDate = array();
    private function getTitlekey($filter_group, $key) {
        $this->titlesDate[$filter_group . ':'. $key] = $key;
    }
    private function getTitlesOrderTotal($filter_group, $response) {

        $titles = array();
        if ($filter_group == 'period') {

            $titles = array(
                'Диапазон сумм',
                'Количество заказов'
            );

            return $titles;
        }

        if (in_array($filter_group, array('year', 'week', 'day', 'month'))) {

            $items = array();
            foreach ($response as $summ_id => $d) {

                foreach($d['ords'] as $order) {
                    $key = 0;

                    if ($filter_group == 'year')
                        $key = date('Y', strtotime($order['date_added']));

                    if ($filter_group == 'week')
                        $key = date('Y.m.W', strtotime($order['date_added']));

                    if ($filter_group == 'day')
                        $key = date('Y.m.d', strtotime($order['date_added']));

                    if ($filter_group == 'month')
                        $key = date('Y.m', strtotime($order['date_added']));

                    if (empty($key))
                        continue;

                    $this->getTitlekey($filter_group, $key);
                }
            }

            if ($this->titlesDate) {
                ksort($this->titlesDate);
            }


            $titles = array();
            $titles[] = 'Диапазон сумм';

            if ($this->titlesDate) {
                foreach($this->titlesDate as $item) {
                    $titles[] = $item;
                }
            }

            $titles[] = 'Количество заказов';

            return $titles;
        }

        return false;
    }

    private function render_string_desc($params) {

        $result_type = !empty($this->request->get['result_type']) ? $this->request->get['result_type'] : 'summ';


        $result_types = array(
            'summ' => ' сумме продаж',
            'count' => ' количеству продукции',
            'orders' => ' количеству заказов  (категории)',
            'orders_total' => ' количеству заказов (по сумме)',
        );

        $result_groups = array(
            'period' => ', общая за период',
            'week' => ', по неделям',
            'year' => ', по годам',
            'day' => ', по дням',
            'month' => ', по месяцам',
        );

        $result_statuses = array(
            0 => ', все статусы',
            ', статус: в обработке',
            ', статус: выполнен',
            ', статус: оплачен',
            ', статус: отменен',
        );

        $message = 'Отчет '.$params['filter_date_start'].' - '.$params['filter_date_end'].' по' . $result_types[$result_type] . $result_groups[$params['filter_group']] . $result_statuses[$params['filter_order_status_id']];

        return $message;

    }

    private function getDataOrderTotal($filter_group, $response) {

        $data = array();
        $all_orders = 0;
        $all_period = array();

        if ($response) {
            foreach ($response as $summ_id => $d) {
                if (empty($d['ords']))
                    continue;

                $countord = count($d['ords']);

                foreach($d['ords'] as $order) {

                    $key = 0;
                    if ($filter_group == 'year')
                        $key = date('Y', strtotime($order['date_added']));

                    if ($filter_group == 'week')
                        $key = date('Y.m.W', strtotime($order['date_added']));

                    if ($filter_group == 'day')
                        $key = date('Y.m.d', strtotime($order['date_added']));

                    if ($filter_group == 'month')
                        $key = date('Y.m', strtotime($order['date_added']));


                    if ($key) {
                        if (!isset($period[$summ_id][$filter_group . ':' . $key]['orders']))
                            $period[$summ_id][$filter_group . ':' . $key]['orders'] = array();

                        if (!isset($period[$summ_id][$filter_group . ':' . $key]['total']))
                            $period[$summ_id][$filter_group . ':' . $key]['total'] = 0;

                        if (!isset($period[$summ_id][$filter_group . ':' . $key]['quantity']))
                            $period[$summ_id][$filter_group . ':' . $key]['quantity'] = 0;

                        if (!isset($period[$summ_id][$filter_group . ':' . $key]['sale']))
                            $period[$summ_id][$filter_group . ':' . $key]['sale'] = 0;


                        $period[$summ_id][$filter_group . ':' . $key]['orders'][] = $order['order_id'];
                    }
                }


                $data[$summ_id] = array();
                $data[$summ_id]['name'] = $d['category']['name'];

                if (!empty($this->titlesDate)) {
                    foreach ($this->titlesDate as $tkey => $tval) {

                        if (!isset($data[$summ_id][$tkey]))
                            $data[$summ_id][$tkey] = 0;

                        if (!isset($all_period[$tkey]))
                            $all_period[$tkey] = array();


                        if (isset($period[$summ_id][$tkey])) {
                            $data[$summ_id][$tkey] = count(array_unique($period[$summ_id][$tkey]['orders']));

                            $all_period[$tkey] = array_merge($all_period[$tkey], $period[$summ_id][$tkey]['orders']);

                        }
                    }
                }

                $data[$summ_id]['orders'] = $countord;
                $all_orders += $countord;
            }
        }

        $data['first']['name'] = 'Общее количество';

        if (!empty($this->titlesDate)) {
            foreach ($this->titlesDate as $tkey => $tval) {

                if (!isset($data['first'][$tkey]))
                    $data['first'][$tkey] = 0;


                if (isset($all_period[$tkey])) {
                    $data['first'][$tkey] = count(array_unique($all_period[$tkey]));
                }
            }
        }

        $data['first']['orders'] = $all_orders;

        return $data;
    }

    private function getTitles($filter_group, $result_type, $response) {

	    $titles = array();
        if ($filter_group == 'period') {

            if ($result_type == 'summ') {
                $titles = array(
                    'Категории',
                    'Сумма',
                    'Скидка',
                    'Итого',
                );
            }

            if ($result_type == 'count') {
                $titles = array(
                    'Категории',
                    'Количество товаров',
                );
            }

            if ($result_type == 'orders') {
                $titles = array(
                    'Категории',
                    'Количество заказов'
                );
            }

            return $titles;
        }



        if (in_array($filter_group, array('year', 'week', 'day', 'month'))) {

            $items = array();
            foreach($response as $category_id => $resp) {
                if (empty($resp['ords']))
                    continue;

                foreach($resp['ords'] as $order_id => $res) {
                    foreach ($res['products'] as $p) {

                        $key = '';

                        if ($filter_group == 'year')
                            $key = date('Y', strtotime($p['order']['date_added']));

                        if ($filter_group == 'week')
                            $key = date('Y.m.W', strtotime($p['order']['date_added']));

                        if ($filter_group == 'day')
                            $key = date('Y.m.d', strtotime($p['order']['date_added']));

                        if ($filter_group == 'month')
                            $key = date('Y.m', strtotime($p['order']['date_added']));

                        if (empty($key))
                            continue;

                        $this->getTitlekey($filter_group, $key);
                    }
                }
            }

            if ($this->titlesDate) {
                ksort($this->titlesDate);
            }


            if ($result_type == 'summ') {
                $titles = array();
                $titles[] = 'Категории\даты';

                if ($this->titlesDate) {
                    foreach($this->titlesDate as $item) {
                        $titles[] = $item;
                    }
                }

                $titles[] = 'Сумма';
                //$titles[] = 'Скидка';
                $titles[] = 'Итого';
            }

            if ($result_type == 'count') {
                $titles = array();
                $titles[] = 'Категории\даты';

                if ($this->titlesDate) {
                    foreach($this->titlesDate as $item) {
                        $titles[] = $item;
                    }
                }

                $titles[] = 'Количество товаров';
            }

            if ($result_type == 'orders') {
                $titles = array();
                $titles[] = 'Категории\даты';

                if ($this->titlesDate) {
                    foreach($this->titlesDate as $item) {
                        $titles[] = $item;
                    }
                }

                $titles[] = 'Количество заказов';
            }
        }

        return $titles;
    }


    private $subtotaltmp = [];
    private function getSubtotal($order_id) {

        if (isset($this->subtotaltmp[$order_id]))
            return $this->subtotaltmp[$order_id];

        $subtotal = 0;
        $prods = $this->model_report_sale->getProductsIdsByOrdersIds(array($order_id));
        foreach($prods as $pro) {
            if ($pro['sale'] == 1)
                continue;

            $subtotal += $pro['total'];
        }

        $this->subtotaltmp[$order_id] = $subtotal;

        return $subtotal;
    }

    private function getData($filter_group, $result_type, $response) {

        $data = array();

        $totals_all = 0;
        $sales = 0;
        $totals = 0;

        $quantity_all = 0;
        $all_orders = array();
        $all_period = array();

        if ($response) {
            foreach ($response as $ccategory_id => $resp_orders) {

                $quantity = 0;
                $total_all = 0;
                $sale = 0;
                $total = 0;

                $orders = array();
                $period = array();

                foreach($resp_orders['ords'] as $ord_id => $resp) {

                    // перебираем товары
                    foreach ($resp['products'] as $p) {
                        // $p['sale'];
                        // перебрать товары и высчитать процент только для товаров

                        // $percent = 0;
                        //$sale_total = 0;
                        //if (!empty($p['order']['discount'])) {
                            // $sale_total
                            //echo $p['order']['order_id'];
                            //$subtotal = $this->getSubtotal($p['order']['order_id']);
                            //var_dump($subtotal);exit();
                            // $subtotal = $p['order']['total'] - $p['order']['discount'];

                            //$percent = $p['order']['discount']/$subtotal*100;

                           /* $percent = (int)$p['order']['total'] / (int)$p['order']['sub_total'];
                            $percent = 100 - ($percent * 100);

                            $sale_total = (int)$p['total'] - ((int)$p['total'] / 100 * $percent);
                            $sale_total = (int)$p['total'] - $sale_total;*/
                        //}



                        $total_all += $p['total']+$p['saleorder'];
                        $sale += $p['saleorder'];
                        $total += $p['total'];

                        $quantity += $p['quantity'];
                        $orders[] = $ord_id;


                        $key = 0;
                        if ($filter_group == 'year')
                            $key = date('Y', strtotime($p['order']['date_added']));

                        if ($filter_group == 'week')
                            $key = date('Y.m.W', strtotime($p['order']['date_added']));

                        if ($filter_group == 'day')
                            $key = date('Y.m.d', strtotime($p['order']['date_added']));

                        if ($filter_group == 'month')
                            $key = date('Y.m', strtotime($p['order']['date_added']));


                        if ($key) {
                            if (!isset($period[$ccategory_id][$filter_group . ':' . $key]['orders']))
                                $period[$ccategory_id][$filter_group . ':' . $key]['orders'] = array();

                            if (!isset($period[$ccategory_id][$filter_group . ':' . $key]['total_all']))
                                $period[$ccategory_id][$filter_group . ':' . $key]['total_all'] = 0;

                            if (!isset($period[$ccategory_id][$filter_group . ':' . $key]['sale']))
                                $period[$ccategory_id][$filter_group . ':' . $key]['sale'] = 0;

                            if (!isset($period[$ccategory_id][$filter_group . ':' . $key]['total']))
                                $period[$ccategory_id][$filter_group . ':' . $key]['total'] = 0;

                            if (!isset($period[$ccategory_id][$filter_group . ':' . $key]['quantity']))
                                $period[$ccategory_id][$filter_group . ':' . $key]['quantity'] = 0;



                            $period[$ccategory_id][$filter_group . ':' . $key]['orders'][] = $ord_id;
                            $period[$ccategory_id][$filter_group . ':' . $key]['total_all'] += $p['total']+$p['saleorder'];
                            $period[$ccategory_id][$filter_group . ':' . $key]['sale'] += $p['saleorder'];
                            $period[$ccategory_id][$filter_group . ':' . $key]['total'] += $p['total'];
                            $period[$ccategory_id][$filter_group . ':' . $key]['quantity'] += $p['quantity'];

                            /*if ($p['sale'] == 1) {
                                $period[$ccategory_id][$filter_group . ':' . $key]['sale'] += 0;
                            } else {
                                $period[$ccategory_id][$filter_group . ':' . $key]['sale'] += $p['saleorder'];
                            }*/
                        }
                    }
                }


                $data[$ccategory_id] = array();
                $data[$ccategory_id]['name'] = $resp_orders['category']['name'];

                if ($result_type == 'summ') {

                    foreach ($this->titlesDate as $tkey => $tval) {

                        if (!isset($data[$ccategory_id][$tkey]))
                            $data[$ccategory_id][$tkey] = 0;

                        if (!isset($all_period[$tkey]))
                            $all_period[$tkey] = 0;


                        if (isset($period[$ccategory_id][$tkey])) {
                            $data[$ccategory_id][$tkey] += $period[$ccategory_id][$tkey]['total'];
                            $all_period[$tkey] += $period[$ccategory_id][$tkey]['total'];
                        }
                    }

                    $data[$ccategory_id]['total_all'] = $total_all;
                    $data[$ccategory_id]['sale'] = $sale;
                    $data[$ccategory_id]['total'] =  $total;
                }

                if ($result_type == 'count') {

                    foreach ($this->titlesDate as $tkey => $tval) {

                        if (!isset($data[$ccategory_id][$tkey]))
                            $data[$ccategory_id][$tkey] = 0;

                        if (!isset($all_period[$tkey]))
                            $all_period[$tkey] = 0;


                        if (isset($period[$ccategory_id][$tkey])) {
                            $data[$ccategory_id][$tkey] += $period[$ccategory_id][$tkey]['quantity'];
                            $all_period[$tkey] += $period[$ccategory_id][$tkey]['quantity'];
                        }
                    }

                    $data[$ccategory_id]['quantity'] = $quantity;
                }

                if ($result_type == 'orders') {

                    foreach ($this->titlesDate as $tkey => $tval) {

                        if (!isset($data[$ccategory_id][$tkey]))
                            $data[$ccategory_id][$tkey] = array();

                        if (!isset($all_period[$tkey]))
                            $all_period[$tkey] = array();


                        if (isset($period[$ccategory_id][$tkey])) {
                            $data[$ccategory_id][$tkey] = array_merge($data[$ccategory_id][$tkey], $period[$ccategory_id][$tkey]['orders']);

                            $all_period[$tkey] = array_merge($all_period[$tkey], $period[$ccategory_id][$tkey]['orders']);

                        }
                    }

                    $orderscount = count(array_unique($orders));
                    $data[$ccategory_id]['orders'] = $orderscount;
                }


                $totals_all += $total_all;
                $sales += $sale;
                $totals += $total;

                $quantity_all += $quantity;
                $all_orders = array_merge($all_orders, $orders);

            }
        }

        $data['first']['name'] = 'Общая сумма';

        // результат общая сумма
        if ($result_type == 'summ') {

            if ($this->titlesDate) {
                foreach ($this->titlesDate as $tkey => $tval) {
                    if (isset($all_period[$tkey])) {
                        $data['first'][$tkey] = $all_period[$tkey];
                    } else {
                        $data['first'][$tkey] = 0;
                    }
                }
            }

            $data['first']['total'] = $totals_all;
            $data['first']['sale'] = $sales;
            $data['first']['final'] = $totals;
        }

        // результат общее количество
        if ($result_type == 'count') {

            if ($this->titlesDate) {
                foreach ($this->titlesDate as $tkey => $tval) {
                    if (isset($all_period[$tkey])) {
                        $data['first'][$tkey] = $all_period[$tkey];
                    } else {
                        $data['first'][$tkey] = 0;
                    }
                }
            }

            $data['first']['quantity'] = $quantity_all;
        }

        // результат общее количество заказов
        if ($result_type == 'orders') {

            if ($this->titlesDate) {
                foreach ($this->titlesDate as $tkey => $tval) {
                    if (isset($all_period[$tkey])) {
                        $orderscount = count(array_unique($all_period[$tkey]));
                        $data['first'][$tkey] = $orderscount;
                    } else {
                        $data['first'][$tkey] = 0;
                    }
                }
            }

            $orderscount = count(array_unique($all_orders));
            $data['first']['all_orders'] = $orderscount;
        }

        $dataChart = $data;

        // формат суммы сделать
        if ($result_type == 'summ') {
            foreach ($data as &$ord) {

                if ($this->titlesDate) {
                    foreach ($this->titlesDate as $tkey => $tval) {
                        $ord[$tkey] = $this->currency->format($ord[$tkey]);
                    }
                }

                $ord['total'] = $this->currency->format($ord['total']);
                $ord['sale'] = $this->currency->format($ord['sale']);
//                $ord['final'] = $this->currency->format($ord['final']);  // fix notice on page Report sale
            }
        }

        if ($result_type == 'orders') {
            foreach ($data as &$ord) {

                if ($this->titlesDate) {
                    foreach ($this->titlesDate as $tkey => $tval) {
                        if (is_array($ord[$tkey])) {
                            $orderscount = count(array_unique($ord[$tkey]));
                            $ord[$tkey] = $orderscount;
                        }
                    }
                }
            }
        }

        return array($dataChart, $data);
    }
}