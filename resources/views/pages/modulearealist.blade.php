

@foreach($moduleAreas as $moduleArea)

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="module-area" data-areaname="{{ $moduleArea->name }}"  data-pageid="{{ $pageId }}">
                <span class="glyphicon glyphicon-plus module-area-add"></span>

                <h5 class="module-header">{{ clean_text($moduleArea->name) }}</h5>

                <ul class="list-group sortable">

                    @foreach ($moduleArea->positions as $position)

                        <li class="list-group-item sortable-item" data-positionid="{{ $position->id }}">

                            {{ $position->module->name }}

                            <span class="sortPosition badge" data-positionid="{{ $position->id }}"><span class="glyphicon glyphicon-sort-by-attributes glyphicon-move"></span></span>

                            <a href="#" class="deletePosition badge" data-positionid="{{ $position->id }}"><span class="glyphicon glyphicon-remove"></span></a>

                            <a href="#" class="setOnAllPages badge"
                               data-is="{{ is_null($position->fkPage) ? 1 : 0 }}"
                               data-positionid="{{ $position->id }}"><span class="{{ is_null($position->fkPage) ? 'glyphicon glyphicon-star' : 'glyphicon glyphicon-star-empty' }}"></span></a>

                        </li>

                    @endforeach
                </ul>
            </div>
        </div>


@endforeach