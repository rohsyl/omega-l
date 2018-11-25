
-- Create form
CALL `om_CreateForm`('google_maps', 'google_maps', 1, 1, 'Google Maps');

-- Create form entry
CALL `om_CreateFormEntry`('google_maps', 'lat', 1, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Latitude', '', 0);
CALL `om_CreateFormEntry`('google_maps', 'long', 2, 'Omega\\Utils\\Plugin\\Type\\TextSimple', '{}', 'Longitude', '', 0);
CALL `om_CreateFormEntry`('google_maps', 'mapstyleEnabled', 3, 'Omega\\Utils\\Plugin\\Type\\CheckBoxes', '{"default": {"mapstyle": false},"options": {"mapstyle": "Yes"}}', 'Enable Map Style', 'Check to enable customized map style.', 0);
CALL `om_CreateFormEntry`('google_maps', 'markerPicture', 4, 'Omega\\Utils\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["picture"]}', 'Marker picture', 'This picture will be displayed at the latitude and longitude position.', 0);
CALL `om_CreateFormEntry`('google_maps', 'markerText', 5, 'Omega\\Utils\\Plugin\\Type\\TextRich', '{}', 'Marker text', 'This text will be displayed when marker is clicked.', 0);