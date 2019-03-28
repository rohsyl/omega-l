<p>Parameters with hardcoded values:
</p>
<pre>
{
	"default": 3,
	"options": {
		"3": "25%",
		"4": "33%",
		"5": "42%",
		"6": "50%",
		"8": "66%",
		"9": "75%"
	}
}
</pre>
<p>Parameters with value from database or from file:
</p>
<pre>
{
	"model" : "OmegaPlugin\\DividedContent\\Model\\DropDownPage"
}
</pre>
<div class="help-block">
    The "model" must extends from "Omega\Utils\Plugin\Type\DropDown\ADropDownModel".
</div>
<p>Model Exemple:
</p>
<pre>
&lt;?php
namespace OmegaPlugin\DividedContent\Model;

use Omega\Utils\Plugin\Type\DropDown\ADropDownModel;

class DropDownPage extends ADropDownModel{

    public  function getKeyValueArray() {
        $pages = Page:all();
        return to_select($pages, 'name', 'id');
    }
}
?&gt;
</pre>
<div class="help-block">
    The getKeyValueArray must return a key/value array with the key is the value of the dropdown item and the value is the title.
</div>
<p>Exemple :</p>
<pre>
&lt;?php
	FormFactory::newFormEntry('[form_name]', '[entry_name]', [order], Omega\Utils\Plugin\Type\DropDown::class, [param], '[title]', '[description]', '[mandatory]')
?&gt;
</pre>