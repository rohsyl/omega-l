<div class="form-horizontal">
    <div class="form-group">
        {{ Form::label('lang', __('Language'), ['class' => 'control-label col-sm-3']) }}
        <div class="col-sm-5">
            {{ Form::select('lang', $langs_select, $page->lang, ['class' => 'form-control']) }}
            @if ($errors->has('lang'))
                <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('lang') }}</strong>
                </span>
            @else
                <span class="help-block">
                    {{ __('Set the language of this page') }}
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="group">{{ __('Corresponding pages') }} :</label>
        <div class="alert alert-info">
            <strong><i class="fa fa-info-circle"></i></strong> {{ __('Link this page with the corresponding ones in other languages') }}
        </div>
        <table class="table" id="table-plangs">
            <tr>
                <th>{{ __('Languages') }}</th>
                <th>{{ __('Page') }}</th>
                <th></th>
            </tr>
            @foreach($langs as $l)
                @if($l->slug != $page->lang)
                    <tr class="row-plangs" data-idparent="{{ isset($correspondingParents[$l->slug]) ? $correspondingParents[$l->slug] : 'null' }}" data-lang="{{ $l->slug }}" data-pid="{{ $page->id }}">
                        <td>{{ $l->name }}</td>
                        <td>
                            <select class="form-control" id="select-plangs-{{ $l->slug }}" name="plangs_rel[{{ $l->slug }}]">
                                <option>{{ __('Loading') }}</option>
                            </select>

                            @if ($errors->has('plangs_rel.'.$l->slug))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('plangs_rel.'.$l->slug) }}</strong>
                                </span>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</div>