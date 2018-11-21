<?php

namespace Omega\Http\Controllers\PublicControllers;


use Omega\Http\Controllers\Controller;
use Omega\Utils\Entity\Page;

class LanguageController extends Controller
{
    public function change($target, $referer = null){
        if($referer) {
            $targetPageId = Page::GetCorrespondingInLang($referer, $target);

            if(!isset($targetPageId)){
                return redirect(url('/' . $target));
            }
            if(is_numeric($targetPageId)){
                $targetPageId = Page::GetCorrespondingInLang($referer, $target);


                $url = Page::GetUrl($targetPageId);
            }
            else{
                $url = $referer;
            }

            session(['front_lang' => $target]);
        }
        else{
            $targetPageId = Page::GetHome($target);
            $url = Page::GetUrl($targetPageId);
        }

        return redirect($url);
    }
}
