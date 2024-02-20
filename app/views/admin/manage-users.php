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
        <button id="openAddUserModal" type="button" class="btn btn-secondary" title="Create New User">Create New User</button>
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
                    <th >Actions</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="closeBtn">&times;</span>
            <h2>Add New User</h2>
            <form id="addUserForm">
                <input type="text" id="newUsername" name="username" placeholder="Username" required>
                <input type="email" id="newUserEmail" name="email" placeholder="Email" required>
                <select id="newUserRole" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
                <input type="password" id="newUserPassword" name="password" placeholder="Password" required>
                <input type="password" id="confirmUserPassword" name="confirmPassword" placeholder="Confirm Password" required>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>
    <div id="editUserModal" class="modal">
    <div class="modal-content">
        <span class="closeBtn">&times;</span>
        <h2>Edit User Details</h2>
        <form id="editUserForm" class="modal-form">
            <input type="hidden" id="editUserId" name="userId">
            <div class="form-group">
                <label for="editUsername" style="margin-right: 10px;">Username:</label>
                <input type="text" id="editUsername" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="editUserEmail" style="margin-right: 10px;">Email:</label>
                <input type="email" id="editUserEmail" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="editUserRole" style="margin-right: 10px;">Role:</label>
                <select id="editUserRole" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
            </div>
            <button type="submit">Update User</button>
        </form>
    </div>
</div>
</div>

</div>

<script src="/js/manage-users.js"></script>
<script src="/js/add-users.js"></script>
<script src="/js/edit-users.js"></script>


<?php include __DIR__ . '/../general_views/footer.php'; ?>
