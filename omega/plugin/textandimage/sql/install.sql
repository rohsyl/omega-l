
-- Create form
CALL `om_CreateForm`('textandimage', 'textandimage', 0, 1, 'Text and image');

-- Create form entry
CALL `om_CreateFormEntry`('textandimage', 'text', 1, 'Omega\\Library\\Plugin\\Type\\TextRich', '{}', 'Text', '', 0);
CALL `om_CreateFormEntry`('textandimage', 'picture', 2, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["picture"]}', 'Image', '', 0);
CALL `om_CreateFormEntry`('textandimage', 'position', 3, 'Omega\\Library\\Plugin\\Type\\RadioButtons', '{"default": 0,"options": {"0": "Left","1": "Right", "2": "Top", "3": "Bottom"}}', 'Image position', '', 0);
CALL `om_CreateFormEntry`('textandimage', 'width_percent', 4, 'Omega\\Library\\Plugin\\Type\\DropDown', '{"default": 3,"options": {"3": "25%","4": "33%","5": "42%","6": "50%","8": "66%","9": "75%"}}', 'Image width', 'Width not used if position is top or bottom', 0);
CALL `om_CreateFormEntry`('textandimage', 'resize', 5, 'Omega\\Library\\Plugin\\Type\\CheckBoxes', '{"default": {"resize": false},"options": {"resize": "Yes"}}', 'Resize image', '', 0);
CALL `om_CreateFormEntry`('textandimage', 'width', 6, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Width', '', 0);
CALL `om_CreateFormEntry`('textandimage', 'height', 7, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Height', '', 0);