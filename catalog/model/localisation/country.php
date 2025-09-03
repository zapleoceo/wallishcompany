<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelLocalisationCountry extends Model {
	public function getCountry($country_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "' AND status = '1'");

		return $query->row;
	}

	public function getCountries() {
		$country_data = $this->cache->get('country.status');

		if (!$country_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country WHERE status = '1' ORDER BY name ASC");

			$country_data = $query->rows;

			$this->cache->set('country.status', $country_data);
		}

		return $country_data;
	}

	public function getCountryIdByCoutry($country) {
	    if (empty($country) || strlen($country) < 3) {
	        return false;
        }

        $query = $this->db->query("SELECT country_id FROM " . DB_PREFIX . "country WHERE name = '" . $this->db->escape($country) . "' LIMIT 1");
        if (empty($query->row)) {
            return $this->addCountry($country);
        }

        return $query->row['country_id'];
    }
    // is_google

    private function addCountry($country) {
	    $insert = array(
	        'name' => $this->db->escape($country),
	        'iso_code_2' => '',
            'iso_code_3' => '',
            'address_format' => '',
            'postcode_required' => 0,
            'is_google' => 1
        );

	    $setSql = array();
	    foreach($insert as $key => $val)
	        $setSql[] = $key . "='" . $val . "'";

        $this->db->query("INSERT INTO " . DB_PREFIX . "country SET " . implode(', ', $setSql));

        $last_insert_id = (int)$this->db->getLastId();
        if (empty($last_insert_id))
            return false;

	    return $last_insert_id;
	}




}