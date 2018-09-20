CALL `om_CreateForm`('completedemoplugin', 'completedemoplugin', 1, 1, 'Complete Demo Plugin');
CALL `om_CreateFormEntry`('completedemoplugin', 'text', 1, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Text Simple', 'This is a simple text entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'richtext', 2, 'Omega\\Library\\Plugin\\Type\\TextRich', '{}', 'Text Rich', 'This is a rich text entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'radiobutt', 3, 'Omega\\Library\\Plugin\\Type\\RadioButtons', '{"default":0,"options":{"0":"Left","1":"Right","2":"Top","3":"Bottom"}}', 'Radio Button', 'This is a radio button entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'mediachoo', 4, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '{"multiple":true,"preview":true,"type":["picture","video","video_ext","audio","document","folder"]}', 'Media Chooser', 'This is a media chooser entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'linkchoo', 5, 'Omega\\Library\\Plugin\\Type\\LinkChooser', '{}', 'Link Chooser', 'This is a link chooser entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'iconchoo', 6, 'Omega\\Library\\Plugin\\Type\\IconChooser', '{}', 'Icon Chooser', 'This is a icon chooser entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'dropdownhc', 7, 'Omega\\Library\\Plugin\\Type\\DropDown', '{"default":3,"options":{"3":"25%","4":"33%","5":"42%","6":"50%","8":"66%","9":"75%"}}', 'Drop Down Hardcoded', 'This is a hardcoded dropdown entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'dropdownmodel', 8, 'Omega\\Library\\Plugin\\Type\\DropDown', '{"model":"Omega\\\\Plugin\\\\Completedemoplugin\\\\Model\\\\DropDownPage"}', 'Drop Down Model', 'This is a model dropdown entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'checkboxhc', 9, 'Omega\\Library\\Plugin\\Type\\CheckBoxes', '{"default":{"opt1":true,"opt2":false},"options":{"opt1":"Option 1","opt2":"Option 2"}}', 'Check Boxes Hardcoded', 'This is a hardcoded check boxes entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'checkboxmodel', 10, 'Omega\\Library\\Plugin\\Type\\CheckBoxes', '{"model":"Omega\\\\Plugin\\\\Completedemoplugin\\\\Model\\\\CheckBoxesPage"}', 'Check Boxes Model', 'This is a model check boxes entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'alert1', 11, 'Omega\\Library\\Plugin\\Type\\Alert', '{"type":"info","text":"This is a info alert."}', 'Alert', 'This is a alert entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'alert2', 12, 'Omega\\Library\\Plugin\\Type\\Alert', '{"type":"warning","text":"This is a warning alert."}', 'Alert', 'This is a alert entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'alert3', 13, 'Omega\\Library\\Plugin\\Type\\Alert', '{"type":"danger","text":"This is a danger alert."}', 'Alert', 'This is a alert entry', 0);
CALL `om_CreateFormEntry`('completedemoplugin', 'alert4', 14, 'Omega\\Library\\Plugin\\Type\\Alert', '{"type":"success","text":"This is a success alert."}', 'Alert', 'This is a alert entry', 0);

