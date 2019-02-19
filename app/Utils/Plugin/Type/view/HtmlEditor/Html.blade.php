<textarea id="{{ $uid }}" name="{{ $uid }}" class="codemirror-editor">{{ isset($value) ? $value : '' }}</textarea>
<script>
    var textarea = document.getElementById('{{ $uid }}');
    var editor = CodeMirror.fromTextArea(textarea, {
        lineNumbers: true
    });
    $(textarea).data('codemirror', editor);
</script>