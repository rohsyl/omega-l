
<div class="row">
    @if(count($plugins) == 0)
        <p class="text-center">{{ __('No components available...') }}</p>
        <p class="text-center text-info"><i class="fa fa-info"></i> {{ __('To add a component you can install plugins from the Plugins page in the left menu') }}</p>
    @else
        <div style="max-height: 450px; overflow-y:auto;">
            @foreach($plugins as $plugin)
            @php $meta = new \Omega\Utils\Plugin\PluginMeta($plugin->name); @endphp
                <div class="col-sm-4">
                    <div class="component-container" data-pluginid="{{ $plugin->id }}" >
                        <div class="component-image" style="background-image: url('{{ plugin_asset($plugin->name, 'images/component-logo.png') }}');"></div>
                        <div class="component-title">{{ $meta->getTitle() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    $(function(){
        $components = $('.component-container');
        $components.click(function(){
            $components.removeClass('active');
            $(this).addClass('active');
        });
    })
</script>