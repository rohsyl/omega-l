<?php

namespace Omega\Utils;


use Illuminate\Support\Facades\Schema;

class OmegaUtils{

    public static function getCurrentUserAvatar()
    {
        /*$user = Dbs::select('userAvatar', 'userFirstName', 'userName')
            ->from('om_user')
            ->where('id', '=', $_SESSION['id'])
            ->run()
            ->getRowArray(0);


        $mediaId = $user['userAvatar'];
        $hasAvatar = isset($mediaId) && !empty($mediaId);

        if ($hasAvatar) {
            $media = new Media($mediaId);
            return '<div class="userAvatarImage" style="background-image: url(\'' . $media->GetThumbnail(150, 150) . '\')"></div>';
        } elseif (!empty($user['userFirstName']) && !empty($user['userName'])) {
            $initial = strtoupper(substr($user['userFirstName'], 0, 1) . substr($user['userName'], 0, 1));
            return '<span class="userAvatarText">' . $initial . '</span>';
        } else {
            return '<span class="userAvatarIcon"><i class="fa fa-user fa-4x"></i></span>';
        }*/
    }

    public static function getCurrentUserName()
    {
        /*$avatar = Dbs::select('userName', 'userFirstname')
            ->from('om_user')
            ->where('id', '=', $_SESSION['id'])
            ->run();

        return $avatar->getString(0, 'userName') . ' ' . $avatar->getString(0, 'userFirstname');*/
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