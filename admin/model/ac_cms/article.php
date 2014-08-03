<?php


class ModelACcmsArticle extends Model {
    
    public function addArticle($data)
    {
        $not_for_blog = (isset($data['not_for_blog']))?$data['not_for_blog']:0;
        $settings = (isset($data['settings']))?$data['settings']:array();
        $sql  = "INSERT INTO ". DB_PREFIX . "ac_cms_article ";
        $sql .= "(author, date_added, date_active, date_expr, sort_order, status, image, comments_approve, allow_comments, not_for_blog, settings, access_level, com_access_level, com_notify) ";
        $sql .= "VALUES({$this->session->data['user_id']},NOW(),'{$this->db->escape($data['date_active'])}','{$this->db->escape($data['date_expr'])}', ";
        $sql .= (int)$data['sort_order'].",".(int)$data['status'].",'{$data['image']}','{$data['com_need_apr']}','{$data['allow_comments']}', ".(int)$not_for_blog.",";
        $sql .= "'" . $this->db->escape(serialize($settings)) . "', '{$data['access_level']}', '{$data['com_access_level']}', '{$data['com_notify']}')";
        
        $this->db->query($sql);
        $b_id = $this->db->getLastId();
        
        foreach ($data['ac_cms_description'] as $language_id => $value)
        {
            $read_more_length = strlen('<hr id="readmore" />');
            $intro_length = strpos(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'), '<hr id="readmore" />');
            if($intro_length)
            {
               $length = strlen(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'));
               $intro = substr(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'), 0, $intro_length);
               $full_text = substr(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'), $intro_length + $read_more_length, $length - $intro_length); 
            }
            else
            {
               $intro = $value['intro'];
               $full_text = null; 
            }

            $sql2  = "INSERT INTO ". DB_PREFIX . "ac_cms_article_description  ";
            $sql2 .= "(b_id, title, language_id, intro, description, meta_description, meta_keyword) ";
            $sql2 .= "VALUES($b_id, '{$this->db->escape($value['title'])}',$language_id, '{$this->db->escape($intro)}', '{$this->db->escape($full_text)}', ";
            $sql2 .= "'{$this->db->escape($value['meta_description'])}','{$this->db->escape($value['meta_keyword'])}')";
            $this->db->query($sql2);
        }
        
        	
        if (isset($data['article_category'])) {
                foreach ($data['article_category'] as $bc_id) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_to_category SET b_id = '" . (int)$b_id . "', bc_id = '" . (int)$bc_id . "'");
                }		
        }
        
        if (isset($data['article_layout'])) {
                foreach ($data['article_layout'] as $store_id => $layout) {
                        if ($layout['layout_id']) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_to_layout SET b_id = '" . (int)$b_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
                        }
                }
        }
        
        if (isset($data['article_store'])) {
            foreach ($data['article_store'] as $store_id) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_to_store SET b_id = '" . (int)$b_id . "', store_id = '" . (int)$store_id . "'");
            }
        }
        
        if ($data['keyword'] && $data['keyword'] != '*') 
        {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'b_id=" . (int)$b_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        
        } elseif($data['keyword'] != '*') {
            $firstlang_data = $data['ac_cms_description'][$this->config->get('config_language_id')];
            $keyword = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(strtolower(str_replace(' ', '_', $firstlang_data['title'])), ENT_QUOTES, 'UTF-8'));
            $keyword = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $keyword);
            unset($firstlang_data);
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'b_id=" . (int)$b_id . "', keyword = '" . $this->db->escape($keyword) . "'");
        }
        
        foreach ($data['article_tag'] as $language_id => $value) {
            if ($value) {
                    $tags = explode(',', $value);

                    foreach ($tags as $tag) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_tag SET b_id = '" . (int)$b_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
                    }
            }
        }
        
        if (isset($data['article_related'])) {
                foreach ($data['article_related'] as $related_id) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$b_id . "' AND related_id = '" . (int)$related_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_related_article SET b_id = '" . (int)$b_id . "', related_id = '" . (int)$related_id . "'");
                        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$related_id . "' AND related_id = '" . (int)$b_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_related_article SET b_id = '" . (int)$related_id . "', related_id = '" . (int)$b_id . "'");
                }
        }
        
        if (isset($data['product_related'])) {
                foreach ($data['product_related'] as $related_id) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_product WHERE b_id = '" . (int)$b_id . "' AND related_id = '" . (int)$related_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_related_product SET b_id = '" . (int)$b_id . "', related_id = '" . (int)$related_id . "'");
                }
        }
        
        $this->cache->delete('ac_cms_article');
    }
    
    
    public function updateArticle($b_id, $data)
    {
        $b_id = (int)$b_id;
        $not_for_blog = (isset($data['not_for_blog']))?$data['not_for_blog']:0;
        $settings = (isset($data['settings']))?$data['settings']:array();
        $sql  = "UPDATE ". DB_PREFIX . "ac_cms_article ";
        $sql .= "SET date_modified = NOW(), date_active='{$this->db->escape($data['date_active'])}', "; 
        $sql .= "date_expr= '{$this->db->escape($data['date_expr'])}', image = '{$data['image']}', sort_order=".(int)$data['sort_order'].", ";
        $sql .= "not_for_blog = ".(int)$not_for_blog.", status=".(int)$data['status'].",comments_approve={$data['com_need_apr']}, allow_comments={$data['allow_comments']}, ";
        $sql .= "settings = '{$this->db->escape(serialize($settings))}', access_level = '{$data['access_level']}', com_access_level = '{$data['com_access_level']}', com_notify = '{$data['com_notify']}' WHERE b_id = {$b_id}";
        
        $this->db->query($sql);
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_description  WHERE b_id = $b_id");
        foreach ($data['ac_cms_description'] as $language_id => $value)
        {
            $read_more_length = strlen('<hr id="readmore" />');
            $intro_length = strpos(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'), '<hr id="readmore" />');
            if($intro_length)
            {
               $length = strlen(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'));
               $intro = substr(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'), 0, $intro_length);
               $full_text = substr(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'), $intro_length + $read_more_length, $length - $intro_length); 
            }
            else
            {
               $intro = $value['intro'];
               $full_text = null; 
            }

            $sql2  = "INSERT INTO ". DB_PREFIX . "ac_cms_article_description  ";
            $sql2 .= "(b_id, title, language_id, intro, description, meta_description, meta_keyword) ";
            $sql2 .= "VALUES($b_id, '{$this->db->escape($value['title'])}',$language_id, '{$this->db->escape($intro)}', '{$this->db->escape($full_text)}', ";
            $sql2 .= "'{$this->db->escape($value['meta_description'])}','{$this->db->escape($value['meta_keyword'])}')";
            $this->db->query($sql2);
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_layout WHERE b_id = '" . (int)$b_id . "'");

        if (isset($data['article_layout'])) {
                foreach ($data['article_layout'] as $store_id => $layout) {
                        if ($layout['layout_id']) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_to_layout SET b_id = '" . (int)$b_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
                        }
                }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_category WHERE b_id = '" . (int)$b_id . "'");
		
        if (isset($data['article_category'])) {
                foreach ($data['article_category'] as $bc_id) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_to_category SET b_id = '" . (int)$b_id . "', bc_id = '" . (int)$bc_id . "'");
                }		
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE related_id = '" . (int)$b_id . "'");

        if (isset($data['article_related'])) {
                foreach ($data['article_related'] as $related_id) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$b_id . "' AND related_id = '" . (int)$related_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_related_article SET b_id = '" . (int)$b_id . "', related_id = '" . (int)$related_id . "'");
                        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$related_id . "' AND related_id = '" . (int)$b_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_related_article SET b_id = '" . (int)$related_id . "', related_id = '" . (int)$b_id . "'");
                }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_product WHERE b_id = '" . (int)$b_id . "'");

        if (isset($data['product_related'])) {
                foreach ($data['product_related'] as $related_id) {
                        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_product WHERE b_id = '" . (int)$b_id . "' AND related_id = '" . (int)$related_id . "'");
                        $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_related_product SET b_id = '" . (int)$b_id . "', related_id = '" . (int)$related_id . "'");
                }
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_tag WHERE b_id = '" . (int)$b_id. "'");
        
        foreach ($data['article_tag'] as $language_id => $value) {
            if ($value) {
                    $tags = explode(',', $value);

                    foreach ($tags as $tag) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_tag SET b_id = '" . (int)$b_id . "', language_id = '" . (int)$language_id . "', tag = '" . $this->db->escape(trim($tag)) . "'");
                    }
            }
        }
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'b_id=" . (int)$b_id. "'");
        if ($data['keyword']) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'b_id=" . (int)$b_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        } else {
            $firstlang_data = $data['ac_cms_description'][$this->config->get('config_language_id')];
            $keyword = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(strtolower(str_replace(' ', '_', $firstlang_data['title'])), ENT_QUOTES, 'UTF-8'));
            $keyword = preg_replace('#[^\w()/.%\-&]#',"",html_entity_decode($keyword, ENT_QUOTES, 'UTF-8'));
            unset($firstlang_data);
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'b_id=" . (int)$b_id . "', keyword = '" . $this->db->escape($keyword) . "'");
        }
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_store WHERE b_id = '" . (int)$b_id . "'");

        if (isset($data['article_store'])) {
            foreach ($data['article_store'] as $store_id) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "ac_cms_article_to_store SET b_id = '" . (int)$b_id . "', store_id = '" . (int)$store_id . "'");
            }
        }
        
        $this->cache->delete('ac_cms_article');
    }
    
    public function deleteArticle($b_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_description  WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'b_id=" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_store WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_article WHERE related_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_layout WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_tag WHERE b_id = '" . (int)$b_id. "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_comment WHERE b_id = '" . (int)$b_id. "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_related_product WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_store WHERE b_id = '" . (int)$b_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "ac_cms_article_to_category WHERE b_id = '" . (int)$b_id . "'");
	
        
        $this->cache->delete('ac_cms_article');
    }
    
    public function copyArticle($b_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ac_cms_article b LEFT JOIN " . DB_PREFIX . "ac_cms_article_description bd ON (b.b_id = bd.b_id) WHERE b.b_id = '" . (int)$b_id . "' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
        
        if ($query->num_rows) {
            
            $data = array();
			
            $data = $query->row;
            
            $data['keyword'] = '*';

            $data['status'] = '0';
            
            $data['settings'] = unserialize($data['settings']);
            $data['com_need_apr'] = $data['comments_approve'];
            unset($data['comments_approve']);
            
            $data = array_merge($data, array('ac_cms_description' => $this->getArticleDescription($b_id)));
            $data = array_merge($data, array('article_category' => $this->getArticleCategories($b_id)));
            $data = array_merge($data, array('article_layout' => $this->getArticleLayouts($b_id)));
            $data = array_merge($data, array('article_store' => $this->getArticleStores($b_id)));
            $data = array_merge($data, array('article_tag' => $this->getArticleTags($b_id)));
            $data = array_merge($data, array('article_related' => $this->getArticleRelated($b_id)));
            $data = array_merge($data, array('product_related' => $this->getProductRelated($b_id)));
            
            $data['ac_cms_description'][(int)$this->config->get('config_language_id')]['title'] = '*' . $data['ac_cms_description'][(int)$this->config->get('config_language_id')]['title'];
            
            $this->addArticle($data);
        }
    }
    
    public function getArticles($data = array())
    {
        $sql = "SELECT b.*, cbd.*, u.username ";
        $sql .= "FROM " . DB_PREFIX . "ac_cms_article b LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  cbd ON (b.b_id = cbd.b_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "user u ON u.user_id = b.author ";
        if(!empty($data['category']))
            $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_category btc ON btc.b_id = b.b_id ";
        $sql .= "WHERE cbd.language_id = " . (int)$this->config->get('config_language_id');
        
        if(!empty($data['category'])){
            
            if(is_array($data['category'])){
                $cat_ids = " btc.bc_id = ".implode(' OR btc.bc_id = ', $data['category']);
            }
            else{
                $cat_ids = ' btc.bc_id = '.(int)$data['category'];
            }
            $sql .= ' AND '.$cat_ids;
        }
        
        if (!empty($data['filter_name'])) {
                $sql .= " AND LCASE(cbd.title) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
        }
        
        if (!empty($data['filter_author'])) {
                $sql .= " AND LCASE(u.username) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_author'])) . "%'";
        }
        
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $sql .= " AND b.status = '" . (int)$data['filter_status'] . "'";
        }
        
        if (isset($data['filter_access_level']) && !is_null($data['filter_access_level'])) {
                $sql .= " AND b.access_level = '" . (int)$data['filter_access_level'] . "'";
        }
        
        $sql .=  " ORDER BY b.sort_order ASC, b.date_added DESC";
        
        if(!empty($data['limit']))
        {
           $sql .= " LIMIT ";

           if(isset($data['start'])){
               $sql .= (int)$data['start'] . ", ";
           }

           $sql .= (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    
    public function getTotalArticles($data = array()) {
        $sql = "SELECT COUNT(*) AS total ";
        $sql .= "FROM " . DB_PREFIX . "ac_cms_article b LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  cbd ON (b.b_id = cbd.b_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "user u ON u.user_id = b.author ";
        if(!empty($data['category']))
            $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_category btc ON btc.b_id = b.b_id ";
        $sql .= "WHERE cbd.language_id = " . (int)$this->config->get('config_language_id');
        
        if(!empty($data['category'])){
            
            if(count($data['category'])>1){
                $cat_ids = " btc.bc_id = ".implode(' OR btc.bc_id = ', $data['category']);
            }
            else{
                $cat_ids = ' btc.bc_id = '.(int)$data['category'][0];
            }
            $sql .= ' AND '.$cat_ids;
        }
        
        if (!empty($data['filter_name'])) {
            $sql .= " AND LCASE(cbd.title) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
        }
        if (!empty($data['filter_author'])) {
                $sql .= " AND LCASE(u.username) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_author'])) . "%'";
        }
        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $sql .= " AND b.status = '" . (int)$data['filter_status'] . "'";
        }
        if (isset($data['filter_access_level']) && !is_null($data['filter_access_level'])) {
                $sql .= " AND b.access_level = '" . (int)$data['filter_access_level'] . "'";
        }
        $query = $this->db->query($sql);

        return $query->row['total'];
    }
    
    public function getArticle($id)
    {
        $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'b_id=" . (int)$id . "') AS keyword FROM " . DB_PREFIX . "ac_cms_article b LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON (b.b_id = bd.b_id) WHERE b.b_id = '" . (int)$id . "' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	if(!empty($query->row)){
            $query->row['settings'] = unserialize($query->row['settings']);
        }
        return $query->row;
    }
    
    public function getArticleDescription($id, $editor = false) 
    {
        $ac_cms_description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_description  WHERE b_id = '" . (int)$id . "'");

        foreach ($query->rows as $result) {
                $ac_cms_description_data[$result['language_id']] = array(
                        'title'            => $result['title'],
                        'meta_keyword'     => $result['meta_keyword'],
                        'meta_description' => $result['meta_description'],
                        'intro'            => $result['intro'],
                        'description'      => $result['description']
                );
         if($editor && !empty($result['description']) && !empty($result['intro']))
            $ac_cms_description_data[$result['language_id']]['intro'] = $result['intro'].'<hr id="readmore" />'.$result['description'];       
        }

        return $ac_cms_description_data;
    }
    
    public function getArticleLayouts($b_id) {
        $article_layout_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_to_layout WHERE b_id = '" . (int)$b_id . "'");

        foreach ($query->rows as $result) {
                $article_layout_data[$result['store_id']] = $result['layout_id'];
        }

        return $article_layout_data;
    }
    
    public function getArticleTags($b_id) {
        $article_tag_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_tag WHERE b_id = '" . (int)$b_id . "'");

        $tag_data = array();

        foreach ($query->rows as $result) {
                $tag_data[$result['language_id']][] = $result['tag'];
        }

        foreach ($tag_data as $language => $tags) {
                $article_tag_data[$language] = implode(',', $tags);
        }

        return $article_tag_data;
    }
    
    public function getArticleRelated($b_id) {
        $article_related_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_related_article WHERE b_id = '" . (int)$b_id . "'");

        foreach ($query->rows as $result) {
                $article_related_data[] = $result['related_id'];
        }

        return $article_related_data;
    }
    
    public function getProductRelated($b_id) {
        $product_related_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_related_product WHERE b_id = '" . (int)$b_id . "'");

        foreach ($query->rows as $result) {
                $product_related_data[] = $result['related_id'];
        }

        return $product_related_data;
    }
    
    public function getArticleStores($b_id) {
        $article_store_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_to_store WHERE b_id = '" . (int)$b_id . "'");

        foreach ($query->rows as $result) {
                $article_store_data[] = $result['store_id'];
        }

        return $article_store_data;
    }
    
    public function getArticleCategories($b_id) {
        $article_category_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_to_category WHERE b_id = '" . (int)$b_id . "'");

        foreach ($query->rows as $result) {
                $article_category_data[] = $result['bc_id'];
        }

        return $article_category_data;
    }
}

?>
