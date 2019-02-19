<body class="subpage">

<!-- Header -->
<header id="header">
    <div class="logo"><a href="{{ url('/') }}">{{ Entity::Site()->name }}</a></div>
    <a href="#menu">Menu</a>
</header>


<!-- Nav -->
@php
    //Personaliser la structure du menu via la method setMenuHtmlStruct.
    Entity::Menu()->setMenuHtmlStruct([
        'ul_main' => ' <ul class="links">%1$s</ul>',
        'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s" %4$s>%2$s</a></li>',
        'li_nochildrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s" %4$s>%2$s</a></li>',
        'li_children' => '<li class=" nav-item-%3$s"><a href="%1$s" %5$s >%2$s <span class="caret"></span></a>%4$s</li>',
        'ul_children' => '<ul class="">%1$s</ul>',
        'li_childrenactiv' => '<li class="nav-item-%3$s"><a href="%1$s" class="dropdown-toggle" data-toggle="dropdown" %5$s>%2$s</a>%4$s</li>'
    ]);
@endphp
<nav id="menu">
    {!! Entity::Menu()->getBySecurity() !!}
</nav>


<!-- Content -->
{!! Entity::Page()->content !!}

<!-- Footer -->
@include('theme::footer')