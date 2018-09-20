
-- Create form
CALL `om_CreateForm`('facebookfeed', 'facebookfeed', 1, 0, 'Facebook Feed');

-- Create form entry
CALL `om_CreateFormEntry`('facebookfeed', 'îdfbpage', 1, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Facebook Page ID', 'Paste here the id of the page you want to display the feed', 0);
CALL `om_CreateFormEntry`('facebookfeed', 'nbpost', 2, 'Omega\\Library\\Plugin\\Type\\TextSimple', '{}', 'Number of feed', 'Enter the number of feed you want to display', 0);