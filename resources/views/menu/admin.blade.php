<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">


    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">{{ __('Toggle nav') }}</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('public') }}" title="Back to the site">OmegaCMS</a>
    </div>


    <div class="nav navbar-top-links navbar-right">
        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('i18n/flags/fr.png') }}" title="" />&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu lang">

                    <li>
                        <a href="#">
                            <img src="{{ asset('i18n/flags/fr.png') }}" title="fr" />&nbsp;&nbsp;Francais
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{ route('profile') }}"><i class="fa fa-male"></i> {{ __('Profile') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">

                <li class="sidebar-search" style="padding:0px">
                    <a href="{{ route('profile') }}">
                        <div class="userAvatarContainer-mini">
                            {!! \Omega\Utils\OmegaUtils::GetCurrentUserAvatar() !!}
                        </div>
                        <span class="userAvatarContainer-mini-username">
                        <span class="bold">{{ \Omega\Utils\OmegaUtils::GetCurrentUserFullName() }}</span><br />
                        <span>{{ \Omega\Utils\OmegaUtils::GetCurrentUserName() }}</span>
                    </span>
                    </a>
                </li>

                {!! add_action(route('admin.dashboard'), 'glyphicon glyphicon-th', __('Dashboard')) !!}
                {!! add_action(route('admin.settings'), 'glyphicon glyphicon-cog',  __('Settings')) !!}

            </ul>
        </div>
    </div>
</nav>