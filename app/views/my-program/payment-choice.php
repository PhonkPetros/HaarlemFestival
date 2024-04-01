<div class="container mt-4 item-container">
    <h3>Select Payment Method</h3>
    <div class="row">

        <div class="col-sm-6 mb-3">
            <div class="payment-option card shadow-sm">
                <label for="ideal-banks" class="payment-label d-flex align-items-center">
                    <img src="/../img/IDEAL_Logo.png" class="img-fluid" alt="iDEAL">
                    <select id="ideal-banks" name="paymentMethod" class="form-control payment-method">
                        <option value="">Choose a Bank</option>
                        <option value="abn_amro">ABN AMRO</option>
                        <option value="ing">ING</option>
                        <option value="rabobank">Rabobank</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="payment-option card shadow-sm">
                <button type="button" class="payment-label d-flex align-items-center">
                    <img class="img-fluid" src="/../img/visa.jpg" alt="Credit / Debit card">
                    <span>Credit / Debit card</span>
                </button>
            </div>
        </div>
    </div>
</div>
<button id="checkout-button" class="btn btn-success" style="width: 100%; padding: 10px; margin-top: 20px;">
    <h3>Check out</h3>
</button>


<script>
document.addEventListener('DOMContentLoaded', function () {
    var checkoutButton = document.getElementById('checkout-button');

    checkoutButton.addEventListener('click', function () {
        fetchTicketsInfo(initiatePayment);
    });
});

function fetchTicketsInfo(callback) {
    fetch('/payment/get-tickets-info', {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        var paymentMethodElement = document.querySelector('.payment-method');
        var paymentMethod = paymentMethodElement.value;
        var issuerElement = document.getElementById('ideal-banks');
        // Determine if an issuer is needed based on the payment method
        var issuer = paymentMethod === 'ideal' ? issuerElement.value : null;

        // Construct the data to send including ticketsInfo fetched
        var dataToSend = {
            paymentMethod: paymentMethod,
            issuer: issuer,
            ticketsInfo: data // The fetched data is directly used here
        };

        callback(dataToSend);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: Could not retrieve ticket information.');
    });
}

function initiatePayment(dataToSend) {
    fetch('/create-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dataToSend)
    })
    .then(response => response.json())
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
}
</script>


<style>
    .payment-label img {
        max-width: 80px;
        height: auto;
        margin-right: 10px;
    }

    .form-control {

        background-color: white;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .payment-option {
        background-color: white;
        border: 1px black;
        padding: 12px;
    }

    .payment-option button {
        width: 100%;
        border: none;
        background: transparent;
        padding: 10px;
        text-align: left;
    }

    .payment-option button:hover {
        background-color: #f2f2f2;
    }
</style>