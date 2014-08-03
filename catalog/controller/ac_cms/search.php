<?php 
class ControllerACcmsSearch extends Controller { 
    
        protected function checkAccess()
        {
            if($this->customer->isLogged()){
                return 1;
            } else {
                return 0;
            }
        }
    
	public function index() { 
                $this->language->load('ac_cms/search');
		
		$this->load->model('ac_cms/category');
		
		$this->load->model('ac_cms/article');
		
		$this->load->model('tool/image'); 
		
                $this->data['search_type'] = 0;
                
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} elseif(isset($this->request->get['search'])) {
                        $filter_name = $this->request->get['search'];
                        $this->data['search_type'] = 1;
                } else {
			$filter_name = '';
		} 
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} elseif (isset($this->request->get['filter_name'])) {
			$filter_tag = $this->request->get['filter_name'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
                } elseif(isset($this->request->get['description'])) {
                        $filter_description = $this->request->get['description'];    
		} else {
			$filter_description = '';
		} 
				
		if (isset($this->request->get['filter_bc_id'])) {
			$filter_category_id = $this->request->get['filter_bc_id'];
		} else {
			$filter_category_id = 0;
		} 
		
		if (isset($this->request->get['filter_sub_category'])) {
			$filter_sub_category = $this->request->get['filter_sub_category'];
                } elseif(isset($this->request->get['sub_category'])) {
                        $filter_sub_category = $this->request->get['sub_category'];
		} else {
			$filter_sub_category = '';
		} 
								
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		} 

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
  		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 15;
		}
		
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['keyword']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
		
		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		} elseif(isset($this->request->get['search'])) {
                        $url .= '&search=' . $this->request->get['search'];
                }
		
		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . $this->request->get['filter_tag'];
		}
				
		if (isset($this->request->get['filter_description'])) {
			$url .= '&filter_description=' . $this->request->get['filter_description'];
		} elseif(isset($this->request->get['description'])) {
                        $url .= '&description=' . $this->request->get['description'];
                }
				
		if (isset($this->request->get['filter_bc_id'])) {
			$url .= '&filter_bc_id=' . $this->request->get['filter_bc_id'];
		}
		
		if (isset($this->request->get['filter_sub_category'])) {
			$url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
		} elseif(isset($this->request->get['sub_category'])) {
                        $url .= '&sub_category=' . $this->request->get['sub_category'];
                }
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}	
		
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
						
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('ac_cms/search', $url),
      		'separator' => $this->language->get('text_separator')
   		);
		
            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_article_empty'] = $this->language->get('text_article_empty');
            $this->data['text_critea'] = $this->language->get('text_critea');
            $this->data['text_search_article'] = $this->language->get('text_search_article');
            $this->data['text_keyword'] = $this->language->get('text_keyword');
            $this->data['text_category'] = $this->language->get('text_category');
            $this->data['text_sub_category'] = $this->language->get('text_sub_category');
            $this->data['text_created'] = $this->language->get('text_created');
            $this->data['text_comments'] = $this->language->get('text_comments');
            $this->data['text_readmore'] = $this->language->get('text_readmore');
            $this->data['text_display'] = $this->language->get('text_display');		
            $this->data['text_sort'] = $this->language->get('text_sort');
            $this->data['text_limit'] = $this->language->get('text_limit');
            $this->data['text_product_search'] = $this->language->get('text_product_search');

            $this->data['entry_search'] = $this->language->get('entry_search');
            $this->data['entry_article_description'] = $this->language->get('entry_article_description');

            $this->data['button_search'] = $this->language->get('button_search');
            $this->data['button_cart'] = $this->language->get('button_cart');
//            
            //Date formats
            $date_format_short = $this->language->get('date_format_short');
            $date_format_long = $this->language->get('date_format_long');
            
            $this->load->model('ac_cms/category');

            // 3 Level Category Search
            $this->data['categories'] = array();

            $categories_1 = $this->model_ac_cms_category->getCategories(0);

            foreach ($categories_1 as $category_1) {
                    $level_2_data = array();

                    $categories_2 = $this->model_ac_cms_category->getCategories($category_1['bc_id']);

                    foreach ($categories_2 as $category_2) {
                            $level_3_data = array();

                            $categories_3 = $this->model_ac_cms_category->getCategories($category_2['bc_id']);

                            foreach ($categories_3 as $category_3) {
                                    $level_3_data[] = array(
                                            'bc_id'       => $category_3['bc_id'],
                                            'name'        => $category_3['name'],
                                    );
                            }

                            $level_2_data[] = array(
                                    'bc_id'       => $category_2['bc_id'],	
                                    'name'        => $category_2['name'],
                                    'children'    => $level_3_data
                            );					
                    }

                    $this->data['categories'][] = array(
                            'bc_id'       => $category_1['bc_id'],
                            'name'        => $category_1['name'],
                            'children'    => $level_2_data
                    );
            }

            $this->data['articles'] = array();

            if (isset($this->request->get['filter_name']) || isset($this->request->get['search']) || isset($this->request->get['filter_tag'])) {
                    $data = array(
                            'filter_name'         => $filter_name, 
                            'filter_tag'          => $filter_tag, 
                            'filter_description'  => $filter_description,
                            'category'            => $filter_category_id, 
                            'filter_sub_category' => $filter_sub_category, 
                            'sort'                => $sort,
                            'order'               => $order,
                            'start'               => ($page - 1) * $limit,
                            'art_amount'          => $limit,
                            'access_level'        => $this->checkAccess()
                    );

                    $article_total = $this->model_ac_cms_article->getTotalArticles($data);

                    $results = $this->model_ac_cms_article->getArticles($data);
                    
                    foreach ($results as $result) {
                            if ($result['image']) {
                                    $image = $this->model_tool_image->resize($result['image'], 120, 120);
                            } else {
                                    $image = false;
                            }
                            
                            if(($result['com_access_level'] == 1 && !$this->customer->isLogged())){
                                $comment_access = false;
                            } else {
                                $comment_access = true;
                            }

                            $this->data['articles'][] = array(
                                    'b_id'              => $result['b_id'],
                                    'date_added'        => date($date_format_short, strtotime($result['date_added'])),
                                    'thumb'             => $image,
                                    'comment_access'    => $comment_access,
                                    'comments'          => $result['comments'],
                                    'name'              => $result['title'],
                                    'intro'             => substr(strip_tags(html_entity_decode($result['intro'], ENT_QUOTES, 'UTF-8')), 0, 400) . '..',
                                    'href'              => $this->url->link('ac_cms/article', $url . '&b_id=' . $result['b_id'])
                            );
                    }
                    
                    $url = '';

                    if (isset($this->request->get['filter_name'])) {
                            $url .= '&filter_name=' . $this->request->get['filter_name'];
                    } elseif(isset($this->request->get['search'])) {
                            $url .= '&search=' . $this->request->get['search'];
                    }

                    if (isset($this->request->get['filter_tag'])) {
                            $url .= '&filter_tag=' . $this->request->get['filter_tag'];
                    }

                    if (isset($this->request->get['filter_description'])) {
                            $url .= '&filter_description=' . $this->request->get['filter_description'];
                    } elseif(isset($this->request->get['description'])) {
                            $url .= '&description=' . $this->request->get['description'];
                    }

                    if (isset($this->request->get['filter_sub_category'])) {
                            $url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
                    } elseif(isset($this->request->get['sub_category'])) {
                            $url .= '&sub_category=' . $this->request->get['sub_category'];
                    }
                    
                    if (isset($this->request->get['filter_bc_id'])) {
                            $url .= '&filter_bc_id=' . $this->request->get['filter_bc_id'];
                    }

                    if (isset($this->request->get['limit'])) {
                            $url .= '&limit=' . $this->request->get['limit'];
                    }

                    $this->data['sorts'] = array();

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_default'),
                            'value' => 'p.sort_order-ASC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=p.sort_order&order=ASC' . $url)
                    );

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_name_asc'),
                            'value' => 'pd.name-ASC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=pd.name&order=ASC' . $url)
                    ); 

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_name_desc'),
                            'value' => 'pd.name-DESC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=pd.name&order=DESC' . $url)
                    );

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_price_asc'),
                            'value' => 'p.price-ASC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=p.price&order=ASC' . $url)
                    ); 

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_price_desc'),
                            'value' => 'p.price-DESC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=p.price&order=DESC' . $url)
                    ); 

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_rating_desc'),
                            'value' => 'rating-DESC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=rating&order=DESC' . $url)
                    ); 

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_rating_asc'),
                            'value' => 'rating-ASC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=rating&order=ASC' . $url)
                    );

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_model_asc'),
                            'value' => 'p.model-ASC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=p.model&order=ASC' . $url)
                    ); 

                    $this->data['sorts'][] = array(
                            'text'  => $this->language->get('text_model_desc'),
                            'value' => 'p.model-DESC',
                            'href'  => $this->url->link('ac_cms/search', 'sort=p.model&order=DESC' . $url)
                    );

                    $url = '';

                    if (isset($this->request->get['filter_name'])) {
                            $url .= '&filter_name=' . $this->request->get['filter_name'];
                    } elseif(isset($this->request->get['search'])) {
                            $url .= '&search=' . $this->request->get['search'];
                    }

                    if (isset($this->request->get['filter_tag'])) {
                            $url .= '&filter_tag=' . $this->request->get['filter_tag'];
                    }

                    if (isset($this->request->get['filter_description'])) {
                            $url .= '&filter_description=' . $this->request->get['filter_description'];
                    } elseif(isset($this->request->get['description'])) {
                            $url .= '&description=' . $this->request->get['description'];
                    }

                    if (isset($this->request->get['filter_sub_category'])) {
                            $url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
                    } elseif(isset($this->request->get['sub_category'])) {
                            $url .= '&sub_category=' . $this->request->get['sub_category'];
                    }

                    if (isset($this->request->get['filter_bc_id'])) {
                            $url .= '&filter_bc_id=' . $this->request->get['filter_bc_id'];
                    }

                    if (isset($this->request->get['sort'])) {
                            $url .= '&sort=' . $this->request->get['sort'];
                    }	

                    if (isset($this->request->get['order'])) {
                            $url .= '&order=' . $this->request->get['order'];
                    }
                    
                    

                    $this->data['limits'] = array();

                    $this->data['limits'][] = array(
                            'text'  => $this->config->get('config_catalog_limit'),
                            'value' => $this->config->get('config_catalog_limit'),
                            'href'  => $this->url->link('ac_cms/search', $url . '&limit=' . $this->config->get('config_catalog_limit'))
                    );

                    $this->data['limits'][] = array(
                            'text'  => 25,
                            'value' => 25,
                            'href'  => $this->url->link('ac_cms/search', $url . '&limit=25')
                    );

                    $this->data['limits'][] = array(
                            'text'  => 50,
                            'value' => 50,
                            'href'  => $this->url->link('ac_cms/search', $url . '&limit=50')
                    );

                    $this->data['limits'][] = array(
                            'text'  => 75,
                            'value' => 75,
                            'href'  => $this->url->link('ac_cms/search', $url . '&limit=75')
                    );

                    $this->data['limits'][] = array(
                            'text'  => 100,
                            'value' => 100,
                            'href'  => $this->url->link('ac_cms/search', $url . '&limit=100')
                    );

                    $url = '';
                    
                    if (isset($this->request->get['filter_name'])) {
                            $url .= '&filter_name=' . $this->request->get['filter_name'];
                    } elseif(isset($this->request->get['search'])) {
                            $url .= '&search=' . $this->request->get['search'];
                    }

                    if (isset($this->request->get['filter_tag'])) {
                            $url .= '&filter_tag=' . $this->request->get['filter_tag'];
                    }

                    if (isset($this->request->get['filter_description'])) {
                            $url .= '&filter_description=' . $this->request->get['filter_description'];
                    } elseif(isset($this->request->get['description'])) {
                            $url .= '&description=' . $this->request->get['description'];
                    }

                    if (isset($this->request->get['filter_sub_category'])) {
                            $url .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
                    } elseif(isset($this->request->get['sub_category'])) {
                            $url .= '&sub_category=' . $this->request->get['sub_category'];
                    }

                    if (isset($this->request->get['filter_bc_id'])) {
                            $url .= '&filter_bc_id=' . $this->request->get['filter_bc_id'];
                    }

                    if (isset($this->request->get['sort'])) {
                            $url .= '&sort=' . $this->request->get['sort'];
                    }	

                    if (isset($this->request->get['order'])) {
                            $url .= '&order=' . $this->request->get['order'];
                    }

                    if (isset($this->request->get['limit'])) {
                            $url .= '&limit=' . $this->request->get['limit'];
                    }

                    $pagination = new Pagination();
                    $pagination->total = $article_total;
                    $pagination->page = $page;
                    $pagination->limit = $limit;
                    $pagination->text = $this->language->get('text_pagination');
                    $pagination->url = $this->url->link('ac_cms/search', $url . '&page={page}');

                    $this->data['pagination'] = $pagination->render();
            }	

            $this->data['filter_name'] = $filter_name;
            $this->data['filter_description'] = $filter_description;
            $this->data['filter_bc_id'] = $filter_category_id;
            $this->data['filter_sub_category'] = $filter_sub_category;
            
            $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
            //Comment engine
            if(isset($global_settings['comment_engine'])){
                $this->data['comment_engine'] = $global_settings['comment_engine'];
            } else {
                $this->data['comment_engine'] = 0;
            }
            
            //Disqus Shortname
            if(isset($global_settings['disqus_id'])){
                $this->data['disqus_id'] = $global_settings['disqus_id'];
            } else {
                $this->data['disqus_id'] = false;
            }
            
            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
            $this->data['limit'] = $limit;
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ac_cms/search.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/ac_cms/search.tpl';
            } else {
                    $this->template = 'default/template/ac_cms/search.tpl';
            }
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/ac_cms.css')) {
                    $this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template') . '/stylesheet/ac_cms.css'); 
            } else {
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/ac_cms.css');
            }

            $this->children = array(
                    'common/column_left',
                    'common/column_right',
                    'common/content_top',
                    'common/content_bottom',
                    'common/footer',
                    'common/header'
            );

            $this->response->setOutput($this->render());
  	}
}
?>