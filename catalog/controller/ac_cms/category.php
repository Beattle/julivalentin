<?php

class ControllerACcmsCategory extends Controller {
    
    protected function checkAccess()
    {
        if($this->customer->isLogged()){
            return 1;
        } else {
            return 0;
        }
    }
    
//    public function archive()
//    {
//        $this->listCategory(true);
//    }
    
    public function index()
    {
        $this->listCategory();
    }
    
    public function listCategory($archive = false)
    {
        $this->language->load('ac_cms/category');
		
        $this->load->model('ac_cms/category');

        $this->load->model('ac_cms/article');

        $this->load->model('tool/image');
        
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
        'text'      => $this->language->get('text_home'),
        'href'      => $this->url->link('common/home'),
        'separator' => false
        );
        
        $category_info = null;
        
        if (isset($this->request->get['ac_path'])) {
            $path = '';

            $parts = explode('_', (string)$this->request->get['ac_path']);

            foreach ($parts as $path_id) {
                    if (!$path) {
                            $path = $path_id;
                    } else {
                            $path .= '_' . $path_id;
                    }

                    $category_info = $this->model_ac_cms_category->getCategory($path_id);

                    if ($category_info) {
                        
                        $href = $this->url->link('ac_cms/category', 'ac_path=' . $path);
                        $name = $category_info['name'];
                        
                        if($archive){
                            $href = $this->url->link('ac_cms/category/archive', 'ac_path=' . $path);
                            $name = $category_info['name'] . ' - ' . $this->language->get('text_archive');
                        }
                        
                        $this->data['breadcrumbs'][] = array(
                                'text'      => $name,
                                'href'      => $href,
                                'separator' => $this->language->get('text_separator')
                        );
                    }
            }		
            $bc_id = array_pop($parts);
        }
                
        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
        
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
            $this->data['text_archive'] = $this->language->get('text_archive');
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
            
            //Image
            if (isset($category_info['image'])) {
                    $this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
            } else {
                    $this->data['thumb'] = '';
            }
            
            //Date formats
            $date_format_short = $this->language->get('date_format_short');
            $date_format_long = $this->language->get('date_format_long');
            
            $data_archive = array();
            
            $this->data['heading_title'] = $category_info['name'];
            
            $this->data['archive_href'] = $this->url->link('ac_cms/category/archive', 'ac_path=' . $bc_id);
            
            $url = '';
            $route = 'ac_cms/category';
            
            if(!$archive)
            {
                //RSS
                if(!empty($category_info['rss'])){
                    $this->data['rss'] = true;
                    $this->data['rss_href'] = $this->url->link('ac_cms/category/rss', 'ac_path=' . $path);
                }else{
                    $this->data['rss'] = false;
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

                //Disable Author
                if(isset($category_info['settings']['override_gs'])){
                    $this->data['disable_author'] = (isset($category_info['settings']['disable_author']))?$category_info['settings']['disable_author']:false;
                }elseif(isset($global_settings['disable_author'])){
                    $this->data['disable_author'] = $global_settings['disable_author'];
                }else{
                    $this->data['disable_author'] = false;
                }

                //Disable Mod Date
                if(isset($category_info['settings']['override_gs'])){
                    $this->data['disable_mod_date'] = (isset($category_info['settings']['disable_mod_date']))?$category_info['settings']['disable_mod_date']:false;
                }elseif(isset($global_settings['disable_mod_date'])){
                    $this->data['disable_mod_date'] = $global_settings['disable_mod_date'];
                }else{
                    $this->data['disable_mod_date'] = false;
                }

                //Disable Create Date
                if(isset($category_info['settings']['override_gs'])){
                    $this->data['disable_create_date'] = (isset($category_info['settings']['disable_create_date']))?$category_info['settings']['disable_create_date']:false;
                }elseif(isset($global_settings['disable_create_date'])){
                    $this->data['disable_create_date'] = $global_settings['disable_create_date'];
                }else{
                    $this->data['disable_create_date'] = false;
                }

                //Disable Cat List
                if(isset($category_info['settings']['override_gs'])){
                    $this->data['disable_cat_list'] = (isset($category_info['settings']['disable_cat_list']))?$category_info['settings']['disable_cat_list']:false;
                }elseif(isset($global_settings['disable_cat_list'])){
                    $this->data['disable_cat_list'] = $global_settings['disable_cat_list'];
                }else{
                    $this->data['disable_cat_list'] = false;
                }

                //Disable Comment Count
                if(isset($category_info['settings']['override_gs'])){
                    $this->data['disable_com_count'] = (isset($category_info['settings']['disable_com_count']))?$category_info['settings']['disable_com_count']:false;
                }elseif(isset($global_settings['disable_com_count'])){
                    $this->data['disable_com_count'] = $global_settings['disable_com_count'];
                }else{
                    $this->data['disable_com_count'] = false;
                }
                
                //Hide Archive
                if(isset($category_info['settings']['archive'])){
                    $this->data['archive'] = $category_info['settings']['archive'];
                }else{
                    $this->data['archive'] = false;
                }
                
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ac_cms/category.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/ac_cms/category.tpl';
                } else {
                        $this->template = 'default/template/ac_cms/category.tpl';
                }
            }
            else 
            {
                $route = 'ac_cms/category/archive';
                
                if (isset($this->request->get['filter_date_from'])) {
                    $filter_date_from = $this->request->get['filter_date_from'];
                } else {
                        $filter_date_from = null;
                }

                if (isset($this->request->get['filter_date_to'])) {
                        $filter_date_to = $this->request->get['filter_date_to'];
                } else {
                        $filter_date_to = null;
                }
                
                

                if (isset($this->request->get['filter_date_from'])) {
                        $url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
                }

                if (isset($this->request->get['filter_date_to'])) {
                        $url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
                }
                
                $this->data['filter_date_from'] = $filter_date_from;
                $this->data['filter_date_to'] = $filter_date_to;
                
                $this->data['rss'] = false;
                $this->data['disable_author'] = false;
                $this->data['disable_mod_date'] = false;
                $this->data['disable_create_date'] = false;
                $this->data['disable_cat_list'] = false;
                $this->data['disable_com_count'] = false;
                $this->data['hide_archive'] = true;
                
                $this->data['text_date_start'] = $this->language->get('text_date_start');
                $this->data['text_date_end'] = $this->language->get('text_date_end');
                $this->data['text_filter'] = $this->language->get('text_filter');
                
                $this->data['heading_title'] = $category_info['name']. ' - ' . $this->language->get('text_archive');
                $data_archive = array(
                    'archive' => true,
                    'filter_date_from' => $filter_date_from,
                    'filter_date_to' =>$filter_date_to
                    );
                $this->data['archive'] = false;
                
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ac_cms/archive.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/ac_cms/archive.tpl';
                } else {
                        $this->template = 'default/template/ac_cms/archive.tpl';
                }
            }
                        
                        
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $data[] = array(
            'category'      => $bc_id,
            'start'         => ($page - 1) * $limit,
            'art_amount'    => $limit,
            'access_level' => $this->checkAccess()
            );
            
            $data = array_merge($data[0], $data_archive);
            
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
                        $categories = $this->model_ac_cms_article->getArticleCategories($article['b_id']);
                        if(!empty($categories)){
                            foreach ($categories as $id => $value)
                            {
                               $parents = array();
                               $parents = $this->model_ac_cms_category->getCategoryParents($id);
                               $parents[] = (string)$id;
                               $value['href']  = $this->url->link('ac_cms/category', 'ac_path=' . implode('_', $parents));
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
                    
                    $archive = '';
                    
                    if($this->request->get['route'] == 'ac_cms/category/archive'){
                        $archive = '&archive=true';
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
                        'allow_comments' => $article['allow_comments'],
                        'comment_access' => $comment_access,
                        'href' => $this->url->link('ac_cms/article', 'ac_path=' . $this->request->get['ac_path'] . $archive . '&b_id=' . $article['b_id']),
                        'c_count' => count($cats)
                    );
                }
            
                //$url = '';
                $data = array('category' => $bc_id, 'access_level' => $this->checkAccess());
                $data = array_merge($data, $data_archive);
                $articles_total = $this->model_ac_cms_article->getTotalArticles($data);
                $pagination = new Pagination();
                $pagination->total = $articles_total;
                $pagination->page = $page;
                $pagination->limit = $limit;
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = $this->url->link($route, 'ac_path=' . $this->request->get['ac_path'] . $url . '&page={page}');
                
                $this->data['pagination'] = $pagination->render();
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
        
        if (isset($this->request->get['ac_path'])) {
            $parts = explode('_', (string)$this->request->get['ac_path']);		
            $bc_id = array_pop($parts);
            $category_info = $this->model_ac_cms_category->getCategory($bc_id);
        }
        
        if(!empty($category_info['rss'])) 
        {
            $rssfeed = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $rssfeed .= '<rss version="2.0">'."\n";
            $rssfeed .= '<channel>'."\n";
            $rssfeed .= '<title>' . strip_tags($category_info['name']) . '</title>'."\n";
            $rssfeed .= '<link>' . $this->url->link('ac_cms/category', 'ac_path=' . $this->request->get['ac_path']) . '</link>'."\n";
            $rssfeed .= '<description>' . strip_tags($category_info['meta_description']) . '</description>'."\n";
            
            $data = array(
            'art_amount'    => 15,
            'category' => $bc_id,
            'access_level' => $this->checkAccess()
            );

            $articles = $this->model_ac_cms_article->getArticles($data);
            foreach($articles as $article) {
                $rssfeed .= '<item>'."\n";
                $rssfeed .= '<title>' . strip_tags($article['title']) . '</title>'."\n";
                $rssfeed .= '<description>' . strip_tags($article['meta_description']) . '</description>'."\n";
                $rssfeed .= '<link>' . $this->url->link('ac_cms/article', 'ac_path=' . $this->request->get['ac_path'] . '&b_id=' . $article['b_id']) . '</link>'."\n";
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
