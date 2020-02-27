{{ Form::text($name, $value, array_merge(
    ['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : ''),
    'id' => $name,
    'data-toggle' => 'datetimepicker',
    'data-target' => '#'.$name,
    'autocomplete' => 'off'
    ], $attributes)) }}
@if($errors->has($name))
    <small class="form-text text-danger">{{ $errors->first($name) }}</small>
@endif
<script type="text/javascript">
    $(function () {
        $('#{{ $name }}').datetimepicker({
            icons: {
                time: 'fas fa-clock',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash',
                close: 'fas fa-times'
            },
            format: 'LT',
            locale: '{{ App::getLocale() }}'
        });
    });
</script>
