document.addEventListener('DOMContentLoaded', function() {
    var editUserModal = document.getElementById('editUserModal');
    var closeEditModalBtn = document.querySelector('#editUserModal .closeBtn');

    window.openEditUserModal = function(userId, username, email, role) {
        document.getElementById('editUserId').value = userId;
        document.getElementById('editUsername').value = username;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserRole').value = role;
    
        editUserModal.style.display = "block";
    };

    closeEditModalBtn.onclick = function() {
        editUserModal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == editUserModal) {
            editUserModal.style.display = "none";
        }
    };

    var editUserForm = document.getElementById('editUserForm');
    editUserForm.onsubmit = function(event) {
        event.preventDefault();
        submitEditUserForm();
    };

    function submitEditUserForm(){
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
            return response.text().then(text => {
                throw new Error('Non-JSON response from server: ' + text);
            });
        })
        .then(() => {
            alert('User has been edited');
            fetchUsers(); 
            editUserModal.style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating user. ' + error);
        });
    }
});
