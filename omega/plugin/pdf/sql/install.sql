
-- Create form
CALL `om_CreateForm`('pdf', 'pdf', 1, 1, 'PDF Preview');

-- Create form entry
CALL `om_CreateFormEntry`('pdf', 'file', 0, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": false, "type": ["document"]}', 'PDF File', '', 0);
CALL `om_CreateFormEntry`('pdf', 'height', 1, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Height', 'value in px', 0);