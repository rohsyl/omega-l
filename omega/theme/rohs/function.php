<?php
use Omega\Library\Entity\Entity;

Entity::Menu()->setMenuHtmlStruct(array(
    'ul_main' => '<ul class="links">%1$s</ul>',
    'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
    'li_children' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" role="button" >%2$s <span class="caret"></span></a>%4$s</li>',
    'ul_children' => '<ul class="dropdown-menu">%1$s</ul>',
    'li_childrenactiv' => '<li class="dropdown nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown">%2$s</a>%4$s</li>'
));