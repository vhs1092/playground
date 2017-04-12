<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    private $obj;
    private $layout;
    private $titlepage = '';
    private $titlepage_sub = '';
    private $classpage = '';
    private $page = '';
    private $page_url = '#';
    private $block_list, $block_new, $block_replace = false;
    private $datapage;
    
    function Layout() {
        $this->datapage = array();
        $this->obj =& get_instance();
        if(isset($this->obj->layout_view)) { $this->layout_view = $this->obj->layout_view; }
        
        $this->datapage['headerpage'] = array();
        $this->datapage['classpage'] = $this->classpage;
        $this->datapage['contentpage'] = array();
    }
    
    function view($view, $data = null, $return = false) {        
        $this->block_replace = true;
        $this->datapage['headerpage']['title'] = $this->titlepage;
        $this->datapage['headerpage']['title_sub'] = $this->titlepage_sub;
        $this->datapage['headerpage']['page'] = $this->page;
        $this->datapage['headerpage']['url'] = $this->page_url;
        $this->datapage['contentbody']['classpage'] = $this->classpage;
        $this->datapage['contentbody']['contenido'] = $this->obj->load->view($view, $data, true);
        $output = $this->obj->load->view($this->layout, $this->datapage, $return);
 
        return $output;
    }
    
    function block($name = '') {
        if($name != '') {
            $this->block_new = $name;
            ob_start();
        } else {
            if($this->block_replace) {
                if(!empty($this->block_list[$this->block_new])) {
                    ob_end_clean();
                    echo($this->block_list[$this->block_new]);
                } else {
                    $this->block_list[$this->block_new] = ob_get_clean();
                }
            }
        }
    }
    
    function setLayout($layout) { $this->layout = $layout; }
    function page($page,$url = '#') { $this->page = $page; $this->page_url = $url; }
    function title($title) { $this->titlepage = $title; }
    function title_sub($title_sub) { $this->titlepage_sub = $title_sub; }
    function addCSS($css) { $this->headcss[] = $css; }
    function addJS($js) { $this->headjs[] = $js; }
    function addClassPage($class) { $this->classpage = $class; }
}