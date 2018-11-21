
-- Create form
CALL `om_CreateForm`('lang_redirect', 'lang_redirect', 1, 1, 'Lang Redirect');

-- Create form entry
CALL `om_CreateFormEntry`('lang_redirect', 'page', 1, 'Omega\\Utils\\Plugin\\Type\\DropDown', '{"model": "OmegaPlugin\\\\LangRedirect\\\\Model\\\\DropDownPage"}', 'Page', 'The page where you want to be redirected.', 0);