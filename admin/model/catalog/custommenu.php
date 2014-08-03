<?php
class ModelCatalogCustommenu extends Model {
	public function addcustommenu($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "custommenu SET link = '" .$data['link'] . "', level1 = '" .$data['level1'] . "', level2 = '" .$data['level2'] . "', `column` = '" .$data['column'] . "',status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$custommenu_id = $this->db->getLastId(); 
		
		foreach ($data['custommenu_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "custommenu_description SET custommenu_id = '" . (int)$custommenu_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "'");
		}

		$this->cache->delete('custommenu');
	}
	
	public function editcustommenu($custommenu_id, $data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "custommenu SET link = '" .$data['link'] . "', level1 = '" .$data['level1'] . "' , level2 = '" .$data['level2'] . "', `column` = '" .$data['column'] . "',status = '" . (int)$data['status'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE custommenu_id = '" . (int)$custommenu_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "custommenu_description WHERE custommenu_id = '" . (int)$custommenu_id . "'");
		
		foreach ($data['custommenu_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "custommenu_description SET custommenu_id = '" . (int)$custommenu_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "'");
		}
		
		$this->cache->delete('custommenu');
	}
	
	public function deletecustommenu($custommenu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "custommenu WHERE custommenu_id = '" . (int)$custommenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "custommenu_description WHERE custommenu_id = '" . (int)$custommenu_id . "'");
		
		

		$this->cache->delete('custommenu');
	}	
	public function getcustommenu($custommenu_id) {
	
			$sql = "SELECT * FROM " . DB_PREFIX . "custommenu where custommenu_id='".$custommenu_id."' ";
			$query = $this->db->query($sql);
			return $query->row;
		
	}
		

	
	public function getcustommenus($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "custommenu i LEFT JOIN " . DB_PREFIX . "custommenu_description id ON (i.custommenu_id = id.custommenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
			$sort_data = array(
				'id.title',				
				'i.link'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY id.title";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
			
			return $query->rows;
		} else {
			$custommenu_data = $this->cache->get('custommenu.' . (int)$this->config->get('config_language_id'));
		
			if (!$custommenu_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custommenu i LEFT JOIN " . DB_PREFIX . "custommenu_description id ON (i.custommenu_id = id.custommenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");
	
				$custommenu_data = $query->rows;
			
				$this->cache->set('custommenu.' . (int)$this->config->get('config_language_id'), $custommenu_data);
			}	
	
			return $custommenu_data;			
		}
	}
	
	public function getcustommenus1($data = array()) {
		
			$sql = "SELECT * FROM " . DB_PREFIX . "custommenu i LEFT JOIN " . DB_PREFIX . "custommenu_description id ON (i.custommenu_id = id.custommenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' and i.level1!=''";
		
			$sort_data = array(
				'id.title',				
				'i.link'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY id.title";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
			
			return $query->rows;
					
		
	}
	
	public function getcustommenuDescriptions($custommenu_id) {
		$custommenu_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "custommenu_description WHERE custommenu_id = '" . (int)$custommenu_id . "'");

		foreach ($query->rows as $result) {
			$custommenu_description_data[$result['language_id']] = array(
				'title'       => $result['title']
				
				);
		}
		
		return $custommenu_description_data;
	}
	
	
		
	public function getTotalcustommenus() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "custommenu");
		
		return $query->row['total'];
	}	
	
	
}
?>