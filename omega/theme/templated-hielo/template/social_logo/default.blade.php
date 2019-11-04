<div class="plugin plugin-sociallogo">
    @foreach($socialNetworks as $key => $sn)
        @if(isset($moduleParam[$key]))
            <a class="logo {{ $key }}" title="{{ $sn['name'] }}" target="_blank" href="{{ $moduleParam[$key] }}"><span class="{{ $sn['class'] }}"></span></a>
        @endif
    @endforeach
</div>
<style>
    @foreach($socialNetworks as $key => $sn)
    @if(isset($moduleParam[$key]))
        .plugin-sociallogo .logo.{{ $key }} {
            background-color : {{ $sn['color'] }};
            transition: 0.3s all ease-in 0s;
            opacity: 0.9;
        }
        .plugin-sociallogo .logo.{{ $key }}:hover {
            background-color : {{ $sn['colorHover'] }};
        }
    @endif
    @endforeach
</style>
