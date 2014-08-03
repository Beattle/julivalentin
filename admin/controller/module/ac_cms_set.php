<?php


class ControllerModuleACcmsSet extends Controller {
    private $error = array();
        public function index() 
        {
            $this->load->model('ac_cms/article_set'); 
            $this->load->language('module/ac_cms_set');
            $this->document->setTitle($this->language->get('heading_title'));
            $this->load->model('setting/setting');
            
            $this->data['sets'] = $this->model_ac_cms_article_set->getArticleSets(); 
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
            {
			$this->model_setting_setting->editSetting('ac_cms', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL'));
            }
           
            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_enabled'] = $this->language->get('text_enabled');
            $this->data['text_disabled'] = $this->language->get('text_disabled');
            $this->data['text_yes'] = $this->language->get('text_yes');
            $this->data['text_no'] = $this->language->get('text_no');
            $this->data['text_content_top'] = $this->language->get('text_content_top');
            $this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
            $this->data['text_column_left'] = $this->language->get('text_column_left');
            $this->data['text_column_right'] = $this->language->get('text_column_right');

            $this->data['entry_limit'] = $this->language->get('entry_limit');
            $this->data['entry_layout'] = $this->language->get('entry_layout');
            $this->data['entry_position'] = $this->language->get('entry_position');
            $this->data['entry_status'] = $this->language->get('entry_status');
            $this->data['entry_sets'] = $this->language->get('entry_sets');
            $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
            $this->data['text_select'] = $this->language->get('text_select');
            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_cancel'] = $this->language->get('button_cancel');
            $this->data['button_add_module'] = $this->language->get('button_add_module');
            $this->data['button_remove'] = $this->language->get('button_remove');

            if (isset($this->error['warning'])) {
                    $this->data['error_warning'] = $this->error['warning'];
            } else {
                    $this->data['error_warning'] = '';
            }
            
            if (isset($this->error['set'])) {
                    $this->data['error_set'] = $this->error['set'];
            } else {
                    $this->data['error_set'] = array();
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
                    'href'      => $this->url->link('module/ac_cms_set', 'token=' . $this->session->data['token'], 'SSL'),
                    'text'      => $this->language->get('heading_title'),
                    'separator' => ' :: '
            );

            $this->data['action'] = $this->url->link('module/ac_cms_set', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['cancel'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');
            
            $this->data['modules'] = array();

            if (isset($this->request->post['ac_cms_set_module'])) {
                    $this->data['modules'] = $this->request->post['ac_cms_set_module'];
            } elseif ($this->config->get('ac_cms_set_module')) { 
                    $this->data['modules'] = $this->config->get('ac_cms_set_module');
            }

            $this->load->model('design/layout');

            $this->data['layouts'] = $this->model_design_layout->getLayouts();

            $this->template = 'module/ac_cms_set.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
	}
        
        private function validate() {
            if (!$this->user->hasPermission('modify', 'module/ac_cms_set')) {
                    $this->error['warning'] = $this->language->get('error_permission');
            }
            
            if (isset($this->request->post['ac_cms_set_module'])) {
                foreach ($this->request->post['ac_cms_set_module'] as $key => $value) {
                        if (!$value['bs_id']) {
                                $this->error['set'][$key] = $this->language->get('error_set');
                        }				
                }
            }

            if (!$this->error) {
                    return true;
            } else {
                    return false;
            }	
	}
}
?>
