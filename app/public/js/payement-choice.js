document.addEventListener('DOMContentLoaded', function () {
    var checkoutButton = document.getElementById('checkout-button');
    checkoutButton.addEventListener('click', function () {
        var paymentMethodElement = document.querySelector('.payment-method');
        var paymentMethod = paymentMethodElement.value;
        var issuerElement = document.getElementById('ideal-banks');
        var issuer = paymentMethod === 'ideal' ? issuerElement.value : null;

        var dataToSend = {
            paymentMethod: paymentMethod,
            issuer: issuer 
        };


        fetch('/create-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(dataToSend)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.paymentUrl;
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: Could not initiate payment.');
            });
    });
});