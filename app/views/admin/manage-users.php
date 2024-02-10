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
    .table td {
        padding: 0.75rem; 
    }
    .table th {
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
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary" title="Create New User">Create New User</button>
        </div>
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
</div>

<script src="/js/manage-users.js"></script>

<?php include __DIR__ . '/../general_views/footer.php'; ?>
