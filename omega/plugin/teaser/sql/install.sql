
-- Create form
CALL `om_CreateForm`('teaser', 'teaser', 1, 1, 'Teaser');

-- Create form entry
CALL `om_CreateFormEntry`('teaser', 'title', 1, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Title', '', 0);
CALL `om_CreateFormEntry`('teaser', 'text', 2, 'Omega\\Utils\\Plugin\\Type\\TextRich', '{}', 'Text', '', 0);
CALL `om_CreateFormEntry`('teaser', 'image', 3, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{ "multiple":false, "preview":true, "type":[ "picture" ] }', 'Image', '', 0);
CALL `om_CreateFormEntry`('teaser', 'link', 4, 'Omega\\Utils\\Plugin\\Type\\LinkChooser', '{}', 'Link', '', 0);
