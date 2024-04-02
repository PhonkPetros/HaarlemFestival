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
            swal("Error", data.message, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "An unexpected error occurred.", "error");
    });
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
            swal("Removed!", "The item was removed from your cart.", "success")
            .then(() => {
                window.location.reload();
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "Failed to delete item from cart.", "error");
    });
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
    event.preventDefault();
    const shareLink = document.getElementById('shareLink');
    navigator.clipboard.writeText(shareLink.href).then(function () {
        swal("Copied!", "Link copied to clipboard!", "success");
    }, function (err) {
        console.error('Could not copy text: ', err);
        swal("Error", "Could not copy link to clipboard.", "error");
    });
}