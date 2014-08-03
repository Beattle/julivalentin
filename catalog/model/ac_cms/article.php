<?php

class ModelACcmsArticle extends Model {
    
    public function getArticle($b_id, $access_level = 0, $archive = false)
    {
        $sql = "SELECT DISTINCT b.*, bd.*, u.firstname, u.lastname, u.email, u.username, ";
        $sql .= "(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ac_cms_comment c WHERE c.b_id = b.b_id AND b.allow_comments = 1 AND b.date_active <= NOW() AND b.status = '1' AND c.status = '1' AND bd.language_id = '" . (int)$this->config->get('config_language_id')."') as comments ";
        $sql .= "FROM ". DB_PREFIX . "ac_cms_article b ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON (b.b_id = bd.b_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_store b2s ON (b.b_id = b2s.b_id) "; 
        $sql .= "LEFT JOIN " . DB_PREFIX . "user u ON u.user_id = b.author ";
        $sql .= "WHERE b.b_id = '" . (int)$b_id . "' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND b.status = '1' AND access_level <= '" .(int)$access_level. "' AND b2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ";
        
        if(empty($archive)){
            $sql .= "AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND (b.date_expr = '0000-00-00' OR b.date_expr > NOW())) ";

        } else {
            $sql .= "AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND (b.date_expr <> '0000-00-00' AND b.date_expr < NOW())) ";
        }
        
        $sql .= "GROUP BY b.b_id ";
        
        $query = $this->db->query($sql);
	if(!empty($query->row)){
            $query->row['settings'] = unserialize($query->row['settings']);
        }
        return $query->row;
    }
    
    public function getArticles($data=array())
    {
        if ($this->customer->isLogged()) {
                $access = 1;
        } else {
                $access = 0;
        }
        
        $cache = md5(http_build_query($data));
		
	$article_data = $this->cache->get('ac_cms_article.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$access . '.' . $cache);
	
        if (!$article_data) 
        {
            $sql = "SELECT DISTINCT b.b_id, b.image, bd.intro, bd.description, bd.title, b.allow_comments, b.comments_approve, b.date_added, b.date_modified, b.date_active, b.date_expr, b.viewed, b.sort_order, u.username, u.firstname, u.lastname, b.status, bd.meta_description, b.access_level, b.com_access_level, ";
                $sql .= "(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "ac_cms_comment c WHERE b.allow_comments = 1 AND c.b_id = b.b_id AND b.date_active <= NOW() AND b.status = '1' AND c.status = '1' AND bd.language_id = '" . (int)$this->config->get('config_language_id')."') as comments ";
                $sql .= "FROM " . DB_PREFIX . "ac_cms_article b LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON b.b_id = bd.b_id ";
                $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_category btc ON btc.b_id = b.b_id ";
                $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_store b2s ON (b.b_id = b2s.b_id) "; 
                if (!empty($data['filter_tag'])) {
                    $sql .= " LEFT JOIN " . DB_PREFIX . "ac_cms_article_tag bt ON (b.b_id = bt.b_id) ";			
                }
                $sql .= "LEFT JOIN " . DB_PREFIX . "user u ON u.user_id = b.author ";
                $sql .= "WHERE bd.language_id = '" . (int)$this->config->get('config_language_id'). "' AND b.status = '1' AND b2s.store_id = '" . (int)$this->config->get('config_store_id') . "' "; 
             
            if(empty($data['archive'])){
                $sql .= "AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND (b.date_expr = '0000-00-00' OR b.date_expr > NOW())) ";

            } else {
                $sql .= "AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND (b.date_expr <> '0000-00-00' AND b.date_expr < NOW())) ";
            }
            
            if(isset($data['filter_date_from'])){
                $sql .= "AND (b.date_expr >= '" . $this->db->escape($data['filter_date_from']) . "') ";
            }
            
            if(isset($data['filter_date_to'])){
                $sql .= "AND (b.date_expr <= '" . $this->db->escape($data['filter_date_to']) . " 23:59:59') ";
            }

            if (!empty($data['category'])) {
                if (!empty($data['filter_sub_category'])) {
                        $implode_data = array();

                        $implode_data[] = "btc.bc_id = '" . (int)$data['category'] . "'";

                        $this->load->model('ac_cms/category');

                        $categories = $this->model_ac_cms_category->getCategoriesByParentId($data['category']);

                        foreach ($categories as $bc_id) {
                                $implode_data[] = "btc.bc_id = '" . (int)$bc_id . "'";
                        }

                        $sql .= " AND (" . implode(' OR ', $implode_data) . ")";			
                } else {
                        if(is_array($data['category'])){
                                $cat_ids = " btc.bc_id = ".implode(' OR btc.bc_id = ', $data['category']);
                        }
                        else{
                                $cat_ids = ' btc.bc_id = '.(int)$data['category'];
                        }

                        $sql .= ' AND (' .$cat_ids . ')';

                        }
            }

            if(!empty($data['article'])){
                if(!empty($data['category'])){
                    $sql .= " OR ";
                }
                else{
                    $sql .= " AND ";
                }
                if(count($data['article'])>1){
                    $art_ids = " b.b_id = ".implode(' OR b.b_id = ', $data['article']);
                }
                else{
                    $art_ids = ' b.b_id = '.(int)$data['article'][0];
                }

                $sql .= '(' . $art_ids . ')';
            }
            if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {

                $sql .= " AND (";

                if (!empty($data['filter_name'])) {
                    $implode = array();

                    $words = explode(' ', $data['filter_name']);

                    foreach ($words as $word) {
                            if (!empty($data['filter_description'])) {
                                    $implode[] = "LCASE(bd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(bd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(bd.intro) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
                            } else {
                                    $implode[] = "LCASE(bd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
                            }				
                    }

                    if ($implode) {
                            $sql .= " " . implode(" OR ", $implode) . "";
                    }
                }

                if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                    $sql .= " OR ";
                }

                if (!empty($data['filter_tag'])) {
                        $implode = array();

                        $words = explode(' ', $data['filter_tag']);

                        foreach ($words as $word) {
                                $implode[] = "LCASE(bt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND bt.language_id = '" . (int)$this->config->get('config_language_id') . "'";
                        }

                        if ($implode) {
                                $sql .= " " . implode(" OR ", $implode) . "";
                        }
                }

                $sql .= ")";
            }

            if (isset($data['not_for_blog'])) {
                    $sql .= " AND not_for_blog = '" .(int)$data['not_for_blog']. "'";
            }
                
            if (isset($data['access_level'])) {
                    $sql.= " GROUP BY b.b_id HAVING b.access_level <= '" .(int)$data['access_level']. "'";
            } else {
                    $sql.= " GROUP BY b.b_id";
            }

            if(isset($data['sort_by']))
            {
                switch ($data['sort_by'])
                {
                    case 0:
                        $data['sort_by'] = 'bd.title';
                        break;

                    case 1:
                        $data['sort_by'] = 'author';
                        break;

                    case 2:
                        $data['sort_by'] = 'viewed';
                        break;

                    case 3:
                        $data['sort_by'] = 'sort_order';
                        break;

                    case 4:
                        $data['sort_by'] = 'date_modified';
                        break;

                    case 5:
                        $data['sort_by'] = 'b.date_added';
                        break;

                    default:
                        $data['sort_by'] = 'b.date_added';
                        break;
                }

                $sql.= " ORDER BY ".$data['sort_by'];
            }
            else
            {
                $sql.= " ORDER BY b.date_added";
            }

            if(isset($data['sort_order']))
            {
               $sql.= " ".$data['sort_order'];
            }
            else{
                $sql.= " DESC";
            }
            
            if(!empty($data['art_amount']))
            {
               $sql .= " LIMIT ";

               if(isset($data['start'])){
                   $sql .= (int)$data['start'] . ", ";
               }

               $sql .= (int)$data['art_amount'];
            }
            
            $query = $this->db->query($sql);
            
            $article_data = $query->rows;

            $this->cache->set('ac_cms_article.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$access . '.' . $cache, $article_data);
        }
	return $article_data;
    } 
    
    
    public function getTotalArticles($data=array())
    {
        $sql = "SELECT COUNT(DISTINCT b.b_id) as total ";
            $sql .= "FROM " . DB_PREFIX . "ac_cms_article b LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON b.b_id = bd.b_id ";
            $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_category btc ON btc.b_id = b.b_id ";
            $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_store b2s ON (b.b_id = b2s.b_id) "; 
            if (!empty($data['filter_tag'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "ac_cms_article_tag bt ON (b.b_id = bt.b_id)";			
            }
            $sql .= "LEFT JOIN " . DB_PREFIX . "user u ON u.user_id = b.author ";
            $sql .= "WHERE bd.language_id = '" . (int)$this->config->get('config_language_id'). "' AND b.status = '1' AND b2s.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
        
        if(empty($data['archive'])){
            $sql .= "AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND (b.date_expr = '0000-00-00' OR b.date_expr > NOW())) ";

        } else {
            $sql .= "AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND (b.date_expr <> '0000-00-00' AND b.date_expr < NOW())) ";
        }
        
        if(isset($data['filter_date_from'])){
            $sql .= "AND (b.date_expr >= '" . $this->db->escape($data['filter_date_from']) . "') ";
        }

        if(isset($data['filter_date_to'])){
            $sql .= "AND (b.date_expr <= '" . $this->db->escape($data['filter_date_to']) . " 23:59:59') ";
        }
            
        if(!empty($data['category'])){
            if(is_array($data['category'])){
                $cat_ids = " btc.bc_id = ".implode(' OR btc.bc_id = ', $data['category']);
            }
            else{
                $cat_ids = ' btc.bc_id = '.(int)$data['category'];
            }
            
            $sql .= ' AND '.$cat_ids;
        }
        
        if(!empty($data['article'])){
            if(!empty($data['category'])){
                $sql .= " OR ";
            }
            else{
                $sql .= " AND ";
            }
            if(count($data['article'])>1){
                $art_ids = " b.b_id = ".implode(' OR b.b_id = ', $data['article']);
            }
            else{
                $art_ids = ' b.b_id = '.(int)$data['article'][0];
            }
                
            $sql .= $art_ids;
        }
        
        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {

            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', $data['filter_name']);

                foreach ($words as $word) {
                        if (!empty($data['filter_description'])) {
                                $implode[] = "LCASE(bd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(bd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(bd.intro) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
                        } else {
                                $implode[] = "LCASE(bd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
                        }				
                }

                if ($implode) {
                        $sql .= " " . implode(" OR ", $implode) . "";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                    $implode = array();

                    $words = explode(' ', $data['filter_tag']);

                    foreach ($words as $word) {
                            $implode[] = "LCASE(bt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%' AND bt.language_id = '" . (int)$this->config->get('config_language_id') . "'";
                    }

                    if ($implode) {
                            $sql .= " " . implode(" OR ", $implode) . "";
                    }
            }

            $sql .= ")";
        }
        
        if (isset($data['not_for_blog'])) {
                $sql .= " AND not_for_blog = '" .(int)$data['not_for_blog']. "'";
        }
        
        if (isset($data['access_level'])) {
                $sql.= " AND access_level <= '" .(int)$data['access_level']. "'";
        }
                        
        $query = $this->db->query($sql);
        
	return $query->row['total'];
    }
    
    
    public function getArticleCategories($b_id) {
        $article_category_data = array();

        $query = $this->db->query("SELECT cd.bc_id, name FROM " . DB_PREFIX . "ac_cms_category_description cd LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_category btc ON cd.bc_id = btc.bc_id LEFT JOIN " . DB_PREFIX . "ac_cms_category bc ON bc.bc_id = btc.bc_id WHERE btc.b_id = '" . (int)$b_id . "' AND bc.status = '1' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cd.bc_id");

        foreach ($query->rows as $result) {
                $article_category_data[$result['bc_id']] = array(
                                    'name' => $result['name'],
                                    //'image' => $result['image']
                                );
        }

        return $article_category_data;
    }
    
    public function getArticleTags($b_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_tag WHERE b_id = '" . (int)$b_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        
        return $query->rows;
    }
    
    public function getArticleLayoutId($b_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ac_cms_article_to_layout WHERE b_id = '" . (int)$b_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
                return $query->row['layout_id'];
        } else {
                return  $this->config->get('config_layout_ac_cms_article');
        }
    }
    
    public function getArticleRelated($b_id, $access_level = 0) {
        $article_related_data = array();

        $sql = "SELECT related_id, title, image FROM " . DB_PREFIX . "ac_cms_related_article ra ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article b ON ra.related_id = b.b_id ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_to_store b2s ON (b.b_id = b2s.b_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "ac_cms_article_description  bd ON ra.related_id = bd.b_id ";
        $sql .= "WHERE ra.b_id = '" . (int)$b_id . "' AND bd.language_id = '" . (int)$this->config->get('config_language_id'). "' AND b.status = '1' AND ((b.date_active = '0000-00-00' OR b.date_active < NOW()) AND access_level <= '" .(int)$access_level. "' AND (b.date_expr = '0000-00-00' OR b.date_expr > NOW())) AND b2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY ra.related_id"; 

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
                $article_related_data[$result['related_id']] = array(
                    'title' => $result['title'],
                    'image' => $result['image']
                    );
        }

        return $article_related_data;
    }
    
    public function getProductRelated($b_id) {
        $product_related_data = array();
        $sql = "SELECT related_id FROM " . DB_PREFIX . "ac_cms_related_product rp ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "product p ON rp.related_id = p.product_id ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
        $sql .= "WHERE b_id = '" . (int)$b_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY rp.related_id";

        $query = $this->db->query($sql);
        
        foreach ($query->rows as $result) { 
			$product_related_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}

        return $product_related_data;
    }
    
    public function getProduct($product_id) {
            if ($this->customer->isLogged()) {
                    $customer_group_id = $this->customer->getCustomerGroupId();
            } else {
                    $customer_group_id = $this->config->get('config_customer_group_id');
            }	

            $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

            if ($query->num_rows) {
                    $query->row['price'] = ($query->row['discount'] ? $query->row['discount'] : $query->row['price']);
                    $query->row['rating'] = (int)$query->row['rating'];

                    return $query->row;
            } else {
                    return false;
            }
    }
    
    public function updateViewed($b_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "ac_cms_article SET viewed = (viewed + 1) WHERE b_id = '" . (int)$b_id . "'");
    }
}

?>
