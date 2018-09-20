
-- Create form
CALL `om_CreateForm`('teaser', 'teaser', 1, 1, 'Teaser');

-- Create form entry
CALL `om_CreateFormEntry`('teaser', 'text', 1, 'Omega\\Library\\Plugin\\Type\\TextRich', '{}', 'Text', '', 0);
CALL `om_CreateFormEntry`('teaser', 'image', 2, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '{ "multiple":false, "preview":true, "type":[ "picture" ] }', 'Image', '', 0);
CALL `om_CreateFormEntry`('teaser', 'link', 3, 'Omega\\Library\\Plugin\\Type\\LinkChooser', '{}', 'Link', '', 0);
