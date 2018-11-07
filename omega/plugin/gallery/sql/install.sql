
-- Create form
CALL `om_CreateForm`('gallery', 'gallery', 0, 1, 'Gallery');

-- Create form entry
CALL `om_CreateFormEntry`('gallery', 'display', 1, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"default": 1,"options": {"1": "Wall","2": "Slider"}}', 'Display', 'Videos are not displayed in slider mode', 0);
CALL `om_CreateFormEntry`('gallery', 'medias', 2, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{"multiple" : true, "preview": true, "type": ["picture", "video_ext", "folder"]}', 'Medias', '', 0);
