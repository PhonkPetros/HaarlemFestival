document.addEventListener('DOMContentLoaded', function() {
    var editUserModal = document.getElementById('editUserModal');
    var closeEditModalBtn = document.querySelector('#editUserModal .closeBtn');

    window.openEditUserModal = function(userId, username, email, role) {
        document.getElementById('editUserId').value = userId;
        document.getElementById('editUsername').value = username;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
    
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.style.display = "block";
    };
    
    var closeEditModalBtn = document.querySelector('#editUserModal .closeBtn');
    closeEditModalBtn.onclick = function() {
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.style.display = "none";
    };
    
    window.onclick = function(event) {
        var editUserModal = document.getElementById('editUserModal');
        if (event.target == editUserModal) {
            editUserModal.style.display = "none";
        }
    };
});

function submitEditUserForm() {
    var userId = document.getElementById('editUserId').value;
    var username = document.getElementById('editUsername').value;
    var email = document.getElementById('editUserEmail').value;
    var role = document.getElementById('editUserRole').value;
    let formData = new FormData();
    formData.append('user_id', userId);
    formData.append('username', username);
    formData.append('email', email);
    formData.append('role', role);

    fetch('/admin/edit-user', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) return response.json();
        return Promise.reject('Failed to edit user');
    })
    .then(data => {
        if(data.success) {
            swal('Success!', 'User has been edited', 'success');
            fetchUsers();
            document.getElementById('editUserModal').style.display = 'none';
        } else {
            throw new Error(data.message || 'Failed to edit user');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", error.message || 'Error editing user.', "error");
    });
}