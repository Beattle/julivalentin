<?php

class ControllerCommonHeader extends Controller
{
    protected function index()
    {

        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
        //Comment engine
        if (isset($global_settings['comment_engine'])) {
            $this->data['comment_engine'] = $global_settings['comment_engine'];
        } else {
            $this->data['comment_engine'] = 0;
        }

        //Facebook ID
        if (isset($global_settings['facebook_admins'])) {
            $this->data['facebook_admins'] = $global_settings['facebook_admins'];
        } else {
            $this->data['facebook_admins'] = false;
        }


        $this->data['title'] = $this->document->getTitle();

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

        $this->data['base'] = $server;
        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        $this->data['name'] = $this->config->get('config_name');

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }

        $this->language->load('common/header');

        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_welcome'] = '<a href="javascript:void(0);" onclick="simple_login_open();return false;" class="top-icons login"></a>';
        $this->data['text_logged'] = $this->customer->getFirstName();
        $this->data['text_account'] = $this->language->get('text_account');
        $this->data['text_checkout'] = $this->language->get('text_checkout');

        $this->data['home'] = $this->url->link('common/home');
        $this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['account'] = $this->url->link('account/account', '', 'SSL');
        $this->data['shopping_cart'] = $this->url->link('checkout/cart');
        $this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

        // Daniel's robot detector
        $status = true;

        if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $robots = explode("\n", trim($this->config->get('config_robots')));

            foreach ($robots as $robot) {
                if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
                    $status = false;

                    break;
                }
            }
        }

        // A dirty hack to try to set a cookie for the multi-store feature
        $this->load->model('setting/store');

        $this->data['stores'] = array();

        if ($this->config->get('config_shared') && $status) {
            $this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();

            $stores = $this->model_setting_store->getStores();

            foreach ($stores as $store) {
                $this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
            }
        }

        // Search
        if (isset($this->request->get['search'])) {
            $this->data['search'] = $this->request->get['search'];
        } else {
            $this->data['search'] = '';
        }

        // Menu
        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            if ($category['top']) {
                // Level 2
                $children_data = array();

                $children = $this->model_catalog_category->getCategories($category['category_id']);

                foreach ($children as $child) {
                    $data = array(
                        'filter_category_id' => $child['category_id'],
                        'filter_sub_category' => true
                    );

                    $product_total = $this->model_catalog_product->getTotalProducts($data);

                    $children_data[] = array(
                        'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                }

                // Level 1
                $this->data['categories'][] = array(
                    'name' => $category['name'],
                    'children' => $children_data,
                    'column' => $category['column'] ? $category['column'] : 1,
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
        }

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        $this->load->model('ac_cms/article');
        $this->load->model('ac_cms/category');

        $this->data['ac_cms_menu'] = array();

        if ($this->config->get('ac_cms_menu')) {
            $ac_cms_menu_items = $this->config->get('ac_cms_menu');
        }

        if (isset($ac_cms_menu_items) && is_array($ac_cms_menu_items)) {
            foreach ($ac_cms_menu_items as $ac_cms_menu_item) {

                if ($ac_cms_menu_item['status'] == 1) {
                    if (in_array($ac_cms_menu_item['sort_order'], $this->sort_ord_temp2) || $ac_cms_menu_item['sort_order'] == '') {
                        $sort = $this->get_sortNum(0);
                    } else {
                        $sort = $ac_cms_menu_item['sort_order'];
                    }

                    $this->sort_ord_temp2[] = $sort;

                    if ($ac_cms_menu_item['b_id'] == 0 && $ac_cms_menu_item['bc_id'] == 0) {
                        $global_settings = $this->config->get('ac_cms_gs_' . (int)$this->config->get('config_store_id'));
                        $lang_id = $this->config->get('config_language_id');
                        $this->data['ac_cms_menu'][$sort] = array(
                            'name' => $global_settings['desc'][$lang_id]['blog_name'],
                            'children' => array(),
                            'href' => $this->url->link('ac_cms/blog')
                        );
                    } elseif ($ac_cms_menu_item['b_id'] == 0) {
                        $limit = (isset($ac_cms_menu_item['limit'])) ? $ac_cms_menu_item['limit'] : false;
                        $articles_a = array();

                        if ($limit !== '0') {
                            $data = array(
                                'category' => $ac_cms_menu_item['bc_id'],
                                'sort_order' => 'ASC',
                                'sort_by' => '3',
                                'art_amount' => $limit
                            );

                            if ($this->customer->isLogged()) {
                                $data['access_level'] = 1;
                            } else {
                                $data['access_level'] = 0;
                            }

                            $articles_a = $this->model_ac_cms_article->getArticles($data);
                        }
                        $chd = array();
                        if (!empty($articles_a)) {
                            foreach ($articles_a as $value) {
                                $chd[] = array(
                                    'name' => $value['title'],
                                    'href' => $this->url->link('ac_cms/article', 'ac_path=' . $ac_cms_menu_item['bc_id'] . '&b_id=' . $value['b_id'])
                                );
                            }
                        }
                        $cat_name = $this->model_ac_cms_category->getCategoryNameById($ac_cms_menu_item['bc_id']);
                        if (!empty($cat_name)) {
                            $this->data['ac_cms_menu'][$sort] = array(
                                'name' => $cat_name,
                                'children' => $chd,
                                'column' => (!empty($ac_cms_menu_item['column'])) ? $ac_cms_menu_item['column'] : 1,
                                'href' => $this->url->link('ac_cms/category', 'ac_path=' . $ac_cms_menu_item['bc_id'])
                            );
                        }

                    } else {
                        $article = $this->model_ac_cms_article->getArticle($ac_cms_menu_item['b_id'], ($this->customer->isLogged()) ? 1 : 0);
                        if (!empty($article)) {
                            $this->data['ac_cms_menu'][$sort] = array(
                                'name' => $article['title'],
                                'children' => array(),
                                'href' => $this->url->link('ac_cms/article', 'ac_path=' . $ac_cms_menu_item['bc_id'] . '&b_id=' . $ac_cms_menu_item['b_id'])
                            );
                        }
                    }
                }
            }
        }

        $combined = array();
        rsort($this->sort_ord_temp2);
        $last_sort = (isset($this->sort_ord_temp2[0])) ? (int)$this->sort_ord_temp2[0] : 0;
        $summ = count($this->data['categories']) + count($this->data['ac_cms_menu']) + $last_sort;

        for ($x = 0; $x <= $summ; $x++) {
            if ((isset($this->data['ac_cms_menu'][$x]))) {
                $combined[$x] = $this->data['ac_cms_menu'][$x];
                $this->sort_ord_temp2[] = $x;
            }

            if (isset($this->data['categories'][$x])) {
                $nx = $this->get_sortNum($x);
                $combined[$nx] = $this->data['categories'][$x];
                $this->sort_ord_temp2[] = $nx;
            }
        }

        ksort($combined);
        $this->data['categories'] = $combined;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header.tpl';
        } else {
            $this->template = 'default/template/common/header.tpl';
        }

        $this->render();
    }

    private $sort_ord_temp2 = array();
    private $sort_free = 0;

    private function get_sortNum($num)
    {
        if (in_array($num, $this->sort_ord_temp2)) {
            $this->get_sortNum($num + 1);
        } else {
            $this->sort_free = $num;
        }

        return $this->sort_free;
    }

}

?>
