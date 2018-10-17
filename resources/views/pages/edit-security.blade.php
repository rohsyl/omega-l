
<div class="form-horizontal">

    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> {{ __('Page can be secured in many different way. You configure it down there.') }}
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="radio">
                <label for="security-0">
                    <input name="security" @if($securityType == 'none') checked @endif id="security-0" value="none" checked="checked" type="radio">
                    {{ __('No security') }}
                </label>
            </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="radio">
                <label for="security-1">
                    <input name="security" @if($securityType == 'bypassword') checked @endif id="security-1" value="bypassword" type="radio">
                    {{ __('Secure with a password') }}
                </label>
            </div>
        </div>
        <div class="panel-body">
            @php
                $message = '';
                $password = '';
                if($securityType == 'bypassword')
                {
                    $message = $securityData['message'];
                    $password = $securityData['password'];
                }
            @endphp
            <div class="form-group">
                {{ Form::label('security_message', __('Message'), ['class' => 'control-label col-sm-3']) }}
                <div class="col-sm-5">
                    {{ Form::textarea('security_message', $message, ['class' => 'form-control']) }}
                    <span class="help-block">
                        {{ __('This message will replace the content when an unauthorized user accessed the page.') }}
                    </span>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('security_password', __('Password'), ['class' => 'control-label col-sm-3']) }}
                <div class="col-sm-5">
                    {{ Form::text('security_password', $password, ['class' => 'form-control']) }}
                    <span class="help-block">
                        {{ __('The password is used to unlock the content of the page.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="radio">
                <label for="security-2">
                    <input name="security" @if($securityType == 'bymember') checked @endif id="security-2" value="bymember" type="radio">
                    {{ __('Secure by membergroup') }}
                </label>
            </div>
        </div>
        <div class="panel-body">
            @php
                $fkMemberGroup = 0;
                if($securityType == 'bymember')
                {
                    $fkMemberGroup = $securityData['membergroup'];
                }
            @endphp
            <div class="form-group">
                {{ Form::label('security_membergroup', __('Membergroups'), ['class' => 'control-label col-sm-3']) }}
                <div class="col-sm-5">
                    {{ Form::select('security_membergroup', $groups, $fkMemberGroup, ['class' => 'form-control']) }}
                    <span class="help-block">
                        {{ __('Access is restricted to members of the selected membergroup.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>