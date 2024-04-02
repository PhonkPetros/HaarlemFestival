<div id="editUserModal" class="modal">
        <div class="modal-content" style="width: 450px">
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