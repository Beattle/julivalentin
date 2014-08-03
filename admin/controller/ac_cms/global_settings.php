<?php

class ControllerACcmsGlobalSettings extends Controller {
    
    private $error = array();
    
    public function index()
    {
        $this->load->model('localisation/language');	
        $this->load->language('ac_cms/global_settings');
        $this->load->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
        {
            if(isset($this->request->get['store_id'])){
                $store_id = $this->request->get['store_id'];
            }else{
                $store_id = 0;
            }
            
            $this->model_setting_setting->editSetting('ac_cms_gs_' . $store_id, $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->data['languages'] = $this->model_localisation_language->getLanguages();
        
        $this->data['breadcrumbs'] = array();
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        
        $this->data['entry_blog_name'] = $this->language->get('entry_blog_name');
        $this->data['entry_page_size'] = $this->language->get('entry_page_size');
        $this->data['entry_disable_cat_list'] = $this->language->get('entry_disable_cat_list');
        $this->data['entry_disable_com_count'] = $this->language->get('entry_disable_com_count');
        $this->data['entry_disable_author'] = $this->language->get('entry_disable_author');
        $this->data['entry_disable_mod_date'] = $this->language->get('entry_disable_mod_date');
        $this->data['entry_disable_create_date'] = $this->language->get('entry_disable_create_date');
        $this->data['entry_comment_page_size'] = $this->language->get('entry_comment_page_size');
        $this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
        $this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $this->data['entry_disable_fblike'] = $this->language->get('entry_disable_fblike');
        $this->data['entry_disable_viewed'] = $this->language->get('entry_disable_viewed');
        $this->data['entry_disable_share'] = $this->language->get('entry_disable_share');
        $this->data['entry_store'] = $this->language->get('entry_store');
        $this->data['entry_blog_rss'] = $this->language->get('entry_blog_rss');
        
        $this->data['text_comment'] = $this->language->get('text_comment');
        $this->data['entry_comment_engine'] = $this->language->get('entry_comment_engine');
        $this->data['entry_facebook_admins'] = $this->language->get('entry_facebook_admins');
        $this->data['entry_disqus_id'] = $this->language->get('entry_disqus_id');
        $this->data['entry_disqus_force_lang'] = $this->language->get('entry_disqus_force_lang');
        $this->data['entry_facebook_width'] = $this->language->get('entry_facebook_width');
        
        $this->data['text_article'] = $this->language->get('text_article');
        $this->data['text_blog'] = $this->language->get('text_blog');
        $this->data['text_module'] = $this->language->get('text_module');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_data'] = $this->language->get('tab_data');
        
        $this->data['cancel'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');
        
        if (isset($this->error['warning'])) {
                $this->data['error_warning'] = $this->error['warning'];
        } else {
                $this->data['error_warning'] = '';
        }
        
        if (isset($this->error['blog_name'])) {
                $this->data['error_blog_name'] = $this->error['blog_name'];
        } else {
                $this->data['error_blog_name'] = array();
        }

        $this->data['breadcrumbs'][] = array(
                'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'text'      => $this->language->get('text_home'),
                'separator' => FALSE
        );

        $this->data['breadcrumbs'][] = array(
                'href'      => $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL'),
                'text'      => $this->language->get('text_module'),
                'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
                'href'      => $this->url->link('ac_cms/global_settings', 'token=' . $this->session->data['token'], 'SSL'),
                'text'      => $this->language->get('heading_title'),
                'separator' => ' :: '
        );
        
        
        
        //STORE
        $this->load->model('setting/store');
        
        $stores = array();
        $this->data['stores']['Default']['href'] = $this->url->link('ac_cms/global_settings', 'store_id=0&token=' . $this->session->data['token'], 'SSL');
        $stores = $this->model_setting_store->getStores();
        foreach ($stores as $store){
            $this->data['stores'][$store['name']]['href'] = $this->url->link('ac_cms/global_settings', 'store_id='.$store['store_id'].'&token=' . $this->session->data['token'], 'SSL');
        }
        
        if(isset($this->request->get['store_id'])){
            $this->data['action'] = $this->data['store_href'] = $this->url->link('ac_cms/global_settings', 'store_id=' .$this->request->get['store_id']. '&token=' . $this->session->data['token'], 'SSL');
            $store_id = $this->request->get['store_id'];
        }else{
            $this->data['action'] = $this->data['store_href'] = $this->url->link('ac_cms/global_settings', 'store_id=0&token=' . $this->session->data['token'], 'SSL');
            $store_id = 0;
        }
        	
            
        $gs_info = $this->config->get('ac_cms_gs_' . $store_id);
        $this->data['store_id'] = $store_id;
                
        if (isset($this->request->post['ac_cms_gs']['desc'])) 
        {
            $this->data['ac_cms_gs']['desc'] = $this->request->post['ac_cms_gs']['desc'];
        } 
        elseif(!empty($gs_info['desc']))
        {
            $this->data['ac_cms_gs']['desc'] = $gs_info['desc'];     
        }
        else
        {
            $gs_info['desc'] = '';
        }
        
        
        //Facebook Admin(s)
        if (isset($this->request->post['ac_cms_gs']['facebook_admins'])) {
                $this->data['facebook_admins'] = $this->request->post['ac_cms_gs']['facebook_admins'];
        } elseif (!empty($gs_info['facebook_admins'])) {
                $this->data['facebook_admins'] = $gs_info['facebook_admins'];
        } else {
                $this->data['facebook_admins'] = '';
        }
        
        //Facebook Container Width
        if (isset($this->request->post['ac_cms_gs']['facebook_width'])) {
                $this->data['facebook_width'] = $this->request->post['ac_cms_gs']['facebook_width'];
        } elseif (!empty($gs_info['facebook_width'])) {
                $this->data['facebook_width'] = $gs_info['facebook_width'];
        } else {
                $this->data['facebook_width'] = '';
        }
        
        //Disqus ID
        if (isset($this->request->post['ac_cms_gs']['disqus_id'])) {
                $this->data['disqus_id'] = $this->request->post['ac_cms_gs']['disqus_id'];
        } elseif (!empty($gs_info['disqus_id'])) {
                $this->data['disqus_id'] = $gs_info['disqus_id'];
        } else {
                $this->data['disqus_id'] = '';
        }
        
        //Disqus Force Lang
        if (isset($this->request->post['ac_cms_gs']['disqus_force_lang'])) {
                $this->data['disqus_force_lang'] = $this->request->post['ac_cms_gs']['disqus_force_lang'];
        } elseif (!empty($gs_info['disqus_force_lang'])) {
                $this->data['disqus_force_lang'] = $gs_info['disqus_force_lang'];
        } else {
                $this->data['disqus_force_lang'] = 0;
        }
        
        //Comment engine
        if (isset($this->request->post['ac_cms_gs']['comment_engine'])) {
                $this->data['comment_engine'] = $this->request->post['ac_cms_gs']['comment_engine'];
        } elseif (!empty($gs_info['comment_engine'])) {
                $this->data['comment_engine'] = $gs_info['comment_engine'];
        } else {
                $this->data['comment_engine'] = 0;
        }
        
        //Articles Per Page
        if (isset($this->request->post['ac_cms_gs']['page_size'])) {
                $this->data['page_size'] = $this->request->post['ac_cms_gs']['page_size'];
        } elseif (!empty($gs_info['page_size'])) {
                $this->data['page_size'] = $gs_info['page_size'];
        } else {
                $this->data['page_size'] = '';
        }
        
        //Comments Per Page
        if (isset($this->request->post['ac_cms_gs']['comment_page_size'])) {
                $this->data['comment_page_size'] = $this->request->post['ac_cms_gs']['comment_page_size'];
        } elseif (!empty($gs_info['comment_page_size'])) {
                $this->data['comment_page_size'] = $gs_info['comment_page_size'];
        } else {
                $this->data['comment_page_size'] = '';
        }
        
        //Disable Author
        if (isset($this->request->post['ac_cms_gs']['disable_author'])) {
                $this->data['disable_author'] = $this->request->post['ac_cms_gs']['disable_author'];
        } elseif (!empty($gs_info['disable_author'])) {
                $this->data['disable_author'] = $gs_info['disable_author'];
        } else {
                $this->data['disable_author'] = 0;
        }

        //Disable Modified Date
        if (isset($this->request->post['ac_cms_gs']['disable_mod_date'])) {
                $this->data['disable_mod_date'] = $this->request->post['ac_cms_gs']['disable_mod_date'];
        } elseif (!empty($gs_info['disable_mod_date'])) {
                $this->data['disable_mod_date'] = $gs_info['disable_mod_date'];
        } else {
                $this->data['disable_mod_date'] = 0;
        }

        //Disable Create Date
        if (isset($this->request->post['ac_cms_gs']['disable_create_date'])) {
                $this->data['disable_create_date'] = $this->request->post['ac_cms_gs']['disable_create_date'];
        } elseif (!empty($gs_info['disable_create_date'])) {
                $this->data['disable_create_date'] = $gs_info['disable_create_date'];
        } else {
                $this->data['disable_create_date'] = 0;
        }

        //Disable Category List
        if (isset($this->request->post['ac_cms_gs']['disable_cat_list'])) {
                $this->data['disable_cat_list'] = $this->request->post['ac_cms_gs']['disable_cat_list'];
        } elseif (!empty($gs_info['disable_cat_list'])) {
                $this->data['disable_cat_list'] = $gs_info['disable_cat_list'];
        } else {
                $this->data['disable_cat_list'] = 0;
        }

        //Disable Number of Comments
        if (isset($this->request->post['ac_cms_gs']['disable_com_count'])) {
                $this->data['disable_com_count'] = $this->request->post['ac_cms_gs']['disable_com_count'];
        } elseif (!empty($gs_info['disable_com_count'])) {
                $this->data['disable_com_count'] = $gs_info['disable_com_count'];
        } else {
                $this->data['disable_com_count'] = 0;
        }
        
        //Disable Viewed
        if (isset($this->request->post['ac_cms_gs']['disable_viewed'])) {
                $this->data['disable_viewed'] = $this->request->post['ac_cms_gs']['disable_viewed'];
        } elseif (!empty($gs_info['disable_viewed'])) {
                $this->data['disable_viewed'] = $gs_info['disable_viewed'];
        } else {
                $this->data['disable_viewed'] = 0;
        }

        //Disable Fb Like Button renroc tra
        if (isset($this->request->post['ac_cms_gs']['disable_fblike'])) {
                $this->data['disable_fblike'] = $this->request->post['ac_cms_gs']['disable_fblike'];
        } elseif (!empty($gs_info['disable_fblike'])) {
                $this->data['disable_fblike'] = $gs_info['disable_fblike'];
        } else {
                $this->data['disable_fblike'] = 0;
        }

        //Disable AddThis
        if (isset($this->request->post['ac_cms_gs']['disable_share'])) {
                $this->data['disable_share'] = $this->request->post['ac_cms_gs']['disable_share'];
        } elseif (!empty($gs_info['disable_share'])) {
                $this->data['disable_share'] = $gs_info['disable_share'];
        } else {
                $this->data['disable_share'] = 0;
        }
        
        //RSS
        if (isset($this->request->post['ac_cms_gs']['blog_rss'])) {
                $this->data['blog_rss'] = $this->request->post['ac_cms_gs']['blog_rss'];
        } elseif (!empty($gs_info['blog_rss'])) {
                $this->data['blog_rss'] = $gs_info['blog_rss'];
        } else {
                $this->data['blog_rss'] = 0;
        }
        
        
        $this->template = 'ac_cms/global_settings.tpl';
        $this->children = array(
                    'common/header',
                    'common/footer'
            );
        
        $this->response->setOutput($this->render());
    }
    
    private function validate() 
    {
        if (!$this->user->hasPermission('modify', 'ac_cms/global_settings')) {
                $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if(isset($this->request->get['store_id'])){
            $store_id = $this->request->get['store_id'];
        }else{
            $store_id = 0;
        }
        
        foreach ($this->request->post['ac_cms_gs_'.$store_id]['desc'] as $language_id => $value) {

                if ((utf8_strlen($value['blog_name']) <= 0) || (utf8_strlen($value['blog_name']) > 255)) {
                        $this->error['blog_name'][$language_id] = $this->language->get('error_blog_name');
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
}

?>
