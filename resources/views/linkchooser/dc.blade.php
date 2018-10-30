@if($m->type == \Omega\Utils\Entity\Media::FOLDER)
    <div class="list-media">
        <table class="table table-hover linkchooser-table-medias">
            @foreach($medias as $m)
                <tr data-id="{{ $m->id }}" data-name="{{ $m->name }}" data-type="{{ $m->type }}">
                    @php
                        $icon = $m->type == \Omega\Utils\Entity\Media::FOLDER ? '<i class="fa fa-folder"></i>' : '<i class="'.$m->getIcon().'"></i>';
                    @endphp
                    <td width="70%">{!! $icon !!} {{ substr_if_longer($m->name, 30, true) }}</td>
                    @if($m->type != \Omega\Utils\Entity\Media::FOLDER)
                        <td width="10%" class="text-right">{{ $m->ext }}</td>
                        <td width="20%" class="text-right">
                            @php
                                $fs = $m->getMediaSize();
                                if(isset($fs))
                                    echo humanReadableBytes($fs)
                            @endphp
                        </td>
                    @else
                        <td width="10%"></td>
                        <td width="20%"></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@else
    <div class="row">
        <div class="col-sm-5">
            @if($m->getType() == \Omega\Utils\Entity\Media::T_PICTURE)
                <img width="100%" src="{{ \Omega\Utils\Url::CombAndAbs(url('/'), $m->path) }}" />
            @else
                <br /><p class="text-center">{{ __('No preview') }}</p>
            @endif
        </div>
        <div class="col-sm-7">
            <table class="table">
                @if(isset($m->title) && !empty($m->title))
                    <tr>
                        <th>Title</th>
                        <td>{{ $m->title }}</td>
                    </tr>
                @endif
                @if(isset($m->description) && !empty($m->description))
                    <tr>
                        <th>Description</th>
                        <td>{{ $m->description }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Name</th>
                    <td>{{ $m->name }}</td>
                </tr>
                <tr>
                    <th>Extension</th>
                    <td>{{ $m->ext }}</td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td>
                        @php
                        $fs = $m->getMediaSize();
                        if(isset($fs))
                            echo humanReadableBytes($fs)
                        @endphp
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endif
