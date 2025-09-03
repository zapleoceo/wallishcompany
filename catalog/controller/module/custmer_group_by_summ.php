<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class Controllermodulecustmergroupbysumm extends Controller {
    public function index() {

    }


    private function getLevelTotal($total) {

        $range = $this->getRanges();

        foreach($range as $r) {
            if ((int)$r['min'] <= $total && (int)$r['max'] >= $total)
                return $r['index'];
        }

        return $r['index'];
    }

    public function getPrices($products) {
        if (empty($products))
            return $products;


       /* $total = 0;
        foreach ($products as $product) {
            if ($product['sale'])
                continue;

            print_r($product);exit();
            $total += $product['total'];
        }

        print_r($total);exit();*/

/*
        $total = 0;
        foreach ($products as $product) {
            if ($product['sale'])
                continue;

            $total += $product['total'];
        }

        return $total;

        */

        /*$products_ids = array_column($products, 'product_id');
        $categories = $this->getProductMainCategoryIds($products_ids);
        $catsarr = array();
        $cats_assoc = array();

        if ($categories) {
            foreach ($categories as $category)
                $catsarr[$category['product_id']] = $category['category_id'];

        }*/

        $result = $this->getproductsPrices($products, 0, array(), false);
        if (empty($result['prods']))
            return $products;

        return $result['prods'];
    }


    public function productsAddSale($totals) {

        $products = $this->cart->getProducts();
        $totalSale = 0;
        $total = 0;
        $totalResult = 0;

        $persent = 0;

        foreach($products as $p) {
//            if ($p['sale'])
//                continue;

            if (empty($persent) && isset($p['saleorder'])) {
                $persent = round($p['saleorder'] / $p['price'] * 100);
            }

            if (!isset($p['saleorder']))
                $p['saleorder'] = 0;

            $total += $p['price'] * $p['quantity'];

            $totalResult += ($p['price'] - $p['saleorder']) * $p['quantity'];
            $totalSale += $p['saleorder'] * $p['quantity'];
        }

        $result = array(
            array(
                'code' => 'all_total',
                'title' => $this->language->get('text_total_total'),
                'value' => $total,
                'sort_order' => 0
            ),
            array(
                'code' => 'sale_total',
                'title' => $this->language->get('text_total_discount'),
                'value' => $totalSale,
                'sort_order' => 1,
                'percent' => $persent
            ),
        );

        if (count($totals)) {
            foreach ($totals as $value) {
                if ($value['code'] == 'shipping') {
                    $result[] = array(
                        'code' => 'shipping',
                        'title' => $value['title'],
                        'value' => $value['value'],
                        'sort_order' => 0
                    );

                    $totalResult += $value['value'];
                }
            }
        }

        $result[] = array(
            'code' => 'sub_total',
            'title' => $this->language->get('text_total_subtotal'),
            'value' => $totalResult,
            'sort_order' => 2
        );

        return $result;
    }

    public function getTotal($totals) {
        foreach($totals as $total) {
            if ($total['code'] == 'sub_total')
                return $total['value'];
        }

        return 0;
    }

    public function productsPrices($products) {
        if (empty($products))
            return $products;


        $total = 0;
        foreach ($products as $product) {
            if ($product['sale'])
                continue;

            $total += $product['total'];
        }


        $ranges = $this->getRanges();
        if (empty($ranges))
            return $products;

        $sale = 0;
        foreach($ranges as $r) {
            if ((int)$r['min'] <= $total && (int)$r['max'] >= $total) {
                $sale = (int)$r['sale'];
                break;
            }
        }

        if (empty($sale))
            return $products;



        foreach($products as &$product) {
            if ($product['sale'])
                continue;

            if (isset($product['is_sale']))
                continue;

            $price = $product['price'];
            $saleprice = number_format($price - (($price * $sale) / 100), 2, '.', '');

            $product['saleorder'] = number_format($price - $saleprice, 2, '.', '');
            $product['is_sale'] = 1;
            unset($price); unset($saleprice);
        }

        $result = array();
        foreach($products as $p) {
            $result[$p['product_id']] = $p;
        }

        return $result;













 /*$products_ids = array_column($products, 'product_id');
 $categories = $this->getProductMainCategoryIds($products_ids);
 $catsarr = array();

 if ($categories) {
     foreach ($categories as $category)
         $catsarr[$category['product_id']] = $category['category_id'];
 }*/

        // return $products;

        // print_r($products);exit(); // УДАЛЕНО: выводил секретную информацию о продуктах

        $range = $this->getRanges();
        $resultprods = array();
        $levelResults = array();
        $level = count($range);
        $levels = array();

        while($level--) {
            $result = $this->getproductsPrices($products, $level, array());
            $levels[$level] = $this->getLevelTotal($result['total']);
            $levelResults[$level] = $result;
        }

        $minlevel = min($levels);
        if (isset($levelResults[$minlevel])) {
            foreach($levelResults[$minlevel]['prods'] as $p) {
                $resultprods[$p['product_id']] = $p;
            }
        } else {
            foreach($prods as $p2) {
                $resultprods[$p['product_id']] = $p2;
            }
        }

        return $resultprods;
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

            if (!isset($product['special']) && (int)$product['price']) {
                $newproducts[$product['product_id']] = $product;
                continue;
            }

            $ranges_prices = $this->getRanges(array('product_id' => $product['product_id']));






            /*

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
            }*/

            $product['pricelevel'] = $level;

            if (empty($ranges_prices) || !(int)$ranges_prices[$level]['value']) {
                $newproducts[$product['product_id']] = $product;
                continue;
            }

            /*$priceint = (int)$ranges_prices[$level]['value'];
            if (empty($priceint)) {
                $newproducts[$product['product_id']] = $product;
                continue;
            }*/

            $product['price'] = $ranges_prices[$level]['value'];


            if (isset($product['total'])) {
                $product['total'] = number_format($product['price']*$product['quantity'], 2, '.', '');
            }

            $newproducts[$product['product_id']] = $product;
        }

        $total = ($istotal) ? $this->getSubTotal($newproducts) : 0;
        return array('prods' => $newproducts, 'total' => $total);
    }

    private function getSubTotal($products = false) {
        $total = 0;
        foreach ($products as $product) {
            if ($product['sale'])
                continue;

            $total += $product['total'];
        }

        return $total;
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



    public $tempdatacats = array();
    private function getValCats($category_id, $index) {
        if(isset($this->tempdatacats[$category_id.$index])) {
            return $this->tempdatacats[$category_id.$index];
        }

        $parent_id = $query = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . "category WHERE category_id = " . $category_id);

        if (empty($parent_id->row))
            return '';

        $parent_id = $parent_id->row['parent_id'];

        if (empty($parent_id))
            return '';

        $path = 'cpcats_' . $parent_id . '_' . $index . '_value';
        $value = $this->config->get($path);

        $valueint = (int)$value;

        if (empty($valueint))
            return $this->getValCats($parent_id, $index);

        return $this->tempdatacats[$category_id.$index] = $value;
    }
/*
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


                    if ($product_id) {
                        $path = 'cpprods_' . $product_id . '_' . $index . '_value';
                        $value = $this->config->get($path);
                    }

                    if (empty($category_id) && $product_id) {
                        $category = $this->getProductMainCategoryIds(array($product_id));
                        if (!empty($category))
                            $category_id = $category[0]['category_id'];
                        unset($category);
                    }

                    $intval = (int)$value;
                    if (!$intval && $category_id) {
                        $path = 'cpcats_' . $category_id . '_' . $index . '_value';
                        $value = $this->config->get($path);
                    }

                    // перебор по дечерним категориям
                    $intval = (int)$value;
                    if (empty($intval)) {
                        $value = $this->getValCats($category_id, $index);
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
*/
    public $tempdata = array();
    public function getRanges($params = array())
    {

        $this->load->language('module/custmer_group_by_summ');

        $this->load->model('setting/setting');

        $data = array();


        $to_summ = $this->config->get('cgbs_to_summ');
        $from_summ = $this->config->get('cgbs_from_summ');
        $sale = $this->config->get('cgbs_sale');

        $data = array();
        if (count($to_summ) > 0)
        {
            for ($index = 0; $index < count($to_summ); $index++) {

                $value = '';

                $data[] = array(
                    'max' => $to_summ[$index],
                    'min' => $from_summ[$index],
                    'sale' => $sale[$index]
                );
            }
        }

        return $data;
    }
}