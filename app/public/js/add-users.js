function validateAndSubmitAddUserForm() {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
    if (password !== confirmPassword) {
        swal("Error", "Passwords do not match.", "error");
        return;
    }
    submitAddUserForm();
}

function submitAddUserForm() {
    const username = document.getElementById('newUsername').value;
    const email = document.getElementById('newUserEmail').value;
    const role = document.getElementById('newUserRole').value;
    const password = document.getElementById('newUserPassword').value;

    let formData = new FormData();
    formData.append('username', username);
    formData.append('email', email);
    formData.append('role', role);
    formData.append('password', password);

    fetch('/admin/add-user', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to add user');
        }
        return response.json();
    })
    .then(() => {
        swal("Success", "User has been added", "success").then(() => {
            fetchUsers();
            document.getElementById('addUserModal').style.display = 'none';
        });
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "Error creating new user.", "error");
    });
}
