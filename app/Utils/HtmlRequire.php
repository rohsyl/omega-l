<?php
namespace Omega\Utils;

class HtmlRequire{

    private static $mainJs = array();
    private static $js = array();
    private static $mainCss = array();
    private static $css = array();


    public function requireMainJs($path)
    {
        self::$mainJs[] = $path;
    }

    public function requireMainCss($path)
    {
        self::$mainCss[] = $path;
    }

    public function requireJs($path)
    {
        self::$js[] = $path;
    }

    public function requireCss($path)
    {
        self::$css[] = $path;
    }

    public function renderJs()
    {
        $js = array_merge(self::$mainJs, self::$js);
        $html = '';
        foreach ($js as $j)
        {
            $html .= '<script language="JavaScript" src="'.$j.'"></script>';
        }
        self::$mainJs = array();
        self::$js = array();
        return $html;
    }

    public function renderCss()
    {
        $css = array_merge(self::$mainCss, self::$css);
        $html = '';
        foreach ($css as $j)
        {
            $html .= '<link href="'.$j.'" rel="stylesheet"/>';
        }
        self::$mainCss = array();
        self::$css = array();
        return $html;
    }

}