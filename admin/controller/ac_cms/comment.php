<?php
class ControllerACcmsComment extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('ac_cms/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('ac_cms/comment');
		
		$this->getList();
	} 

	public function insert() {
		$this->load->language('ac_cms/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('ac_cms/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_ac_cms_comment->addComment($this->request->post);
			
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
						
			$this->redirect($this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('ac_cms/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('ac_cms/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_ac_cms_comment->editComment($this->request->get['comment_id'], $this->request->post);
			
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
						
			$this->redirect($this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->load->language('ac_cms/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('ac_cms/comment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $comment_id) {
				$this->model_ac_cms_comment->deleteComment($comment_id);
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
						
			$this->redirect($this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'c.date_added';
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
			'href'      => $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
                        'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('ac_cms/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('ac_cms/comment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
                $this->data['cp'] = $this->url->link('ac_cms/control_panel', 'token=' . $this->session->data['token'], 'SSL');
                
		$this->data['comments'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$comment_total = $this->model_ac_cms_comment->getTotalComments();
	
		$results = $this->model_ac_cms_comment->getComments($data);
                
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('ac_cms/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $result['comment_id'] . $url, 'SSL')
			);
						
			$this->data['comments'][] = array(
				'comment_id' => $result['comment_id'],
				'title'      => $result['title'],
				'name'       => $result['name'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['comment_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_article'] = $this->language->get('column_article');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');	
                
		$this->data['button_cp'] = $this->language->get('button_cp');
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
		
		$this->data['sort_article'] = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . '&sort=bd.title' . $url, 'SSL');
		$this->data['sort_name'] = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . '&sort=c.name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'ac_cms/comment_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');

		$this->data['entry_article'] = $this->language->get('entry_article');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_text'] = $this->language->get('entry_text');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['article'])) {
			$this->data['error_article'] = $this->error['article'];
		} else {
			$this->data['error_article'] = '';
		}
		
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
 		if (isset($this->error['text'])) {
			$this->data['error_text'] = $this->error['text'];
		} else {
			$this->data['error_text'] = '';
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
			'href'      => $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
                        'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['comment_id'])) { 
			$this->data['action'] = $this->url->link('ac_cms/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('ac_cms/comment/update', 'token=' . $this->session->data['token'] . '&comment_id=' . $this->request->get['comment_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('ac_cms/comment', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$comment_info = $this->model_ac_cms_comment->getComment($this->request->get['comment_id']);
		}
			
		$this->load->model('ac_cms/article');
		
		if (isset($this->request->post['b_id'])) {
			$this->data['b_id'] = $this->request->post['b_id'];
		} elseif (!empty($comment_info)) {
			$this->data['b_id'] = $comment_info['b_id'];
		} else {
			$this->data['b_id'] = '';
		}

		if (isset($this->request->post['article'])) {
			$this->data['article'] = $this->request->post['article'];
		} elseif (!empty($comment_info)) {
			$this->data['article'] = $comment_info['article'];
		} else {
			$this->data['article'] = '';
		}
				
		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($comment_info)) {
			$this->data['name'] = $comment_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['text'])) {
			$this->data['text'] = $this->request->post['text'];
		} elseif (!empty($comment_info)) {
			$this->data['text'] = $comment_info['text'];
		} else {
			$this->data['text'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$this->data['status'] = $comment_info['status'];
		} else {
			$this->data['status'] = '';
		}

		$this->template = 'ac_cms/comment_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'ac_cms/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['b_id']) {
			$this->error['article'] = $this->language->get('error_article');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (utf8_strlen($this->request->post['text']) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'ac_cms/comment')) {
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