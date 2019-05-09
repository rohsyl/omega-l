@extends('layouts.app')

@section('content')
    <h1 class="page-header">Update</h1>

    <p>Before performing an update, it's <strong>strongly</strong> recommended to backup your files and your database so you can easly restore your website back in case of error during the update.</p>
    <p>The updater automatically put your website in maintenance mode during the update.</p>
    <hr />
    <div id="update_notification" style="display: none">
    </div>
    <br />
    <pre id="output" style="display: none; max-height: 500px;">

    </pre>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $ouput = $('#output');
            $alert = $('#update_notification');
            $.ajax({
                type: 'GET',
                url: route('laraupdater.check'),
                async: false,
                success: function(response) {
                    $alert.empty();
                    $ouput.hide();
                    if(response != ''){
                        $alert.append('<strong>Update Available <span class="badge badge-pill badge-info">'+response+'</span></strong>');
                        $alert.append('<a role="button" href="javascript:update()" class="btn btn-sm btn-info pull-right">Update Now</a>');
                    }
                    else {
                        $alert.append('<strong>No Update Available</strong>');
                        $ouput.hide();
                    }
                    $alert.show();
                }
            });
        });


        function update() {

            $ouput.show();

            xhr = new XMLHttpRequest();
            xhr.open("GET", route('laraupdater.update'), true);
            xhr.onprogress = function(e) {
                $ouput.append(e.currentTarget.responseText);
                scrollToBottom();
            };
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    $ouput.append('Complete');
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