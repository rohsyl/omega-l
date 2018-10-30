<div class="alert alert-danger">
    <strong>{{ $e->getMessage() }}</strong>
    <br />
    <br />
    <a href="#" id="{{ $type->getUniqId() }}-toggle" class="btn btn-danger">Show details</a>
    <br />
    <div id="{{ $type->getUniqId() }}-container" class="hidden">
        <br />
        <pre>
{{ $e->getMessage() }}

File : {{ $e->getFile() }}
Code : {{ $e->getCode() }}
Line : {{ $e->getLine() }}

{{ $e->getTraceAsString() }}
        </pre>
    </div>
</div>
<script>
    $(function () {
        $('#{{ $type->getUniqId() }}-toggle').click(function(e){
            e.preventDefault();
            $('#{{ $type->getUniqId() }}-container').toggleClass('hidden');
            return false;
        })
    });
</script>