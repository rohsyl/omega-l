<?php

namespace Omega\Utils;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Omega\Facades\Entity;

class OmegaUtils{

    private $dependencies;

    private $htmlRequireHelper;

    public function __construct()
    {
        $this->htmlRequireHelper = new HtmlRequire();
        $this->dependencies = [
            'css' => [],
            'js' => []
        ];
    }

    public function GetCurrentUserAvatar()
    {
        $user = Auth::user();

        return self::GetUserAvatar($user);
    }

    public function GetUserAvatar($user){
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

    public function GetCurrentUserName()
    {
        return Auth::user()->username;
    }

    public function GetCurrentUserFullName()
    {
        return Auth::user()->fullname;
    }

    public function getInstalledPlugin()
    {
        /*$plugins = Dbs::select('plugName')
            ->from('om_plugin')
            ->run()
            ->getAllArray();

        return $plugins;*/
    }

    public function renderMeta()
    {
        return view('public.meta')->with([
            'descr' => om_config('om_seo_description'),
            'keywords' => om_config('om_seo_keyword')
        ]);
    }


    public function isInstalled() {
        return Schema::hasTable('configs');
    }

    public function member_IsInGroup($idMember, $idGroup)
    {
/*
        $count = Dbs::select('count(*) as nbr')
            ->from('om_member_membergroup')
            ->where('fkMember', '=', $idMember)
            ->andwhere('fkMemberGroup', '=', $idGroup)
            ->runScalar('nbr');

        return $count > 0;*/
    }

    public function addDependencies($dep = null) {
        if(isset($dep['css']))
        {
            foreach($dep['css'] as $css)
            {
                if(!in_array ($css , $this->dependencies['css']))
                    $this->dependencies['css'][] = $css;
            }
        }
        if(isset($dep['js']))
        {
            foreach($dep['js'] as $js)
            {
                if(!in_array ($js , $this->dependencies['js']))
                    $this->dependencies['js'][] = $js;
            }
        }

    }

    public function renderDependencies()
    {
        $this->addDependencies([
            'css' => Entity::Page()->getCssTheme()
        ]);

        foreach($this->dependencies['css'] as $css)
        {
            $this->htmlRequireHelper->requireCss($css);
        }
        foreach($this->dependencies['js'] as $js)
        {
            $this->htmlRequireHelper->requireJs($js);
        }

        return
            $this->htmlRequireHelper->renderCss()
            .
            $this->htmlRequireHelper->renderJs();
    }

}