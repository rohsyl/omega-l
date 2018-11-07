
-- Create form
CALL `om_CreateForm`('title', 'title', 1, 1, 'Title');

-- Create form entry
CALL `om_CreateFormEntry`('title', 'title', 1, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Title', '', 0);
CALL `om_CreateFormEntry`('title', 'subtitle', 2, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Subtitle', '', 0);
CALL `om_CreateFormEntry`('title', 'level', 3, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"default": 1,"options": {"1": "Title 1", "2": "Title 2", "3": "Title 3", "4": "Title 4", "5": "Title 5", "6": "Title 6"}}', 'Level', 'The level of the title', 0);