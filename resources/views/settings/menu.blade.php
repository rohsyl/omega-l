<ul class="nav nav-tabs">
    @if(has_right('setting_general'))
    <li {!! class_active_route('admin.settings') !!}>
             <a href="{{ route('admin.settings') }}">{{ __('General') }}
             </a>
    </li>
    @endif
    @if(has_right('setting_flang'))
    <li {!! class_active_route('admin.settings.flang') !!}>
             <a href="{{ route('admin.settings.flang') }}">{{ __('Front-end languages') }}
             </a>
    </li>
    @endif
    @if(has_right('setting_seo'))
    <li {!! class_active_route('admin.settings.seo') !!}>
             <a href="{{ route('admin.settings.seo') }}">{{ __('SEO') }}
             </a>
    </li>
    @endif
    {{--
    <li {!! class_active_route('admin.settings.smtp') !!}>
             <a href="{{ route('admin.settings.smtp') }}">{{ __('SMTP') }}
             </a>
    </li>
    --}}
    @if(has_right('setting_member'))
    <li {!! class_active_route('admin.settings.member') !!}>
             <a href="{{ route('admin.settings.member') }}">{{ __('Member') }}
             </a>
    </li>
    @endif
    @if(has_right('setting_advanced'))
    <li {!! class_active_route('admin.settings.advanced') !!}>
             <a href="{{ route('admin.settings.advanced') }}">{{ __('Advanced') }}
             </a>
    </li>
    @endif
</ul>
<br />