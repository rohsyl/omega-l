<?php

namespace Omega\Utils;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class OmegaUtils{

    public static function GetCurrentUserAvatar()
    {
        $user = Auth::user();

        return self::GetUserAvatar($user);
    }

    public static function GetUserAvatar($user){
        $mediaId = $user->avatar;
        $hasAvatar = isset($mediaId) && !empty($mediaId);

        if ($hasAvatar) {
            //$media = new Media($mediaId);
            return '<div class="userAvatarImage" style="background-image: url()"></div>';
        } elseif (!empty($user->fullname)) {
            $initial = strtoupper(substr($user->fullname, 0, 1));
            return '<span class="userAvatarText">' . $initial . '</span>';
        } else {
            return '<span class="userAvatarIcon"><i class="fa fa-user fa-4x"></i></span>';
        }
    }

    public static function GetCurrentUserName()
    {
        return Auth::user()->username;
    }

    public static function GetCurrentUserFullName()
    {
        return Auth::user()->fullname;
    }

    public static function getInstalledPlugin()
    {
        /*$plugins = Dbs::select('plugName')
            ->from('om_plugin')
            ->run()
            ->getAllArray();

        return $plugins;*/
    }

    public static function renderMeta()
    {
        /*
        echo '<meta name="description" content="' . Config::get('om_seo_description') . '">
        <meta name="keywords" content="' . Config::get('om_seo_keyword') . '">';*/
    }


    public static function isInstalled()
    {
        return Schema::hasTable('configs');
    }

    public static function member_IsInGroup($idMember, $idGroup)
    {
/*
        $count = Dbs::select('count(*) as nbr')
            ->from('om_member_membergroup')
            ->where('fkMember', '=', $idMember)
            ->andwhere('fkMemberGroup', '=', $idGroup)
            ->runScalar('nbr');

        return $count > 0;*/
    }

    public static function addDependencies($dep)
    {
        /*global $dependencies;
        if(isset($dep['css']))
        {
            foreach($dep['css'] as $css)
            {
                if(!in_array ($css , $dependencies['css']))
                    $dependencies['css'][] = $css;
            }
        }
        if(isset($dep['js']))
        {
            foreach($dep['js'] as $js)
            {
                if(!in_array ($js , $dependencies['js']))
                    $dependencies['js'][] = $js;
            }
        }*/
    }

    public static function renderDependencies()
    {
        /*global $dependencies;

        $htmlHelper = new Html();

        foreach($dependencies['css'] as $css)
        {
            $htmlHelper->requireCss($css);
        }
        foreach($dependencies['js'] as $js)
        {
            $htmlHelper->requireJs($js);
        }

        $htmlHelper->renderCss();
        $htmlHelper->renderJs();*/
    }

}