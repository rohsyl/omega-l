
-- Create form
CALL `om_CreateForm`('document', 'document', 1, 1, 'Documents');

-- Create form entry
CALL `om_CreateFormEntry`('document', 'filesize', 1, 'Omega\\Utils\\Plugin\\Type\\CheckBoxes', '{"default": {"filesize": true},"options": {"filesize": "Yes"}}', 'Display filesize', '', 0);
CALL `om_CreateFormEntry`('document', 'documents', 2, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{"multiple" : true, "preview": true, "type": ["document", "folder"]}', 'Documents', '', 0);
