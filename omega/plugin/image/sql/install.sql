
-- Create form
CALL `om_CreateForm`('image', 'image', 1, 1, 'Image');

-- Create form entry
CALL `om_CreateFormEntry`('image', 'picture', 1, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["picture"]}', 'Picture', '', 0);
CALL `om_CreateFormEntry`('image', 'parallax', 2, 'Omega\\Library\\Plugin\\Type\\CheckBoxes', '{"default": {"parallax": false},"options": {"parallax": "Yes"}}', 'Enable Parallax', 'The HTML element that contains this component must have a transparent background to allow this option to work', 0);
CALL `om_CreateFormEntry`('image', 'parallax_height', 3, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Parallax height', 'Height in px', 0);
