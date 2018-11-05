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
                    <img src="{{ \Omega\Utils\Language\BackLangManager::getSessionLang()->getFlag() }}" title="" />&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu lang">
                    @foreach(\Omega\Utils\Language\BackLangManager::getAllLang() as $l)
                    <li>
                        <a href="#">
                            <img src="{{ $l->getFlag() }}" title="{{ $l->getName() }}" />&nbsp;&nbsp;{{ $l->getName() }}
                        </a>
                    </li>
                    @endforeach
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
                            {!! OmegaUtils::GetCurrentUserAvatar() !!}
                        </div>
                        <span class="userAvatarContainer-mini-username">
                        <span class="bold">{{ OmegaUtils::GetCurrentUserFullName() }}</span><br />
                        <span>{{ OmegaUtils::GetCurrentUserName() }}</span>
                    </span>
                    </a>
                </li>

                {!! add_action(route('admin.dashboard'), 'glyphicon glyphicon-th', __('Dashboard')) !!}
                {!! add_action(route('admin.settings'), 'glyphicon glyphicon-cog',  __('Settings')) !!}
                {!! add_action(route('admin.pages'), 'fa fa-file-text',  __('Pages')) !!}
                {!! add_action(route('member.index'), 'fa fa-university', __('Members')) !!}
                {!! add_action('#', 'fa fa-users',  __('Users & Groups'), [
                    add_action(route('user.add'), 'fa fa-user-plus', __('Add user')),
                    add_action(route('user.index'), 'fa fa-list-alt', __('Manage users')),
                    add_action(route('group.add'), 'fa fa-plus', __('Add group')),
                    add_action(route('group.index'), 'fa fa-list-alt', __('Manage groups'))
                ]) !!}
                {!! add_action('#', 'glyphicon glyphicon-text-width',  __('Apparences'), [
                    add_action(route('theme.index'), 'fa fa-paint-brush', __('Theme')),
                    //add_action(route('editor.index'), 'fa fa-code', __('File editor')),
                    add_action(route('menu.index'), 'glyphicon glyphicon-list-alt', __('Menus'))
                ]) !!}
                {!! add_action(route('admin.plugins'), 'fa fa-cubes',  __('Plugins'), add_sub_actions_plugin()) !!}


                {!! add_action(route('media.library'), 'glyphicon glyphicon-picture',  __('Media Library')) !!}
            </ul>
        </div>
    </div>
</nav>