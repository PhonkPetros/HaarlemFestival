document.addEventListener('DOMContentLoaded', function() {
    if (response && response.length > 0) {
        response.forEach(function(resp) {
            var modalType = resp.success ? 's_modal' : 'e_modal';
            var modal = document.querySelector('.' + modalType);
            var modalWrapper = document.querySelector('.modal_wrapper');
            modal.querySelector('.s_text p').textContent = resp.message;
            modalWrapper.classList.add('active');
            modal.classList.add('active');

            modal.querySelector('.close').addEventListener('click', function() {
                modal.classList.remove('active');
                modalWrapper.classList.remove('active');
            });
        });
    }
});