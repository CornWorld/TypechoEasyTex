<?php

use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\Widget\Helper\Form\Element\Text;
use Widget\Options;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * TypechoEasyTex
 *
 * @package TypechoEasyTex
 * @author CornWorld
 * @version 0.1
 * @link https://cornworld.com/TypechoEasyTex
 */
class TypechoEasyTex_Plugin implements Typecho_Plugin_Interface
{
    public static function activate() {
        Typecho_Plugin::factory('Widget_Archive')->header = array(__CLASS__, 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer_page');
       	
	/*
	// TODO: Add adaption to hyperDown.js
	Typecho_Plugin::factory('admin/write-post.php')->content = array(__CLASS__, 'header');
        Typecho_Plugin::factory('admin/write-post.php')->bottom = array(__CLASS__, 'footer_admin');
        Typecho_Plugin::factory('admin/write-page.php')->content = array(__CLASS__, 'header');
        Typecho_Plugin::factory('admin/write-page.php')->bottom = array(__CLASS__, 'footer_admin');
    	*/
    }
    public static function deactivate() {}

    public static function config(Typecho_Widget_Helper_Form $form) {
        $url=new Typecho_Widget_Helper_Form_Element_Text('url',
		NULL, 'pluginUrl', _t('Url'));
		$form->addInput($url);
    }
    
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

    public static function header() {
        $dir=Helper::options()->plugin('TypechoEasyTex')->url;
        if(empty($dir) || $dir=='pluginUrl') $dir=Helper::options()->pluginUrl.'/TypechoEasyTex';
        echo <<<HTML
        <link href="{$dir}/katex/katex.min.css" rel="stylesheet">
        <link href="{$dir}/katex/contrib/copy-tex.min.css" rel="stylesheet">
        <style>.ketex{ font-size: 1.1em; text-indent: 0; text-rendering:0; }</style>
        HTML;
    }
    
    public static function footer_admin() {
        $dir=Helper::options()->plugin('TypechoEasyTex')->url;
        self::footer_common($dir,"document.getElementById('wmd-preview')");
    }
    
    public static function footer_page() {
        $dir=Helper::options()->plugin('TypechoEasyTex')->url;
        self::footer_common($dir,"document.getElementsByClassName('post-content')[0]");
    }

    public static function footer_common($dir, $selectElement) {
        if(empty($dir) || $dir=='pluginUrl') $dir=Helper::options()->pluginUrl.'/TypechoEasyTex';
        echo <<<HTML
        <script defer src="{$dir}/katex/katex.min.js"></script>
        <script src="{$dir}/katex/contrib/copy-tex.min.js"></script>
        <script defer src="{$dir}/katex/contrib/auto-render.min.js" onload="renderMathInElement(
            {$selectElement},{
                delimiters: [ {left: '$$', right: '$$', display: true}, {left: '$', right: '$', display: false} ],
                macros: { '\\ge': '\\geqslant','\\le': '\\leqslant','\\geq': '\\geqslant','\\leq': '\\leqslant'}
            }
        );"></script>
        HTML;
    }


}
