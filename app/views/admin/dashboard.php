<?php include __DIR__ . '/../general_views/adminheader.php';

 ?>


<!-- <style>
    .navbar-secondary {
        background-color: #000000;
    }
    .navbar-secondary .navbar-nav .nav-link {
        color: white; 
    }
    .content {
        text-align: center;
        padding: 2rem;
    }
</style> -->

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
