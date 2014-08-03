<?php
class ControllerACcmsControlPanel extends Controller {
	private $error = array();
	public function index() 
        {
            $this->load->language('ac_cms/control_panel');
            $this->document->setTitle($this->language->get('heading_title'));
            $this->load->model('setting/setting');
           
            $this->data['new_article_url'] = $this->url->link('ac_cms/article/create', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['manage_articles_url'] = $this->url->link('ac_cms/article/admin', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['manage_category_url'] = $this->url->link('ac_cms/category/categories', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['manage_article_set_url'] = $this->url->link('ac_cms/article_set/article_sets', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['manage_comment_url'] = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['manage_menu_url'] = $this->url->link('module/ac_cms_menu', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['manage_global_settings_url'] = $this->url->link('ac_cms/global_settings', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['place_your_set_url'] = $this->url->link('module/ac_cms_set', 'token=' . $this->session->data['token'], 'SSL');
            $this->data['category_module_url'] = $this->url->link('module/ac_cms_category', 'token=' . $this->session->data['token'], 'SSL');
                        
            $this->data['text_new_article'] = $this->language->get('text_new_article');
            $this->data['text_manage_articles'] = $this->language->get('text_manage_articles');
            $this->data['text_manage_categories'] = $this->language->get('text_manage_categories');
            $this->data['text_manage_article_sets'] = $this->language->get('text_manage_article_sets');
            $this->data['text_place_article_set'] = $this->language->get('text_place_article_set');
            $this->data['text_manage_comments'] = $this->language->get('text_manage_comments');
            $this->data['text_manage_menu'] = $this->language->get('text_manage_menu');
            $this->data['text_global_settings'] = $this->language->get('text_global_settings');
            $this->data['text_category_module'] = $this->language->get('text_category_module');
            
            $this->data['heading_title'] = $this->language->get('heading_title');
            $this->data['button_save'] = $this->language->get('button_save');
            $this->data['button_cancel'] = $this->language->get('button_cancel');

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
                    'text'      => $this->language->get('heading_title'),
                    'separator' => ' :: '
            );

            $this->data['action'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');


            $this->template = 'ac_cms/control_panel.tpl';
            $this->children = array(
                    'common/header',
                    'common/footer'
            );

            $this->response->setOutput($this->render());
	}
}

?>