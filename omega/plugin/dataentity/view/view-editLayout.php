<?php
use Omega\Library\Util\Url;
use function Omega\Library\__;
?>
<script src="<?php echo Url::CombAndAbs(ABSPATH, '/assets/js/ace/ace.js'); ?>"></script>
<script src="<?php echo Url::CombAndAbs(ABSPATH, '/assets/js/ace/ext-language_tools.js'); ?>"></script>


<br />
<ol class="breadcrumb">
    <li><a href="<?php echo $this->getAdminLink('index') ?>"><i class="fa fa-home"></i> Data Entity</a></li>
    <li><a href="<?php echo $this->getAdminLink('layout') ?>"><i class="fa fa-object-group"></i> Layouts</a></li>
    <li><i class="fa fa-pencil"></i> Edit Layout</li>
</ol>

<div>
    <!-- Text input-->
    <div class="form-group">
        <label class="control-label" for="layoutName">Name</label>
        <input id="layoutName" name="layoutName" type="text" placeholder="Name" class="form-control input-md" value="<?php echo $layout->name ?>">
        <span class="help-block">The name of the layout</span>
    </div>

    <label class="control-label" for="layoutCode">View code</label>
    <div id="layoutCode" style="height: 450px;"><?php echo htmlspecialchars($layout->view) ?></div>
    <div class="help-block">Use <code>[Ctrl] + [Space]</code> to show up available variables</div>

    <button class="btn btn-primary" id="btnSaveView"><?php __('Save') ?></button>
</div>




<script>
    var editor = ace.edit("layoutCode");
    var langTools = ace.require("ace/ext/language_tools");
    editor.setTheme("ace/theme/textmate");
    editor.session.setMode("ace/mode/php");
    editor.setOptions({
        enableBasicAutocompletion: true,
        enableLiveAutocompletion: true,
        enableSnippets: false
    });

    var myList = <?php echo $autoComplete ?>;
    var myCompleter = {
        identifierRegexps: [/[^\s]+/],
        getCompletions: function(editor, session, pos, prefix, callback) {
            callback(
                null,
                myList.filter(entry=>{
                    return entry.includes(prefix);
        }).map(entry=>{
                return {
                    value: entry
                };
        })
        );
        }
    };
    langTools.setCompleters([myCompleter]);


    var $btnSaveView = $('#btnSaveView');

    $btnSaveView.click(function(e){
        save();
    });

    $(window).keypress(function(e) {
        var key = undefined;
        var possible = [ e.key, e.keyIdentifier, e.keyCode, e.which ];

        while (key === undefined && possible.length > 0)
        {
            key = possible.pop();
        }

        if (key && (key == '115' || key == '83' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
        {
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
            save();
            return false;
        }
        return true;
    });

    function save(){
        var data = {
            name : $('#layoutName').val(),
            view : editor.getValue()
        };

        if(data.name.length === 0){
            omega.notice.error(undefined, __('Please write a name'));
            return false;
        }

        var url = omega.plugin.mvc.url('dataentity', 'saveLayout',  { id: <?php echo $layout->id ?>});
        omega.ajax.query(url, data, omega.ajax.POST, function(data){
            if(data.result){
                omega.notice.success(undefined, __('Layout updated successfully !'));
            }
            else{
                omega.notice.error(undefined, __('Error while updating Layout...'));
            }
        }, undefined, {dataType: 'json'});
    }
</script>