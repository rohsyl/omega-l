<?php
namespace Omega\Utils\Language;


class BackLangManager {

    public static function getCurrentLang()
    {
        $lang = om_config('om_lang');
        return new BackLang($lang);
    }

    public static function getSessionLang(){
        if(session()->has('admin.lang')){
            return new BackLang(session('admin.lang'));
        }
        else{
            return self::getCurrentLang();
        }
    }

    public static function getLang($twoLetterId)
    {
        return new BackLang($twoLetterId);
    }

    public static function getAllLang() {

        return array(
            'en' => new BackLang('en'),
            'fr' => new BackLang('fr'),
            'de' => new BackLang('de')
        );
    }

    public static function getAllLangAsString(){
        return 'en,fr,de';
    }
}