<?php

class ControllerModuleACcmsSet extends Controller
{

    protected function checkAccess()
    {
        if ($this->customer->isLogged()) {
            return 1;
        } else {
            return 0;
        }
    }

    protected function index($settings)
    {
        $this->load->model('ac_cms/category');
        $this->load->model('ac_cms/article');
        $this->load->model('ac_cms/set');
        $this->load->model('tool/image');
        $this->language->load('module/ac_cms_set');
        $this->language->load('ac_cms/article');
        static $module = 0;
        $m_module = $module++;
        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');


        $attributes_groups = $this->model_catalog_product->getProductAttributes($product_id);
        // Some check just in case

        if ($attributes_groups[0]['attribute_group_id'] == 7) {
            $arr_alias = explode(',', $attributes_group[0]['attribute'][0]['text']);
        }

        $this->data['check'] = $arr_alias;


        $article_set = $this->model_ac_cms_set->getArticleSet($settings['bs_id']);

        if ($article_set) {
            $this->renderAset(array(
                'article_set' => $article_set,
                'module' => $m_module,
                'settings' => $settings
            ));
        }

    }

    private function initArticleset($article_set)
    {
        $this->data['text_readmore'] = $this->language->get('text_readmore');

        $this->data['text_category'] = $this->language->get('text_category');
        $this->data['text_author'] = $this->language->get('text_author');
        $this->data['text_modified'] = $this->language->get('text_modified');
        $this->data['text_created'] = $this->language->get('text_created');
        $this->data['text_comments'] = $this->language->get('text_comments');

        $this->data['sort'] = explode(',', $article_set['settings']['sort']);
        $this->data['title_order'] = $this->getOrder($article_set['settings']['title_order']);
        $this->data['info_order'] = $this->getOrder($article_set['settings']['info_order']);
        $this->data['image_order'] = $this->getOrder($article_set['settings']['image_order'], true);
        $this->data['text_order'] = $this->getOrder($article_set['settings']['text_order']);
        $this->data['readmore_order'] = $this->getOrder($article_set['settings']['readmore_order']);

        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
        //Comment engine
        if (isset($global_settings['comment_engine'])) {
            $this->data['comment_engine'] = $global_settings['comment_engine'];
        } else {
            $this->data['comment_engine'] = 0;
        }

        //TEXT AS LINK
        if (isset($article_set['settings']['text_as_link'])) {
            $this->data['text_as_link'] = $article_set['settings']['text_as_link'];
        } else {
            $this->data['text_as_link'] = 0;
        }

        //IMAGE AS LINK
        if (isset($article_set['settings']['image_as_link'])) {
            $this->data['image_as_link'] = $article_set['settings']['image_as_link'];
        } else {
            $this->data['image_as_link'] = 0;
        }

        //TITLE AS LINK
        if (isset($article_set['settings']['title_as_link'])) {
            $this->data['title_as_link'] = $article_set['settings']['title_as_link'];
        } else {
            $this->data['title_as_link'] = 0;
        }

        //DISABLE AUTHOR
        if (isset($article_set['settings']['disable_author'])) {
            $this->data['disable_author'] = $article_set['settings']['disable_author'];
        } else {
            $this->data['disable_author'] = 0;
        }

        //DISABLE MOD DATE
        if (isset($article_set['settings']['disable_mod_date'])) {
            $this->data['disable_mod_date'] = $article_set['settings']['disable_mod_date'];
        } else {
            $this->data['disable_mod_date'] = 0;
        }

        //DISABLE CREATE DATE
        if (isset($article_set['settings']['disable_create_date'])) {
            $this->data['disable_create_date'] = $article_set['settings']['disable_create_date'];
        } else {
            $this->data['disable_create_date'] = 0;
        }

        //DISABLE CAT LIST
        if (isset($article_set['settings']['disable_cat_list'])) {
            $this->data['disable_cat_list'] = $article_set['settings']['disable_cat_list'];
        } else {
            $this->data['disable_cat_list'] = 0;
        }

        //DISABLE NUM COMMENTS
        if (isset($article_set['settings']['disable_com_count'])) {
            $this->data['disable_com_count'] = $article_set['settings']['disable_com_count'];
        } else {
            $this->data['disable_com_count'] = 0;
        }

        //LEAD ARTICLES
        if (!empty($article_set['settings']['lead_art_amount'])) {
            $this->data['lead_art_amount'] = $article_set['settings']['lead_art_amount'];
        } else {
            $this->data['lead_art_amount'] = 0;
        }

        //IMG MARGIN
        if (!empty($article_set['settings']['image_margin'])) {
            $this->data['image_margin'] = $article_set['settings']['image_margin'];
        } else {
            $this->data['image_margin'] = '0px 0px 0px 0px';
        }

        //WIDTH CALC
        if (!empty($article_set['settings']['art_columns'])) {
            if (!empty($article_set['settings']['column_width'])) {
                $this->data['width'] = $article_set['settings']['column_width'] . 'px';
            } else {
                $this->data['width'] = 100 / $article_set['settings']['art_columns'] - 2 + 2 / $article_set['settings']['art_columns'] . '%';
            }
        } else {
            $this->data['width'] = '100%';
        }

        //Column Width
        if (!empty($article_set['settings']['column_width'])) {
            $this->data['column_width'] = $article_set['settings']['column_width'] . '%';
        } else {
            $this->data['column_width'] = '100%';
        }

        //COLUMNS NUM
        if (!empty($article_set['settings']['art_columns']) && is_numeric($article_set['settings']['art_columns']) &&
            $article_set['settings']['art_columns'] > 1
        ) {
            $this->data['columns'] = $article_set['settings']['art_columns'];
            $this->data['class_last'] = 'last';
        } else {
            $this->data['columns'] = 1;
            $this->data['class_last'] = '';
        }

        //CALC LIST POS
        $width = rtrim($this->data['width'], '%');
        $c_width = rtrim($this->data['column_width'], '%');
        $margin = $c_width / 2;
        if ($this->data['columns'] > 1) {
            $comp = 100 - $width * $this->data['columns'];
            $margin -= $comp;
        }
        $this->data['center'] = "-" . $margin . '%';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/ac_cms.css')) {
            $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/ac_cms.css');
        } else {
            $this->document->addStyle('catalog/view/theme/default/stylesheet/ac_cms.css');
        }

    }

    public function renderAset($data)
    {
        $article_set = $data['article_set'];
        $settings = $data['settings'];
        $this->data['module'] = $data['module'];
        $this->data['title'] = $article_set['title'];
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->initArticleset($article_set);

        if (!isset($article_set['display_type'])) {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set.tpl';
            } else {
                $this->template = 'default/template/module/ac_cms_set.tpl';
            }
        } else {
            switch ($article_set['display_type']) {
                case '1':
                    $this->data['articles'] = $this->getArticles($article_set);
                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set_ac.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set_ac.tpl';
                    } else {
                        $this->template = 'default/template/module/ac_cms_set_ac.tpl';
                    }
                    break;

                case '2':
                    $this->data['articles'] = $this->getArticles($article_set);
                    $this->document->addScript('catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js');
                    $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/slideshow.css');

                    if (!empty($article_set['settings']['slideshow_cm'])) {
                        $this->data['slideshow_cm'] = $article_set['settings']['slideshow_cm'];
                    } else {
                        $this->data['slideshow_cm'] = '0';
                    }

                    if (!empty($article_set['settings']['slideshow_width'])) {
                        $this->data['slideshow_width'] = $article_set['settings']['slideshow_width'];
                    } else {
                        $this->data['slideshow_width'] = 868;
                    }

                    if (!empty($article_set['settings']['slideshow_height'])) {
                        $this->data['slideshow_height'] = $article_set['settings']['slideshow_height'];
                    } else {
                        $this->data['slideshow_height'] = 300;
                    }

                    $this->data['caption_width'] = (int)$this->data['slideshow_width'] - (int)$article_set['settings']['image_width'];
                    $this->data['left_push'] = (int)$this->data['slideshow_width'] - (int)$this->data['caption_width'];


                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set_slidshow.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set_slidshow.tpl';
                    } else {
                        $this->template = 'default/template/module/ac_cms_set_slidshow.tpl';
                    }
                    break;

                case '3':
                    $this->data['articles'] = $this->getArticles($article_set);
                    $this->document->addScript('catalog/view/javascript/jquery/tabs_ac_cms.js');
                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set_tab.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set_tab.tpl';
                    } else {
                        $this->template = 'default/template/module/ac_cms_set_tab.tpl';
                    }
                    break;

                case '4':

                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set_tab_cat.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set_tab_cat.tpl';
                    } else {
                        $this->template = 'default/template/module/ac_cms_set_tab_cat.tpl';
                    }
                    if (!empty($article_set['settings']['set_category'])) {
                        $cats = $article_set['settings']['set_category'];
                    } else {
                        $cats = false;
                    }
                    $this->data['cats'] = implode('_', $cats);
                    $this->document->addScript('catalog/view/javascript/jquery/tabs_ac_cms.js');
                    $categories_tabs = array();
                    if ($cats) {
                        $categories_tabs_info = $this->model_ac_cms_category->getCategoriesNPC(array('categories' => $cats));

                        if (is_array($cats)) {
                            foreach ($categories_tabs_info as $cat) {
                                $categories_tabs[] = array(
                                    'name' => $cat['name'],
                                    'bc_id' => $cat['bc_id']
                                );
                            }
                            $categories_tabs[0]['articles'] = $this->getArticles($article_set, $cats[0]['bc_id']);
                        }
                    }
                    $this->data['bs_id'] = $settings['bs_id'];
                    $this->data['categories_tabs'] = $categories_tabs;

                    break;

                default:
                    $this->data['articles'] = $this->getArticles($article_set);
                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set.tpl';
                    } else {
                        $this->template = 'default/template/module/ac_cms_set.tpl';
                    }
                    break;
            }
        }
        $this->document->addScript('catalog/view/javascript/jquery/jcarousellite_1.0.1.pack.js');
        if (!empty($this->data['articles']) || !empty($this->data['categories_tabs'])) {
            $this->render();
        }
    }

    public function tabitem()
    {
        $this->load->model('ac_cms/category');
        $this->load->model('ac_cms/article');
        $this->load->model('ac_cms/set');
        $this->language->load('module/ac_cms_set');
        $this->language->load('ac_cms/article');
        $this->load->model('tool/image');

        $article_set = array();

        if (isset($this->request->get['bc_id']) && isset($this->request->get['bs_id']) && isset($this->request->get['module'])) {
            $article_set = $this->model_ac_cms_set->getArticleSet((int)$this->request->get['bs_id']);
            $this->initArticleset($article_set);
            $this->data['articles'] = $this->getArticles($article_set, $this->request->get['bc_id']);
            $this->data['module'] = $this->request->get['module'];

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/ac_cms_set_tab_catitem.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/module/ac_cms_set_tab_catitem.tpl';
            } else {
                $this->template = 'default/template/module/ac_cms_set_tab_catitem.tpl';
            }
            $this->response->setOutput($this->render());
        }

    }

    private function getArticles($article_set, $in_categories = null)
    {
        //Date formats
        $date_format_short = $this->language->get('date_format_short');
        //$date_format_long = $this->language->get('date_format_long');

        //GET ARTICLES
        $data = array();
        if (!empty($article_set['settings']['set_category']) && !isset($in_categories)) {
            $data['category'] = $article_set['settings']['set_category'];

        } elseif (isset($in_categories)) {

            $data['category'] = $in_categories;

        }

        if (!empty($article_set['settings']['article_related'])) {
            $data['article'] = $article_set['settings']['article_related'];
        }

        //ARTICLES NUMBER
        $data['art_amount'] = $article_set['settings']['art_amount'];


        //SORT ORDER
        $data['sort_order'] = $article_set['settings']['sort_order'];
        if (isset($data['sort_order'])) {
            $data['sort_order'] = ($data['sort_order'] == 0) ? 'ASC' : 'DESC';
        }

        //SORT BY
        if (isset($article_set['settings']['sort_by'])) {
            $data['sort_by'] = $article_set['settings']['sort_by'];
        }

        $data['access_level'] = $this->checkAccess();

        $articles = $this->model_ac_cms_article->getArticles($data);

        $ret_article = array();

        foreach ($articles as $article) {
            //Date Modified
            if (!empty($article['date_modified'])) {
                $date_modified = date($date_format_short, strtotime($article['date_modified']));
            } else {
                $date_modified = false;
            }

            if (!empty($article_set['settings']['max_char_title']) && is_numeric($article_set['settings']['max_char_title'])) {
                $length = strlen($article['title']);
                $dot = ($article_set['settings']['max_char_title'] < $length) ? ' ...' : '';
                $title = trim(utf8_substr(strip_tags(html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8')), 0, (int)$article_set['settings']['max_char_title'])) . $dot;
            } else {
                $title = html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8');
            }

            if (!empty($article_set['settings']['max_char_content'])) {
                $length = strlen($article['intro']);
                $dot = ($article_set['settings']['max_char_content'] < $length) ? ' ...' : '';
                $intro = trim(utf8_substr(strip_tags(html_entity_decode($article['intro'], ENT_QUOTES, 'UTF-8')), 0, (int)$article_set['settings']['max_char_content'])) . $dot;
            } elseif (empty($article_set['settings']['max_char_content']) && isset($article_set['settings']['keep_html_format'])) {
                $intro = html_entity_decode($article['intro'], ENT_QUOTES, 'UTF-8');
            } else {
                $intro = strip_tags(html_entity_decode($article['intro'], ENT_QUOTES, 'UTF-8'));
            }

            //IMAGE

            $thumb2 = '';
            $thumb3 = '';

            if (isset($article['image']) && !empty($article_set['settings']['image_width']) && !empty($article_set['settings']['image_height'])) {
                $thumb = $this->model_tool_image->resize($article['image'], $article_set['settings']['image_width'], $article_set['settings']['image_height']);
            } else {
                $thumb = '';
            }

            if (isset($article['image']) && isset($article_set['display_type'])) {
                if ($article_set['display_type'] == 2) {
                    $thumb2 = $this->model_tool_image->resize($article['image'], 200, 200);
                    $thumb3 = $this->model_tool_image->resize($article['image'], 100, 100);
                }
            }

            //Cats
            $categories = $this->model_ac_cms_article->getArticleCategories($article['b_id']);
            $art_cat = array();
            if (!empty($categories)) {
                foreach ($categories as $id => $value) {
                    $parents = array();
                    $parents = $this->model_ac_cms_category->getCategoryParents($id);
                    $parents[] = (string)$id;
                    $value['href'] = $this->url->link('ac_cms/category', 'ac_path=' . implode('_', $parents));
                    $art_cat[$id] = $value;
                }
            }

            if (($article['com_access_level'] == 1 && !$this->customer->isLogged())) {
                $comment_access = false;
            } else {
                $comment_access = true;
            }

            if (!empty($article['firstname'])) {
                $username = $article['firstname'] . ' ' . $article['lastname'];
            } else {
                $username = $article['username'];
            }

            $ret_article[] = array(
                'username' => $username,
                'date_added' => date($date_format_short, strtotime($article['date_added'])),
                'date_modified' => $date_modified,
                'title' => $title,
                'intro' => $intro,
                'thumb' => $thumb,
                'thumb2' => $thumb2,
                'thumb3' => $thumb3,
                'href' => $this->url->link('ac_cms/article', 'b_id=' . $article['b_id']),
                'categories' => $art_cat,
                'c_count' => count($categories),
                'comment_access' => $comment_access,
                'comments' => $article['comments'],
                'allow_comments' => $article['allow_comments']
            );
        }

        //COUNT ARTICLES IN SET
        $this->data['count'] = count($articles);

        return $ret_article;
    }

    private function getOrder($order, $is_image = false)
    {
        $style = '';
        switch ($order) {
            case 0:
                $style = 0;
                break;

            case 1:
                if ($is_image) {
                    $style = 'float:left';
                } else {
                    $style = 'left;';
                }
                break;

            case 2:
                if ($is_image) {
                    $style = 'float:right';
                } else {
                    $style = 'right;';
                }
                break;

            case 3:
                if ($is_image) {
                    $style = 'text-align:center';
                } else {
                    $style = 'center;';
                }
                break;

            case 4:
                $style = 'justify;';
                break;
        }

        return $style;
    }
}

?>