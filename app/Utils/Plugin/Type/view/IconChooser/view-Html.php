<div>
<button data-iconset="fontawesome"
        data-icon="<?php echo $value ?>"
        class="btn btn-primary features_icon_button"
        id="<?php echo $uid ?>"
        name="<?php echo $uid ?>">Choose a icon</button>
</div>
<script>
    $(document).ready(function() {
        $('#<?php echo $uid ?>').iconpicker();
    });
</script>