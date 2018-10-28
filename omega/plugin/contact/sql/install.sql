CALL `om_CreateForm`('contact', 'contact', 1, 1, 'Contact');
CALL `om_CreateFormEntry`('contact', 'view', 1, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{ "default": 1, "options": { "1": "Form", "2": "Informations" } }', 'View', 'What to display', 0);

