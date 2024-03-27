$(document).on('click', 'tr', function () {
    const orderDetailsModal = $("#orderDetailsModal")[0];
    const modalBody = $("#orderDetailsModal").find(".modal-body")[0];

    const orderItemId = $(this).find("th")[0].textContent;
    const order = ordersContent.find(order => order['order_item_id'] == orderItemId);

    console.log(order);
    const keys = Object.keys(order);
    console.log(keys);

    modalBody.innerHTML = "";

    for (let i = 0; i < keys.length; i++) {
        const value = order[keys[i]];

        if (value) {
            const title = keys[i].replaceAll("_", " ");
            modalBody.innerHTML += 
            `
            <div class="mb-3">
                <label for="${keys[i]}" class="form-label">${title}</label>
                <input type="text" class="form-control" id="${keys[i]}" name="${keys[i]}" value="${value}" disabled>
            </div>
            `
        }
        
    }

    orderDetailsModal.style.display = "block";
});