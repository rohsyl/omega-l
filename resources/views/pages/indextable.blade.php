{{--
use Omega\Library;
use Omega\Library\Util\Util;
use Omega\Library\Util\Url;
use Omega\Library\Language\Front\Lang;
use function Omega\Library\__;

$lPageTitle 		= Library\__('Title', true);
$lPageLastEditor 	= Library\__('Last editor', true);
$lPageCreated 		= Library\__('Created', true);
$lPageUpdated 		= Library\__('Updated', true);
$lPageModel 		= Library\__('Model', true);
$lLang 		        = Library\__('Language', true);
$lPageCssTheme 		= Library\__('Style', true);
$lAllPage 			= Library\__('All pages', true);
$lAddNewPage 		= Library\__('Add new', true);
$lNoPage 			= Library\__('No page', true);
$lTitleLinkEdit 	= Library\__('Edit', true);
$lTitleLinkDelete 	= Library\__('Delete', true);
$lTitleLinkEnable 	= Library\__('Click to enable the page', true);
$lTitleLinkDisable	= Library\__('Click to disable the page', true);

$gIconFile 			= 'glyphicon glyphicon-file';
$gIconPlus 			= 'glyphicon glyphicon-plus-sign';
$gIconEdit	 		= 'glyphicon glyphicon-pencil';
$gIconDelete 		= 'glyphicon glyphicon-trash';
$gIconEnable 		= 'glyphicon glyphicon-ok';
$gIconDisable 		= 'glyphicon glyphicon-remove';

$dateFormat 		= 'd/m/Y H:i:s';

--}}

<table class="table table-hover">
    <tr>
        <th>{{ __('Title') }}</th>
        <th>{{ __('Last editor') }}</th>
        <th>{{ __('Updated') }}</th>
        <th>{{ __('Model') }}</th>
        @if($enabledLang)
        <th>{{ __('Language') }}</th>
        @endif
        <th></th>
    </tr>
    @if(count($pages) == 0)
    <tr>
        <td colspan="@if($enabledLang) 5 @else 4 @endif" align="center">
            {{ __('No page') }}
            @php $args = $enabledLang ? ['lang' => $currentLang] : []; @endphp
            <a href="{{ route('admin.pages.add', $args) }}" class="btn btn-primary btn-xs">
                <span class="glyphicon glyphicon-plus-sign"></span> {{ __('Add new') }}
            </a>
        </td>
    </tr>

    @else
        @foreach($pages as $page)
            <tr class="row-page" data-idPage="{{ $page->id }}" data-title="{{ $page->name }}">

                <td><a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">{{ $page->name }}</a></td>
                <td>{{ $page->owner->username }}</td>
                <td>{{ $page->updated_at }}</td>
                <td>{{ isset($page->model) ? $page->model : __('Default') }}</td>

                @if($enabledLang)
                    <td>{{ isset($page->lang) ? $page->lang : __('Any')}}</td>
                @endif

                <td>
                    <span class="action-img-page-list">
                        <a  href="{{ route('admin.pages.edit', ['id' => $page->id]) }}"
                            title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                        |
                        <a  href="{{ route('admin.pages.delete', ['id' => $page->id]) }}"
                            title="{{ __('Delete') }}"
                            data-url="{{ route('admin.pages.delete', ['id' => $page->id, 'confirmed' => true]) }}"
                            class="delete text-danger">{{ __('Delete') }}</a>
                        |
                        @if($page->isEnabled)
                            <a href="{{ route('admin.pages.enable', ['id' => $page->id, 'enable' => false]) }}" title="{{ __('Disable') }}">{{ __('Disable') }}</a>
                        @else
                            <a href="{{ route('admin.pages.enable', ['id' => $page->id, 'enable' => true]) }}" title="{{ __('Enable') }}">{{ __('Enable') }}</a>
                        @endif

                    </span>
                </td>

            </tr>

            @if (sizeof($page->children) > 0)
                @foreach($page->children as $child)
                    <tr>

                        <td><i class="fa fa-minus"></i> <a href="{{ route('admin.pages.edit', ['id' => $child->id]) }}">{{ $child->name }}</a></td>
                        <td>{{ $child->owner->username }}</td>
                        <td>{{ $child->updated_at }}</td>
                        <td>{{ isset($child->model) ? $child->model : __('Default') }}</td>

                        @if($enabledLang)
                            <td>{{ isset($child->lang) ? $child->lang : __('Any')}}</td>
                        @endif

                        <td>
                    <span class="action-img-page-list">
                        <a  href="{{ route('admin.pages.edit', ['id' => $child->id]) }}"
                            title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                        |
                        <a  href="{{ route('admin.pages.delete', ['id' => $child->id]) }}"
                            title="{{ __('Delete') }}"
                            data-url="{{ route('admin.pages.delete', ['id' => $child->id, 'confirmed' => true]) }}"
                            class="delete text-danger">{{ __('Delete') }}</a>
                        |
                        @if($child->isEnabled)
                            <a href="{{ route('admin.pages.enable', ['id' => $child->id, 'enable' => false]) }}" title="{{ __('Disable') }}">{{ __('Disable') }}</a>
                        @else
                            <a href="{{ route('admin.pages.enable', ['id' => $child->id, 'enable' => true]) }}" title="{{ __('Enable') }}">{{ __('Enable') }}</a>
                        @endif

                    </span>
                        </td>

                    </tr>
                @endforeach
            @endif


        @endforeach

    @endif
</table>