
-- Create form
CALL `om_CreateForm`('text_and_image', 'text_and_image', 0, 1, 'Text and image');

-- Create form entry
CALL `om_CreateFormEntry`('text_and_image', 'text', 1, 'Omega\\Utils\\Plugin\\Type\\TextRich', '{}', 'Text', '', 0);
CALL `om_CreateFormEntry`('text_and_image', 'picture', 2, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["picture"]}', 'Image', '', 0);
CALL `om_CreateFormEntry`('text_and_image', 'position', 3, 'Omega\\Utils\\Plugin\\Type\\RadioButtons', '{"default": 0,"options": {"0": "Left","1": "Right", "2": "Top", "3": "Bottom"}}', 'Image position', '', 0);
CALL `om_CreateFormEntry`('text_and_image', 'width_percent', 4, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"default": 3,"options": {"3": "25%","4": "33%","5": "42%","6": "50%","8": "66%","9": "75%"}}', 'Image width', 'Width not used if position is top or bottom', 0);
CALL `om_CreateFormEntry`('text_and_image', 'resize', 5, 'Omega\\Library\\Utils\\Type\\CheckBoxes', '{"default": {"resize": false},"options": {"resize": "Yes"}}', 'Resize image', '', 0);
CALL `om_CreateFormEntry`('text_and_image', 'width', 6, 'Omega\\Library\\Utils\\Type\\TextSimple', '{}', 'Width', '', 0);
CALL `om_CreateFormEntry`('text_and_image', 'height', 7, 'Omega\\Library\\Utils\\Type\\TextSimple', '{}', 'Height', '', 0);