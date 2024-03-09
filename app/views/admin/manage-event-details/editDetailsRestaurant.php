<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container mt-5">
    <h2>Restaurant Details</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($restaurants as $restaurant): ?>
            <tr>
                <td><?php echo htmlspecialchars($restaurant['location']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    

<?php include __DIR__ . '/../../general_views/footer.php'; ?>
