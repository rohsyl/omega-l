@extends('layouts.app')

@section('content')
    <h1 class="page-header">Update</h1>

    <p>Before performing an update, it's <strong>strongly</strong> recommended to backup your files and your database so you can easly restore your website back in case of error during the update.</p>
    <p>The updater automatically put your website in maintenance mode during the update.</p>
    <hr />
    <div id="update_notification">
    </div>
    <br />
    <pre id="output" style="max-height: 500px">

    </pre>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: route('laraupdater.check'),
                async: false,
                success: function(response) {
                    if(response != ''){
                        $('#update_notification').append('<strong>Update Available <span class="badge badge-pill badge-info">'+response+'</span></strong>');
                        $('#update_notification').append('<a role="button" href="javascript:update()" class="btn btn-sm btn-info pull-right">Update Now</a>');
                        $('#update_notification').show();
                    }
                }
            });
        });


        function update() {

            xhr = new XMLHttpRequest();
            xhr.open("GET", route('laraupdater.update'), true);
            xhr.onprogress = function(e) {
                $('#output').append(e.currentTarget.responseText);
                scrollToBottom();
            };
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    $('#output').append('Complete');
                    scrollToBottom();
                }
            };
            xhr.send();
        }

        function scrollToBottom() {
            var objDiv = document.getElementById("output");
            objDiv.scrollTop = objDiv.scrollHeight;
        }
    </script>
@endpush