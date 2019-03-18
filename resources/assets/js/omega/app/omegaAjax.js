window.$ = window.jQuery = require('jquery');


(function (define) {
    define(['jquery'], function ($) {

        OmegaAjax = function(root){
            this.root = root;
            this.POST = 'post';
            this.GET = 'get';
        };
        OmegaAjax.prototype = {
            //---- Public method ----//
            query: function(url, data, method, onDone, onError, userArgs){
                if (typeof userArgs === 'undefined') { userArgs = {}; }
                if (typeof method === 'undefined') { method = this.GET; }
                var ajaxArgs = {
                    url: url,
                    data: data,
                    method: method,
                };
                var args = $.extend( {}, ajaxArgs, userArgs );
                var jqXhr;
                jqXhr = $.ajax(args);
                jqXhr.done(function(data){
                    if(typeof onDone !== 'undefined'){
                        onDone(data);
                    }
                });
                jqXhr.fail(function(data){
                    if(typeof onError !== 'undefined'){
                        onError(data);
                    }
                    else{
                        console.log(data);
                        omega.notice.error(data.responseJSON.message);
                    }
                });
            },

            loadHtml: function($target, url)
            {
                $target.load(url);
            },

            form: function($target, urlGet, paramGet, urlPost, urlCancelAndEnd, formPostedCallback){
                var _this = this;
                this.query(urlGet, paramGet, 'GET', function(html){
                    var html = '<div id="omega_ajax_form">' + html;
                    html += '<p><input type="button" id="omega_ajax_form_submit" class="btn btn-primary" value="'+__('Save')+'" /> ';
                    html += '<input type="button" id="omega_ajax_form_cancel" class="btn btn-default" value="'+__('Cancel')+'" />';
                    html += '</p></div>';
                    $target.html(html);
                    var inputsContainer = $('#omega_ajax_form');
                    var btnSubmit = $('#omega_ajax_form_submit');
                    var btnCancel = $('#omega_ajax_form_cancel');

                    btnSubmit.click(function(){
                        var formData = _this._serializeInputContainedInDiv(inputsContainer);
                        _this.query(urlPost, formData, 'POST', function(data){
                            formPostedCallback();
                            _this.query(urlCancelAndEnd, {}, 'GET', function(html){
                                $target.html(html);
                            });
                        });
                    });
                    btnCancel.click(function(){
                        _this.query(urlCancelAndEnd, {}, 'GET', function(html){
                            $target.html(html);
                        });
                    });
                });
            },

            getSpinner: function(){
                return '<p class="text-center text-muted"><i class="fa fa-spinner fa-2x fa-spin"></i></p>';
            },

            //---- Private method ----//
            _serializeForm: function($form){
                return $form.serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});
            },

            _serializeInputContainedInDiv: function($div){
                $inputs = $div.find(':input');
                var data = {};
                $.each($inputs, function(){
                    if(this.name.length > 0)
                    data[this.name] = this.value;
                });
                return data;
            }


        };

        return OmegaAjax;

    });

}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    }
}));
