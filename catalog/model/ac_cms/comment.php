<?php
class ModelACcmsComment extends Model {		
	public function addComment($b_id, $data, $auto_apr = false) {
                $sql = "INSERT INTO " . DB_PREFIX . "ac_cms_comment ";
                $sql .= "SET name = '" . $this->db->escape($data['name']) . "', customer_id = '" . (int)$this->customer->getId() . "', ";
                if($auto_apr){
                    $sql .= "status = '1', ";
                }
                $sql .= "b_id = '" . (int)$b_id . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', date_added = NOW()";
		$this->db->query($sql);
                $this->cache->delete('ac_cms_article');
	}
		
	public function getCommentsByArticleId($b_id, $start = 0, $limit = 20) {
		$query = $this->db->query("SELECT c.comment_id, c.name, c.text, b.b_id, bd.title, b.image, c.date_added FROM " . DB_PREFIX . "ac_cms_comment c LEFT JOIN " . DB_PREFIX . "ac_cms_article b ON (c.b_id = b.b_id) LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON (b.b_id = bd.b_id) WHERE b.b_id = '" . (int)$b_id . "' AND b.date_active <= NOW() AND b.status = '1' AND c.status = '1' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}	
	
	public function getTotalComments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ac_cms_comment c LEFT JOIN " . DB_PREFIX . "ac_cms_article b ON (c.b_id = b.b_id) WHERE b.date_active <= NOW() AND b.status = '1' AND c.status = '1'");
		
		return $query->row['total'];
	}
        
        public function getArticleSettingsByArticleId($b_id) {
		$sql = "SELECT comments_approve, com_notify, bd.title, u.username, b.com_access_level, b.allow_comments, b.date_expr FROM " . DB_PREFIX . "ac_cms_article b ";
                $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_description bd ON b.b_id = bd.b_id ";
                $sql .= "LEFT JOIN " . DB_PREFIX . "user u ON b.author = u.user_id ";
                $sql .= "WHERE b.b_id = '".$b_id."' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
                
                $query = $this->db->query($sql);
		
		return $query->row;
	}

	public function getTotalCommentsByArticleId($b_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ac_cms_comment c LEFT JOIN " . DB_PREFIX . "ac_cms_article b ON (c.b_id = b.b_id) LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON (b.b_id = bd.b_id) WHERE b.b_id = '" . (int)$b_id . "' AND b.date_active <= NOW() AND b.status = '1' AND c.status = '1' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}
}
?>