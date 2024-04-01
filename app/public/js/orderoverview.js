$(document).on('click', 'tr', function (e) {
    if (e.target.type == "checkbox") {
        return;
    }

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

$(document).on('click', '.btn-export', function (e) {
    const checkedCheckboxes = $("table input[type='checkbox']:checked");
    const orderIds = [];

    for (let i = 0; i < checkedCheckboxes.length; i++) {
        orderIds.push(checkedCheckboxes[i].getAttribute("data-orderid"));
    }

    const formData = new FormData();
    formData.append('orderIds', orderIds.join(','));
    fetch(`/admin/order-overview/export`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(new Blob([blob]));

        const a = document.createElement('a');
        a.href = url;
        a.download = 'ordersContent.xls';

        document.body.appendChild(a);
        a.click();

        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    });
});

$(document).on('click', '.modal .btn-close', function (e) {
    e.target.closest('.modal').style.display = 'none';
});