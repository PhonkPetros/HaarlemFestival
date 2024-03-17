updateTotalCartPrice();
function modifyItemQuantity(ticketId, eventId, change) {
    fetch('/modifyQuantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ticketId, eventId, change })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.querySelector(`#quantity-${ticketId}`).textContent = data.newQuantity;
                document.querySelector(`#total-price-${ticketId}`).textContent = data.newTotalPrice.toFixed(2);
                updateTotalCartPrice();
            }
        })

        .catch(error => console.error('Error:', error));
}

function deleteItemFromCart(ticketId, eventId) {
    fetch('/deleteItem', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ticketId, eventId })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.querySelector(`#ticket-container-${ticketId}`).remove();
                updateTotalCartPrice();
            }
        })
        .catch(error => console.error('Error:', error));
}

function updateTotalCartPrice() {
    fetch('/getTotalCartPrice', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('total-cart-price').textContent = data.totalCartPrice.toFixed(2);
            }
        })
        .catch(error => console.error('Error:', error));
}
