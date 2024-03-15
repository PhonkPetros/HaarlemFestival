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
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Section added successfully!');
                    window.location.reload(); 
                } else {
                    alert('Failed to add section.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});