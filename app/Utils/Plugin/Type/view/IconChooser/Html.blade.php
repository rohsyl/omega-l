<div>
    <button data-iconset="fontawesome"
        data-icon="{{ $value }}"
        class="btn btn-primary features_icon_button"
        id="{{ $uid }}"
        name="{{ $uid }}">Choose a icon</button>
</div>
<script>
    $(document).ready(function() {
        $('#{{ $uid }}').iconpicker();
    });
</script>