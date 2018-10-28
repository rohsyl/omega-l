<p>Parameters with hardcoded values:
</p>
<pre>
{
	"default": {
		"opt1": true,
		"opt2": false
	},
	"options": {
		"opt1": "Option 1",
		"opt2": "Option 2"
	}
}
</pre>
<p>Parameters with model:
</p>
<pre>
{
"model" : "Omega\\\\Plugin\\\\News\\\\Model\\\\CheckBoxesCategoriesModel"
}
</pre>
<p>Model must extends from Omega\Library\Plugin\Type\CheckBoxes\ACheckBoxesModel</p>
<div class="alert alert-warning">
    <strong>Be careful !</strong> When JSON inserted via SQL Query, must add 4 "\" !!
</div>
<p>Exemple of SQL insert with CheckBoxes type:</p>
<pre>
CALL `om_CreateFormEntry`('[form_name]', '[field_name]', 1, 'Omega\\Library\\Plugin\\Type\\CheckBoxes', '[param]', '[field_title]', '[field_description]', 0);
</pre>