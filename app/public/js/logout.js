
    function confirmLogout() {
        swal({
            title: "Are you sure?",
            text: "Do you want to log out?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willLogOut) => {
            if (willLogOut) {
                window.location.href = '/logout';
            }
        });
    }

