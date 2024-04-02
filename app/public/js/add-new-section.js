document.addEventListener('DOMContentLoaded', function() {
    var addNewSectionBtn = document.getElementById('addNewSectionBtn');
    if (!addNewSectionBtn.disabled) {
        addNewSectionBtn.addEventListener('click', function() {
            var pageId = addNewSectionBtn.getAttribute('data-page-id');
            fetch('/admin/add-section', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    pageId: pageId
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to add section');
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    swal('Success!', 'Section added successfully!', 'success')
                    .then(() => {
                        window.location.reload();
                    });
                } else {
                    swal('Failed!', 'Failed to add section.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal('Error!', error.message, 'error');
            });
        });
    }
});
