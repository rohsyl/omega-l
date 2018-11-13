<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Omega\Http\Requests\Settings\Flang\CreateFlangRequest;
use Omega\Http\Requests\Settings\Flang\UpdateFlangRequest;
use Omega\Http\Requests\Settings\FlangSettingsRequest;
use Omega\Http\Requests\Settings\GeneralSettingsRequest;
use Omega\Http\Requests\Settings\MemberSettingsRequest;
use Omega\Http\Requests\Settings\SeoSettingsRequest;
use Omega\Http\Requests\Settings\SmtpSettingsRequest;
use Omega\Repositories\LangRepository;
use Omega\Utils\Crypto;
use Omega\Utils\Language\BackLangManager;

class SettingsController extends AdminController
{
    private $langRepository;

    public function __construct(LangRepository $langRepository) {
        parent::__construct();
        $this->langRepository = $langRepository;
    }

    #region general
    public function index(){

        return view('settings.index')
            ->with('generalConfig', [
                'om_site_title' => om_config('om_site_title'),
                'om_site_slogan' => om_config('om_site_slogan'),
                'om_home_page_id' => om_config('om_home_page_id'),
                'om_lang' => om_config('om_lang'),
                'om_web_adress' => om_config('om_web_adress'),
            ])
            ->with('backLanguages', BackLangManager::getAllLang())
            ->with('currentBackLanguage', BackLangManager::getCurrentLang());
    }

    public function saveGeneral(GeneralSettingsRequest $request) {

        om_config(['om_site_title' => $request->input('title')]);
        om_config(['om_site_slogan' => $request->input('slogan')]);
        om_config(['om_home_page_id' => $request->input('home')]);
        om_config(['om_lang' => $request->input('lang')]);
        om_config(['om_web_adress' => $request->input('web_adress')]);

        toast()->success('General settings saved !');
        return redirect(route('admin.settings'));
    }
    #endregion

    #region lang
    public function flang() {
        return view('settings.flang')
            ->with('defaultFrontLanguage', om_config('om_default_front_langauge'))
            ->with('enableFrontLanguage', om_config('om_enable_front_langauge'))
            ->with('fallLang', to_select($this->langRepository->allEnabled(), 'name', 'slug'))
            ->with('langftable', '');
    }

    public function saveFlang(FlangSettingsRequest $request) {

        om_config(['om_enable_front_langauge' => $request->input('flang_enable')]);
        om_config(['om_default_front_langauge' => $request->input('flang_default')]);

        toast()->success('Front-end language settings saved !');
        return redirect(route('admin.settings.flang'));
    }
    #endregion

    #region seo
    public function seo() {
        return view('settings.seo')
            ->with('om_seo_keyword', om_config('om_seo_keyword'))
            ->with('om_seo_description', om_config('om_seo_description'));
    }

    public function saveSeo(SeoSettingsRequest $request) {

        om_config(['om_seo_keyword' => $request->input('keywords')]);
        om_config(['om_seo_description' => $request->input('description')]);

        toast()->success('Seo settings saved !');
        return redirect(route('admin.settings.seo'));
    }
    #endregion

    /*
    #region smtp
    public function smtp() {
        $cryptedPassword = om_config('smtpAuthPasswd');
        $key = sha1(om_config('smtpAuthUser') . SALT);
        $decriptedPassword = Crypto::Decrypt($cryptedPassword, $key);
        $starPassword = '';
        for($i = 0; $i < strlen($decriptedPassword); $i++)
        {
            $starPassword .= '*';
        }
        return view('settings.smtp')
            ->with('smtp', 	[
                'smtpHost' => om_config('smtpHost'),
                'smtpPort' => om_config('smtpPort'),
                'smtpAuthUser' => om_config('smtpAuthUser'),
                'smtpAuthPasswd' => $starPassword,
                'smtpIsSsl' => om_config('smtpIsSsl')
            ]);
    }

    public function saveSmtp(SmtpSettingsRequest $request) {
        $username = $request->input('smtpAuthUser');
        $purPassword = $request->input('smtpAuthPasswd');

        $cryptedPassword = om_config('smtpAuthPasswd');
        $key = sha1($username . SALT);
        $decriptedPassword = Crypto::Decrypt($cryptedPassword, $key);



        $starPassword = '';
        for($i = 0; $i < strlen($decriptedPassword); $i++) {
            $starPassword .= '*';
        }

        if(strlen($purPassword) == 0) {
            $encryptedPassword = '';
        }
        elseif($purPassword == $starPassword) {
            $encryptedPassword = $cryptedPassword;
        }
        else {
            $encryptedPassword = Crypto::Encrypt($purPassword, $key);
        }

        om_config(['smtpHost' => $request->input('smtpHost')]);
        om_config(['smtpPort' => $request->input('smtpPort')]);
        om_config(['smtpAuthUser' => $username]);
        om_config(['smtpAuthPasswd' => $encryptedPassword]);
        om_config(['smtpIsSsl' => $request->input('smtpIsSsl')]);

        toast()->success('SMTP settings saved !');
        return redirect(route('admin.settings.smtp'));
    }
    #endregion
    */

    #region member
    public function member() {
        return view('settings.member')
            ->with('member', [
                'acceptTermsEnabled' => om_config('om_member_enable_checkbox_conditions'),
                'conditions' => om_config('om_member_file_conditions'),
            ]);
    }

    public function saveMember(MemberSettingsRequest $request) {
        om_config(['om_member_enable_checkbox_conditions' => $request->input('acceptTermsEnabled')]);
        om_config(['om_member_file_conditions' => $request->input('fileConditions')]);

        toast()->success('Member settings saved !');
        return redirect(route('admin.settings.member'));
    }
    #endregion

    #region advanced
    public function advanced() {
        return view('settings.advanced');
    }

    public function clearCache(){
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');

        toast()->success('Cache cleared !');
        return redirect()->back();
    }
    #endregion

    public function langftable(){
        return view('settings.flangtable')
            ->with('fallLang', $this->langRepository->all());
    }

    public function langfadd(){
        return view('settings.flangadd');
    }

    public function langfcreate(CreateFlangRequest $request){
        $this->langRepository->create($request->all());

        return response()->json([
            'success' => true
        ]);
    }

    public function langfedit($slug){
        $lang = $this->langRepository->getBySlug($slug);

        return view('settings.flangedit')
            ->with('lang', $lang);
    }

    public function langfupdate(UpdateFlangRequest $request, $slug){
        $lang = $this->langRepository->getBySlug($slug);

        $this->langRepository->update($lang, $request->all());

        return response()->json([
            'success' => true
        ]);
    }

    public function langfdelete($slug){
        $this->langRepository->delete($slug);

        return response()->json([
            'success' => true
        ]);
    }

}
