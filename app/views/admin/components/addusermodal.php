<div id="addUserModal" class="modal">
        <div class="modal-content" style="width: 450px">
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
                <input type="password" id="confirmUserPassword" name="confirmPassword" placeholder="Confirm Password"
                    required>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>