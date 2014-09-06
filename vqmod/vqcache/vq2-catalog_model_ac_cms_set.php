<?php

class ModelACcmsSet extends Model
{
    public function getArticlesByAlias($arr_alias)
    {
        $arr_id = array();

        if (is_array($arr_alias) || is_string($arr_alias)) {

            foreach ($arr_alias as $alias) {
                $query = $this->db->query("SELECT  * FROM " `. DB_PREFIX . "url_alias`  WHERE `keyword` = '" .$alias. "'");
                $arr_id[] = $query->row;
            }
            $arr_id =  $arr_alias;
        }
        return $arr_id;
    }
            
    public function getArticleSet($bs_id) 
    {
        $ret_ar = array();
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ac_cms_set s LEFT JOIN " . DB_PREFIX . "ac_cms_set_description sd ON s . bs_id = sd . bs_id WHERE s . bs_id = '" . (int)$bs_id . "' AND sd . language_id = '" . (int)$this->config->get('config_language_id') . "'");
        foreach ($query->rows as $result) {
            $ret_ar['title'] = $result['title'];
            $ret_ar['display_type'] = $result['display_type'];
            $ret_ar['bs_id'] = $result['bs_id'];
            $ret_ar['settings'] = unserialize($result['settings']);
        }
        return $ret_ar;
    } 
}
?>
