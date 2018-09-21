
-- Create form
CALL `om_CreateForm`('googlemaps', 'googlemaps', 1, 1, 'Google Maps');

-- Create form entry
CALL `om_CreateFormEntry`('googlemaps', 'lat', 1, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Latitude', '', 0);
CALL `om_CreateFormEntry`('googlemaps', 'long', 2, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Longitude', '', 0);
CALL `om_CreateFormEntry`('googlemaps', 'mapstyleEnabled', 3, 'Omega\\Library\\Plugin\\Type\\CheckBoxes', '{"default": {"mapstyle": false},"options": {"mapstyle": "Yes"}}', 'Enable Map Style', 'Check to enable customized map style.', 0);
CALL `om_CreateFormEntry`('googlemaps', 'markerPicture', 4, 'Omega\\Library\\Plugin\\Type\\MediaChooser', '{"multiple" : false, "preview": true, "type": ["picture"]}', 'Marker picture', 'This picture will be displayed at the latitude and longitude position.', 0);
CALL `om_CreateFormEntry`('googlemaps', 'markerText', 5, 'Omega\\Library\\Plugin\\Type\\TextRich', '{}', 'Marker text', 'This text will be displayed when marker is clicked.', 0);