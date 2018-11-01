(function (define) {
    define(['jquery'], function ($) {

        OmegaHtml = function (root){
            this.root = root;
        };
        OmegaHtml.prototype = {
            linkChooser: function(selector, param){
                return new LinkChooser(selector, param);
            }
        };

        var linkChooserInstanceNbr = 0;
        function LinkChooser(selector, param){

            // jQuery selector to the input
            this.selector = selector;

            // User parameters
            if(typeof param === undefined)
                this.param = {};
            else
                this.param = param;

            // Default parameters
            this.default = {
                target : '_self'
            };

            // The input
            this.input = undefined;
            this.hiddenInput = undefined;
            this.button = undefined;

            this.data = {};

            // Start initialization
            this.__init();
        }
        LinkChooser.prototype = {
            // Public

            // Private
            __init: function(){
                linkChooserInstanceNbr++;
                this.input = $(this.selector);
                this.param = $.extend({}, this.default, this.param);

                this.__initHtml();
                this.__initEvent();
                this.__initValue();

                console.log('LinkChooser init : ok');
            },

            __initHtml: function(){
                var divInputGroup = $('<div class="input-group"></div>').attr('id', this.__getId('input-group'));
                var spanInputGroupBtn = $('<span class="input-group-btn"></span>').attr('id', this.__getId('input-group-btn'));
                var btn = $('<button class="btn btn-default" type="button"><i class="fa fa-link"></i></button>').attr('id', this.__getId('button'));

                this.input.wrap(divInputGroup);

                var $divInputGroup = $('#'+this.__getId('input-group'));
                $divInputGroup.prepend(spanInputGroupBtn);

                var $spanInputGroupBtn = $('#'+this.__getId('input-group-btn'));
                $spanInputGroupBtn.append(btn);

                this.button = $('#'+this.__getId('button'));

                this.hiddenInput = this.input.clone().attr('type', 'hidden');
                this.hiddenInput.insertAfter(this.input);
                this.input.attr('id', this.__getId('input')).removeAttr('name').prop('readonly', true);

            },

            __initEvent: function(){
                // Initialize button click event
                var _this = this;
                this.button.click(function(e){
                    _this.__onClickEvent(e);
                })
            },

            __initValue: function(){
                var rawValue = decodeURIComponent(this.hiddenInput.val());

                if(this.__isJSON(rawValue)){
                    this.data = $.parseJSON(rawValue);
                }
                else{
                    this.data = {
                        target: this.param.target,
                        type: 'external',
                        link: rawValue,
                        text: 'External:"'+rawValue+'"'
                    };
                }

                console.log(this.data);
                this.__updateInputFromData();
            },

            __updateInputFromData: function(){
                this.hiddenInput.val(encodeURIComponent(JSON.stringify(this.data)));
                this.input.val(this.data.text);
            },

            __onClickEvent: function(e){
                var _this = this;
                console.log('btn clicked');

                var url = route('linkchooser.form');
                omega.ajax.query(url, {}, omega.ajax.GET, function(html){
                    var mid = omega.modal.open('Choose link', html, 'Ok', function(){
                        _this.data = $.parseJSON(decodeURIComponent($('.linkchooser-input').val()));
                        _this.__updateInputFromData();
                        omega.modal.hide(mid);
                    });
                });
            },

            __getId: function(name){
                return 'linkchooser-'+linkChooserInstanceNbr+'-'+name;
            },

            __isJSON: function(data){
                var ret = true;
                try {
                    JSON.parse(data);
                }catch(e) {
                    ret = false;
                }
                return ret;
            }
        };

        return OmegaHtml;
    });


}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    }
}));
