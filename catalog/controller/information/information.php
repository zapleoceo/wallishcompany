<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerInformationInformation extends Controller {

    private $discounts_table = array();
    private $discounts_table_mobile = array();
    private function adding($category){
        $ranges = $this->load->controller('module/custmer_group_by_summ/getRanges', array('category_id' => $category['category_id']));

        if (empty($ranges))
            return $category;

        $this->discounts_table_mobile[$category['name']]['category'] = $category;
        unset($this->discounts_table_mobile[$category['name']]['category']['children']);
        $ranges_titles = array();

        foreach($ranges as $r) {
            if ($r['min'] == 0) {
                $title = $this->language->get('text_doo') . ' ' . $r['max'] . ' ' . $this->language->get('text_grn');
            } elseif ($r['max'] == 0){
                $title = '> ' . $r['min'] . ' ' . $this->language->get('text_grn');
            } else {
                $title = $r['min'].'-' . $r['max'] . ' ' . $this->language->get('text_grn');
            }

            if (!empty($r['value']))
                $r['value'] = $r['value'].' '. $this->language->get('text_grn');


            $ranges_titles[] = $title;
        }

        $this->discounts_table_mobile[$category['name']]['ranges'] = $ranges;
        $this->discounts_table_mobile[$category['name']]['ranges_titles'] = $ranges_titles;

        $category['ranges'] = $ranges;

        if (empty($this->discounts_table)) {

            $table_title = array();
            //$table_title[] = '';

            foreach($ranges as $r) {
                if ($r['min'] == 0) {
                    $title = $this->language->get('text_doo') . ' ' . $r['max'] . ' ' . $this->language->get('text_grn');
                } elseif ($r['max'] == 0){
                    $title = '> ' . $r['min'] . ' ' . $this->language->get('text_grn');
                } else {
                    $title = $r['min'].'-' . $r['max'] . ' ' . $this->language->get('text_grn');
                }

                $table_title[] = $title;
            }

            $this->discounts_table[] = $table_title;
        } else {

            /*$category['name'] = explode('&gt;', $category['name']);
            unset($category['name'][0]);
            $category['name'] = implode('&gt;', $category['name']);
            */

            $table_body = array();
            $table_body[] = '<a style="font-size: 12px;" target="_blank" href="'.$category['href'].'">' . $category['name'] . '</a>';

            foreach($ranges as $r) {
                if (!empty($r['value'])) {
                    $table_body[] = (int) $r['value'];
                } else {
                    $table_body[] = '';
                }
            }

            $this->discounts_table[$category['name']] = $table_body;
        }

        ksort($this->discounts_table);

        ksort($this->discounts_table_mobile);

        return $category;
    }

    public function index() {
        $this->load->language('information/information');

        $this->load->model('catalog/information');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['information_id'])) {
            $information_id = (int)$this->request->get['information_id'];
        } else {
            $information_id = 0;
        }

        $information_info = $this->model_catalog_information->getInformation($information_id);

        // Сотрудничество
        if ($information_id == 3) {


            $data['catalog_link'] = rtrim( $this->url->link('product/category', '' . '&category_id=' . 69) ).'/';
            $data['text_go_catalog_big'] = $this->language->get('text_go_catalog_big');
            $data['newsroom'] = $this->load->controller('blog/article/getcategory', array('category_id' => 73, 'limit' => 5));

            $this->load->language('information/information_cooperation');

            $data['text_cooperation_0'] = $this->language->get('text_cooperation_0');
            $data['text_cooperation_1'] = $this->language->get('text_cooperation_1');
            $data['text_cooperation_2'] = $this->language->get('text_cooperation_2');

            $data['text_cooperation_3'] = sprintf($this->language->get('text_cooperation_3'), $this->url->link('information/information', '' . '&information_id=10'));

            $data['text_cooperation_4'] = sprintf($this->language->get('text_cooperation_4'), $this->url->link('information/information', '' . '&information_id=10'));

            $data['text_cooperation_5'] = $this->language->get('text_cooperation_5');

            $data['text_cooperation_6'] = sprintf($this->language->get('text_cooperation_6'), $this->url->link('information/information', '' . '&information_id=12'));;

            $data['text_cooperation_7'] = $this->language->get('text_cooperation_7');
            $data['text_cooperation_8'] = $this->language->get('text_cooperation_8');
            $data['text_cooperation_9'] = $this->language->get('text_cooperation_9');
            $data['text_cooperation_10'] = $this->language->get('text_cooperation_10');
            $data['text_cooperation_11'] = $this->language->get('text_cooperation_11');
            $data['text_cooperation_12'] = $this->language->get('text_cooperation_12');
            $data['text_cooperation_13'] = $this->language->get('text_cooperation_13');
            $data['text_cooperation_14'] = $this->language->get('text_cooperation_14');
            $data['text_cooperation_15'] = $this->language->get('text_cooperation_15');

            $this->load->language('information/information');

            $custom_view = 'information_cooperation.tpl';
        }

        // Система скидок
        if ($information_id == 12) {

            $this->load->model('catalog/category');
            $data['discounts_table'] = array();

            $variant = 2;

            /* @start VARIANT 1 */
            /*if ($variant == 1) {
                $categories = $this->model_catalog_category->getCategoriesTitle();
                if (!empty($categories)) {
                    $this->discounts_table = array();

                    foreach ($categories as &$cat) {
                        $cat['href'] = $this->url->link('product/category', 'category_id=' . $cat['category_id']);
                        $cat = $this->adding($cat);
                    }

                    $data['discounts_table'] = $this->discounts_table;
                    $data['discounts_table_mobile'] = $this->discounts_table_mobile;
                }
            }*/
            /* @end VARIANT 1 */

            /* @start VARIANT 2 */
            if ($variant == 2) {
                $categories = $this->load->controller('product/category/getCategoriesTree');

                $this->discounts_table = array();
                $this->discounts_table_mobile = array();

                if (!empty($categories)) {
                    foreach ($categories as &$cat) {
                        $cat = $this->adding($cat);

                        /*if (empty($cat['children']))
                            continue;

                        foreach ($cat['children'] as &$cat2) {
                            $cat2 = $this->adding($cat2);

                            if (empty($cat2['children']))
                                continue;

                            foreach ($cat2['children'] as &$cat3) {
                                $cat3 = $this->adding($cat3);

                                if (empty($cat3['children']))
                                    continue;

                                foreach ($cat3['children'] as &$cat4) {
                                    $cat4 = $this->adding($cat4);
                                }
                            }
                        }*/
                    }

                    $data['discounts_table'] = $this->discounts_table;
                    $data['discounts_table_mobile'] = $this->discounts_table_mobile;
                }
            }
            /* @end VARIANT 2 */

            //$this->document->addScript(STYLE_PATH . 'js/d3.min.js' . CSSJS);
            //$this->document->addScript(STYLE_PATH . 'js/reduction.js' . CSSJS);

            $data['catalog_link'] = rtrim( $this->url->link('product/category', '' . '&category_id=' . 69) ).'/';
            $data['text_go_catalog_big'] = $this->language->get('text_go_catalog_big');

            //$data['text_discount_1'] = $this->language->get('text_discount_1');
            $data['text_discount_2'] = $this->language->get('text_discount_2');
            $data['text_discount_3'] = $this->language->get('text_discount_3');

            $data['text_summ_pokup'] = $this->language->get('text_summ_pokup');
            $data['text_catname'] = $this->language->get('text_catname');
            $data['text_no_sale_prods'] = $this->language->get('text_no_sale_prods');
			$data['text_no_sale_prods1'] = $this->language->get('text_no_sale_prods1');
			$data['ot'] = $this->language->get('ot');
			$data['text_grn'] = $this->language->get('text_grn');
			
            $custom_view = 'information_discount.tpl';
            $data['newsroom'] = $this->load->controller('blog/article/getcategory', array('category_id' => 73, 'limit' => 5));
        }

        // О нас
        if ($information_id == 4) {

            $data['catalog_link'] = rtrim( $this->url->link('product/category', '' . '&category_id=' . 69) ).'/';
            $data['text_go_catalog_big'] = $this->language->get('text_go_catalog_big');

            $this->load->language('information/information_about');
            $data['text_about_0'] = $this->language->get('text_about_0');
            $data['text_about_1'] = $this->language->get('text_about_1');


            $data['newsroom'] = $this->load->controller('blog/article/getcategory', array('category_id' => 73, 'limit' => 5));
            $custom_view = 'information_about.tpl';
            $this->load->language('information/information');
        }

        // Оплата Доставка
        if ($information_id == 10) {
            $this->load->language('information/information_delivery');

            $data['text_delivery_0'] = $this->language->get('text_delivery_0');
            $data['text_delivery_1'] = $this->language->get('text_delivery_1');
            $data['text_delivery_2'] = $this->language->get('text_delivery_2');
            $data['text_delivery_3'] = $this->language->get('text_delivery_3');
            $data['text_delivery_4'] = $this->language->get('text_delivery_4');
            $data['text_delivery_5'] = $this->language->get('text_delivery_5');
            $data['text_delivery_6'] = $this->language->get('text_delivery_6');
            $data['text_delivery_7'] = $this->language->get('text_delivery_7');
            $data['text_delivery_8'] = $this->language->get('text_delivery_8');
            $data['text_delivery_9'] = $this->language->get('text_delivery_9');
            $data['text_delivery_10'] = $this->language->get('text_delivery_10');
            $data['text_delivery_11'] = $this->language->get('text_delivery_11');
            $data['text_delivery_12'] = $this->language->get('text_delivery_12');
            $data['text_delivery_13'] = $this->language->get('text_delivery_13');
            $data['text_delivery_14'] = $this->language->get('text_delivery_14');
            $data['text_delivery_15'] = $this->language->get('text_delivery_15');
            $data['text_delivery_16'] = $this->language->get('text_delivery_16');
            $data['text_delivery_17'] = $this->language->get('text_delivery_17');
            $data['text_delivery_18'] = $this->language->get('text_delivery_18');

            $data['newsroom'] = $this->load->controller('blog/article/getcategory', array('category_id' => 73, 'limit' => 5));
            $custom_view = 'information_delivery.tpl';
            $this->load->language('information/information');
        }

        if ($information_info) {

            if ($information_info['meta_title']) {
                $this->document->setTitle($information_info['meta_title']);
            } else {
                $this->document->setTitle($information_info['title']);
            }

            if ($information_info['noindex'] <= 0) {
                $this->document->setRobots('noindex,follow');
            }

            if ($information_info['meta_h1']) {
                $data['heading_title'] = $information_info['meta_h1'];
            } else {
                $data['heading_title'] = $information_info['title'];
            }

            $this->document->setDescription($information_info['meta_description']);
            $this->document->setKeywords($information_info['meta_keyword']);

            $data['breadcrumbs'][] = array(
                'text' => $information_info['title'],
                'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
            );

            $data['button_continue'] = $this->language->get('button_continue');

            $data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');


            $custom_view = !empty($custom_view) ? $custom_view : 'information.tpl';

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/' . $custom_view)) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/' . $custom_view, $data));
            } else {
                $this->response->setOutput($this->load->view('default/template/information/' . $custom_view, $data));
            }
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('information/information', 'information_id=' . $information_id)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

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

    public function agree() {
        $this->load->model('catalog/information');

        if (isset($this->request->get['information_id'])) {
            $information_id = (int)$this->request->get['information_id'];
        } else {
            $information_id = 0;
        }

        $output = '';

        $information_info = $this->model_catalog_information->getInformation($information_id);

        if ($information_info) {
            $output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
        }

        $this->response->setOutput($output);
    }
}