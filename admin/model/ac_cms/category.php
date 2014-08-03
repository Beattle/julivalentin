<?php
class ModelACcmsCategory extends Model {
    
    public function addCategory($data)
    {
        $settings = (isset($data['settings']))?$data['settings']:array();
        $sql = "INSERT INTO ". DB_PREFIX . "ac_cms_category ";
        $sql .= "(parent, image, status, sort_order, settings, rss) "; 
        $sql .= "VALUES (".(int)$data['parent'].",'{$data['image']}','".(int)$data['cat_status']."','".(int)$data['sort_order']."', ";
        $sql .= "'" . $this->db->escape(serialize($settings)) . "','{$data['cat_rss']}')";
        $this->db->query($sql);
        $bc_id = $this->db->getLastId();
        
        foreach ($data['category_description'] as $language_id => $value)
        {
            $sql2  = "INSERT INTO ". DB_PREFIX . "ac_cms_category_description ";
            $sql2 .= "(bc_id, name, language_id, description, meta_description, meta_keyword) ";
            $sql2 .= "VALUES($bc_id, '{$this->db->escape($value['name'])}',$language_id, '{$this->db->escape($value['description'])}', ";
            $sql2 .= "'{$this->db->escape($value['meta_description'])}','{$this->db->escape($value['meta_keyword'])}')";
            $this->db->query($sql2);
        }
        
        if (isset($data['category_layout'])) {
                foreach ($data['category_layout'] as $store_id => $layout) {
                        if ($layout['layout_id']) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_category_to_layout SET bc_id = '" . (int)$bc_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
                        }
                }
        }
        
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_category_to_store SET bc_id = '" . (int)$bc_id . "', store_id = '" . (int)$store_id . "'");
            }
        }
        
        if ($data['cat_keyword']) 
        {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'bc_id=" . (int)$bc_id . "', keyword = '" . $this->db->escape($data['cat_keyword']) . "'");
        } else {
            $firstlang_data = $data['category_description'][$this->config->get('config_language_id')];
            $keyword = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(strtolower(str_replace(' ', '_', $firstlang_data['name'])), ENT_QUOTES, 'UTF-8'));
            $keyword = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $keyword);
            unset($firstlang_data);
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'bc_id=" . (int)$bc_id . "', keyword = '" . $this->db->escape($keyword) . "'");
        }
        
        $this->cache->delete('ac_cms_category');
    }
    
    public function updateCategory($bc_id, $data)
    {
        $settings = (isset($data['settings']))?$data['settings']:array();
        $sql = "UPDATE ". DB_PREFIX . "ac_cms_category ";
        $sql .= "SET parent = ".(int)$data['parent'].", image = '{$data['image']}', status = ".(int)$data['cat_status'].", sort_order=".(int)$data['sort_order'] . ", settings = '{$this->db->escape(serialize($settings))}'". ", rss = '".(int)$data['cat_rss']."'";
        $sql .= " WHERE bc_id = ".(int)$bc_id;
        $this->db->query($sql);
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category_description WHERE bc_id = '" . (int)$bc_id . "'");
        foreach ($data['category_description'] as $language_id => $value)
        {
            $sql2  = "INSERT INTO ". DB_PREFIX . "ac_cms_category_description ";
            $sql2 .= "(bc_id, name, language_id, description, meta_description, meta_keyword) ";
            $sql2 .= "VALUES($bc_id, '{$this->db->escape($value['name'])}',$language_id, '{$this->db->escape($value['description'])}', ";
            $sql2 .= "'{$this->db->escape($value['meta_description'])}','{$this->db->escape($value['meta_keyword'])}')";
            $this->db->query($sql2);
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category_to_layout WHERE bc_id = '" . (int)$bc_id . "'");

        if (isset($data['category_layout'])) {
                foreach ($data['category_layout'] as $store_id => $layout) {
                        if ($layout['layout_id']) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_category_to_layout SET bc_id = '" . (int)$bc_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
                        }
                }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category_to_store WHERE bc_id = '" . (int)$bc_id . "'");
        if (isset($data['category_store'])) {
            foreach ($data['category_store'] as $store_id) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_category_to_store SET bc_id = '" . (int)$bc_id . "', store_id = '" . (int)$store_id . "'");
            }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'bc_id=" . (int)$bc_id . "'");
        
        if ($data['cat_keyword']) 
        {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'bc_id=" . (int)$bc_id . "', keyword = '" . $this->db->escape($data['cat_keyword']) . "'");
        } else {
            $firstlang_data = $data['category_description'][$this->config->get('config_language_id')];
            $keyword = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(strtolower(str_replace(' ', '_', $firstlang_data['name'])), ENT_QUOTES, 'UTF-8'));
            $keyword = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $keyword);
            unset($firstlang_data);
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'bc_id=" . (int)$bc_id . "', keyword = '" . $this->db->escape($keyword) . "'");
        }
        
        $this->cache->delete('ac_cms_category');
    }
    
    public function deleteCategory($bc_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category WHERE bc_id = '" . (int)$bc_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category_description WHERE bc_id = '" . (int)$bc_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category_to_store WHERE bc_id = '" . (int)$bc_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_category_to_layout WHERE bc_id = '" . (int)$bc_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'bc_id=" . (int)$bc_id . "'");
        $this->cache->delete('ac_cms_category');
    }
    
    public function getCategory($bc_id) 
    {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'bc_id=" . (int)$bc_id . "') AS keyword FROM " . DB_PREFIX . "ac_cms_category WHERE bc_id = '" . (int)$bc_id . "'");
        if(!empty($query->row)){
            $query->row['settings'] = unserialize($query->row['settings']);
        }
        return $query->row;
    } 
	
    public function getCategories($parent = 0) {
            $category_data = $this->cache->get('ac_cms_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent);

            if (!$category_data) {
                    $category_data = array();

                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_category c LEFT JOIN " . DB_PREFIX . "ac_cms_category_description cd ON (c.bc_id = cd.bc_id) WHERE c.parent = '" . (int)$parent . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cd.name ASC");

                    foreach ($query->rows as $result) {
                            $category_data[] = array(
                                    'bc_id' => $result['bc_id'],
                                    'name'        => $this->getPath($result['bc_id'], $this->config->get('config_language_id')),
                                    'status'  	  => $result['status'],
                                    'parent'  	  => $result['parent'],
                                    'sort_order'  => $result['sort_order']
                            );

                            $category_data = array_merge($category_data, $this->getCategories($result['bc_id']));
                    }	

                    $this->cache->set('ac_cms_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent, $category_data);
            }

            return $category_data;
    }
	
    public function getPath($bc_id) {
            $query = $this->db->query("SELECT name, parent FROM " . DB_PREFIX . "ac_cms_category c LEFT JOIN " . DB_PREFIX . "ac_cms_category_description cd ON (c.bc_id = cd.bc_id) WHERE c.bc_id = '" . (int)$bc_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY cd.name ASC");

            if ($query->row['parent']) {
                    return $this->getPath($query->row['parent'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $query->row['name'];
            } else {
                    return $query->row['name'];
            }
    }

    public function getCategoryDescriptions($bc_id) {
            $category_description_data = array();

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_category_description WHERE bc_id = '" . (int)$bc_id . "'");

            foreach ($query->rows as $result) {
                    $category_description_data[$result['language_id']] = array(
                            'name'             => $result['name'],
                            'meta_keyword'     => $result['meta_keyword'],
                            'meta_description' => $result['meta_description'],
                            'description'      => $result['description']
                    );
            }

            return $category_description_data;
    }

    public function getCategoryStores($bc_id) {
        $category_store_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_category_to_store WHERE bc_id = '" . (int)$bc_id . "'");

        foreach ($query->rows as $result) {
                $category_store_data[] = $result['store_id'];
        }

        return $category_store_data;
    }
    
    public function getCategoryLayouts($bc_id) {
        $article_layout_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_category_to_layout WHERE bc_id = '" . (int)$bc_id . "'");

        foreach ($query->rows as $result) {
                $article_layout_data[$result['store_id']] = $result['layout_id'];
        }

        return $article_layout_data;
    }
    
}
?>
