    <input type="text" id="<?php echo $uid ?>" name="<?php echo $uid ?>" value="<?php echo $value ?>" class="form-control" />
<script>
    $(document).ready(function() {
        omega.html.linkChooser('#<?php echo $uid ?>');
    });
</script>