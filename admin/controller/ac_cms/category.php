<?php

class ControllerACcmsCategory extends Controller {
        private $error = array();
        /**
         * Categories
         */
        public function categories()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/category'); 
            $this->load->language('ac_cms/category');
            
            $this->getCategoryList();
        }
        
        /**
         * Create Category
         */
        public function create_category()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/category'); 
            $this->load->language('ac_cms/category');
            
            $this->data['languages'] = $this->model_localisation_language->getLanguages();
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateCatForm()) {
                    $this->model_ac_cms_category->addCategory($this->request->post); 

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL')); 
            }

            $this->getCategoryForm();
	}
        
        /**
         * Update Category
         */
        public function update_category()    
        {
            $this->load->model('localisation/language');	
            $this->load->model('ac_cms/category'); 
            $this->load->language('ac_cms/category');
            
            $this->data['languages'] = $this->model_localisation_language->getLanguages();
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateCatForm()) {
                    $this->model_ac_cms_category->updateCategory($this->request->get['bc_id'], $this->request->post); 

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL')); 
            }
            
            $this->getCategoryForm();
        }
        
        /**
         * Delete Article
         */
        public function delete()    
        {
            $this->load->model('ac_cms/category'); 
            $this->load->language('ac_cms/category');

            $this->data['heading_title'] = $this->language->get('heading_title');

            if (isset($this->request->post['selected']) && $this->validateDelete()) {
                    foreach ($this->request->post['selected'] as $bc_id) {
                            $this->model_ac_cms_category->deleteCategory($bc_id);
                    }

                    $this->session->data['success'] = $this->language->get('text_success');

                    $this->redirect($this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL'));
            }
            
            $this->getCategoryList();
	}
        
        private function getCategoryList() 
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
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
            );

            $this->data['insert'] = $this->url->link('ac_cms/category/create_category', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['delete'] = $this->url->link('ac_cms/category/delete', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['cp'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');

            $this->data['categories'] = array();

            $results = $this->model_ac_cms_category->getCategories(0);
            
            foreach ($results as $result) {
                    $action = array();

                    $action[] = array(
                            'text' => $this->language->get('text_edit'),
                            'href' => $this->url->link('ac_cms/category/update_category', 'token=' . $this->session->data['token'] . '&bc_id=' . $result['bc_id'], 'SSL')
                    );

                    $this->data['categories'][] = array(
                            'bc_id'       => $result['bc_id'],
                            'name'        => $result['name'],
                            'status'        => $result['status'],
                            'sort_order'  => $result['sort_order'],
                            'selected'    => isset($this->request->post['selected']) && in_array($result['bc_id'], $this->request->post['selected']),
                            'action'      => $action
                    );
            }

            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_no_results'] = $this->language->get('text_no_results');

            $this->data['column_name'] = $this->language->get('text_column_name');
            $this->data['column_sort_order'] = $this->language->get('text_column_sort_order');
            $this->data['column_action'] = $this->language->get('text_column_action');

            $this->data['button_insert'] = $this->language->get('button_insert');
            $this->data['button_delete'] = $this->language->get('button_delete');
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

            $this->template = 'ac_cms/category_list.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
	}
        
        private function getCategoryForm()
        {
            //General
            $this->data['entry_cat_name'] = $this->language->get('entry_cat_name');
            $this->data['entry_content'] = $this->language->get('entry_content');
            $this->data['meta_keywords'] = $this->language->get('entry_meta_keywords');
            $this->data['meta_description'] = $this->language->get('entry_meta_description');
            
            //Data
            $this->data['entry_parent'] = $this->language->get('entry_parent');
            $this->data['entry_store'] = $this->language->get('entry_store');
            $this->data['entry_seo'] = $this->language->get('entry_seo');
            $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
            $this->data['entry_status'] = $this->language->get('entry_status');
            $this->data['entry_rss'] = $this->language->get('entry_rss');
            $this->data['entry_image'] = $this->language->get('entry_image');
            $this->data['entry_column'] = $this->language->get('entry_column');
            $this->data['entry_disable_cat_list'] = $this->language->get('entry_disable_cat_list');
            $this->data['entry_disable_viewed'] = $this->language->get('entry_disable_viewed');
            $this->data['entry_disable_share'] = $this->language->get('entry_disable_share');
            $this->data['entry_disable_com_count'] = $this->language->get('entry_disable_com_count');
            $this->data['entry_disable_author'] = $this->language->get('entry_disable_author');
            $this->data['entry_disable_create_date'] = $this->language->get('entry_disable_create_date');
            $this->data['entry_disable_fblike'] = $this->language->get('entry_disable_fblike');
            $this->data['entry_disable_mod_date'] = $this->language->get('entry_disable_mod_date');
            $this->data['entry_override_gs'] = $this->language->get('entry_override_gs');
            $this->data['entry_archive'] = $this->language->get('entry_archive');
            
            $this->data['entry_layout'] = $this->language->get('entry_layout');
            
            $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
            $this->data['entry_category'] = $this->language->get('entry_category');
            
            $this->data['text_enabled'] = $this->language->get('text_enabled');
            $this->data['text_default'] = $this->language->get('text_default');
            $this->data['text_yes'] = $this->language->get('text_yes');
            $this->data['text_no'] = $this->language->get('text_no');
            $this->data['text_disabled'] = $this->language->get('text_disabled');
            $this->data['text_browse'] = $this->language->get('text_browse');
            $this->data['text_clear'] = $this->language->get('text_clear');
            $this->data['text_image_manager'] = $this->language->get('text_image_manager');
            $this->data['text_none'] = $this->language->get('text_none');
            
            $this->data['heading_title'] = $this->language->get('heading_title');
            
            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_cancel'] = $this->language->get('button_cancel');
            $this->data['tab_general'] = $this->language->get('tab_general');
            $this->data['tab_data'] = $this->language->get('tab_data');
            $this->data['tab_links'] = $this->language->get('tab_links');
            $this->data['tab_design'] = $this->language->get('tab_design');
            $this->data['token'] = $this->session->data['token'];
            $this->data['cancel'] = $this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL');
            
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
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
            );
            
            if (isset($this->error['warning'])) {
                    $this->data['error_warning'] = $this->error['warning'];
            } else {
                    $this->data['error_warning'] = '';
            }
            
            if (isset($this->error['name'])) {
                    $this->data['error_name'] = $this->error['name'];
            } else {
                    $this->data['error_name'] = array();
            }
            
            //DESCRIPTION
            if (isset($this->request->post['category_description'])) 
            {
		$this->data['category_description'] = $this->request->post['category_description'];
            } 
            elseif (isset($this->request->get['bc_id'])) 
            {
                $this->data['category_description'] = $this->model_ac_cms_category->getCategoryDescriptions($this->request->get['bc_id']);
            } 
            else 
            {
                $this->data['category_description'] = array();
            }
            
            if (isset($this->request->get['bc_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')){
              $category_info = $this->model_ac_cms_category->getCategory($this->request->get['bc_id']);  
            }
            
            //PARENT
            $categories = $this->model_ac_cms_category->getCategories(0);
            // Remove own id from list
            if (!empty($category_info)) {
                    foreach ($categories as $key => $category) {
                            if ($category['bc_id'] == $category_info['bc_id'] || $category['parent'] == $category_info['bc_id']) {
                                    unset($categories[$key]);
                            }
                    }
            }

            $this->data['categories'] = $categories;

            if (isset($this->request->post['parent'])) {
                    $this->data['parent'] = $this->request->post['parent'];
            } elseif (!empty($category_info)) {
                    $this->data['parent'] = $category_info['parent'];
            } else {
                    $this->data['parent'] = 0;
            }
            
            //IMAGE
            if (isset($this->request->post['image'])) {
                    $this->data['image'] = $this->request->post['image'];
            } elseif (!empty($category_info)) {
                    $this->data['image'] = $category_info['image'];
            } else {
                    $this->data['image'] = '';
            }

            $this->load->model('tool/image');

            if (!empty($category_info) && $category_info['image'] && file_exists(DIR_IMAGE . $category_info['image'])) {
                    $this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
            } else {
                    $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
            }
            
            $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
            
            //RSS
            if (isset($this->request->post['cat_rss'])) {
                    $this->data['rss'] = $this->request->post['cat_rss'];
            } elseif (!empty($category_info['rss'])) {
                    $this->data['rss'] = $category_info['rss'];
            } else {
                    $this->data['rss'] = 0;
            }
            
            //STATUS
            if (isset($this->request->post['cat_status'])) {
                    $this->data['status'] = $this->request->post['cat_status'];
            } elseif (!empty($category_info['status'])) {
                    $this->data['status'] = $category_info['status'];
            } else {
                    $this->data['status'] = 0;
            }
            
            //STORE
            $this->load->model('setting/store');
		
            $this->data['stores'] = $this->model_setting_store->getStores();

            if (isset($this->request->post['category_store'])) {
                    $this->data['category_store'] = $this->request->post['category_store'];
            } elseif (isset($this->request->get['bc_id'])) {
                    $this->data['category_store'] = $this->model_ac_cms_category->getCategoryStores($this->request->get['bc_id']);
            } else {
                    $this->data['category_store'] = array(0);
            }	
            
            //SORT ORDER
            if (isset($this->request->post['sort_order'])) {
                    $this->data['sort_order'] = $this->request->post['sort_order'];
            } elseif (!empty($category_info)) {
                    $this->data['sort_order'] = $category_info['sort_order'];
            } else {
                    $this->data['sort_order'] = "";
            }
            
            //KEYWORD
            if (isset($this->request->post['cat_keyword'])) {
                    $this->data['cat_keyword'] = $this->request->post['cat_keyword'];
            } elseif (!empty($category_info)) {
                    $this->data['cat_keyword'] = $category_info['keyword'];
            } else {
                    $this->data['cat_keyword'] = '';
            }
            
            //Disable Author
            if (isset($this->request->post['settings']['disable_author'])) {
                    $this->data['disable_top_bar'] = $this->request->post['settings']['disable_author'];
            } elseif (!empty($category_info['settings']['disable_author'])) {
                    $this->data['disable_author'] = $category_info['settings']['disable_author'];
            } else {
                    $this->data['disable_author'] = 0;
            }
            
            //Disable Create Date
            if (isset($this->request->post['settings']['disable_create_date'])) {
                    $this->data['disable_create_date'] = $this->request->post['settings']['disable_create_date'];
            } elseif (!empty($category_info['settings']['disable_create_date'])) {
                    $this->data['disable_create_date'] = $category_info['settings']['disable_create_date'];
            } else {
                    $this->data['disable_create_date'] = 0;
            }
            
            //Disable Fb Like Button
            if (isset($this->request->post['settings']['disable_fblike'])) {
                    $this->data['disable_fblike'] = $this->request->post['settings']['disable_fblike'];
            } elseif (!empty($category_info['settings']['disable_fblike'])) {
                    $this->data['disable_fblike'] = $category_info['settings']['disable_fblike'];
            } else {
                    $this->data['disable_fblike'] = 0;
            }
            
            //Disable AddThis
            if (isset($this->request->post['settings']['disable_share'])) {
                    $this->data['disable_share'] = $this->request->post['settings']['disable_share'];
            } elseif (!empty($category_info['settings']['disable_share'])) {
                    $this->data['disable_share'] = $category_info['settings']['disable_share'];
            } else {
                    $this->data['disable_share'] = 0;
            }

            //Disable Modified Date
            if (isset($this->request->post['settings']['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $this->request->post['settings']['disable_mod_date'];
            } elseif (!empty($category_info['settings']['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $category_info['settings']['disable_mod_date'];
            } else {
                    $this->data['disable_mod_date'] = 0;
            }
            
            //Disable Cat List
            if (isset($this->request->post['settings']['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $this->request->post['settings']['disable_cat_list'];
            } elseif (!empty($category_info['settings']['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $category_info['settings']['disable_cat_list'];
            } else {
                    $this->data['disable_cat_list'] = 0;
            }
            
            //Disable Com Count
            if (isset($this->request->post['settings']['disable_com_count'])) {
                    $this->data['disable_com_count'] = $this->request->post['settings']['disable_com_count'];
            } elseif (!empty($category_info['settings']['disable_com_count'])) {
                    $this->data['disable_com_count'] = $category_info['settings']['disable_com_count'];
            } else {
                    $this->data['disable_com_count'] = 0;
            }
            
            //Disable Viewed
            if (isset($this->request->post['settings']['disable_viewed'])) {
                    $this->data['disable_viewed'] = $this->request->post['settings']['disable_viewed'];
            } elseif (!empty($category_info['settings']['disable_viewed'])) {
                    $this->data['disable_viewed'] = $category_info['settings']['disable_viewed'];
            } else {
                    $this->data['disable_viewed'] = 0;
            }
            
            //Override Gs
            if (isset($this->request->post['settings']['override_gs'])) {
                    $this->data['override_gs'] = $this->request->post['settings']['override_gs'];
            } elseif (!empty($category_info['settings']['override_gs'])) {
                    $this->data['override_gs'] = $category_info['settings']['override_gs'];
            } else {
                    $this->data['override_gs'] = 0;
            }
            
            //Hide Archive
            if (isset($this->request->post['settings']['archive'])) {
                    $this->data['archive'] = $this->request->post['settings']['archive'];
            } elseif (!empty($category_info['settings']['archive'])) {
                    $this->data['archive'] = $category_info['settings']['archive'];
            } else {
                    $this->data['archive'] = 0;
            }
            
            //Layout
            if (isset($this->request->post['category_layout'])) {
                    $this->data['category_layout'] = $this->request->post['category_layout'];
            } elseif (isset($this->request->get['bc_id'])) {
                    $this->data['category_layout'] = $this->model_ac_cms_category->getCategoryLayouts($this->request->get['bc_id']);
            } else {
                    $this->data['category_layout'] = array();
            }
            
            $this->load->model('design/layout');
		
            $this->data['layouts'] = $this->model_design_layout->getLayouts();
            
            //URL
            if (!isset($this->request->get['bc_id'])) {
                    $this->data['action'] = $this->url->link('ac_cms/category/create_category', 'token=' . $this->session->data['token'], 'SSL');
            } else {
                    $this->data['action'] = $this->url->link('ac_cms/category/update_category', 'token=' . $this->session->data['token'] . '&bc_id=' . $this->request->get['bc_id'], 'SSL');
            }
            $this->template = 'ac_cms/category_form.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
        }
        
        private function validateCatForm() 
        {
            if (!$this->user->hasPermission('modify', 'ac_cms/category')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            
            foreach ($this->request->post['category_description'] as $language_id => $value) {
                    
                    if ((utf8_strlen($value['name']) <= 0) || (utf8_strlen($value['name']) > 255)) {
                            $this->error['name'][$language_id] = $this->language->get('error_name');
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
		if (!$this->user->hasPermission('modify', 'ac_cms/category')) {
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
