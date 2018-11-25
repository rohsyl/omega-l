<textarea id="{{ $uid }}" name="{{ $uid }}">{{ isset($value) ? $value : '' }}</textarea>
<script>
    var textarea = document.getElementById('{{ $uid }}');
    var editor = CodeMirror.fromTextArea(textarea, {
        lineNumbers: true
    });
</script>