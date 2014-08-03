<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {

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
                    
                    //Disqus Force Lang
                    if(isset($global_settings['disqus_force_lang'])){
                        $this->data['disqus_force_lang'] = $global_settings['disqus_force_lang'];
                    } else {
                        $this->data['disqus_force_lang'] = 0;
                    }
                    
		$this->language->load('common/footer');

					if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		    $this->data['base'] = $server;

			if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
        $this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
        $this->data['logo'] = '';
        }

        $this->data['home'] = $this->url->link('common/home');
        $this->data['name'] = $this->config->get('config_name');


        


			//$this->data['categories']= array();
		//////////////////////////////Custommenu//////////////////////////////////
		$this->load->model('catalog/custommenu');
		($this->data['custommenu'] =$this->model_catalog_custommenu->getcustommenu());
		////////////////////////////////////////////////////////////////
		


			           if (isset($this->request->get['_route_'])){
            $this->data['route'] = $this->request->get['_route_'];
        }

        elseif(isset($this->request->get['route']) && $this->request->get['route'] == 'common/home'){
           $this->data['route'] = '/';
        }

        elseif(isset($this->request->get['route'])){
            $this->data['route'] = $this->request->get['route'];
        }

        else{$this->data['route'] = '/';
        }
        	if (isset($this->request->get['path'])) {
			$this->data['path'] = $this->request->get['path'];
			}

			if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
			} else {
			$product_id = '';
		    }
		    $this->data['product_id'] = $product_id;

		//////////////////////////////HeaderMenu//////////////////////////////////
		$this->load->model('catalog/headermenu');
		$headermenu =$this->model_catalog_headermenu->getHeadermenu();

		foreach ($headermenu as &$header){
			if($header['link'] == $this->data['route']){
		        $header['class'] = 'active';
		    } else {
		        $header['class'] = '';
		    }
		    if($header['link'] == '/'){
		        $header['link'] = $this->data['base'];
		    }

		    if($header['sub_title']){
                $header['class'] .=' parent';
                foreach ($header['sub_title'] as $sub_title){
                    if($sub_title['link'] == $this->data['route']){
		            $header['class'] .= 'active';
		            } else {
		            $header['class'] = '';
		            }
		            if($sub_title['sub_title']){
		                foreach($subtitle['sub_title'] as $subtitle){
		                   if($sub_title['link'] == $this->data['route']){
		                    $header['class'] .= 'active';
		                    } else {
		                    $header['class'] = '';
		                    }
		                }
		            }
                }
		    }


		}

		$this->data['headermenu'] = $headermenu;
		////////////////////////////////////////////////////////////////
		
		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_service'] = $this->language->get('text_service');
		$this->data['text_extra'] = $this->language->get('text_extra');
		$this->data['text_contact'] = $this->language->get('text_contact');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_order'] = $this->language->get('text_order');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}
		$this->data['text_search'] = $this->language->get('text_search');



		

		$this->load->model('catalog/information');

		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$this->data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$this->data['contact'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
		$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer');
		$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');		

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];	
			} else {
				$ip = ''; 
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];	
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];	
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}

$this->children[] = 'common/footer_center';
		$this->render();
	}
}
?>