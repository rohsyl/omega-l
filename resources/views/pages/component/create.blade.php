
<div class="row">
    @if(count($plugins) == 0)
    <p class="text-center">There is any components installed...</p>
    @else
    <div style="max-height: 450px; overflow-y:auto;">
        @foreach($plugins as $plugin)
        @php $meta = new \Omega\Utils\Plugin\PluginMeta($plugin->name); @endphp
        <div class="col-sm-4">
            <div class="component-container" data-pluginid="{{ $plugin->id }}" >
                <div class="component-image" style="background-image: url('{{ \Omega\Utils\Url::CombAndAbs(url('../omega/plugin'), '/'.$plugin->name.'/image/component-logo.png') }}');"></div>
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