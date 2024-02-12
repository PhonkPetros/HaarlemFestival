<?php include __DIR__ . '/../general_views/adminheader.php';

 ?>

<div class="content">
    <h1>Admin Dashboard</h1>

    <?php if (isset($userDetails)): ?>
        <section>
            <br>
            <h2>Currently Logged In User</h2>
            <br>
            <p>Username: <?php echo htmlspecialchars($userDetails['username']); ?></p>
            <p>Email: <?php echo htmlspecialchars($userDetails['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($userDetails['role']); ?></p>
        </section>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>
