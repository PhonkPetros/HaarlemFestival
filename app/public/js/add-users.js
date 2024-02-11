function setupEventListeners() {
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

    var openModalBtn = document.getElementById('openAddUserModal');
    var addUserModal = document.getElementById('addUserModal');
    var closeModalBtn = document.querySelector('.modal .closeBtn');

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

    var addUserForm = document.getElementById('addUserForm');
    addUserForm.addEventListener('submit', function(event) {
        event.preventDefault();
        var password = document.querySelector('input[name="password"]').value;
        var confirmPassword = document.querySelector('input[name="confirmPassword"]').value;
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }
        
        function submitAddUserForm(){
            var username = document.getElementById('newUsername').value;
            var email = document.getElementById('newUserEmail').value;
            var role = document.getElementById('newUserRole').value;
            var password = document.getElementById('newUserPassword').value;

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
                addUserModal.style.display = 'none'; 
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating new user.');
            });
        }
        submitAddUserForm();
    });
}