document.querySelectorAll('.delete-btn').forEach(function(button) {
    button.addEventListener('click', function(e) {
        var form = this.closest('form');
        swal({
            title: "Are you sure?",
            text: "Do you want to delete this Page? This action cannot be undone.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    });
});

var modal = document.getElementById('addPageModal');

var openModalBtn = document.getElementById('openModalBtn');

var closeModalBtn = document.getElementById('closeModalBtn');
var closeModalFooterBtn = document.getElementById('closeModalFooterBtn');

openModalBtn.addEventListener('click', function () {
    modal.style.display = 'block';
});

closeModalBtn.addEventListener('click', function () {
    modal.style.display = 'none';
});

closeModalFooterBtn.addEventListener('click', function () {
    modal.style.display = 'none';
});

window.addEventListener('click', function (e) {
    if (e.target == modal) {
        modal.style.display = 'none';
    }
});
