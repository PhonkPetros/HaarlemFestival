
<?php if (isset($_SESSION['response'])): ?>
    <script type="text/javascript">
        window.onload = function() {
            var response = <?php echo json_encode($_SESSION['response']); ?>;

            var titleText = response.success ? 'Success!' : 'Failure';
            var iconType = response.success ? 'success' : 'error';

            swal({
                title: titleText,
                text: response.message,
                icon: iconType,
                button: "OK",
            });
        };
        <?php unset($_SESSION['response']); ?>
    </script>
<?php endif; ?>