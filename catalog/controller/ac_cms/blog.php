<?php

class ControllerACcmsBlog extends Controller {
    
    protected function checkAccess()
    {
        if($this->customer->isLogged()){
            return 1;
        } else {
            return 0;
        }
    }
    
    public function index()
    {
         $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home'),
        'separator' => false
        );
        
        $this->language->load('ac_cms/category');
		
        $this->load->model('ac_cms/category');

        $this->load->model('ac_cms/article');

        $this->load->model('tool/image');
        
        $lang_id = $this->config->get('config_language_id');
        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
        $category_info = array(
            'name' => (isset($global_settings['desc'][$lang_id]['blog_name'])) ? $global_settings['desc'][$lang_id]['blog_name'] : '',
            'meta_description' => (isset($global_settings['desc'][$lang_id]['meta_description'])) ? $global_settings['desc'][$lang_id]['meta_description'] : '',
            'meta_keyword' => (isset($global_settings['desc'][$lang_id]['meta_keyword'])) ? $global_settings['desc'][$lang_id]['meta_keyword'] : '',
            'rss' => (!empty($global_settings['blog_rss'])) ? true : false,
        );
        
        $this->data['breadcrumbs'][] = array(
            'text'      => $category_info['name'],
            'href'      => $this->url->link('ac_cms/blog'),
            'separator' => $this->language->get('text_separator')
        );
        
        $articles_total = $this->model_ac_cms_article->getTotalArticles(array('not_for_blog'=>0, 'access_level' => $this->checkAccess()));
        
        if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
        } else { 
                $page = 1;
        }
        
        if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
        } else {
                $limit = (!empty($global_settings['page_size'])) ? $global_settings['page_size'] : 10;
        }
        
        if ($category_info) {
            $this->data['text_viewed'] = $this->language->get('text_viewed');
            $this->data['text_comments'] = $this->language->get('text_comments');
            $this->data['text_category'] = $this->language->get('text_category');
            $this->data['text_author'] = $this->language->get('text_author');
            $this->data['text_share'] = $this->language->get('text_share');
            $this->data['text_modified'] = $this->language->get('text_modified');
            $this->data['text_created'] = $this->language->get('text_created');
            $this->data['text_rss'] = $this->language->get('text_rss');
            $this->data['text_readmore'] = $this->language->get('text_readmore');
            $this->data['text_empty'] = $this->language->get('text_empty');
            $this->data['button_continue'] = $this->language->get('button_continue');
            
            $this->data['continue'] = $this->url->link('common/home');
            
            
            $this->document->setTitle($category_info['name']);
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);
            
            //Description
            if(isset($category_info['description'])){
                $this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            }else{
                $this->data['description'] = null;
            }
            
            //RSS
            if(!empty($category_info['rss'])){
                $this->data['rss'] = true;
                $this->data['rss_href'] = $this->url->link('ac_cms/blog/rss');
            }else{
                $this->data['rss'] = false;
            }
            
            //Image
            if (isset($category_info['image'])) {
                    $this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
            } else {
                    $this->data['thumb'] = '';
            }
            
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
            
            //Date formats
            $date_format_short = $this->language->get('date_format_short');
            $date_format_long = $this->language->get('date_format_long');
            
            //Disable Author
            if(!empty($category_info['settings']['disable_author']) && !empty($category_info['settings']['override_gs'])){
                $this->data['disable_author'] = $category_info['settings']['disable_author'];
            }elseif(!empty($global_settings['disable_author'])){
                $this->data['disable_author'] = $global_settings['disable_author'];
            }else{
                $this->data['disable_author'] = false;
            }
            
            //Disable Mod Date
            if(!empty($category_info['settings']['disable_mod_date']) && !empty($category_info['settings']['override_gs'])){
                $this->data['disable_mod_date'] = $category_info['settings']['disable_mod_date'];
            }elseif(!empty($global_settings['disable_mod_date'])){
                $this->data['disable_mod_date'] = $global_settings['disable_mod_date'];
            }else{
                $this->data['disable_mod_date'] = false;
            }
            
            //Disable Create Date
            if(!empty($category_info['settings']['disable_create_date']) && !empty($category_info['settings']['override_gs'])){
                $this->data['disable_create_date'] = $category_info['settings']['disable_create_date'];
            }elseif(!empty($global_settings['disable_create_date'])){
                $this->data['disable_create_date'] = $global_settings['disable_create_date'];
            }else{
                $this->data['disable_create_date'] = false;
            }
            
            //Disable Cat List
            if(!empty($category_info['settings']['disable_cat_list']) && !empty($category_info['settings']['override_gs'])){
                $this->data['disable_cat_list'] = $category_info['settings']['disable_cat_list'];
            }elseif(!empty($global_settings['disable_cat_list'])){
                $this->data['disable_cat_list'] = $global_settings['disable_cat_list'];
            }else{
                $this->data['disable_cat_list'] = false;
            }
            
            //Disable Comment Count
            if(!empty($category_info['settings']['disable_com_count']) && !empty($category_info['settings']['override_gs'])){
                $this->data['disable_com_count'] = $category_info['settings']['disable_com_count'];
            }elseif(!empty($global_settings['disable_com_count'])){
                $this->data['disable_com_count'] = $global_settings['disable_com_count'];
            }else{
                $this->data['disable_com_count'] = false;
            }

            $this->data['heading_title'] = $category_info['name'];
            
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $data = array(
            'start'         => ($page - 1) * $limit,
            'art_amount'    => $limit,
            'not_for_blog'  => 0,
            'access_level' => $this->checkAccess()
            );
            
            
            $articles = $this->model_ac_cms_article->getArticles($data);
            
            $this->data['articles'] = array();
            if(is_array($articles))
            {
                foreach($articles as $article)
                {
                    if(!empty($article['viewed'])){
                        $viewed = $article['viewed'];
                    } else {
                        $viewed = 0;
                    }
                
                    if(!empty($article['date_modified'])&& strtotime($article['date_modified'])){
                        $date_modified = date($date_format_long, strtotime($article['date_modified']));
                    } else {
                        $date_modified = false;
                    }
                    
                    $date_added = date($date_format_short, strtotime($article['date_added'])); 
                    
                    $intro = html_entity_decode($article['intro'], ENT_QUOTES, 'UTF-8');
                    
                    //Cats             
                    $cats = array();
                    if(!$this->data['disable_cat_list'] )        
                    {
                        $categories = $this->model_ac_cms_article->getArticleCategories($article['b_id']);;
                        if(!empty($categories)){
                            foreach ($categories as $id => $value)
                            {
                                $value['href']  = $this->url->link('ac_cms/category', 'ac_path=' . $id);
                                $cats[$id] = $value;
                            }
                        }
                    }
                    
                    if(isset($article['description'])){
                        if(strip_tags(html_entity_decode($article['description'], ENT_QUOTES, 'UTF-8'))!= ''){
                            $description = true;
                        }else{
                            $description = null;
                        }
                    }
                    
                    if(($article['com_access_level'] == 1 && !$this->customer->isLogged())){
                        $comment_access = false;
                    } else {
                        $comment_access = true;
                    }
                    
                    if(!empty($article['firstname'])){
                        $username = $article['firstname'] . ' ' . $article['lastname'];
                    } else {
                        $username = $article['username'];
                    }
                    
                    
                    $this->data['articles'][] = array(
                        'title' => $article['title'],
                        'username' => $username,
                        'date_added' => $date_added,
                        'categories' => $cats,
                        'intro' => $intro,
                        'description' => $description,
                        'date_modified' => $date_modified,
                        'viewed' => $viewed,
                        'comments' => $article['comments'],
                        'comment_access' => $comment_access,
                        'allow_comments' => $article['allow_comments'],
                        'href' => $this->url->link('ac_cms/article', 'b_id=' . $article['b_id']),
                        'c_count' => count($cats)
                    );
                }
                $url = '';
                $pagination = new Pagination();
                $pagination->total = $articles_total;
                $pagination->page = $page;
                $pagination->limit = $limit;
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = $this->url->link('ac_cms/blog', $url . '&page={page}');
                
                $this->data['pagination'] = $pagination->render();

                /*$this->data['sort'] = $sort;
                $this->data['order'] = $order;
                $this->data['limit'] = $limit;*/
            }
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ac_cms/category.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/ac_cms/category.tpl';
            } else {
                    $this->template = 'default/template/ac_cms/category.tpl';
            }
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/ac_cms.css')) {
                $this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template') . '/stylesheet/ac_cms.css'); 
            } else {
                $this->document->addStyle('catalog/view/theme/default/stylesheet/ac_cms.css');
            }

            $this->children = array(
                    'common/column_left',
                    'common/column_right',
                    'common/content_top',
                    'common/content_bottom',
                    'common/footer',
                    'common/header'
            );

            $this->response->setOutput($this->render());
        }
        else
        {
            $url = '';
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            
            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_error'),
                'href'      => $this->url->link('ac_cms/category', $url),
                'separator' => $this->language->get('text_separator')
            );
            
            $this->document->setTitle($this->language->get('text_error'));

            $this->data['heading_title'] = $this->language->get('text_error');

            $this->data['text_error'] = $this->language->get('text_error');

            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                    $this->template = 'default/template/error/not_found.tpl';
            }

            $this->children = array(
                    'common/column_left',
                    'common/column_right',
                    'common/content_top',
                    'common/content_bottom',
                    'common/footer',
                    'common/header'
            );

            $this->response->setOutput($this->render());
        }
    }
    
    public function rss()
    {
        $this->load->model('ac_cms/category');
        $this->load->model('ac_cms/article');
        
        $lang_id = $this->config->get('config_language_id');
        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
        $category_info = array(
            'meta_description' => (isset($global_settings['desc'][$lang_id]['meta_description'])) ? $global_settings['desc'][$lang_id]['meta_description'] : '',
            'name' => (isset($global_settings['desc'][$lang_id]['blog_name'])) ? $global_settings['desc'][$lang_id]['blog_name'] : '',
            'rss' =>(!empty($global_settings['blog_rss'])) ? true : false
        );
        
        if($category_info['rss']) 
        {
            $rssfeed = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $rssfeed .= '<rss version="2.0">'."\n";
            $rssfeed .= '<channel>'."\n";
            $rssfeed .= '<title>' . strip_tags($category_info['name']) . '</title>'."\n";
            $rssfeed .= '<link>' . $this->url->link('ac_cms/blog') . '</link>'."\n";
            $rssfeed .= '<description>' . strip_tags($category_info['meta_description']) . '</description>'."\n";
            
            $data = array(
            'art_amount'    => 15,
            'not_for_blog'  => 0,
            'access_level' => $this->checkAccess()
            );
            
            $articles = $this->model_ac_cms_article->getArticles($data);
            
            foreach($articles as $article) {
                $rssfeed .= '<item>'."\n";
                $rssfeed .= '<title>' . strip_tags($article['title']) . '</title>'."\n";
                $rssfeed .= '<description>' . strip_tags($article['meta_description']) . '</description>'."\n";
                $rssfeed .= '<link>' . $this->url->link('ac_cms/article', 'b_id=' . $article['b_id']) . '</link>'."\n";
                $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($article['date_added'])) . '</pubDate>'."\n";
                $rssfeed .= '</item>'."\n";
            }

            $rssfeed .= '</channel>'."\n";
            $rssfeed .= '</rss>';

            $this->response->addHeader('Content-Type: application/rss+xml');
            $this->response->setOutput($rssfeed);
        } 
        else 
        {
            $this->redirect($this->url->link('error/not_found')); 
        }
    }
}

?>
