<?php

class ControllerACcmsArticle extends Controller
{

    protected function checkAccess()
    {
        if ($this->customer->isLogged()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function index()
    {
        $this->language->load('ac_cms/article');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->load->model('ac_cms/category');

        if (isset($this->request->get['ac_path'])) {
            $ac_path = '';

            foreach (explode('_', $this->request->get['ac_path']) as $ac_path_id) {
                if (!$ac_path) {
                    $ac_path = $ac_path_id;
                } else {
                    $ac_path .= '_' . $ac_path_id;
                }

                $category_info = $this->model_ac_cms_category->getCategory($ac_path_id);

                if ($category_info) {
                    $this->data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('ac_cms/category', 'ac_path=' . $ac_path),
                        'separator' => $this->language->get('text_separator')
                    );
                }
            }
        }

        if (isset($this->request->get['b_id'])) {
            $b_id = $this->request->get['b_id'];
        } else {
            $b_id = 0;
        }

        $this->load->model('ac_cms/article');

        if (isset($this->request->get['archive'])) {
            $article_info = $this->model_ac_cms_article->getArticle($b_id, $this->checkAccess(), true);
            $this->data['archive'] = $this->request->get['archive'];

        } else {
            $article_info = $this->model_ac_cms_article->getArticle($b_id, $this->checkAccess());
            $this->data['archive'] = false;
        }

        $this->data['article_info'] = $article_info;

        if (!empty($article_info)) {
            if (($article_info['access_level'] == 1 && $this->customer->isLogged()) || ($article_info['access_level'] == 0)) {
                $this->model_ac_cms_article->updateViewed($this->request->get['b_id']);
                $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));

                $this->data['text_viewed'] = $this->language->get('text_viewed');
                $this->data['text_category'] = $this->language->get('text_category');
                $this->data['text_author'] = $this->language->get('text_author');
                $this->data['text_tags'] = $this->language->get('text_tags');
                $this->data['text_share'] = $this->language->get('text_share');
                $this->data['text_modified'] = $this->language->get('text_modified');
                $this->data['text_created'] = $this->language->get('text_created');
                $this->data['text_rel_article'] = $this->language->get('text_rel_article');
                $this->data['text_rel_product'] = $this->language->get('text_rel_product');
                $this->data['text_rss'] = $this->language->get('text_rss');
                $this->data['text_note'] = $this->language->get('text_note');
                $this->data['text_write'] = $this->language->get('text_write');
                $this->data['button_add_comment'] = $this->language->get('button_add_comment');
                $this->data['text_wait'] = $this->language->get('text_wait');
                $this->data['text_no_comments'] = $this->language->get('text_no_comments');
                $this->data['text_comments'] = $this->language->get('text_comments');
                //$this->data['text_success_need_apr'] = $this->language->get('text_success_need_apr');
                //$this->data['text_success_need_apr'] = $this->language->get('text_success_need_apr');

                $this->data['b_id'] = $b_id;

                $this->data['error_name'] = $this->language->get('error_name');
                $this->data['error_text'] = $this->language->get('error_text');
                $this->data['error_captcha'] = $this->language->get('error_captcha');

                $this->data['entry_name'] = $this->language->get('entry_name');
                $this->data['entry_comment'] = $this->language->get('entry_comment');
                $this->data['entry_captcha'] = $this->language->get('entry_captcha');

                $url = '';

                if (isset($this->request->get['ac_path'])) {
                    $url .= '&ac_path=' . $this->request->get['ac_path'];
                }

                $this->data['breadcrumbs'][] = array(
                    'text' => $article_info['title'],
                    'href' => $this->url->link('ac_cms/article', $url . '&b_id=' . $this->request->get['b_id']),
                    'separator' => $this->language->get('text_separator')
                );

                $this->data['rel_articles'] = array();
                $rel_articles = $this->model_ac_cms_article->getArticleRelated($b_id, $this->checkAccess());
                if (!empty($rel_articles)) {
                    foreach ($rel_articles as $id => $value) {
                        $value['href'] = $this->url->link('ac_cms/article', 'b_id=' . $id);
                        $this->data['rel_articles'][$id] = $value;
                    }
                }

                $this->load->model('tool/image');
                $this->language->load('product/product');
                $this->data['button_cart'] = $this->language->get('button_cart');

                $this->data['products'] = array();

                $results = $this->model_ac_cms_article->getProductRelated($b_id);

                foreach ($results as $result) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
                    } else {
                        $image = false;
                    }

                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $price = false;
                    }

                    if ((float)$result['special']) {
                        $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $special = false;
                    }

                    if ($this->config->get('config_review_status')) {
                        $rating = (int)$result['rating'];
                    } else {
                        $rating = false;
                    }

                    $this->data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'thumb' => $image,
                        'name' => $result['name'],
                        'price' => $price,
                        'special' => $special,
                        'rating' => $rating,
                        'reviews' => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
                        'href' => $this->url->link('product/product', 'product_id=' . $result['product_id']),
                    );
                }

                $this->data['heading_title'] = $article_info['title'];

                //Article Href
                $this->data['href'] = $this->url->link('ac_cms/article', 'b_id=' . $b_id);

                //Date formats
                $date_format_short = $this->language->get('date_format_short');
                $date_format_long = $this->language->get('date_format_long');

                //Fb like
                $this->data['fb_href'] = urlencode($this->url->link('ac_cms/article', 'b_id=' . $b_id));

                //Disable Author
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_author'] = (isset($article_info['settings']['disable_author'])) ? $article_info['settings']['disable_author'] : false;
                } elseif (isset($global_settings['disable_author'])) {
                    $this->data['disable_author'] = $global_settings['disable_author'];
                } else {
                    $this->data['disable_author'] = false;
                }

                //Disable Mod Date
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_mod_date'] = (isset($article_info['settings']['disable_mod_date'])) ? $article_info['settings']['disable_mod_date'] : false;
                } elseif (isset($global_settings['disable_mod_date'])) {
                    $this->data['disable_mod_date'] = $global_settings['disable_mod_date'];
                } else {
                    $this->data['disable_mod_date'] = false;
                }

                //Disable Create Date
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_create_date'] = (isset($article_info['settings']['disable_create_date'])) ? $article_info['settings']['disable_create_date'] : false;
                } elseif (isset($global_settings['disable_create_date'])) {
                    $this->data['disable_create_date'] = $global_settings['disable_create_date'];
                } else {
                    $this->data['disable_create_date'] = false;
                }

                //Disable Cat List
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_cat_list'] = (isset($article_info['settings']['disable_cat_list'])) ? $article_info['settings']['disable_cat_list'] : false;
                } elseif (isset($global_settings['disable_cat_list'])) {
                    $this->data['disable_cat_list'] = $global_settings['disable_cat_list'];
                } else {
                    $this->data['disable_cat_list'] = false;
                }

                //Disable Comment Count

                if (($article_info['com_access_level'] == 1 && !$this->customer->isLogged())) {
                    $this->data['disable_com_count'] = true;
                } elseif (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_com_count'] = (isset($article_info['settings']['disable_com_count'])) ? $article_info['settings']['disable_com_count'] : false;
                } elseif (isset($global_settings['disable_com_count'])) {
                    $this->data['disable_com_count'] = $global_settings['disable_com_count'];
                } else {
                    $this->data['disable_com_count'] = false;
                }

                //Disable FB Button
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_fblike'] = (isset($article_info['settings']['disable_fblike'])) ? $article_info['settings']['disable_fblike'] : false;
                } elseif (isset($global_settings['disable_fblike'])) {
                    $this->data['disable_fblike'] = $global_settings['disable_fblike'];
                } else {
                    $this->data['disable_fblike'] = false;
                }

                //Fb admins
                if (isset($global_settings['facebook_admins'])) {
                    $this->data['facebook_admins'] = $global_settings['facebook_admins'];
                } else {
                    $this->data['facebook_admins'] = false;
                }

                //Fb container width
                if (isset($global_settings['facebook_width'])) {
                    $this->data['facebook_width'] = $global_settings['facebook_width'];
                } else {
                    $this->data['facebook_width'] = 470;
                }

                //Comment engine
                if (isset($global_settings['comment_engine'])) {
                    $this->data['comment_engine'] = $global_settings['comment_engine'];
                } else {
                    $this->data['comment_engine'] = 0;
                }

                //Disqus Shortname
                if (isset($global_settings['disqus_id'])) {
                    $this->data['disqus_id'] = $global_settings['disqus_id'];
                } else {
                    $this->data['disqus_id'] = false;
                }

                //Comments per page
                if (isset($global_settings['comment_page_size'])) {
                    $this->data['comment_page_size'] = $global_settings['comment_page_size'];
                } else {
                    $this->data['comment_page_size'] = 10;
                }

                //Disqus Force Lang
                if (isset($global_settings['disqus_force_lang'])) {
                    $this->data['disqus_force_lang'] = $global_settings['disqus_force_lang'];
                } else {
                    $this->data['disqus_force_lang'] = 0;
                }

                //Disable FB Button
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_fblike'] = (isset($article_info['settings']['disable_fblike'])) ? $article_info['settings']['disable_fblike'] : false;
                } elseif (isset($global_settings['disable_fblike'])) {
                    $this->data['disable_fblike'] = $global_settings['disable_fblike'];
                } else {
                    $this->data['disable_fblike'] = false;
                }

                //Disable Viewed
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_viewed'] = (isset($article_info['settings']['disable_viewed'])) ? $article_info['settings']['disable_viewed'] : false;
                } elseif (isset($global_settings['disable_viewed'])) {
                    $this->data['disable_viewed'] = $global_settings['disable_viewed'];
                } else {
                    $this->data['disable_viewed'] = false;
                }

                //Disable AddThis
                if (isset($article_info['settings']['override_gs'])) {
                    $this->data['disable_share'] = (isset($article_info['settings']['disable_share'])) ? $article_info['settings']['disable_share'] : false;
                } elseif (isset($global_settings['disable_share'])) {
                    $this->data['disable_share'] = $global_settings['disable_share'];
                } else {
                    $this->data['disable_share'] = false;
                }

                //Comments Appr
                if (!empty($article_info['comments_approve'])) {
                    $this->data['comments_approve'] = true;
                } else {
                    $this->data['comments_approve'] = false;
                }


                //Comment Count
                if (isset($article_info['comments'])) {
                    $this->data['comments'] = $article_info['comments'];
                    if (!empty($ac_path)) {
                        $this->data['comment_href'] = $this->url->link('ac_cms/article', 'ac_path=' . $ac_path . '&b_id=' . $b_id) . '#comments';
                    } else {
                        $this->data['comment_href'] = $this->url->link('ac_cms/article', 'b_id=' . $b_id) . '#comments';
                    }
                } else {
                    $this->data['comments'] = 0;
                }

                //Cats          
                $this->data['categories'] = array();
                $this->data['c_count'] = 0;
                if (!$this->data['disable_cat_list']) {
                    $categories = $this->model_ac_cms_article->getArticleCategories($b_id);
                    if (!empty($categories)) {
                        foreach ($categories as $id => $value) {
                            $value['href'] = $this->url->link('ac_cms/category', 'ac_path=' . $id);
                            $this->data['categories'][$id] = $value;
                        }
                        $this->data['c_count'] = count($this->data['categories']);
                    }
                }

                //Tags
                $this->data['tags'] = array();
                $tags = $this->model_ac_cms_article->getArticleTags($b_id);
                $this->data['c_tags'] = count($tags);
                foreach ($tags as $result) {
                    $this->data['tags'][] = array(
                        'tag' => $result['tag'],
                        'href' => $this->url->link('ac_cms/search', 'filter_tag=' . $result['tag']),
                        'name' => $this->language->get($result['tag']),
                        'pic' => 'image/data/ingredients/' . str_replace(' ', '_'$result['tag']).'.png'
                    
                                );
                        }

                //Date Added
                $this->data['date_added'] = date($date_format_short, strtotime($article_info['date_added']));

                //Date Modified
                if (!empty($article_info['date_modified']) && strtotime($article_info['date_modified'])) {
                    $this->data['date_modified'] = date($date_format_long, strtotime($article_info['date_modified']));
                } else {
                    $this->data['date_modified'] = false;
                }

                //Allow Comments
                if (!empty($article_info['allow_comments'])) {
                    $this->data['allow_comments'] = $article_info['allow_comments'];
                } else {
                    $this->data['allow_comments'] = false;
                }

                $this->data['allow_access'] = true;

                if (($article_info['com_access_level'] == 1) && !$this->customer->isLogged()) {
                    $this->data['allow_access'] = false;
                }

                if (!empty($article_info['firstname'])) {
                    $this->data['username'] = $article_info['firstname'] . ' ' . $article_info['lastname'];
                } else {
                    $this->data['username'] = $article_info['username'];
                }


                if (!empty($article_info['viewed'])) {
                    $this->data['viewed'] = $article_info['viewed'];
                } else {
                    $this->data['viewed'] = 0;
                }

                $this->data['intro'] = html_entity_decode($article_info['intro'], ENT_QUOTES, 'UTF-8');

                $this->data['description'] = html_entity_decode($article_info['description'], ENT_QUOTES, 'UTF-8');

                if ($article_info['image']) {
                    $image_ac = $this->model_tool_image->resize($article_info['image'], 775, 390);
                } else {
                    $image_ac = false;
                }
                $this->data['article_info']['image_ac'] = $image_ac;


                $this->document->setTitle($article_info['title']);
                $this->document->setDescription($article_info['meta_description']);
                $this->document->setKeywords($article_info['meta_keyword']);
                $this->document->addLink($this->url->link('ac_cms/article', 'b_id=' . $this->request->get['b_id']), 'canonical');

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ac_cms/article.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/ac_cms/article.tpl';
                } else {
                    $this->template = 'default/template/ac_cms/article.tpl';
                }

                $this->children = array(
                    'common/column_left',
                    'common/column_right',
                    'common/content_top',
                    'common/content_bottom',
                    'common/footer',
                    'common/header'
                );

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/ac_cms.css')) {
                    $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/ac_cms.css');
                } else {
                    $this->document->addStyle('catalog/view/theme/default/stylesheet/ac_cms.css');
                }

                $this->response->setOutput($this->render());
            } else {
                $this->redirect($this->url->link('account/login'));
            }
        } else {

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

    public function comment()
    {
        $this->language->load('ac_cms/article');

        $this->load->model('ac_cms/comment');

        $this->data['text_no_comments'] = $this->language->get('text_no_comments');

        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->data['comments'] = array();

        $c_limit = (!empty($global_settings['comment_page_size'])) ? $global_settings['comment_page_size'] : 10;

        $comment_total = $this->model_ac_cms_comment->getTotalCommentsByArticleId($this->request->get['b_id']);

        $results = $this->model_ac_cms_comment->getCommentsByArticleId($this->request->get['b_id'], ($page - 1) * $c_limit, $c_limit);

        foreach ($results as $result) {
            $this->data['comments'][] = array(
                'name' => $result['name'],
                'text' => strip_tags($result['text']),
                'comments' => sprintf($this->language->get('text_comments'), (int)$comment_total),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $pagination = new Pagination();
        $pagination->total = $comment_total;
        $pagination->page = $page;
        $pagination->limit = $c_limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $pagination->url = 'index.php?route=ac_cms/article/comment&b_id=' . $this->request->get['b_id'] . '&page={page}';

        $this->data['pagination'] = $pagination->render();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/ac_cms/comment.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/ac_cms/comment.tpl';
        } else {
            $this->template = 'default/template/ac_cms/comment.tpl';
        }

        $this->response->setOutput($this->render());
    }

    public function write()
    {
        $this->language->load('ac_cms/article');

        $this->load->model('ac_cms/comment');

        $json = array();

        $article_settings = $this->model_ac_cms_comment->getArticleSettingsByArticleId($this->request->get['b_id']);

        if (!empty($article_settings['com_access_level']) && !$this->customer->isLogged()) {
            $json['error'] = $this->language->get('error_access');
        }
        //JAV Lejár cikkhez ne lehessen kommentet írni
//            if (isset($article_settings['date_expr'])) {
//                
//                $expr = strtotime($article_settings['date_expr']);
//                $now = strtotime(date("Y-m-d"));
//                if(!empty($expr)){
//                    If($expr < $now){
//                        $json['error'] = $this->language->get('error_access');
//                    }
//                }
//            }

        if (empty($article_settings['allow_comments'])) {
            $json['error'] = $this->language->get('error_access');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
            $json['error'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['text']) < 3) || (utf8_strlen($this->request->post['text']) > 1000)) {
            $json['error'] = $this->language->get('error_text');
        }

        if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
            $json['error'] = $this->language->get('error_captcha');
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {

            $this->model_ac_cms_comment->addComment($this->request->get['b_id'], $this->request->post, (bool)$article_settings['comments_approve']);
            if (!empty($article_settings['com_notify'])) {
                if (!empty($article_settings['comments_approve'])) {
                    $msg = $this->language->get('mail_message');
                } else {
                    $msg = $this->language->get('mail_message_need_apr');
                }

                $subject = sprintf($this->language->get('mail_subject'), $this->config->get('config_name'));
                $link = $this->url->link('ac_cms/article', 'b_id=' . $this->request->get['b_id']);
                $message = '<html dir="ltr" lang="en">' . "\n";
                $message .= '<head>' . "\n";
                $message .= '<title>' . $subject . '</title>' . "\n";
                $message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
                $message .= '</head>' . "\n";
                $message .= '<body>' . sprintf($msg, $article_settings['username'], $this->request->post['name'], $article_settings['title'], strip_tags(html_entity_decode($this->request->post['text'], ENT_QUOTES, 'UTF-8')), '<a href="' . $link . '" >' . $link . '</a>') . '</body>' . "\n";
                $message .= '</html>' . "\n";

                $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setTo($this->config->get('config_email'));
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->request->post['name']);
                $mail->setSubject($subject);

                $mail->setHtml($message);
                $mail->send();
            }

            $json['success'] = ((bool)$article_settings['comments_approve']) ? $this->language->get('text_success') : $this->language->get('text_success_need_apr');

        }

        $this->response->setOutput(json_encode($json));
    }

    public function captcha()
    {
        $this->load->library('captcha');

        $captcha = new Captcha();

        $this->session->data['captcha'] = $captcha->getCode();

        $captcha->showImage();
    }
}

?>
