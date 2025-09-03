<?php
class ControllerCatalogPricer extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('catalog/pricer');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $request = $this->request->post;
            $this->session->data['changes'] = $request;

            switch ($this->request->post['operation_id']) {
                case 1:
                    $this->session->data['changes']['price_result'] = $this->changeProductPrice($request);
                    break;
                case 2:
                    $this->session->data['changes']['marks_result'] = $this->changeProductMarks($request);
                    break;
                case 3:
                    $this->session->data['changes']['discount_result'] = $this->changeProductDiscount($request);
                    break;
                case 4:
                    $this->session->data['changes']['price_result'] = $this->changeProductPrice($request);
                    $this->session->data['changes']['marks_result'] = $this->changeProductMarks($request);
                    break;
                case 5:
                    $this->session->data['changes']['price_result'] = $this->changeProductPrice($request);
                    $this->session->data['changes']['discount_result'] = $this->changeProductDiscount($request);
                    break;
                case 6:
                    $this->session->data['changes']['marks_result'] = $this->changeProductMarks($request);
                    $this->session->data['changes']['discount_result'] = $this->changeProductDiscount($request);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/pricer', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_result'] = $this->language->get('text_result');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_changes'] = $this->language->get('text_changes');

        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_operation'] = $this->language->get('entry_operation');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_new'] = $this->language->get('entry_new');
        $data['entry_sale'] = $this->language->get('entry_sale');
        $data['entry_fete'] = $this->language->get('entry_fete');
        $data['entry_discount_percentage'] = $this->language->get('entry_discount_percentage');

        $data['help_operation'] = $this->language->get('help_operation');
        $data['help_discount'] = $this->language->get('help_discount');

        $data['button_upload'] = $this->language->get('button_upload');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/pricer', 'token=' . $this->session->data['token'], 'SSL')
        );

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->session->data['changes'])) {
            $data['changes'] = $this->session->data['changes'];

            unset($this->session->data['changes']);
        } else {
            $data['changes'] = '';
        }

        $data['operations'] = array(
            array('operation_id' => 1, 'name' => $this->language->get('text_operation_1')),
            array('operation_id' => 2, 'name' => $this->language->get('text_operation_2')),
            array('operation_id' => 3, 'name' => $this->language->get('text_operation_3')),
            array('operation_id' => 4, 'name' => $this->language->get('text_operation_4')),
            array('operation_id' => 5, 'name' => $this->language->get('text_operation_5')),
            array('operation_id' => 6, 'name' => $this->language->get('text_operation_6'))
        );

        $data['action'] = $this->url->link('catalog/pricer', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

        $data['token'] = $this->session->data['token'];

        $this->load->model('catalog/category');

        $categories = $this->model_catalog_category->getAllCategories();

        $data['categories'] = $this->getAllCategoriesSorting($categories);


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/pricer.tpl', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'setting/setting')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['category_id'])) {
            $this->error['warning'] = $this->language->get('error_category');
        }

        if (empty($this->request->post['operation_id'])) {
            $this->error['warning'] = $this->language->get('error_operation');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function changeProductPrice($data = array()) {
        $this->load->model('catalog/product');

        $prod_prices = array();

        if (isset($data['category_id'])) {
            $products = $this->getProductsByCategoryId($data['category_id']);

            if (!empty($data['price']) && $data['price'] > 0) {
                foreach ($products as $product) {
                    $prod_prices[] = array(
                        'id' => $product['product_id'],
                        'old_price' => $product['price'],
                        'new_price' => (float)$data['price']
                    );

                    $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$data['price'] . "' WHERE product_id = '" . $product['product_id'] . "'");
                }
            }
        }

        return $prod_prices;
    }

    protected function changeProductMarks($data = array()) {
        $this->load->model('catalog/product');

        $prod_marks = array();

        if (isset($data['category_id'])) {
            $products = $this->getProductsByCategoryId($data['category_id']);

            foreach ($products as $product) {
                $prod_marks[] = array(
                    'id' => $product['product_id'],
                    'mark_new' => $data['new'],
                    'mark_sale' => $data['sale'],
                    'mark_fete' => $data['fete']
                );

                $this->model_catalog_product->editProductNew($product['product_id'], $data['new']);
                $this->model_catalog_product->editProductSale($product['product_id'], $data['sale']);
                $this->model_catalog_product->editProductFete($product['product_id'], $data['fete']);
            }
        }

        return $prod_marks;
    }

    protected function changeProductDiscount($data = array()) {
        $this->load->model('catalog/product');

        $prod_discounts = array();

        if (isset($data['category_id'])) {
            $products = $this->getProductsByCategoryId($data['category_id']);

            if (!empty($data['discount']) && $data['discount'] > 0) {
                foreach ($products as $product) {
                    $discount = 1 - ($data['discount'] / 100);

                    $new_price = round(($product['price'] * $discount));

                    $prod_discounts[] = array(
                        'id' => $product['product_id'],
                        'old_price' => $product['price'],
                        'new_price' => $new_price
                    );

                    $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . $product['product_id'] . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . $product['product_id'] . "', customer_group_id = '1', priority = '0', price = '" . $new_price . "', date_start = '0000-00-00', date_end = '0000-00-00'");
                }
            } elseif (isset($data['discount']) && $data['discount'] == 0) {
                foreach ($products as $product) {
                    $prod_discounts[] = array(
                        'id' => $product['product_id'],
                        'ref_price' => $product['price']
                    );

                    $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . $product['product_id'] . "'");
                }
            }
        }

        return $prod_discounts;
    }

    private function getProductsByCategoryId($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category p2c WHERE category_id = '" . (int)$category_id . "' ORDER BY p2c.product_id");

        $prod_id_array = array();

        foreach ($query->rows as $prod) {
            $prod_id_array[] = $prod['product_id'];
        }

        $prod_string = implode(",", $prod_id_array);

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p WHERE product_id IN (".$prod_string.")  ORDER BY p.product_id");

        return $query->rows;
    }

    private function getAllCategoriesSorting($categories, $parent_id = 0, $parent_name = '') {
        $output = array();

        if (array_key_exists($parent_id, $categories)) {
            if ($parent_name != '') {
                $parent_name .= ' &gt; ';
            }

            foreach ($categories[$parent_id] as $category) {
                $output[$category['category_id']] = array(
                    'category_id' => $category['category_id'],
                    'name'        => $parent_name . $category['name']
                );

                $output += $this->getAllCategoriesSorting($categories, $category['category_id'], $parent_name . $category['name']);
            }
        }

        uasort($output, array($this, 'sortByName'));

        return $output;
    }

    function sortByName($a, $b) {
        return strcmp($a['name'], $b['name']);
    }
}