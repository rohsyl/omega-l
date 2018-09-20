
-- Create form
CALL `om_CreateForm`('dividedcontent', 'dividedcontent', 0, 1, 'Divided Content');

-- Create form entry
CALL `om_CreateFormEntry`('dividedcontent', 'page', 1, 'Omega\\Library\\Plugin\\Type\\DropDown', '{"model": "Omega\\\\Plugin\\\\DividedContent\\\\Model\\\\DropDownPage"}', 'Page', 'Select the page that contains components you want to insert as divided content', 0);
CALL `om_CreateFormEntry`('dividedcontent', 'type', 2, 'Omega\\Library\\Plugin\\Type\\DropDown', '{"default": 1, "options": { "1": "2 Columns", "2": "3 Columns", "3": "4 Columns", "4": "Tabs", "5": "Collapse" } }', 'Type', 'How to divide the content', 0);


/*

{
	"default": 1,
	"options": {
		"1": "2 Columns",
		"2": "3 Columns",
		"3": "4 Columns",
		"4": "Tabs",
		"5": "Collapse"
	}
}

 */