
-- Create form
CALL `om_CreateForm`('video', 'video', 1, 1, 'Video');

-- Create form entry
CALL `om_CreateFormEntry`('video', 'video', 1, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["video_ext"]}', 'Video', '', 0);