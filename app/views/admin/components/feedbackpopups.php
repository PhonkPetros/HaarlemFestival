<?php if (isset($_SESSION['error_message'])): ?>
<script>
    swal({
        title: "Error",
        text: "<?php echo addslashes($_SESSION['error_message']); ?>",
        icon: "error",
        button: "OK",
    });
</script>
<?php 
unset($_SESSION['error_message']);
endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
<script>
    swal({
        title: "Success",
        text: "<?php echo addslashes($_SESSION['success_message']); ?>",
        icon: "success",
        button: "OK",
    });
</script>
<?php 
unset($_SESSION['success_message']);
endif; ?>