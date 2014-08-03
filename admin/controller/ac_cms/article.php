<?php

class ControllerACcmsArticle extends Controller {
    private $error = array();
    /**
         * List Articles
         */
        public function admin()
        {
            $this->load->model('ac_cms/article'); 
            $this->load->language('ac_cms/article');

            $this->data['heading_title'] = $this->language->get('heading_title');
            
            $this->getList();
	}
        
        /**
         * Create Article
         */
        public function create()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/article'); 
            $this->load->language('ac_cms/article');
            
            $this->data['languages'] = $this->model_localisation_language->getLanguages();
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                    $this->model_ac_cms_article->addArticle($this->request->post); 
                    
                    $url = '';

                    if (isset($this->request->get['filter_title'])) {
                            $url .= '&filter_title=' . $this->request->get['filter_title'];
                    }

                    if (isset($this->request->get['filter_author'])) {
                            $url .= '&filter_author=' . $this->request->get['filter_author'];
                    }	

                    if (isset($this->request->get['filter_access_level'])) {
                            $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
                    }

                    if (isset($this->request->get['filter_status'])) {
                            $url .= '&filter_status=' . $this->request->get['filter_status'];
                    }

                    if (isset($this->request->get['filter_category'])) {
                            $url .= '&filter_category=' . $this->request->get['filter_category'];
                    }

                    if (isset($this->request->get['page'])) {
                            $url .= '&page=' . $this->request->get['page'];
                    }
                    
                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
            }

            $this->getForm();
	}
        
        /**
         * Update Article
         */
        public function update()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/article'); 
            $this->load->language('ac_cms/article');
            
            $this->data['languages'] = $this->model_localisation_language->getLanguages();
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                    $this->model_ac_cms_article->updateArticle($this->request->get['b_id'],$this->request->post); 
                    
                    $url = '';

                    if (isset($this->request->get['filter_title'])) {
                            $url .= '&filter_title=' . $this->request->get['filter_title'];
                    }

                    if (isset($this->request->get['filter_author'])) {
                            $url .= '&filter_author=' . $this->request->get['filter_author'];
                    }	

                    if (isset($this->request->get['filter_access_level'])) {
                            $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
                    }

                    if (isset($this->request->get['filter_status'])) {
                            $url .= '&filter_status=' . $this->request->get['filter_status'];
                    }

                    if (isset($this->request->get['filter_category'])) {
                            $url .= '&filter_category=' . $this->request->get['filter_category'];
                    }

                    if (isset($this->request->get['page'])) {
                            $url .= '&page=' . $this->request->get['page'];
                    }
                    
                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
            }
            
            $this->getForm();
	}
        
        /**
         * Delete Article
         */
        public function delete()    
        {
            $this->load->model('ac_cms/article'); 
            $this->load->language('ac_cms/article');

            $this->data['heading_title'] = $this->language->get('heading_title');

            if (isset($this->request->post['selected']) && $this->validateDelete()) {
                    foreach ($this->request->post['selected'] as $b_id) {
                            $this->model_ac_cms_article->deleteArticle($b_id);
                    }
                    
                    $url = '';

                    if (isset($this->request->get['filter_title'])) {
                            $url .= '&filter_title=' . $this->request->get['filter_title'];
                    }

                    if (isset($this->request->get['filter_author'])) {
                            $url .= '&filter_author=' . $this->request->get['filter_author'];
                    }	

                    if (isset($this->request->get['filter_access_level'])) {
                            $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
                    }

                    if (isset($this->request->get['filter_status'])) {
                            $url .= '&filter_status=' . $this->request->get['filter_status'];
                    }

                    if (isset($this->request->get['filter_category'])) {
                            $url .= '&filter_category=' . $this->request->get['filter_category'];
                    }

                    if (isset($this->request->get['page'])) {
                            $url .= '&page=' . $this->request->get['page'];
                    }

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
            }
            
            $this->getList();
	}
        
        
        /**
         * Copy Article
         */
        public function copy()
        {
            $this->load->model('ac_cms/article');
            $this->load->language('ac_cms/article');
            
            if (isset($this->request->post['selected']) && $this->validateCopy()) {
                foreach ($this->request->post['selected'] as $b_id) {
                        $this->model_ac_cms_article->copyArticle($b_id);
                }
                
                $url = '';

                if (isset($this->request->get['filter_title'])) {
                        $url .= '&filter_title=' . $this->request->get['filter_title'];
                }

                if (isset($this->request->get['filter_author'])) {
                        $url .= '&filter_author=' . $this->request->get['filter_author'];
                }	

                if (isset($this->request->get['filter_access_level'])) {
                        $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
                }

                if (isset($this->request->get['filter_status'])) {
                        $url .= '&filter_status=' . $this->request->get['filter_status'];
                }

                if (isset($this->request->get['filter_category'])) {
                        $url .= '&filter_category=' . $this->request->get['filter_category'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                $this->session->data['success'] = $this->language->get('text_success');
                
                $this->redirect($this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
            }
        }


        private function getList()
        {
            if (isset($this->request->get['filter_title'])) {
                    $filter_title = $this->request->get['filter_title'];
            } else {
                    $filter_title = null;
            }

            if (isset($this->request->get['filter_author'])) {
                    $filter_author = $this->request->get['filter_author'];
            } else {
                    $filter_author = null;
            }

            if (isset($this->request->get['filter_status'])) {
                    $filter_status = $this->request->get['filter_status'];
            } else {
                    $filter_status = null;
            }
            
            if (isset($this->request->get['filter_access_level'])) {
                    $filter_access_level = $this->request->get['filter_access_level'];
            } else {
                    $filter_access_level = null;
            }
            
            if (isset($this->request->get['filter_category'])) {
                    $filter_category = $this->request->get['filter_category'];
            } else {
                    $filter_category = null;
            }

            if (isset($this->request->get['page'])) {
                    $page = $this->request->get['page'];
            } else {
                    $page = 1;
            }

            $url = '';

            if (isset($this->request->get['filter_title'])) {
                    $url .= '&filter_title=' . $this->request->get['filter_title'];
            }

            if (isset($this->request->get['filter_author'])) {
                    $url .= '&filter_author=' . $this->request->get['filter_author'];
            }	

            if (isset($this->request->get['filter_access_level'])) {
                    $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
            }
            
            if (isset($this->request->get['filter_status'])) {
                    $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['filter_category'])) {
                    $url .= '&filter_category=' . $this->request->get['filter_category'];
            }

            if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
            }
            
            //CATEGORIES	
            $this->load->model('ac_cms/category');
            $this->data['categories'] = $this->model_ac_cms_category->getCategories(0);

            if (isset($this->request->post['article_category'])) {
                    $this->data['article_category'] = $this->request->post['article_category'];
            } elseif (isset($this->request->get['b_id'])) {
                    $this->data['article_category'] = $this->model_ac_cms_article->getArticleCategories($this->request->get['b_id']);
            } else {
                    $this->data['article_category'] = array();
            }
            
            $this->data['text_no_results'] = $this->language->get('text_no_results');

            $this->data['text_column_name'] = $this->language->get('text_column_name');
            $this->data['entry_date_added'] = $this->language->get('entry_date_added');
            $this->data['text_column_status'] = $this->language->get('text_column_status');
            $this->data['text_column_action'] = $this->language->get('text_column_action');	
            $this->data['text_column_author'] = $this->language->get('text_column_author');	
            $this->data['text_column_access_level'] = $this->language->get('text_column_access_level');
            $this->data['text_public'] = $this->language->get('text_public');
            $this->data['text_registred'] = $this->language->get('text_registred');
            
            $this->data['text_column_date_add'] = $this->language->get('text_column_date_add');
            $this->data['text_enabled'] = $this->language->get('text_enabled');
            $this->data['text_disabled'] = $this->language->get('text_disabled');
            
            
            $this->data['button_filter'] = $this->language->get('button_filter');
            $this->data['button_module'] = $this->language->get('button_module');
            $this->data['button_insert'] = $this->language->get('button_insert');
            $this->data['button_delete'] = $this->language->get('button_delete');
            $this->data['button_copy'] = $this->language->get('button_copy');
            $this->data['button_cp'] = $this->language->get('button_cp');
            $this->data['token'] = $this->session->data['token'];
            
            if (isset($this->error['warning'])) {
                    $this->data['error_warning'] = $this->error['warning'];
            } else {
                    $this->data['error_warning'] = '';
            }

            if (isset($this->session->data['success'])) {
                    $this->data['success'] = $this->session->data['success'];

                    unset($this->session->data['success']);
            } else {
                    $this->data['success'] = '';
            }

            $this->data['breadcrumbs'] = array();

            $this->data['breadcrumbs'][] = array(
                    'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('text_home'),
                    'separator' => FALSE
            );
            
            $this->data['breadcrumbs'][] = array(
                    'href'      => $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('text_ac_cms_cp'),
                    'separator' => ' :: '
            );

            $this->data['breadcrumbs'][] = array(
                    'href'      => $this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('heading_title'),
                    'separator' => ' :: '
            );
            
            $this->data['module'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['insert'] = $this->url->link('ac_cms/article/create', 'token=' . $this->session->data['token'] . $url, 'SSL');
            $this->data['delete'] = $this->url->link('ac_cms/article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
            $this->data['copy'] = $this->url->link('ac_cms/article/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');

            $this->data['ac_cms'] = array();
            
            $data = array(
                'start' => ($page - 1) * 15,
                'limit' => 15,
		'filter_name'   => $filter_title,
                'filter_author' => $filter_author,
                'filter_status'   => $filter_status,
                'category' => $filter_category,
                'filter_access_level' => $filter_access_level
            );
            
            $results = $this->model_ac_cms_article->getArticles($data);
            $article_total = $this->model_ac_cms_article->getTotalArticles($data);
            
            $this->data['articles'] = array();
            if(!empty($results))
            {
                foreach ($results as $result) {
                        $action = array();

                        $action[] = array(
                                'text' => $this->language->get('text_edit'),
                                'href' => $this->url->link('ac_cms/article/update', 'token=' . $this->session->data['token'] . '&b_id=' . $result['b_id'] . $url, 'SSL')
                        );

                        $this->data['articles'][] = array(
                                'b_id'         => $result['b_id'],
                                'title'         => $result['title'],
                                'author'        => $result['username'],
                                'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                                'status'        => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                                'access_level'  => ($result['access_level']) ? $this->language->get('text_registred') : $this->language->get('text_public'),
                                'selected'      => isset($this->request->post['selected']) && in_array($result['b_id'], $this->request->post['selected']),
                                'action'        => $action
                        );
                } 
            }
                        
            $url = '';

            if (isset($this->request->get['filter_title'])) {
                    $url .= '&filter_title=' . $this->request->get['filter_title'];
            }

            if (isset($this->request->get['filter_author'])) {
                    $url .= '&filter_author=' . $this->request->get['filter_author'];
            }	
            
            if (isset($this->request->get['filter_category'])) {
                    $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            
            if (isset($this->request->get['filter_access_level'])) {
                    $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
            }

            if (isset($this->request->get['filter_status'])) {
                    $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            $pagination = new Pagination();
            $pagination->total = $article_total;
            $pagination->page = $page;
            $pagination->limit = 15;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
            $this->data['filter_title'] = $filter_title;
            $this->data['filter_author'] = $filter_author;
            $this->data['filter_status'] = $filter_status;
            $this->data['filter_category'] = $filter_category;
            $this->data['filter_access_level'] = $filter_access_level;

            $this->data['pagination'] = $pagination->render();
            
            $this->template = 'ac_cms/article_list.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
        }


        private function getForm()
        {
            $this->data['entry_store'] = $this->language->get('entry_store');
            $this->data['entry_title'] = $this->language->get('entry_title');
            $this->data['entry_date_active'] = $this->language->get('entry_date_active');
            $this->data['entry_date_expr'] = $this->language->get('entry_date_expr');
            $this->data['entry_status'] = $this->language->get('entry_status');
            $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
            $this->data['entry_content'] = $this->language->get('entry_content');
            $this->data['entry_seo'] = $this->language->get('entry_seo');
            $this->data['entry_image'] = $this->language->get('entry_image');
            $this->data['entry_allow_comments'] = $this->language->get('entry_allow_comments');
            $this->data['entry_com_need_apr'] = $this->language->get('entry_com_need_apr');
            $this->data['entry_related_articles'] = $this->language->get('entry_related_articles');
            $this->data['entry_related_products'] = $this->language->get('entry_related_products');
            $this->data['entry_article_tags'] = $this->language->get('entry_article_tags');
            $this->data['entry_category'] = $this->language->get('entry_category');
            $this->data['entry_layout'] = $this->language->get('entry_layout');
            $this->data['entry_disable_cat_list'] = $this->language->get('entry_disable_cat_list');
            $this->data['entry_disable_com_count'] = $this->language->get('entry_disable_com_count');
            $this->data['entry_disable_author'] = $this->language->get('entry_disable_author');
            $this->data['entry_disable_create_date'] = $this->language->get('entry_disable_create_date');
            $this->data['entry_disable_mod_date'] = $this->language->get('entry_disable_mod_date');
            $this->data['entry_override_gs'] = $this->language->get('entry_override_gs');
            $this->data['entry_disable_fblike'] = $this->language->get('entry_disable_fblike');
            $this->data['entry_disable_viewed'] = $this->language->get('entry_disable_viewed');
            $this->data['entry_disable_share'] = $this->language->get('entry_disable_share');
            $this->data['entry_not_for_blog'] = $this->language->get('entry_not_for_blog');
            $this->data['entry_access_level'] = $this->language->get('entry_access_level');
            $this->data['entry_com_notify'] = $this->language->get('entry_com_notify');
            
            $this->data['text_enabled'] = $this->language->get('text_enabled');
            $this->data['text_disabled'] = $this->language->get('text_disabled');
            $this->data['text_default'] = $this->language->get('text_default');
            $this->data['text_yes'] = $this->language->get('text_yes');
            $this->data['text_no'] = $this->language->get('text_no');
            $this->data['text_browse'] = $this->language->get('text_browse');
            $this->data['text_clear'] = $this->language->get('text_clear');
            $this->data['text_image_manager'] = $this->language->get('text_image_manager');
            $this->data['text_select_all'] = $this->language->get('text_select_all');
	    $this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
            $this->data['text_read_more_tag'] = $this->language->get('text_read_more_tag');
            $this->data['text_read_more_tag_err'] = $this->language->get('text_read_more_tag_err');
            $this->data['text_read_more_tag_err2'] = $this->language->get('text_read_more_tag_err2');
            $this->data['text_public'] = $this->language->get('text_public');
            $this->data['text_registred'] = $this->language->get('text_registred');
            
            $this->data['heading_title'] = $this->language->get('heading_title');
            $this->data['breadcrumbs'] = array();
            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_cancel'] = $this->language->get('button_cancel');
            $this->data['tab_general'] = $this->language->get('tab_general');
            $this->data['tab_data'] = $this->language->get('tab_data');
            $this->data['tab_comment'] = $this->language->get('tab_comment');
            $this->data['tab_links'] = $this->language->get('tab_links');
            $this->data['tab_design'] = $this->language->get('tab_design');
            $this->data['meta_keywords'] = $this->language->get('entry_meta_keywords');
            $this->data['meta_description'] = $this->language->get('entry_meta_description');
            $this->data['token'] = $this->session->data['token'];
            
            $url = '';

            if (isset($this->request->get['filter_title'])) {
                    $url .= '&filter_title=' . $this->request->get['filter_title'];
            }

            if (isset($this->request->get['filter_author'])) {
                    $url .= '&filter_author=' . $this->request->get['filter_author'];
            }	
            
            if (isset($this->request->get['filter_category'])) {
                    $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            
            if (isset($this->request->get['filter_access_level'])) {
                    $url .= '&filter_access_level=' . $this->request->get['filter_access_level'];
            }

            if (isset($this->request->get['filter_status'])) {
                    $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            
            if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->data['cancel'] = $this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'] . $url, 'SSL');
            
            if (isset($this->error['warning'])) {
                    $this->data['error_warning'] = $this->error['warning'];
            } else {
                    $this->data['error_warning'] = '';
            }
            
            if (isset($this->error['title'])) {
                    $this->data['error_title'] = $this->error['title'];
            } else {
                    $this->data['error_title'] = array();
            }
            
            if (isset($this->error['intro'])) {
                    $this->data['error_intro'] = $this->error['intro'];
            } else {
                    $this->data['error_intro'] = array();
            }

            $this->data['breadcrumbs'][] = array(
                    'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('text_home'),
                    'separator' => FALSE
            );
            
            $this->data['breadcrumbs'][] = array(
                    'href'      => $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('text_ac_cms_cp'),
                    'separator' => ' :: '
            );

            $this->data['breadcrumbs'][] = array(
                    'href'      => $this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('heading_title'),
                    'separator' => ' :: '
            );
            
            
            $this->load->model('setting/store');
		
            $this->data['stores'] = $this->model_setting_store->getStores();
            
            //ARTICLE TO STORE
            if (isset($this->request->post['article_store'])) {
                    $this->data['article_store'] = $this->request->post['article_store'];
            } elseif (isset($this->request->get['b_id'])) {
                    $this->data['article_store'] = $this->model_ac_cms_article->getArticleStores($this->request->get['b_id']);
            } else {
                    $this->data['article_store'] = array(0);
            }
            
            //DESCRIPTION
            if (isset($this->request->post['ac_cms_description'])) 
            {
		$this->data['ac_cms_description'] = $this->request->post['ac_cms_description'];
            } 
            elseif (isset($this->request->get['b_id'])) 
            {
                $this->data['ac_cms_description'] = $this->model_ac_cms_article->getArticleDescription($this->request->get['b_id'], true);
            } 
            else 
            {
                $this->data['ac_cms_description'] = array();
            }
            
            if (isset($this->request->get['b_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')){
              $article_info = $this->model_ac_cms_article->getArticle($this->request->get['b_id']);  
            }
            
            //CATEGORIES	
            $this->load->model('ac_cms/category');
            $this->data['categories'] = $this->model_ac_cms_category->getCategories(0);

            if (isset($this->request->post['article_category'])) {
                    $this->data['article_category'] = $this->request->post['article_category'];
            } elseif (isset($this->request->get['b_id'])) {
                    $this->data['article_category'] = $this->model_ac_cms_article->getArticleCategories($this->request->get['b_id']);
            } else {
                    $this->data['article_category'] = array();
            }
            
            //SEO
            if (isset($this->request->post['keyword'])) {
                    $this->data['keyword'] = $this->request->post['keyword'];
            } elseif (!empty($article_info)) {
                    $this->data['keyword'] = $article_info['keyword'];
            } else {
                    $this->data['keyword'] = '';
            }
            
            //PROD RELATE
            $this->load->model('catalog/product');
            if (isset($this->request->post['product_related'])) {
                $products = $this->request->post['product_related'];
            } elseif (isset($this->request->get['b_id'])) {		
                    $products = $this->model_ac_cms_article->getProductRelated($this->request->get['b_id']);
            } else {
                    $products = array();
            }
            $this->data['product_related'] = array();
            
            foreach ($products as $product_id) {
                $related_info = $this->model_catalog_product->getProduct($product_id);

                if ($related_info) {
                        $this->data['product_related'][] = array(
                                'product_id' => $related_info['product_id'],
                                'name'       => $related_info['name']
                        );
                }
            }
            
            //ARTICLE RELATE
            if (isset($this->request->post['article_related'])) {
                $articles = $this->request->post['article_related'];
            } elseif (isset($this->request->get['b_id'])) {		
                    $articles = $this->model_ac_cms_article->getArticleRelated($this->request->get['b_id']);
            } else {
                    $articles = array();
            }
            $this->data['article_related'] = array();
		
            foreach ($articles as $b_id) {
                $related_info = $this->model_ac_cms_article->getArticle($b_id);
                if ($related_info) {
                        $this->data['article_related'][] = array(
                                'b_id'        => $related_info['b_id'],
                                'title'       => $related_info['title']
                        );
                }
            }
            
            //IMAGE
            if (isset($this->request->post['image'])) {
                    $this->data['image'] = $this->request->post['image'];
            } elseif (!empty($article_info)) {
                    $this->data['image'] = $article_info['image'];
            } else {
                    $this->data['image'] = '';
            }

            $this->load->model('tool/image');

            if (!empty($article_info) && $article_info['image'] && file_exists(DIR_IMAGE . $article_info['image'])) {
                    $this->data['thumb'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
            } else {
                    $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
            }
            
            $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
            
            //TAG
            if (isset($this->request->post['article_tag'])) {
                    $this->data['article_tag'] = $this->request->post['article_tag'];
            } elseif (isset($this->request->get['b_id'])) {
                    $this->data['article_tag'] = $this->model_ac_cms_article->getArticleTags($this->request->get['b_id']);
            } else {
                    $this->data['article_tag'] = array();
            }
            
            //STATUS
            if (isset($this->request->post['status'])) {
                    $this->data['status'] = $this->request->post['status'];
            } elseif (!empty($article_info)) {
                    $this->data['status'] = $article_info['status'];
            } else {
                    $this->data['status'] = 0;
            }
            
            //ACCESS LEVEL
            if (isset($this->request->post['access_level'])) {
                    $this->data['access_level'] = $this->request->post['access_level'];
            } elseif (!empty($article_info)) {
                    $this->data['access_level'] = $article_info['access_level'];
            } else {
                    $this->data['access_level'] = 0;
            }
            
            //COMMENT ACCESS LEVEL
            if (isset($this->request->post['com_access_level'])) {
                    $this->data['com_access_level'] = $this->request->post['com_access_level'];
            } elseif (!empty($article_info)) {
                    $this->data['com_access_level'] = $article_info['com_access_level'];
            } else {
                    $this->data['com_access_level'] = 0;
            }
            
            //COMMEN NOTIFY
            if (isset($this->request->post['com_notify'])) {
                    $this->data['com_notify'] = $this->request->post['com_notify'];
            } elseif (!empty($article_info)) {
                    $this->data['com_notify'] = $article_info['com_notify'];
            } else {
                    $this->data['com_notify'] = 0;
            }
            
            //Remove From Blog
            if (isset($this->request->post['not_for_blog'])) {
                    $this->data['not_for_blog'] = $this->request->post['not_for_blog'];
            } elseif (!empty($article_info['not_for_blog'])) {
                    $this->data['not_for_blog'] = $article_info['not_for_blog'];
            } else {
                    $this->data['not_for_blog'] = 0;
            }
            
            //ALLOW COMMENTS
            if (isset($this->request->post['allow_comments'])) {
                    $this->data['allow_comments'] = $this->request->post['allow_comments'];
            } elseif (!empty($article_info)) {
                    $this->data['allow_comments'] = $article_info['allow_comments'];
            } else {
                    $this->data['allow_comments'] = 0;
            }
            
            //COMMENTS NEED APROVE
            if (isset($this->request->post['com_need_apr'])) {
                    $this->data['com_need_apr'] = $this->request->post['com_need_apr'];
            } elseif (!empty($article_info)) {
                    $this->data['com_need_apr'] = $article_info['comments_approve'];
            } else {
                    $this->data['com_need_apr'] = 0;
            }
            
            //DATE ACTIVE
            if (isset($this->request->post['date_active'])) {
                    $this->data['date_active'] = $this->request->post['date_active'];
            } elseif (!empty($article_info)) {
                    $this->data['date_active'] = $article_info['date_active'];
            } else {
                    $this->data['date_active'] = "";
            }
            
            //DATE EXPR
            if (isset($this->request->post['date_expr'])) {
                    $this->data['date_expr'] = $this->request->post['date_expr'];
            } elseif (!empty($article_info)) {
                    $this->data['date_expr'] = $article_info['date_expr'];
            } else {
                    $this->data['date_expr'] = "";
            }
            
            //SORT ORDER
            if (isset($this->request->post['sort_order'])) {
                    $this->data['sort_order'] = $this->request->post['sort_order'];
            } elseif (!empty($article_info)) {
                    $this->data['sort_order'] = $article_info['sort_order'];
            } else {
                    $this->data['sort_order'] = "";
            }

            //Disable Author
            if (isset($this->request->post['settings']['disable_author'])) {
                    $this->data['disable_top_bar'] = $this->request->post['settings']['disable_author'];
            } elseif (!empty($article_info['settings']['disable_author'])) {
                    $this->data['disable_author'] = $article_info['settings']['disable_author'];
            } else {
                    $this->data['disable_author'] = 0;
            }
            
            //Disable Create Date
            if (isset($this->request->post['settings']['disable_create_date'])) {
                    $this->data['disable_create_date'] = $this->request->post['settings']['disable_create_date'];
            } elseif (!empty($article_info['settings']['disable_create_date'])) {
                    $this->data['disable_create_date'] = $article_info['settings']['disable_create_date'];
            } else {
                    $this->data['disable_create_date'] = 0;
            }
            
            //Disable Modified Date
            if (isset($this->request->post['settings']['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $this->request->post['settings']['disable_mod_date'];
            } elseif (!empty($article_info['settings']['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $article_info['settings']['disable_mod_date'];
            } else {
                    $this->data['disable_mod_date'] = 0;
            }
            
            //Disable Cat List
            if (isset($this->request->post['settings']['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $this->request->post['settings']['disable_cat_list'];
            } elseif (!empty($article_info['settings']['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $article_info['settings']['disable_cat_list'];
            } else {
                    $this->data['disable_cat_list'] = 0;
            }
            
            //Disable Com Count
            if (isset($this->request->post['settings']['disable_com_count'])) {
                    $this->data['disable_com_count'] = $this->request->post['settings']['disable_com_count'];
            } elseif (!empty($article_info['settings']['disable_com_count'])) {
                    $this->data['disable_com_count'] = $article_info['settings']['disable_com_count'];
            } else {
                    $this->data['disable_com_count'] = 0;
            }
            
            //Disable Viewed
            if (isset($this->request->post['settings']['disable_viewed'])) {
                    $this->data['disable_viewed'] = $this->request->post['settings']['disable_viewed'];
            } elseif (!empty($article_info['settings']['disable_viewed'])) {
                    $this->data['disable_viewed'] = $article_info['settings']['disable_viewed'];
            } else {
                    $this->data['disable_viewed'] = 0;
            }
            
            //Disable Fb Like Button renroc tra
            if (isset($this->request->post['settings']['disable_fblike'])) {
                    $this->data['disable_fblike'] = $this->request->post['settings']['disable_fblike'];
            } elseif (!empty($article_info['settings']['disable_fblike'])) {
                    $this->data['disable_fblike'] = $article_info['settings']['disable_fblike'];
            } else {
                    $this->data['disable_fblike'] = 0;
            }
            
            //Disable AddThis
            if (isset($this->request->post['settings']['disable_share'])) {
                    $this->data['disable_share'] = $this->request->post['settings']['disable_share'];
            } elseif (!empty($article_info['settings']['disable_share'])) {
                    $this->data['disable_share'] = $article_info['settings']['disable_share'];
            } else {
                    $this->data['disable_share'] = 0;
            }
            
            //Override Gs golb_ca
            if (isset($this->request->post['settings']['override_gs'])) {
                    $this->data['override_gs'] = $this->request->post['settings']['override_gs'];
            } elseif (!empty($article_info['settings']['override_gs'])) {
                    $this->data['override_gs'] = $article_info['settings']['override_gs'];
            } else {
                    $this->data['override_gs'] = 0;
            }
                       
            //Layout
            if (isset($this->request->post['article_layout'])) {
                    $this->data['article_layout'] = $this->request->post['article_layout'];
            } elseif (isset($this->request->get['b_id'])) {
                    $this->data['article_layout'] = $this->model_ac_cms_article->getArticleLayouts($this->request->get['b_id']);
            } else {
                    $this->data['article_layout'] = array();
            }
            
            if (!isset($this->request->get['b_id'])) {
                    $this->data['action'] = $this->url->link('ac_cms/article/create', 'token=' . $this->session->data['token'] . $url, 'SSL');
            } else {
                    $this->data['action'] = $this->url->link('ac_cms/article/update', 'token=' . $this->session->data['token'] . '&b_id=' . $this->request->get['b_id'] . $url, 'SSL');
            }
            
            $this->load->model('design/layout');
		
            $this->data['layouts'] = $this->model_design_layout->getLayouts();
            
            $this->template = 'ac_cms/article_form.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
        }

                     
                
        private function validateForm() 
        {
            if (!$this->user->hasPermission('modify', 'ac_cms/article')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            
            foreach ($this->request->post['ac_cms_description'] as $language_id => $value) {
                    
                    if ((utf8_strlen($value['title']) <= 0) || (utf8_strlen($value['title']) > 255)) {
                            $this->error['title'][$language_id] = $this->language->get('error_title');
                    }
                    if (utf8_strlen(trim(strip_tags(html_entity_decode($value['intro'], ENT_QUOTES, 'UTF-8'),'<img>,<iframe>'))) <= 3) {
                            $this->error['intro'][$language_id] = $this->language->get('error_description');
                    }
            }
            if ($this->error && !isset($this->error['warning'])) {
                    $this->error['warning'] = $this->language->get('error_form');
            }
            if (!$this->error) {
                    return true;
            } else {
                    return false;
            }	
	}
        
        private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ac_cms/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
        
        private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'ac_cms/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
        
        //AUTOCOMPLETE
        public function autocomplete() {
            $json = array();
            
            if (isset($this->request->get['filter_name'])) {
                    $filter_name = $this->request->get['filter_name'];
            } else {
                    $filter_name = '';
            }

            $data = array('filter_name' => $filter_name);
            
            if (isset($this->request->get['type'])) {
                if($this->request->get['type'] == 'product')
                {
                    $this->load->model('catalog/product'); 
                    
                    $results = $this->model_catalog_product->getProducts($data);

                    foreach ($results as $result) {
                        $json[] = array(
                                'product_id' => $result['product_id'],
                                'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')
                        );
                    }
                }
            }
            else
            {                
                $data = array('filter_name' => $filter_name);
                
                $this->load->model('ac_cms/article'); 

                $results = $this->model_ac_cms_article->getArticles($data);

                foreach ($results as $result) {
                    $json[] = array(
                            'b_id' => $result['b_id'],
                            'title'       => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')
                    );
                }
            }
            
            $this->response->setOutput(json_encode($json));
        }
        
        public function articles() {
            
            $this->load->language('ac_cms/article');
            
            $output = '<option value="">' . $this->language->get('text_select_all_d') . '</option>';

            $this->load->model('ac_cms/article');
            
            $results = array();
            
            if($this->request->get['bc_id'] != 0)
            {
               $results = $this->model_ac_cms_article->getArticles(array('category' => $this->request->get['bc_id'])); 
            }
            
            foreach ($results as $result) {
                $output .= '<option value="' . $result['b_id'] . '"';

                if (isset($this->request->get['b_id']) && ($this->request->get['b_id'] == $result['b_id'])) {
                        $output .= ' selected="selected"';
                }

                $output .= '>' . $result['title'] . '</option>';
            } 

            $this->response->setOutput($output);
        } 
}

?>
