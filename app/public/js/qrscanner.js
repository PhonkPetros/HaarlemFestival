function domReady(fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

domReady(function () {
    function onScanSuccess(decodedText, decodedResult) {
        swal("Success!", "QR Code detected: " + decodedText, "success");
        const data = { qrCodeText: decodedText };

        fetch('/employee/dashboard', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            swal("Success!", "QR Code data sent successfully", "success");
            htmlscanner.clear();
        })
        .catch((error) => {
            console.error('Error:', error);
            swal("Error!", "Failed to send QR Code data", "error");
            htmlscanner.clear(); 
        });
    }

    let htmlscanner = new Html5QrcodeScanner("my-qr-reader", { fps: 10, qrbox: 250 });
    htmlscanner.render(onScanSuccess);
});
