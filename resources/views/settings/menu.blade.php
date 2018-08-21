<ul class="nav nav-tabs">
    <li {!! class_active_route('admin.settings') !!}>
             <a href="{{ route('admin.settings') }}">{{ __('General') }}
             </a>
    </li>
    <li {!! class_active_route('admin.settings.flang') !!}>
             <a href="{{ route('admin.settings.flang') }}">{{ __('Front-end languages') }}
             </a>
    </li>
    <li {!! class_active_route('admin.settings.seo') !!}>
             <a href="{{ route('admin.settings.seo') }}">{{ __('SEO') }}
             </a>
    </li>
    <li {!! class_active_route('admin.settings.smtp') !!}>
             <a href="{{ route('admin.settings.smtp') }}">{{ __('SMTP') }}
             </a>
    </li>
    <li {!! class_active_route('admin.settings.member') !!}>
             <a href="{{ route('admin.settings.member') }}">{{ __('Member') }}
             </a>
    </li>
    <li {!! class_active_route('admin.settings.advanced') !!}>
             <a href="{{ route('admin.settings.advanced') }}">{{ __('Advanced') }}
             </a>
    </li>
</ul>
<br />