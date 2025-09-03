<?php

class Controllermodulecustmergroupbysumm extends Controller
{

    private $error = array();

    public function index()
    {
        $this->load->language('module/custmer_group_by_summ');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $this->load->model('customer/customer_group');


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
        {

            $this->model_setting_setting->editSetting('cgbs', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_add_row'] = $this->language->get('entry_add_row');
        $data['entry_regroup_customer'] = $this->language->get('entry_regroup_customer');
        
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning']))
        {
            $data['error_warning'] = $this->error['warning'];
        } else
        {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/custmer_group_by_summ', 'token=' . $this->session->data['token'], true)
        );

        $data['action'] = $this->url->link('module/custmer_group_by_summ', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->post['cgbs_status']))
        {
            $data['cgbs_status'] = $this->request->post['cgbs_status'];
        } else
        {
            $data['cgbs_status'] = $this->config->get('cgbs_status');
        }

        if (isset($this->request->post['cgbs_to_summ']))
            $to_summ = $this->request->post['cgbs_to_summ'];
        else
            $to_summ = $this->config->get('cgbs_to_summ');


        if (isset($this->request->post['cgbs_from_summ']))
            $from_summ = $this->request->post['cgbs_from_summ'];
        else
            $from_summ = $this->config->get('cgbs_from_summ');

        /*if (isset($this->request->post['cgbs_group']))
            $group = $this->request->post['cgbs_group'];
        else
            $group = $this->config->get('cgbs_group');*/

        if (isset($this->request->post['cgbs_type']))
            $type = $this->request->post['cgbs_type'];
        else
            $type = $this->config->get('cgbs_type');

        if (isset($this->request->post['cgbs_sale']))
            $sale = $this->request->post['cgbs_sale'];
        else
            $sale = $this->config->get('cgbs_sale');



        if (count($to_summ) > 0)
        {
            $rows = '';
            for ($i = 0; $i < count($to_summ); $i++)
                $rows .= $this->get_row($from_summ[$i], $to_summ[$i], $type[$i], $sale[$i]);

            $data['rows'] = $rows;
        }

        $data['token'] = $this->session->data['token'];
        $data['row'] = $this->get_row();


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/custmer_group_by_summ.tpl', $data));
    }


    private $tmpcats = array();
    public function getProductMainCategoryIds($products_ids) {
        $key = implode(':', $products_ids);

        if (isset($this->tmpcats[$key]))
            return $this->tmpcats[$key];

        $query = $this->db->query("SELECT category_id,product_id FROM " . DB_PREFIX . "product_to_category WHERE product_id IN (" . implode(',', $products_ids) . ") AND main_category = '1'");

        $this->tmpcats[$key] = $query->rows;

        return ($query->num_rows ? $query->rows : 0);
    }

    public $tempdata = array();
    public function getRanges($params = array())
    {

        $category_id = isset($params['category_id']) ? (int)$params['category_id'] : 0;
        $product_id = isset($params['product_id']) ? (int)$params['product_id'] : 0;

        if(isset($this->tempdata[$category_id.$product_id])) {
            return $this->tempdata[$category_id.$product_id];
        }

        //$this->load->language('module/custmer_group_by_summ');

        $this->load->model('setting/setting');

        $data = array();


        $to_summ = $this->config->get('cgbs_to_summ');
        $from_summ = $this->config->get('cgbs_from_summ');

        $data = array();
        if (count($to_summ) > 0)
        {
            for ($index = 0; $index < count($to_summ); $index++) {

                $value = '';
                if (!empty($category_id) || !empty($product_id)) {


                    /*if ($category_id) {
                        $path = 'cpcats_' . $category_id . '_' . $index . '_value';
                    } else {
                        $path = 'cpprods_' . $product_id . '_' . $index . '_value';
                    }*/

                    if ($product_id) {
                        $path = 'cpprods_' . $product_id . '_' . $index . '_value';
                        $value = $this->config->get($path);
                    }

                    if ($category_id) {
                        $path = 'cpcats_' . $category_id . '_' . $index . '_value';
                        if ((int)$value == 0)
                            $value = $this->config->get($path);
                    }


                    $value = !empty($value) ? number_format($value, 2, '.', '') : '';

                }

                $data[] = array(
                    'index' => $index,
                    'max' => $to_summ[$index],
                    'min' => $from_summ[$index],
                    'value' => $value
                );
            }
        }

        $this->tempdata[$category_id.$product_id] = $data;

        return $data;
    }

    public function get_row($from_summ = 0, $to_summ = 0, $type = 0, $sale = 0)
    {
        $this->load->language('module/custmer_group_by_summ');
        //$groups = $this->model_customer_customer_group->getCustomerGroups();

        $data['entry_from_summ'] = $this->language->get('entry_from_summ');
        $data['entry_to_summ'] = $this->language->get('entry_to_summ');
        //$data['entry_group'] = $this->language->get('entry_group');

        $data['entry_sale'] = $this->language->get('entry_sale');
        $data['entry_proc'] = $this->language->get('entry_proc');
        $data['entry_grn'] = $this->language->get('entry_grn');

        $data['from_summ'] = $from_summ;
        $data['to_summ'] = $to_summ;

        $data['type'] = $type;
        $data['sale'] = $sale;

        return $this->load->view('module/custmer_group_by_summ_row.tpl', $data);
    }

    public function regroup_customers()
    {
        $this->load->language('module/custmer_group_by_summ');
        $this->load->model('sale/order');
        $this->load->model('customer/customer');

        $customers = $this->model_customer_customer->getCustomers();
        foreach ($customers as $c)
        {
            $sum = $this->model_sale_order->getCompleteOrdersByCustomerId($c['customer_id']);
            
            if ($sum)
            {
                $from_summ = $this->config->get('cgbs_from_summ');
                $to_summ = $this->config->get('cgbs_to_summ');
                $group = $this->config->get('cgbs_group');

                for ($i = 0; $i < count($from_summ); $i++)
                    if ($from_summ[$i] < $sum && $sum < $to_summ[$i])
                    {
                        $this->db->query("UPDATE " . DB_PREFIX . "customer SET customer_group_id = '" . $group[$i] . "' WHERE customer_id ='" . $c['customer_id'] . "'");
                        break;
                    }
            }
        }
        
        echo $this->language->get('regroup_customers_complete');
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/custmer_group_by_summ'))
        {

            $this->error['warning'] = $this->language->get('error_permission');
        } else if (!isset($this->request->post['cgbs_status']) || !isset($this->request->post['cgbs_from_summ']) || !isset($this->request->post['cgbs_to_summ']) || !isset($this->request->post['cgbs_sale']))
        {
            //$this->error['warning'] = $this->language->get('error_empty');
        } else if (count($this->request->post['cgbs_from_summ']) !== count($this->request->post['cgbs_to_summ']) ||
                count($this->request->post['cgbs_from_summ']) !== count($this->request->post['cgbs_group']))
        {
            //$this->error['warning'] = $this->language->get('error_diff_num');
        } else
        {

            for ($i = 0; $i < count($this->request->post['cgbs_from_summ']); $i++)
                if (!is_numeric($this->request->post['cgbs_from_summ'][$i]) || !is_numeric($this->request->post['cgbs_to_summ'][$i]))
                {
                    $this->error['warning'] = $this->language->get('error_num');
                    break;
                }
        }

        return !$this->error;
    }

    public function getPrices($products) {
        if (empty($products))
            return $products;

        $products_ids = array_column($products, 'product_id');
        $categories = $this->getProductMainCategoryIds($products_ids);
        $catsarr = array();

        if ($categories) {
            foreach ($categories as $category)
                $catsarr[$category['product_id']] = $category['category_id'];
        }

        $result = $this->getproductsPrices($products, 0, $catsarr, false);
        if (empty($result['prods']))
            return $products;

        return $result['prods'];
    }

    public function getproductsPrices($products, $level, $catsarr = false, $istotal = true) {

        if (empty($products) || !is_array($products))
            return $products;

        $this->load->model('catalog/product');
        $newproducts = array();

        foreach ($products as $product) {

            $product['pricelevel'] = $level;


            /*if (isset($product['special']) && (int)$product['special'] > 0 && (int)$product['price'] == 0)
                $product['price'] = $product['special'];*/

            /*if ((int)$product['price'] > 0) {
                $newproducts[$product['product_id']] = $product;
                continue;
            }*/

            $ranges_prices = $this->getRanges(array('product_id' => $product['product_id']));

            if ($ranges_prices) {
                $category_id = isset($catsarr[$product['product_id']]) ? (int)$catsarr[$product['product_id']] : 0;
                $ranges_prices_category = $this->getRanges(array('category_id' => $category_id));
                foreach ($ranges_prices as $rpk => &$rp) {
                    $intrpvalue = (int)$rp['value'];
                    if (empty($intrpvalue) && isset($ranges_prices_category[$rpk]))
                        $rp['value'] = $ranges_prices_category[$rpk]['value'];
                }
            } else {

                $category_id = isset($catsarr[$product['product_id']]) ? (int)$catsarr[$product['product_id']] : 0;
                if ($category_id)
                    $ranges_prices = $this->getRanges(array('category_id' => $category_id));
            }

            
            if (empty($ranges_prices)) {
                $newproducts[$product['product_id']] = $product;
                continue;
            }

            $priceint = (int)$ranges_prices[$level]['value'];
            if (empty($priceint)) {
                $newproducts[$product['product_id']] = $product;
                continue;
            }

            $product['price'] = $ranges_prices[$level]['value'];


            if (isset($product['total'])) {
                $product['total'] = number_format($product['price']*$product['quantity'], 2, '.', '');
            }

            $newproducts[$product['product_id']] = $product;
        }


        $total = ($istotal) ? $this->getSubTotal($newproducts) : 0;
        return array('prods' => $newproducts, 'total' => $total);
    }

}
