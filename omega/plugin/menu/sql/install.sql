
-- Create form
CALL `om_CreateForm`('menu', 'menu', 1, 0, 'Menu');

-- Create form entry
CALL `om_CreateFormEntry`('menu', 'menu', 1, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"model": "OmegaPlugin\\\\DividedContent\\\\Model\\\\DropDownPage"}', 'Page', 'Select the page that contains components you want to insert as divided content. Be carefull, it must be a child of this page.', 0);
CALL `om_CreateFormEntry`('menu', 'class_ul', 2, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Class ul', 'The css class that will be added on the ul tag', 0);
CALL `om_CreateFormEntry`('menu', 'class_li', 3, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Class li', 'The css class that will be added on each li tag', 0);

