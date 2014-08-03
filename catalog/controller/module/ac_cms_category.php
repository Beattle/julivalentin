<?php  
class ControllerModuleACcmsCategory extends Controller {
	protected function index() {
		$this->language->load('module/ac_cms_category');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['ac_path'])) {
			$parts = explode('_', (string)$this->request->get['ac_path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['bc_id'] = $parts[0];
		} else {
			$this->data['bc_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		$this->load->model('ac_cms/category');
		
		$this->data['categories'] = array();
					
		$categories = $this->model_ac_cms_category->getCategories(0);
		
		foreach ($categories as $category) {
			$children_data = array();
			
			$children = $this->model_ac_cms_category->getCategories($category['bc_id']);
                        
			foreach ($children as $child) {
											
				$children_data[] = array(
					'bc_id'       => $child['bc_id'],
					'name'        => $child['name'],
					'href'        => $this->url->link('ac_cms/category', 'ac_path=' . $category['bc_id'] . '_' . $child['bc_id'])	
				);					
			}
										
			$this->data['categories'][] = array(
				'bc_id' => $category['bc_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('ac_cms/category', 'ac_path=' . $category['bc_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/ac_cms_category.tpl';
		} else {
			$this->template = 'default/template/module/ac_cms_category.tpl';
		}
                
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/ac_cms.css')) {
                    $this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template') . '/stylesheet/ac_cms.css'); 
                } else {
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/ac_cms.css');
                }
		
		$this->render();
  	}
}
?>