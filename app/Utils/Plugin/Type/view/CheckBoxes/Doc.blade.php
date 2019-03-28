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
	"model" : "OmegaPlugin\\News\\Model\\CheckBoxesCategoriesModel"
}
</pre>
<p>Model must extends from Omega\Utils\Plugin\Type\CheckBoxes\ACheckBoxesModel</p>
<p>Exemple :</p>
<pre>
&lt;?php
	FormFactory::newFormEntry('[form_name]', '[entry_name]', [order], Omega\Utils\Plugin\Type\CheckBoxes::class, [param], '[title]', '[description]', '[mandatory]')
?&gt;
</pre>