function setupEventListeners() {
    setupFilterButton();
    setupResetButton();
    setupModalControls();
    setupAddUserFormSubmission();
}

function setupFilterButton() {
    document.getElementById('filterBtn').addEventListener('click', function() {
        const username = document.getElementById('username').value;
        const role = document.getElementById('role').value;
        filterUsers(username, role);
    });
}

function setupResetButton() {
    document.getElementById('resetBtn').addEventListener('click', function() {
        document.getElementById('username').value = '';
        document.getElementById('role').value = '';
        fetchUsers();
    });
}

function setupModalControls() {
    const openModalBtn = document.getElementById('openAddUserModal');
    const addUserModal = document.getElementById('addUserModal');
    const closeModalBtn = document.querySelector('.modal .closeBtn');

    openModalBtn.addEventListener('click', function() {
        addUserModal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', function() {
        addUserModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === addUserModal) {
            addUserModal.style.display = 'none';
        }
    });
}

function setupAddUserFormSubmission() {
    const addUserForm = document.getElementById('addUserForm');
    addUserForm.addEventListener('submit', function(event) {
        event.preventDefault();
        validateAndSubmitAddUserForm();
    });
}

function validateAndSubmitAddUserForm() {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
    if (password !== confirmPassword) {
        alert("Passwords do not match.");
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
        if (response.ok) return response.json();
        return Promise.reject('Failed to add user');
    })
    .then(() => {
        alert('User has been added');
        fetchUsers();
        document.getElementById('addUserModal').style.display = 'none'; 
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating new user.');
    });
}
