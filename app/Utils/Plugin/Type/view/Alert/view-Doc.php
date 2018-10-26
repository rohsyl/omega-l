<p>Parameters:
</p>
<pre>
{
	"type": "info|warning|danger|success",
	"text": "The text message you want to show up! It can contain html tags."
}
</pre>
<p>Exemple of SQL insert with Alert type:</p>
<pre>
CALL `om_CreateFormEntry`('[form_name]', '[field_name]', 1, 'Omega\\Library\\Plugin\\Type\\Alert', '[param]', '[field_title]', '[field_description]', 0);
</pre>