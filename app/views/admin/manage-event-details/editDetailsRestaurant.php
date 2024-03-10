<?php include __DIR__ . '/../../general_views/adminheader.php'; ?>

<div class="container mt-5">
    <h2>Restaurant Details</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Seats</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
    <?php if (isset($restaurants) && is_array($restaurants)): ?>
        <?php foreach ($restaurants as $restaurant): ?>
            <tr>
                <td><?= htmlspecialchars($restaurant->getId()) ?></td>
                <td><?= htmlspecialchars($restaurant->getLocation()) ?></td>
                <td><?= htmlspecialchars($restaurant->getPrice()) ?></td>
                <td><?= htmlspecialchars($restaurant->getSeats()) ?></td>
                <td><?= htmlspecialchars($restaurant->getStartDate()) ?></td>
                <td><?= htmlspecialchars($restaurant->getEndDate()) ?></td>
                <td><a href="edit_restaurant.php?id=<?= $restaurant->getId() ?>" class="btn btn-primary">Edit</a></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No restaurants found.</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</div>

<?php include __DIR__ . '/../../general_views/footer.php'; ?>


    

<?php include __DIR__ . '/../../general_views/footer.php'; ?>
