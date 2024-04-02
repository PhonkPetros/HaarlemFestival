document.addEventListener('DOMContentLoaded', function() {
    fetchUsers();
    setupEventListeners();
});

function fetchUsers(sortParam = '') {
    let url = '/admin/fetch-all-users';
    if (sortParam) {
        url += `?sort=${sortParam}`;
    }
    
    fetch(url, {
        method: 'GET',
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
            <td>${user.email}</td>
            <td>${user.created_at}</td>
            <td>
                <button onclick="openEditUserModal('${user.user_id}','${user.username}', '${user.email}', '${user.role}')" class="btn btn-primary btn-sm">Edit</button>
                <button onclick="deleteUser(${user.user_id})" class="btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>`;
        tableBody.innerHTML += row;
    });
}


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
    swal({
        title: "Are you sure?",
        text: `Do you want to delete user ${userId}? This action cannot be undone.`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            let formData = new FormData();
            formData.append('user_id', userId);

            fetch('/admin/delete-user', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to delete user');
                return response.json();
            })
            .then(() => {
                swal("User deleted successfully", {
                    icon: "success",
                }).then(() => {
                    fetchUsers(); 
                });
            })
            .catch(error => {
                console.error('Error:', error);
                swal("Error", "Error deleting user.", "error");
            });
        }
    });
}



