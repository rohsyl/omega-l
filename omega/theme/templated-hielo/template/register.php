<?php
use Omega\Utils\Theme\Template;

/**
 * @var Template
 */
return Template::For('templated-hielo')
    ->registerComponentTemplateView('text', 'display', '1.0.0', 'text/textSuperStylish', 'Text on 3 column')
    ->registerComponentTemplateView('contact', 'display_info', '1.0.0', 'contact/information', 'Contact Informations')
    ;