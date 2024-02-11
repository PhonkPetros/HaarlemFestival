<?php include __DIR__ . '/../general_views/header.php'; ?>

<style>
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
.table td, .table th {
    padding: 0.75rem;
}
#filterForm {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    gap: 10px;
}
#filterForm input, #filterForm select, #filterForm button {
    padding: 5px 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
#filterForm button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}
#filterForm button:hover {
    background-color: #0056b3;
}
#resetBtn {
    background-color: #6c757d;
}
#resetBtn:hover {
    background-color: #545b62;
}
.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.6); 
}
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: 5% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 40%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    animation-name: modalopen;
    animation-duration: 0.4s;
}
@keyframes modalopen {
    from {top: -300px; opacity: 0}
    to {top: 0; opacity: 1}
}
.closeBtn {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
}
.closeBtn:hover,
.closeBtn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
#addUserForm input[type=text],
#addUserForm input[type=email],
#addUserForm input[type=password],
#addUserForm select,
#addUserForm button {
    width: calc(100% - 20px);
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
#addUserForm button {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
#addUserForm button:hover {
    background-color: #45a049;
}

.modal-form input[type=text],
.modal-form input[type=email],
.modal-form select,
.modal-form button {
    width: calc(100% - 20px);
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
.modal-form button {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.modal-form button:hover {
    background-color: #45a049;
}
.modal-form .form-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.modal-form .form-group label {
    margin-bottom: 0; 
}

.modal-form input[type="text"],
.modal-form input[type="email"],
.modal-form select {
    flex-grow: 1; 
}


@media screen and (max-width: 600px) {
    .modal-content {
        width: 95%;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-secondary justify-content-center">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/admin/manage-users">Manage Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Manage Festival</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Edit Festival</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Orders</a>
        </li>
    </ul>
</nav>

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
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
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
