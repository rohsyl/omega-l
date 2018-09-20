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
	"model" : "Omega\\\\Plugin\\\\DividedContent\\\\Model\\\\DropDownPage"
}
</pre>
<div class="alert alert-warning">
    <strong>Be careful !</strong> When JSON inserted via SQL Query, must add 4 "\" !!
</div>
<div class="help-block">
    The "model" must extends from "Omega\Library\Plugin\Type\DropDown\ADropDownModel".
</div>
<p>Model Exemple:
</p>
<pre>
namespace Omega\Plugin\DividedContent\Model;

use Omega\Library\Plugin\Type\DropDown\ADropDownModel;
use Omega\Library\Database\Dbs;
use function Omega\Library\__;

class DropDownPage extends ADropDownModel{

    public  function getKeyValueArray() {
        $stmt  = Dbs::select('id', 'pageName')
            ->from('om_page')
            ->where('fkPageParent', '=', $this->getEntry()->getIdPage())
            ->run();

        $keyvalue = array();
        $keyvalue['null'] = __('Choose a page');
        if($stmt->length() > 0){
            foreach($stmt->getAllArray() as $row){
                $keyvalue[$row['id']] = $row['pageName'];
            }
        }
        return $keyvalue;
    }
}
</pre>
<div class="help-block">
    The getKeyValueArray must return a key/value array with the key is the value of the dropdown item and the value is the title.
</div>
<p>Exemple of SQL insert with DropDown type:</p>
<pre>
CALL `om_CreateFormEntry`('[form_name]', '[field_name]', 1, 'Omega\\Library\\Plugin\\Type\\DropDown', '[param]', '[field_title]', '[field_description]', 0);
</pre>