<?php

class ControllerACcmsArticleSet extends Controller {
     private $error = array();
     
     public function article_sets()
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/article_set'); 
            $this->load->language('ac_cms/article_set');
            
            $this->getArticleSetList();
        }

        /**
         * Create Article Set
         */
        public function create_set()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/article_set'); 
            $this->load->language('ac_cms/article_set');
            
            $this->data['languages'] = $this->model_localisation_language->getLanguages();
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSetForm()) {
                
                if($this->request->post['set_id'] == 0) {
                    $this->model_ac_cms_article_set->addSet($this->request->post); 
                } else {
                    $this->model_ac_cms_article_set->updateSet($this->request->post['set_id'], $this->request->post);
                }

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL')); 
            }

            $this->getArticleSetForm();
	}
        
        public function update_set()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/article_set'); 
            $this->load->language('ac_cms/article_set');
            
            $this->data['languages'] = $this->model_localisation_language->getLanguages();
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateSetForm()) {
                    $this->model_ac_cms_article_set->updateSet($this->request->get['bs_id'], $this->request->post); 

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL')); 
            }

            $this->getArticleSetForm();
	}
        
        public function delete_set()    
        {
            $this->load->model('ac_cms/article_set'); 
            $this->load->language('ac_cms/article_set');

            $this->data['heading_title'] = $this->language->get('heading_title');

            if (isset($this->request->post['selected']) && $this->validateDelete()) {
                    foreach ($this->request->post['selected'] as $bs_id) {
                            $this->model_ac_cms_article_set->deleteSet($bs_id);
                    }

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL'));
            }
            
            $this->getList();
	}
        
        /**
         * Copy Article Set
         */
        public function copy()
        {
            $this->load->model('ac_cms/article_set');
            $this->load->language('ac_cms/article_set');
            
            if (isset($this->request->post['selected']) && $this->validateCopy()) {
                foreach ($this->request->post['selected'] as $bs_id) {
                    $this->model_ac_cms_article_set->copySet($bs_id);
                }
                
                $this->session->data['success'] = $this->language->get('text_success');
                
                $this->redirect($this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }
        
        private function getArticleSetList() 
        {
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
                    'href'      => $this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('heading_title'),
                    'separator' => ' :: '
            );

            $this->data['insert'] = $this->url->link('ac_cms/article_set/create_set', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['copy'] = $this->url->link('ac_cms/article_set/copy', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['delete'] = $this->url->link('ac_cms/article_set/delete_set', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['module'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['article_sets'] = array();

            $results = $this->model_ac_cms_article_set->getArticleSets();

            foreach ($results as $result) {
                    $action = array();

                    $action[] = array(
                            'text' => $this->language->get('text_edit'),
                            'href' => $this->url->link('ac_cms/article_set/update_set', 'token=' . $this->session->data['token'] . '&bs_id=' . $result['bs_id'], 'SSL')
                    );

                    $this->data['article_sets'][] = array(
                            'bs_id'       => $result['bs_id'],
                            'title'        => $result['title'],
                            'selected'    => isset($this->request->post['selected']) && in_array($result['bs_id'], $this->request->post['selected']),
                            'action'      => $action
                    );
            }

            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_no_results'] = $this->language->get('text_no_results');

            $this->data['text_column_name'] = $this->language->get('text_column_name');
            $this->data['text_column_action'] = $this->language->get('text_column_action');
            
            $this->data['button_insert'] = $this->language->get('button_insert');
            $this->data['button_delete'] = $this->language->get('button_delete');
            $this->data['button_copy'] = $this->language->get('button_copy');
            $this->data['button_cp'] = $this->language->get('button_cp');

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

            $this->template = 'ac_cms/article_set_list.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
	}
        
        private function getArticleSetForm()
        {
            $this->data['entry_as_title'] = $this->language->get('entry_as_title');
            $this->data['entry_select_cat'] = $this->language->get('entry_select_cat');
            $this->data['entry_select_art'] = $this->language->get('entry_select_art');
            $this->data['entry_column_width'] = $this->language->get('entry_column_width');
            $this->data['entry_lead_art_amount'] = $this->language->get('entry_lead_art_amount');
            $this->data['entry_art_amount'] = $this->language->get('entry_art_amount');
            $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
            $this->data['entry_art_columns'] = $this->language->get('entry_art_columns');
            $this->data['entry_sort_by'] = $this->language->get('entry_sort_by');
            $this->data['entry_allow_paging'] = $this->language->get('entry_allow_paging');
            $this->data['entry_page_size'] = $this->language->get('entry_page_size');
            $this->data['entry_title_position'] = $this->language->get('entry_title_position');
            $this->data['entry_info_position'] = $this->language->get('entry_info_position');
            $this->data['entry_image_position'] = $this->language->get('entry_image_position');
            $this->data['entry_text_position'] = $this->language->get('entry_text_position');
            $this->data['entry_readmore_position'] = $this->language->get('entry_readmore_position');
            $this->data['entry_title_order'] = $this->language->get('entry_title_order');
            $this->data['entry_info_order'] = $this->language->get('entry_info_order');
            $this->data['entry_image_order'] = $this->language->get('entry_image_order');
            $this->data['entry_text_order'] = $this->language->get('entry_text_order');
            $this->data['entry_readmore_order'] = $this->language->get('entry_readmore_order');
            $this->data['entry_disable_author'] = $this->language->get('entry_disable_author');
            $this->data['entry_disable_mod_date'] = $this->language->get('entry_disable_mod_date');
            $this->data['entry_disable_create_date'] = $this->language->get('entry_disable_create_date');
            $this->data['entry_max_char_content'] = $this->language->get('entry_max_char_content');
            $this->data['entry_max_char_title'] = $this->language->get('entry_max_char_title');
            $this->data['entry_news_image_height'] = $this->language->get('entry_news_image_height');
            $this->data['entry_news_image_width'] = $this->language->get('entry_news_image_width');
            $this->data['entry_news_image_margin'] = $this->language->get('entry_news_image_margin');
            $this->data['entry_position'] = $this->language->get('entry_position');
            $this->data['entry_disable_cat_list'] = $this->language->get('entry_disable_cat_list');
            $this->data['entry_disable_com_count'] = $this->language->get('entry_disable_com_count');
            $this->data['entry_text_as_link'] = $this->language->get('entry_text_as_link');
            $this->data['entry_image_as_link'] = $this->language->get('entry_image_as_link');
            $this->data['entry_title_as_link'] = $this->language->get('entry_title_as_link');
            $this->data['entry_keep_html_format'] = $this->language->get('entry_keep_html_format');
            $this->data['entry_display_type'] = $this->language->get('entry_display_type');
            $this->data['entry_slideshow_width'] = $this->language->get('entry_slideshow_width');
            $this->data['entry_slideshow_height'] = $this->language->get('entry_slideshow_height');
            $this->data['entry_slideshow_cm'] = $this->language->get('entry_slideshow_cm');
            
            $this->data['heading_title'] = $this->language->get('heading_title');
            $this->data['tab_general'] = $this->language->get('tab_general');
            $this->data['tab_data'] = $this->language->get('tab_data');
            
            $this->data['text_disabled'] = $this->language->get('text_disabled');
            $this->data['text_left'] = $this->language->get('text_left');
            $this->data['text_right'] = $this->language->get('text_right');
            $this->data['text_center'] = $this->language->get('text_center');
            $this->data['text_justify'] = $this->language->get('text_justify');
            $this->data['text_desc'] = $this->language->get('text_desc');
            $this->data['text_asc'] = $this->language->get('text_asc');
            $this->data['text_select_all'] = $this->language->get('text_select_all');
	    $this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
            
            $this->data['text_sort_by_title'] = $this->language->get('text_sort_by_title');
            $this->data['text_sort_by_author'] = $this->language->get('text_sort_by_author');
            $this->data['text_sort_by_viewed'] = $this->language->get('text_sort_by_viewed');
            $this->data['text_sort_by_art_so'] = $this->language->get('text_sort_by_art_so');
            $this->data['text_sort_by_modate'] = $this->language->get('text_sort_by_modate');
            $this->data['text_sort_by_crdate'] = $this->language->get('text_sort_by_crdate');
                                
            $this->data['token'] = $this->session->data['token'];
            $this->data['cancel'] = $this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_apply'] = $this->language->get('button_apply');
            $this->data['button_cancel'] = $this->language->get('button_cancel');
            $this->data['bs_id'] = (isset($this->request->get['bs_id'])) ? $this->request->get['bs_id'] : 0;
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
                    'href'      => $this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('heading_title'),
                    'separator' => ' :: '
            );
            
            //DESCRIPTION
            if (isset($this->request->post['article_set_description'])) 
            {
		$this->data['article_set_description'] = $this->request->post['article_set_description'];
            } 
            elseif (isset($this->request->get['bs_id'])) 
            {
                $this->data['article_set_description'] = $this->model_ac_cms_article_set->getArticleSetDescriptions($this->request->get['bs_id']);
            } 
            else 
            {
                $this->data['article_set_description'] = array();
            }
            
            if (isset($this->request->get['bs_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')){
              $article_set_info = $this->model_ac_cms_article_set->getArticleSet($this->request->get['bs_id']);  
            }
            
            //TYPE
            if (isset($this->request->post['display_type'])) {
                    $this->data['display_type'] = $this->request->post['display_type'];
            } elseif (!empty($article_set_info['display_type'])) {
                    $this->data['display_type'] = $article_set_info['display_type'];
            } else {
                    $this->data['display_type'] = '';
            }
            
            $this->data['display_types'] = array(
                '' => $this->language->get('text_default'),
                1 => $this->language->get('text_accordion'),
                2 => $this->language->get('text_slideshow'),
                3 => $this->language->get('text_tabs_article'),
                4 => $this->language->get('text_tabs_category')
            );
            
            
            //Slideshow Width
            if (isset($this->request->post['settings']['slideshow_width'])) {
                    $this->data['slideshow_width'] = $this->request->post['settings']['slideshow_width'];
            } elseif (!empty($article_set_info['settings']['slideshow_width'])) {
                    $this->data['slideshow_width'] = $article_set_info['settings']['slideshow_width'];
            } else {
                    $this->data['slideshow_width'] = '';
            }
            
            //Slideshow Height
            if (isset($this->request->post['settings']['slideshow_height'])) {
                    $this->data['slideshow_height'] = $this->request->post['settings']['slideshow_height'];
            } elseif (!empty($article_set_info['settings']['slideshow_height'])) {
                    $this->data['slideshow_height'] = $article_set_info['settings']['slideshow_height'];
            } else {
                    $this->data['slideshow_height'] = '';
            }
            
            //Slideshow Caption Margin
            if (isset($this->request->post['settings']['slideshow_cm'])) {
                    $this->data['slideshow_cm'] = $this->request->post['settings']['slideshow_cm'];
            } elseif (!empty($article_set_info['settings']['slideshow_cm'])) {
                    $this->data['slideshow_cm'] = $article_set_info['settings']['slideshow_cm'];
            } else {
                    $this->data['slideshow_cm'] = '';
            }
            
            //Column Width
            if (isset($this->request->post['settings']['column_width'])) {
                    $this->data['column_width'] = $this->request->post['settings']['column_width'];
            } elseif (!empty($article_set_info['settings']['column_width'])) {
                    $this->data['column_width'] = $article_set_info['settings']['column_width'];
            } else {
                    $this->data['column_width'] = '';
            }
            
            //Lead Article Amount
            if (isset($this->request->post['settings']['lead_art_amount'])) {
                    $this->data['lead_art_amount'] = $this->request->post['settings']['lead_art_amount'];
            } elseif (!empty($article_set_info['settings']['lead_art_amount'])) {
                    $this->data['lead_art_amount'] = $article_set_info['settings']['lead_art_amount'];
            } else {
                    $this->data['lead_art_amount'] = '';
            }
            
            //Article Amount
            if (isset($this->request->post['settings']['art_amount'])) {
                    $this->data['art_amount'] = $this->request->post['settings']['art_amount'];
            } elseif (!empty($article_set_info['settings']['art_amount'])) {
                    $this->data['art_amount'] = $article_set_info['settings']['art_amount'];
            } else {
                    $this->data['art_amount'] = '';
            }
            
            //Article Columns
            if (isset($this->request->post['settings']['art_columns'])) {
                    $this->data['art_columns'] = $this->request->post['settings']['art_columns'];
            } elseif (!empty($article_set_info['settings']['art_columns'])) {
                    $this->data['art_columns'] = $article_set_info['settings']['art_columns'];
            } else {
                    $this->data['art_columns'] = '';
            }
            
            //Sort By
            if (isset($this->request->post['settings']['sort_by'])) {
                    $this->data['sort_by'] = $this->request->post['settings']['sort_by'];
            } elseif (!empty($article_set_info['settings']['sort_by'])) {
                    $this->data['sort_by'] = $article_set_info['settings']['sort_by'];
            } else {
                    $this->data['sort_by'] = '';
            }
            
            //Page Size
            if (isset($this->request->post['settings']['page_size'])) {
                    $this->data['page_size'] = $this->request->post['settings']['page_size'];
            } elseif (!empty($article_set_info['settings']['page_size'])) {
                    $this->data['page_size'] = $article_set_info['settings']['page_size'];
            } else {
                    $this->data['page_size'] = '';
            }
            
            //Max Char Title
            if (isset($this->request->post['settings']['max_char_title'])) {
                    $this->data['max_char_title'] = $this->request->post['settings']['max_char_title'];
            } elseif (!empty($article_set_info['settings']['max_char_title'])) {
                    $this->data['max_char_title'] = $article_set_info['settings']['max_char_title'];
            } else {
                    $this->data['max_char_title'] = '';
            }
            
            //Max Char Content
            if (isset($this->request->post['settings']['max_char_content'])) {
                    $this->data['max_char_content'] = $this->request->post['settings']['max_char_content'];
            } elseif (!empty($article_set_info['settings']['max_char_content'])) {
                    $this->data['max_char_content'] = $article_set_info['settings']['max_char_content'];
            } else {
                    $this->data['max_char_content'] = '';
            }
            
            //Keep text formating
            if (isset($this->request->post['settings']['keep_html_format'])) {
                    $this->data['keep_html_format'] = $this->request->post['settings']['keep_html_format'];
            } elseif (!empty($article_set_info['settings']['keep_html_format'])) {
                    $this->data['keep_html_format'] = $article_set_info['settings']['keep_html_format'];
            } else {
                    $this->data['keep_html_format'] = '';
            }
            
            //Image Height
            if (isset($this->request->post['settings']['image_height'])) {
                    $this->data['image_height'] = $this->request->post['settings']['image_height'];
            } elseif (!empty($article_set_info['settings']['image_height'])) {
                    $this->data['image_height'] = $article_set_info['settings']['image_height'];
            } else {
                    $this->data['image_height'] = '';
            }
            
            //Image Width
            if (isset($this->request->post['settings']['image_width'])) {
                    $this->data['image_width'] = $this->request->post['settings']['image_width'];
            } elseif (!empty($article_set_info['settings']['image_width'])) {
                    $this->data['image_width'] = $article_set_info['settings']['image_width'];
            } else {
                    $this->data['image_width'] = '';
            }
            
            //Image Margin
            if (isset($this->request->post['settings']['image_margin'])) {
                    $this->data['image_margin'] = $this->request->post['settings']['image_margin'];
            } elseif (!empty($article_set_info['settings']['image_margin'])) {
                    $this->data['image_margin'] = $article_set_info['settings']['image_margin'];
            } else {
                    $this->data['image_margin'] = '0px 0px 0px 0px';
            }
            
            //Sort
            if (isset($this->request->post['settings']['sort'])) {
                    $this->data['sort'] = $this->request->post['settings']['sort'];
            } elseif (!empty($article_set_info['settings']['sort'])) {
                    $this->data['sort'] = $article_set_info['settings']['sort'];
                    $this->data['sort_array'] = explode(',', $article_set_info['settings']['sort']);
            } else {
                    $this->data['sort'] = 'title,info,image,text,r_more';
            }
            
            //Title Order
            if (isset($this->request->post['settings']['title_order'])) {
                    $this->data['title_order'] = $this->request->post['settings']['title_order'];
            } elseif (isset($article_set_info['settings']['title_order'])) {
                    $this->data['title_order'] = $article_set_info['settings']['title_order'];
            } else {
                    $this->data['title_order'] = 1;
            }
            
            //Info Order
            if (isset($this->request->post['settings']['info_order'])) {
                    $this->data['info_order'] = $this->request->post['settings']['info_order'];
            } elseif (isset($article_set_info['settings']['info_order'])) {
                    $this->data['info_order'] = $article_set_info['settings']['info_order'];
            } else {
                    $this->data['info_order'] = 1;
            }
            
            //Image Order
            if (isset($this->request->post['settings']['image_order'])) {
                    $this->data['image_order'] = $this->request->post['settings']['image_order'];
            } elseif (isset($article_set_info['settings']['image_order'])) {
                    $this->data['image_order'] = $article_set_info['settings']['image_order'];
            } else {
                    $this->data['image_order'] = 1;
            }
            
            //Text Order
            if (isset($this->request->post['settings']['text_order'])) {
                    $this->data['text_order'] = $this->request->post['settings']['text_order'];
            } elseif (isset($article_set_info['settings']['text_order'])) {
                    $this->data['text_order'] = $article_set_info['settings']['text_order'];
            } else {
                    $this->data['text_order'] = 1;
            }
            
            //Read More Order
            if (isset($this->request->post['settings']['readmore_order'])) {
                    $this->data['readmore_order'] = $this->request->post['settings']['readmore_order'];
            } elseif (isset($article_set_info['settings']['readmore_order'])) {
                    $this->data['readmore_order'] = $article_set_info['settings']['readmore_order'];
            } else {
                    $this->data['readmore_order'] = 1;
            }
            
            //Text as Link
            if (isset($this->request->post['settings']['text_as_link'])) {
                    $this->data['text_as_link'] = $this->request->post['settings']['text_as_link'];
            } elseif (isset($article_set_info['settings']['text_as_link'])) {
                    $this->data['text_as_link'] = $article_set_info['settings']['text_as_link'];
            } else {
                    $this->data['text_as_link'] = 0;
            }
            
            //Image as Link
            if (isset($this->request->post['settings']['image_as_link'])) {
                    $this->data['image_as_link'] = $this->request->post['settings']['image_as_link'];
            } elseif (isset($article_set_info['settings']['image_as_link'])) {
                    $this->data['image_as_link'] = $article_set_info['settings']['image_as_link'];
            } else {
                    $this->data['image_as_link'] = 0;
            }
            
            //Title as Link
            if (isset($this->request->post['settings']['title_as_link'])) {
                    $this->data['title_as_link'] = $this->request->post['settings']['title_as_link'];
            } elseif (isset($article_set_info['settings']['title_as_link'])) {
                    $this->data['title_as_link'] = $article_set_info['settings']['title_as_link'];
            } else {
                    $this->data['title_as_link'] = 0;
            }
            
            //Disable Author
            if (isset($this->request->post['settings']['disable_author'])) {
                    $this->data['disable_author'] = $this->request->post['settings']['disable_author'];
            } elseif (isset($article_set_info['settings']['disable_author'])) {
                    $this->data['disable_author'] = $article_set_info['settings']['disable_author'];
            } else {
                    $this->data['disable_author'] = 0;
            }
            
            //Disable Modified Date
            if (isset($this->request->post['settings']['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $this->request->post['settings']['disable_mod_date'];
            } elseif (isset($article_set_info['settings']['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $article_set_info['settings']['disable_mod_date'];
            } else {
                    $this->data['disable_mod_date'] = 0;
            }
            
            //Disable Create Date
            if (isset($this->request->post['settings']['disable_create_date'])) {
                    $this->data['disable_create_date'] = $this->request->post['settings']['disable_create_date'];
            } elseif (isset($article_set_info['settings']['disable_create_date'])) {
                    $this->data['disable_create_date'] = $article_set_info['settings']['disable_create_date'];
            } else {
                    $this->data['disable_create_date'] = 0;
            }
            
            //Disable Category List
            if (isset($this->request->post['settings']['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $this->request->post['settings']['disable_cat_list'];
            } elseif (isset($article_set_info['settings']['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $article_set_info['settings']['disable_cat_list'];
            } else {
                    $this->data['disable_cat_list'] = 0;
            }
            
            //Disable Number of Comments
            if (isset($this->request->post['settings']['disable_com_count'])) {
                    $this->data['disable_com_count'] = $this->request->post['settings']['disable_com_count'];
            } elseif (isset($article_set_info['settings']['disable_com_count'])) {
                    $this->data['disable_com_count'] = $article_set_info['settings']['disable_com_count'];
            } else {
                    $this->data['disable_com_count'] = 0;
            }
            
            //Allow Paging
            if (isset($this->request->post['settings']['allow_paging'])) {
                    $this->data['allow_paging'] = $this->request->post['settings']['allow_paging'];
            } elseif (isset($article_set_info['settings']['allow_paging'])) {
                    $this->data['allow_paging'] = $article_set_info['settings']['allow_paging'];
            } else {
                    $this->data['allow_paging'] = 0;
            }
            
            //Sort Order
            if (isset($this->request->post['settings']['sort_order'])) {
                    $this->data['sort_order'] = $this->request->post['settings']['sort_order'];
            } elseif (!empty($article_set_info['settings']['sort_order'])) {
                    $this->data['sort_order'] = $article_set_info['settings']['sort_order'];
            } else {
                    $this->data['sort_order'] = 0;
            }
            
            //CATEGORIES	
            $this->load->model('ac_cms/category');
            $this->data['categories'] = $this->model_ac_cms_category->getCategories(0);

            if (isset($this->request->post['settings']['set_category'])) {
                    $this->data['set_category'] = $this->request->post['settings']['set_category'];
            } elseif (!empty($article_set_info['settings']['set_category'])) {
                    $this->data['set_category'] = $article_set_info['settings']['set_category'];
            } else {
                    $this->data['set_category'] = array();
            }
            
            //ARTICLE RELATE
            $this->load->model('ac_cms/article');
            if (isset($this->request->post['settings']['article_related'])) {
                $articles = $this->request->post['settings']['article_related'];
            } elseif (!empty($article_set_info['settings']['article_related'])) {
                    $articles = $article_set_info['settings']['article_related'];
            } else {
                    $articles = array();
            }
            $this->data['article_related'] = array();
            foreach ($articles as $b_id) {
                $related_info = $this->model_ac_cms_article->getArticle($b_id);
                if ($related_info) {
                        $this->data['article_related'][] = array(
                                'b_id'          => $related_info['b_id'],
                                'title'         => $related_info['title']
                        );
                }
            }
            
            //URL
            if (!isset($this->request->get['bs_id'])) {
                    $this->data['action'] = $this->url->link('ac_cms/article_set/create_set', 'token=' . $this->session->data['token'], 'SSL');
            } else {
                    $this->data['action'] = $this->url->link('ac_cms/article_set/update_set', 'token=' . $this->session->data['token'] . '&bs_id=' . $this->request->get['bs_id'], 'SSL');
            }
            $this->template = 'ac_cms/article_set_form.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
        }
        
        public function ajaxSave(){
            $json = array();
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/article_set'); 
            $this->load->language('ac_cms/article_set');
            
            
            if (!$this->user->hasPermission('modify', 'ac_cms/article_set')) {
                    $json['error'] = $this->language->get('error_permission');
            }
            
            foreach ($this->request->post['article_set_description'] as $language_id => $value) {
                    
                    if ((utf8_strlen($value['title']) <= 0) || (utf8_strlen($value['title']) > 255)) {
                            $json['error'] = $this->language->get('error_title');
                            break;
                    }
            }
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
                
                if(!empty($this->request->get['id'])){
                    $this->model_ac_cms_article_set->updateSet($this->request->get['id'], $this->request->post); 
                } else {
                    $newid = $this->model_ac_cms_article_set->addSet($this->request->post); 
                    if($newid){
                        $json['id'] = $newid;
                    }
                }
                    
                $json['success'] =  $this->language->get('text_success');
            }
            
            $this->response->setOutput(json_encode($json));
        }
        
        private function validateSetForm() 
        {
            if (!$this->user->hasPermission('modify', 'ac_cms/article_set')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            
            foreach ($this->request->post['article_set_description'] as $language_id => $value) {
                    
                    if ((utf8_strlen($value['title']) <= 0) || (utf8_strlen($value['title']) > 255)) {
                            $this->error['title'][$language_id] = $this->language->get('error_title');
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
            if (!$this->user->hasPermission('modify', 'ac_cms/article_set')) {
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
}

?>
