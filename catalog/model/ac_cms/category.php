<?php

class ModelACcmsCategory extends Model {
    
    public function getCategory($bc_id) 
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ac_cms_category c LEFT JOIN " . DB_PREFIX . "ac_cms_category_description cd ON c.bc_id = cd.bc_id LEFT JOIN " . DB_PREFIX . "ac_cms_category_to_store c2s ON (c.bc_id = c2s.bc_id) WHERE c.bc_id = '" . (int)$bc_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1'");
        if(!empty($query->row)){
            $query->row['settings'] = unserialize($query->row['settings']);
        }
        return $query->row;
    } 
    
    public function getCategoryNameById($bc_id) 
    {
        $query = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "ac_cms_category c LEFT JOIN " . DB_PREFIX . "ac_cms_category_description cd ON c.bc_id = cd.bc_id LEFT JOIN " . DB_PREFIX . "ac_cms_category_to_store c2s ON (c.bc_id = c2s.bc_id) WHERE c.bc_id = '" . (int)$bc_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1'");
        if($query->num_rows){
            return $query->row['name'];
        }
    } 
    
    public function getCategories($parent = 0, $data=array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "ac_cms_category c ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_category_description cd ON (c.bc_id = cd.bc_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_category_to_store c2s ON (c.bc_id = c2s.bc_id) ";
        $sql .= "WHERE c.parent = '" . (int)$parent . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
        $sql .= "AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ";
        
        if (!empty($data['categories'])) {
            
                $cat_ids = " c.bc_id = ".implode(' OR c.bc_id = ', $data['categories']);

                $sql .= " AND (" . $cat_ids . ") ";			
        }
        $sql .= "ORDER BY c.sort_order, LCASE(cd.name) ";
        
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
    public function getCategoriesNPC($data=array()) {
        $sql = "SELECT *, parent, (SELECT acd.name FROM " . DB_PREFIX . "ac_cms_category ac LEFT JOIN " . DB_PREFIX . "ac_cms_category_description acd ON (acd.language_id = '" . (int)$this->config->get('config_language_id') . "' )  WHERE c.bc_id=ac.bc_id AND acd.bc_id = c.parent) as pname ";
        $sql .= "FROM " . DB_PREFIX . "ac_cms_category c ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_category_description cd ON (c.bc_id = cd.bc_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_category_to_store c2s ON (c.bc_id = c2s.bc_id) ";
        $sql .= "WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";
        $sql .= "AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ";

        if (!empty($data['categories'])) {

                $cat_ids = " c.bc_id = ".implode(' OR c.bc_id = ', $data['categories']);

                $sql .= " AND (" . $cat_ids . ") ";			
        }
        $sql .= "ORDER BY c.sort_order, LCASE(cd.name) ";

        $query = $this->db->query($sql);

        return $query->rows;
    }
    
    public function getCategoriesByParentId($bc_id) {
        $category_data = array();

        $category_query = $this->db->query("SELECT bc_id FROM " . DB_PREFIX . "ac_cms_category WHERE parent = '" . (int)$bc_id . "'");

        foreach ($category_query->rows as $category) {
                $category_data[] = $category['bc_id'];

                $children = $this->getCategoriesByParentId($category['bc_id']);

                if ($children) {
                        $category_data = array_merge($children, $category_data);
                }			
        }

        return $category_data;
    }
    
    public function getCategoryParents($bc_id) {
        $category_data = array();

        $category_query = $this->db->query("SELECT parent FROM " . DB_PREFIX . "ac_cms_category WHERE bc_id = '" . (int)$bc_id . "'");

        foreach ($category_query->rows as $category) {
                if(!empty($category['parent'])){
                    $category_data[] = $category['parent'];
                }

                $parent = $this->getCategoryParents($category['parent']);

                if ($parent) {
                        $category_data = array_merge($parent, $category_data);
                }			
        }

        return $category_data;
    }
    
    public function getCategoryLayoutId($bc_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_category_to_layout WHERE bc_id = '" . (int)$bc_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_ac_cms_category');
		}
    }
}

?>
