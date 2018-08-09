@extends('layouts.install')

@section('title')
    <strong>Omega CMS Installation</strong> - Language
@endsection

@section('content')

    <p class="text-center">
        Welcome to the very hardcore <strong>Omega CMS</strong> installation. Click below to start the installation...
    </p>
    {{ Form::open(['route' => 'install.step1', 'method' => 'POST', 'class' => 'form-horizontal']) }}

        <p class="text-center ">
            Please select the language...
        </p>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
                {{ Form::select('lang', [ 'en' => 'Engish', 'fr' => 'French', 'German' => 'de'], 'en', ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
                {{ Form::submit('Begin installation', ['class' => 'btn btn-primary btn-lg btn-block']) }}
            </div>
        </div>
    {{ Form::close() }}
 @endsection