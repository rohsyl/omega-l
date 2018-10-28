
-- Create form
CALL `om_CreateForm`('features', 'features', 0, 1, 'Features');

-- Create form entry
CALL `om_CreateFormEntry`('features', 'title', 1, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Title', '', 0);
CALL `om_CreateFormEntry`('features', 'text', 2, 'Omega\\Utils\\Plugin\\Type\\TextRich', '{}', 'Text', '', 0);
CALL `om_CreateFormEntry`('features', 'image', 3, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["picture"]}', 'Image', '', 0);
CALL `om_CreateFormEntry`('features', 'icon', 4, 'Omega\\Utils\\Plugin\\Type\\IconChooser', '{}', 'Icon', '', 0);
CALL `om_CreateFormEntry`('features', 'radio', 5, 'Omega\\Utils\\Plugin\\Type\\RadioButtons', '{ "default": 0, "options": { "0": "Image", "1": "Icon" } }', 'Use image or icon', '', 0);
CALL `om_CreateFormEntry`('features', 'link', 6, 'Omega\\Utils\\Plugin\\Type\\LinkChooser', '{}', 'Link', '', 0);