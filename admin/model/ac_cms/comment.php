<?php
class ModelACcmsComment extends Model {
	public function addComment($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_comment SET name = '" . $this->db->escape($data['name']) . "', b_id = '" . $this->db->escape($data['b_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) ."', status = '" . (int)$data['status'] . "', date_added = NOW()");
                $this->cache->delete('ac_cms_article');
	}
	
	public function editComment($comment_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "ac_cms_comment SET name = '" . $this->db->escape($data['name']) . "', b_id = '" . $this->db->escape($data['b_id']) . "', text = '" . $this->db->escape(strip_tags($data['text'])) ."', status = '" . (int)$data['status'] . "', date_added = NOW() WHERE comment_id = '" . (int)$comment_id . "'");
                $this->cache->delete('ac_cms_article');
	}
	
	public function deleteComment($comment_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_comment WHERE comment_id = '" . (int)$comment_id . "'");
                $this->cache->delete('ac_cms_article');
	}
	
	public function getComment($comment_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT bd.title FROM " . DB_PREFIX . "ac_cms_article_description  bd WHERE bd.b_id = c.b_id AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS article FROM " . DB_PREFIX . "ac_cms_comment c WHERE c.comment_id = '" . (int)$comment_id . "'");
		
		return $query->row;
	}

	public function getComments($data = array()) {
		$sql = "SELECT c.comment_id, bd.title, c.name,c.status, c.date_added FROM " . DB_PREFIX . "ac_cms_comment c LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON (c.b_id = bd.b_id) WHERE bd.language_id = '" . (int)$this->config->get('config_language_id') . "'";																																					  
		
		$sort_data = array(
			'bd.title',
			'c.name',
			'c.status',
			'c.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.date_added";	
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
	
	public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ac_cms_comment");
		
		return $query->row['total'];
	}
	
	public function getTotalCommentsAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ac_cms_comment WHERE status = '0'");
		
		return $query->row['total'];
	}	
}
?>