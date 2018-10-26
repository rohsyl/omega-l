<p>Parameters:
</p>
<pre>
{
    "default" : 1,
    "options" : {
        "0" : "Left",
        "1" : "Right",
        "2" : "Top",
        "3" :"Bottom"
    }
}
</pre>
<p>Exemple of SQL insert with RadioButtons type:</p>
<pre>
CALL `om_CreateFormEntry`('[form_name]', '[field_name]', 1, 'Omega\\Library\\Plugin\\Type\\RadioButtons', '[param]', '[field_title]', '[field_description]', 0);
</pre>