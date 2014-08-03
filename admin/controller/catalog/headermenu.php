<?php
class ControllerCatalogheadermenu extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/headermenu');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('catalog/headermenu');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/headermenu');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/headermenu');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_headermenu->addheadermenu($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/headermenu');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/headermenu');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_headermenu->editheadermenu($this->request->get['headermenu_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->language->load('catalog/headermenu');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/headermenu');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $headermenu_id) {
				$this->model_catalog_headermenu->deleteheadermenu($headermenu_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id.title';
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
		
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('catalog/headermenu/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/headermenu/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['headermenus'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$headermenu_total = $this->model_catalog_headermenu->getTotalheadermenus();
	
		$results = $this->model_catalog_headermenu->getheadermenus($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/headermenu/update', 'token=' . $this->session->data['token'] . '&headermenu_id=' . $result['headermenu_id'] . $url, 'SSL')
			);
						
			$this->data['headermenus'][] = array(
				'headermenu_id' => $result['headermenu_id'],
				'title'          => $result['title'],
				'level2'          => $result['level2'],
				'link'          => $result['link'],
				'sort_order'          => $result['sort_order'],
				'selected'       => isset($this->request->post['selected']) && in_array($result['headermenu_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_link'] = $this->language->get('column_link');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
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

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = $this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $headermenu_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/headermenu_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_bottom'] = $this->language->get('entry_bottom');
		$this->data['entry_top'] = $this->language->get('entry_top');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['text_select'] = $this->language->get('text_select');
		
		////////////////////////////////////headermenus//////////////////////////
		$this->data['entry_level2'] = $this->language->get('entry_level2');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_link'] = $this->language->get('entry_link');
		$this->data['entry_level1'] = $this->language->get('entry_level1');
		$this->data['entry_column'] = $this->language->get('entry_column');
		$this->data['headermenu'] = $this->model_catalog_headermenu->getheadermenus();
		$this->data['headermenu1'] = $this->model_catalog_headermenu->getheadermenus1();
		
		////////////////////////////////////headermenus//////////////////////////
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
    	
		$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');

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
		
	 	if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}
		
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['headermenu_id'])) {
			$this->data['action'] = $this->url->link('catalog/headermenu/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/headermenu/update', 'token=' . $this->session->data['token'] . '&headermenu_id=' . $this->request->get['headermenu_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/headermenu', 'token=' . $this->session->data['token'] . $url, 'SSL');

		
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->get['headermenu_id'])) {
		$headermenu_info=$this->model_catalog_headermenu->getheadermenu($this->request->get['headermenu_id']);
		}	
		
	
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($headermenu_info)) {
			$this->data['status'] = $headermenu_info['status'];
		} else {
			$this->data['status'] = 1;
		}	
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($headermenu_info)) {
			$this->data['sort_order'] = $headermenu_info['sort_order'];
		} else {
			$this->data['sort_order'] ='';
		}
				
	
		///////////////////////headermenus/////////////////////
		if (isset($this->request->post['headermenu_description'])) {
			$this->data['headermenu_description'] = $this->request->post['headermenu_description'];
		} elseif (isset($this->request->get['headermenu_id'])) {
			$this->data['headermenu_description'] =$this->model_catalog_headermenu->getheadermenuDescriptions($this->request->get['headermenu_id']);
		} else {
			$this->data['headermenu_description'] = array();
		}
		
		
		if (isset($this->request->post['link'])) {
			$this->data['link'] = $this->request->post['link'];
		} elseif (!empty($headermenu_info)) {
			$this->data['link'] = $headermenu_info['link'];
		} else {
			$this->data['link'] = '';
		}
	
		if (isset($this->request->post['level1'])) {
			$this->data['level1'] = $this->request->post['level1'];
		} elseif (!empty($headermenu_info)) {
			$this->data['level1'] = $headermenu_info['level1'];
		} else {
			$this->data['level1'] = '';
		}
		
		
		if (isset($this->request->post['level2'])) {
			$this->data['level2'] = $this->request->post['level2'];
		} elseif (!empty($headermenu_info)) {
			$this->data['level2'] = $headermenu_info['level2'];
		} else {
			$this->data['level2'] = '';
		}
		
			if (isset($this->request->post['column'])) {
			$this->data['column'] = $this->request->post['column'];
		} elseif (!empty($headermenu_info)) {
			$this->data['column'] = $headermenu_info['column'];
		} else {
			$this->data['column'] = '';
		}
		
		
		///////////////////////headermenus/////////////////////

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
				
		$this->template = 'catalog/headermenu_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/headermenu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['headermenu_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		
		
		}
		
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/headermenu')) {
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