<?php include __DIR__ . '/../general_views/adminheader.php'; ?>

<div class="content">
    <h1>Manage Festival Events</h1>
    <p style="font-size: 20px">Click on the event you want to manage to modify or add event details, prices, available slots, etc.</p>
    <p style="font-size: 20px; padding-bottom: 20px;">To edit the content of a page, please go to the edit festival page.</p>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">
                        <button class="btn btn-dark" style="margin: 20px; padding: 10px;">Add a new event</button>
                    </th>
                </tr>
                <tr>
                    <th>Events</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allEvents as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['name']); ?></td>
                        <td>
                            <a href="/manage-event-details/editDetails?id=<?php echo htmlspecialchars($event['event_id']); ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>
