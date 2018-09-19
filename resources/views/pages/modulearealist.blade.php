

@foreach($moduleAreas as $moduleArea)

    @if(sizeof($moduleArea->positions) > 0)

        <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="module-area" data-areaname="{{ $moduleArea->name }}"  data-pageid="{{ $pageId }}">
                <span class="glyphicon glyphicon-plus"></span>
                    <h5 class="module-header">{{ clean_text($moduleArea->name) }}</h5>
                <table class="table sortable">

                    @foreach ($moduleArea->positions as $position)

                        <tr data-positionid="{{ $position->id }}">
                            <td>{{ $position->module->name }}</td>
                            <td>
                                @if($position->module == 0)
                                <a href="#" class="setOnAllPages" data-is="1"><span class="glyphicon glyphicon-star"></span></a>
                                @else
                                <a href="#" class="setOnAllPages" data-is="0"><span class="glyphicon glyphicon-star-empty"></span></a>
                                @endif

                                <a href="#" class="deletePosition"><span class="glyphicon glyphicon-remove"></span></a>
                                <a href="#" class="sortPosition"><span class="glyphicon glyphicon-sort-by-attributes"></span></a>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </div>
        </div>

    @else

        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="module-area empty" data-areaname="{{ $moduleArea->name }}"  data-pageid="{{ $pageId }}">
                <h5 class="module-header">{{ clean_text($moduleArea->name) }}</h5>
                <div class="module-list">
                    <span class="glyphicon glyphicon-plus empty"></span>
                </div>
            </div>
        </div>

    @endif

@endforeach