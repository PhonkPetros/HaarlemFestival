document.addEventListener('DOMContentLoaded', function () {
    updateTotalCartPrice();
});

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
            } else if (data.status === 'error') {
                alert(data.message);
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

function generateAndShareLink() {
    fetch('/get-share-link', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const shareableLink = data.link;
                const shareLink = document.getElementById('shareLink');
                shareLink.href = shareableLink;
                shareLink.style.display = 'inline';
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

function copyToClipboard(event) {
    const shareLink = document.getElementById('shareLink');
    event.preventDefault();
    navigator.clipboard.writeText(shareLink.href).then(function () {
        alert('Link copied to clipboard!');
    }, function (err) {
        console.error('Could not copy text: ', err);
    });
}
