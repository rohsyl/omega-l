
-- Create form
CALL `om_CreateForm`('divided_content', 'divided_content', 0, 1, 'Divided Content');

-- Create form entry
CALL `om_CreateFormEntry`('divided_content', 'page', 1, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"model": "OmegaPlugin\\\\DividedContent\\\\Model\\\\DropDownPage"}', 'Page', 'Select the page that contains components you want to insert as divided content. Be carefull, it must be a child of this page.', 0);
CALL `om_CreateFormEntry`('divided_content', 'type', 2, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"model": "OmegaPlugin\\\\DividedContent\\\\Model\\\\DropDownDisplayType"}', 'Type', 'How to divide the content', 0);

