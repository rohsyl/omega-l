<p>Parameters:
</p>
<pre>
{
	"type": "info|warning|danger|success",
	"text": "The text message you want to show up! It can contain html tags."
}
</pre>
<p>Exemple :</p>
<pre>
&lt;?php
	FormFactory::newFormEntry('[form_name]', '[entry_name]', [order], Omega\Utils\Plugin\Type\Alert::class, [param], '[title]', '[description]', '[mandatory]')
?&gt;
</pre>