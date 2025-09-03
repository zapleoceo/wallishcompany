<?php
/*
 * @copyright Copyright (c) 2011 Shilovsky Andrej, Dmitrij (an911@ukr.net)
 */
class ModelPaymentPrivat24 extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/privat24');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('privat24_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('privat24_total') > 0 && $this->config->get('privat24_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('privat24_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'privat24',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('privat24_sort_order')
			);
		}

		return $method_data;                
               
	}
}
?>