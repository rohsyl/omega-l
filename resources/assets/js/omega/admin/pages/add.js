
$(function() {

    var $selectLang = $('#lang');
    var $pageParent = $('#parent');

    $selectLang.change(function () {
        var langs = $(this).val();
        var url = route('admin.pages.getPagesLevelZeroBylang', {lang: langs});
        omega.ajax.query(url, {}, omega.ajax.GET, function(html){
            $pageParent.empty().html(html);
        });
    })
});