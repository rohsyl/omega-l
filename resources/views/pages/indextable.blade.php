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
        </td>
    </tr>

    @else
        @foreach($pages as $page)
            <tr class="row-page" data-idPage="{{ $page->id }}" data-title="{{ $page->name }}">

                <td><a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">{{ $page->name }}</a></td>
                <td>{{ $page->owner->username }}</td>
                <td><em><small> {{ $page->updated_at }}</small></em></td>
                <td>{{ prettify_text(isset($page->model) ? without_ext(without_ext($page->model)) : __('default')) }}</td>

                @if($enabledLang)
                    <td>{{ isset($page->lang) ? $page->lang : __('Any')}}</td>
                @endif

                <td>
                    <span class="action-img-page-list">
                        @if(has_right('page_update'))
                        <a  href="{{ route('admin.pages.edit', ['id' => $page->id]) }}"
                            title="{{ __('Edit') }}">{{ __('Edit') }}</a>
                        @endif
                        |
                        @if(has_right('page_delete'))
                        <a  href="{{ route('admin.pages.delete', ['id' => $page->id]) }}"
                            title="{{ __('Delete') }}"
                            data-url="{{ route('admin.pages.delete', ['id' => $page->id, 'confirmed' => true]) }}"
                            class="delete text-danger">{{ __('Delete') }}</a>

                            @endif
                    </span>
                </td>

            </tr>

            @if (sizeof($page->children) > 0)
                @foreach($page->children as $child)
                    <tr>

                        <td><i class="fa fa-minus"></i> <a href="{{ route('admin.pages.edit', ['id' => $child->id]) }}">{{ $child->name }}</a></td>
                        <td>{{ $child->owner->username }}</td>
                        <td><em><small> {{ $child->updated_at }}</small></em></td>
                        <td>{{ prettify_text(isset($child->model) ? without_ext(without_ext($child->model)) : __('default')) }}</td>

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
                            data-url="{{ route('admin.pages.delete', ['id' => $child->id, 'confirmed' => 1]) }}"
                            class="delete text-danger">{{ __('Delete') }}</a>

                    </span>
                        </td>

                    </tr>
                @endforeach
            @endif


        @endforeach


    @endif
</table>
<div class="text-center">
    {{ $pages->links() }}
</div>