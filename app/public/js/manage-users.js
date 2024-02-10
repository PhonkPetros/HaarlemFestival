document.addEventListener('DOMContentLoaded', function() {
    fetchUsers();
});

function fetchUsers() {
    fetch('/admin/fetch-all-users', {
        method: 'POST',
    })
    .then(response => response.json())
    .then(data => {
        updateTable(data);
    })
    .catch(error => console.error('Error:', error));
}

function updateTable(data) {
    var tableBody = document.querySelector('.table tbody');
    tableBody.innerHTML = '';
    data.forEach(user => {
        var row = `<tr id="user-${user.user_id}">
            <td>${user.user_id}</td>
            <td>${user.username}</td>
            <td>${user.role}</td>
            <td>${user.e_mail}</td>
            <td>${user.registration_date}</td>
            <td>
                <a href="/admin/edit-user-form?user_id=${user.user_id}" class="btn btn-primary btn-sm">Edit</a>
                <button onclick="deleteUser('${user.user_id}')" class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>`;
        tableBody.innerHTML += row;
    });
}

document.getElementById('filterBtn').addEventListener('click', function() {
    var username = document.getElementById('username').value;
    var role = document.getElementById('role').value;
    filterUsers(username, role);
});

document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('username').value = '';
    document.getElementById('role').value = '';
    fetchUsers();
});

function filterUsers(username, role) {
    var formData = new FormData();
    formData.append('username', username);
    formData.append('role', role);

    fetch('/admin/filter-users', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        updateTable(data);
    })
    .catch(error => console.error('Error:', error));
}

function deleteUser(userId) {
    const confirmed = confirm(`Are you sure you want to delete user ${userId}?`);
    if (confirmed) {
        let formData = new FormData();
        formData.append('user_id', userId);

        fetch('/admin/delete-user', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                alert(`User ${userId} deleted.`);
                document.getElementById(`user-${userId}`).remove();
            } else {
                alert('Error deleting user.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
