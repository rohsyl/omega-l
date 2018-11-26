

@if($param['displayLogo'] && isset($param['contactLogo']))
    <div class="contact-contactlogo">
        <img src="{{ asset($image()->path) }}" alt="{{ $image()->name }}"/>
    </div>
@endif


<address class="contact-contactadress">
    <i class="fa fa-map-marker"></i><br/>
    <strong>{{ $param['name'] }}</strong><br>
    {{ $param['street'] }}<br>
    {{ $param['locality'] }}, {{ $param['npa'] }}<br>
</address>


<address class="contact-contactinfo">
    @if(!empty($param['mail_info']))
    <div class="center-icon mail">
        <i class="fa fa-envelope"></i>
    </div>
    <a href="mailto:{{ $param['mail_info'] }}">{{ $param['mail_info'] }}</a><br />
    @endif
    @if(!empty($param['phone']))
        <div class="center-icon phone">
            <i class="fa fa-phone"></i>
        </div>
        {{ $param['phone'] }}<br />
    @endif
    @if(!empty($param['mobile']))
        <div class="center-icon mobile">
            <i class="fa fa-mobile"></i>
        </div>
        {{ $param['mobile'] }}<br />
    @endif
    @if(!empty($param['fax']))
         <div class="center-icon fax">
            <i class="fa fa-fax"></i>
         </div>
        {{ $param['fax'] }}
    @endif
</address>
