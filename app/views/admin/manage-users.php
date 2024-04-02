<?php include __DIR__ . '/../general_views/adminheader.php'; ?>

<div class="content">
    <h1>Manage Users</h1>
    <br>
    <div id="filterForm">
        <input type="text" name="username" placeholder="Username" id="username">
        <select name="role" id="role">
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="customer">Customer</option>
            <option value="employee">Employee</option>
        </select>
        <button type="button" id="filterBtn">Filter</button>
        <button type="button" id="resetBtn">Reset</button>
        <button id="openAddUserModal" type="button" class="btn btn-secondary" title="Create New User">Create New
            User</button>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th><button data-sort="user_id" class="sorting-button">User ID</button></th>
                    <th><button data-sort="username" class="sorting-button">Username</button></th>
                    <th><button data-sort="role" class="sorting-button">Role</button></th>
                    <th><button data-sort="email" class="sorting-button">Email</button></th>
                    <th><button data-sort="registration_date" class="sorting-button">Registration Date</button></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <? include __DIR__ . '/components/addusermodal.php' ?>
    <? include __DIR__ . '/components/editusermodal.php' ?>
</div>

</div>

<script src="/js/manage-users.js"></script>
<script src="/js/add-users.js"></script>
<script src="/js/edit-users.js"></script>


<?php include __DIR__ . '/../general_views/footer.php'; ?>