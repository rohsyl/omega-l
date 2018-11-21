
@if(isset($page))
    <script>

        /*
        Browser Language Redirect script- By JavaScript Kit
        For this and over 400+ free scripts, visit http://www.javascriptkit.com
        This notice must stay intact
        */

        //Enter ISO 639-2 letter Language codes to detect (see: http://www.w3.org/WAI/ER/IG/ert/iso639.htm):
        var languages = {!! json_encode($matches) !!};
        var gotodefault = true;
        var sessionLang = '{{ $sessionLang }}';


        var languageinfo = navigator.language ? navigator.language : navigator.userLanguage;

        function redirectpage(dest){
            if (window.location.replace)
                window.location.replace(dest);
            else
                window.location=dest
        }

        if(sessionLang != null) {
            if(languages[sessionLang] != null){
                redirectpage(languages[sessionLang]);
                gotodefault = false;
            }
        }
        else {
            for(lang in languages){
                if (languageinfo.substr(0,2) === lang) {
                    if(languages[lang] != null){
                        redirectpage(languages[lang]);
                        gotodefault = false;
                        break;
                    }
                }
            }
        }

        if (gotodefault)
            redirectpage('{{ $defaultUrl }}');
    </script>
@else
    <div class="alert alert-info">
        {{ __('No page selected...') }}
    </div>
@endif