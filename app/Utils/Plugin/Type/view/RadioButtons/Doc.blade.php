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
<p>Exemple :</p>
<pre>
&lt;?php
	FormFactory::newFormEntry('[form_name]', '[entry_name]', [order], Omega\Utils\Plugin\Type\RadioButtons::class, [param], '[title]', '[description]', '[mandatory]')
?&gt;
</pre>