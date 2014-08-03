<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}
		

                if(isset($this->request->get["_route_"]))
                {
                        
                        $ac_parts = explode('/', $this->request->get['_route_']);
                        foreach ($ac_parts as $ac_part) {
                        
                        if($ac_part == 'blog')
                        {
                            $this->request->get['route'] = 'ac_cms/blog';
                        }
                        elseif($this->request->get['_route_'] == 'blog/rss.xml')
                        {
                            $this->request->get['route'] = 'ac_cms/blog/rss';
                        }
                        else{
                            $ac_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($ac_part) . "'");
                            if ($ac_query->num_rows) 
                            {
                                $ac_url = explode('=', $ac_query->row['query']);

                                if ($ac_url[0] == 'b_id') 
                                {
                                    $this->request->get['b_id'] = $ac_url[1];
                                }

                                if ($ac_url[0] == 'bc_id') {
                                    if (!isset($this->request->get['ac_path'])) {
                                            $this->request->get['ac_path'] = $ac_url[1];
                                    } else {
                                            $this->request->get['ac_path'] .= '_' . $ac_url[1];
                                    }
                                }
                            }
                            else 
                            {
                                $this->request->get['route'] = "error/not_found";	
                            }
                        }
                    }
                    
                    
                    if (isset($this->request->get['b_id'])) 
                    {
                        $this->request->get['route'] = 'ac_cms/article';
                    } 
                    elseif (isset($this->request->get['ac_path'])) 
                    {
                        if($ac_part == 'rss.xml'){
                            $this->request->get['route'] = 'ac_cms/category/rss';
                        } elseif ($ac_part == 'archive') {
                            $this->request->get['route'] = 'ac_cms/category/archive';
                        } else {
                            $this->request->get['route'] = 'ac_cms/category';
                        }
                    }
                    
                    if (isset($this->request->get['route'])) {
                            return $this->forward($this->request->get['route']);
                    }
                
                }
                        
		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);
			
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
				
				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);
					
					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}
					
					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}	
					
					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}
					
					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}	
				} else {
					$this->request->get['route'] = 'error/not_found';	
				}
			}
			
			if (isset($this->request->get['product_id'])) {
				$this->request->get['route'] = 'product/product';
			} elseif (isset($this->request->get['path'])) {
				$this->request->get['route'] = 'product/category';
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$this->request->get['route'] = 'product/manufacturer/info';
			} elseif (isset($this->request->get['information_id'])) {
				$this->request->get['route'] = 'information/information';
			}
			
			if (isset($this->request->get['route'])) {
				return $this->forward($this->request->get['route']);
			}
		}
	}
	
	public function rewrite($link) {

                        if(preg_match('/ac_cms/', $link) && $this->config->get('config_seo_url')){
                        $ac_link = & $link;
                        
                        $ac_url_info = parse_url(str_replace('&amp;', '&', $ac_link));

                        $ac_url = ''; 

                        $ac_data = array();

                        parse_str($ac_url_info['query'], $ac_data);

                        foreach ($ac_data as $key => $value) {
                            if($ac_data[$key] == 'ac_cms/blog'){
                                $ac_url .= '/blog';
                            }elseif($ac_data[$key] == 'ac_cms/blog/rss'){
                                $ac_url .= '/blog/rss.xml';
                            }elseif ($key == 'b_id'){

                                $ac_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

                                if ($ac_query->num_rows) {
                                            $ac_url .= '/' . $ac_query->row['keyword'];
                                            unset($ac_data[$key]);
                                }

                            }elseif ($key == 'ac_path') {
                                    $cms_categories = explode('_', $value);
                                    $count = 0;
                                    if(is_array($cms_categories)){
                                        $count = count($cms_categories);
                                    }
                                    $i = 1;
                                    foreach ($cms_categories as $cms_category) {
                                            $ac_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'bc_id=" . (int)$cms_category . "'");

                                            if (($ac_query->num_rows) && ($ac_data['route'] == 'ac_cms/category/rss') && ($i == $count)) {
                                                    $ac_url .= '/' . $ac_query->row['keyword'] . '/rss.xml';
                                            }elseif(($ac_query->num_rows) && ($ac_data['route'] == 'ac_cms/category/archive') && ($i == $count)) {
                                                    $ac_url .= '/' . $ac_query->row['keyword'] . '/archive';
                                            } elseif($ac_query->num_rows) {
                                                    $ac_url .= '/' . $ac_query->row['keyword'];
                                            }
                                            $i++;
                                    }

                                    unset($ac_data[$key]);
                            }
                        }

                        if ($ac_url) {
                                unset($ac_data['route']);

                                $ac_query = '';

                                if ($ac_data) {
                                        foreach ($ac_data as $key => $value) {
                                                $ac_query .= '&' . $key . '=' . $value;
                                        }

                                        if ($ac_query) {
                                                $ac_query = '?' . trim($ac_query, '&');
                                        }
                                }

                                return $ac_url_info['scheme'] . '://' . $ac_url_info['host'] . (isset($ac_url_info['port']) ? ':' . $ac_url_info['port'] : '') . str_replace('/index.php', '', $ac_url_info['path']) . $ac_url . $ac_query;
                        } else {
                                return $ac_link;
                        }
                    }
                        
                        
		$url_info = parse_url(str_replace('&amp;', '&', $link));
	
		$url = ''; 
		
		$data = array();
		
		parse_str($url_info['query'], $data);
		
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
				
					if ($query->num_rows) {
						$url .= '/' . $query->row['keyword'];
						
						unset($data[$key]);
					}					
				} elseif ($key == 'path') {
					$categories = explode('_', $value);
					
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
				
						if ($query->num_rows) {
							$url .= '/' . $query->row['keyword'];
						}							
					}
					
					unset($data[$key]);
				}
			}
		}
	
		if ($url) {
			unset($data['route']);
		
			$query = '';
		
			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . $key . '=' . $value;
				}
				
				if ($query) {
					$query = '?' . trim($query, '&');
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}	
}
?>