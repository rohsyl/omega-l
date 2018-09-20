

<div>
    <!-- Text input-->
    <div class="form-group">
        <label class="control-label" for="viewName">Name</label>
        <input id="viewName" name="viewName" type="text" placeholder="Name" class="form-control input-md" value="<?php echo $view->name ?>">
        <span class="help-block">The name of the view</span>
    </div>

    <label class="control-label" for="viewCode">View code</label>
    <div id="viewCode" style="height: 500px;"><?php echo htmlspecialchars($view->view) ?></div>
    <div class="help-block">Use <code>[Ctrl] + [Space]</code> to show up available variables</div>
    <script>
        var editor = ace.edit("viewCode");
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
                console.info("myCompleter prefix:", prefix);
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
    </script>
</div>

