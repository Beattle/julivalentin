<?php
class ModelACcmsArticleSet extends Model {
    
    public function addSet($data)
    {
        $sql = "INSERT INTO " . DB_PREFIX . "ac_cms_set SET display_type='" . $data['display_type'] . "', settings = '". $this->db->escape(serialize($data['settings']))."'";
        $this->db->query($sql);
        $bs_id = $this->db->getLastId();
        
        foreach ($data['article_set_description'] as $language_id => $value)
        {
            $sql2  = "INSERT INTO ". DB_PREFIX ."ac_cms_set_description ";
            $sql2 .= "(bs_id, title, language_id) ";
            $sql2 .= "VALUES($bs_id, '{$this->db->escape($value['title'])}',$language_id )";
            $this->db->query($sql2);
        }
        
        $this->cache->delete('ac_cms_set');
        $this->cache->delete('ac_cms_article');
        
        return $bs_id;
    }
    
    public function updateSet($bs_id, $data)
    {
        $sql = "UPDATE " . DB_PREFIX . "ac_cms_set SET display_type='" . $data['display_type'] . "', settings = '". $this->db->escape(serialize($data['settings']))."' ";
        $sql .= " WHERE bs_id = ".(int)$bs_id;
        $this->db->query($sql);
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_set_description WHERE bs_id = '" . (int)$bs_id . "'");
        foreach ($data['article_set_description'] as $language_id => $value)
        {
            $sql2  = "INSERT INTO ". DB_PREFIX ."ac_cms_set_description ";
            $sql2 .= "(bs_id, title, language_id) ";
            $sql2 .= "VALUES($bs_id, '{$this->db->escape($value['title'])}',$language_id )";
            $this->db->query($sql2);
        }
        
        $this->cache->delete('ac_cms_set');
        $this->cache->delete('ac_cms_article');
    }
    
    public function deleteSet($bs_id)
    {
         $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_set WHERE bs_id = '" . (int)$bs_id . "'");
         $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_set_description WHERE bs_id = '" . (int)$bs_id . "'");
         
         $this->cache->delete('ac_cms_set');
    }
    
    public function copySet($bs_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ac_cms_set s LEFT JOIN " . DB_PREFIX . "ac_cms_set_description sd ON (s.bs_id = sd.bs_id) WHERE s.bs_id = '" . (int)$bs_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
        
        if ($query->num_rows) {
            
            $data = array();
			
            $data = $query->row;
            
            $data['settings'] = unserialize($data['settings']);
            
            $data = array_merge($data, array('article_set_description' => $this->getArticleSetDescriptions($bs_id)));
            
            $data['article_set_description'][(int)$this->config->get('config_language_id')]['title'] = '*' . $data['article_set_description'][(int)$this->config->get('config_language_id')]['title'];
            
            $this->addSet($data);
        }
    }
   
    public function getArticleSet($bs_id) 
    {
        $ret_ar = array();
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ac_cms_set WHERE bs_id = '" . (int)$bs_id . "'");
        foreach ($query->rows as $result) {
            $ret_ar['bs_id'] = $result['bs_id'];
            $ret_ar['display_type'] = $result['display_type'];
            $ret_ar['settings'] = unserialize($result['settings']);
        }
        return $ret_ar;
    } 
    
    public function getArticleSets()
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "ac_cms_set s LEFT JOIN " . DB_PREFIX . "ac_cms_set_description sd ON (s.bs_id = sd.bs_id)  WHERE sd.language_id = " . (int)$this->config->get('config_language_id');
        
        $query = $this->db->query($sql);
        return $query->rows;
    }
    
    public function getArticleSetDescriptions($bs_id) 
    {
        $article_set_description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_set_description WHERE bs_id = '" . (int)$bs_id . "'");

        foreach ($query->rows as $result) {
                $article_set_description_data[$result['language_id']] = array(
                        'title' => $result['title']
                );
        }

        return $article_set_description_data;
    }
}
?>
