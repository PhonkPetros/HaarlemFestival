function domReady(fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

domReady(function () {
    let isScanning = false;

    let htmlscanner = new Html5QrcodeScanner("my-qr-reader", { fps: 10, qrbox: 250 }, false);
    
    function onScanSuccess(decodedText, decodedResult) {
        if (!isScanning) return;
        isScanning = false;
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
            if (data.success) {
                swal("Success!", "QR Code processed successfully: " + decodedText, "success");
            } else {
                if (data.message === "Ticket has already been scanned.") {
                    swal("Notice!", data.message, "warning");
                } else {
                    swal("Error!", data.message, "error");
                }
            }
            htmlscanner.clear(); // Clear QR code scanner drawing regardless of the outcome
        })
        .catch((error) => {
            console.error('Error:', error);
            swal("Error!", "Failed to send QR Code data", "error");
            htmlscanner.clear(); // Clear QR code scanner drawing on error
        });
    }
    
    

    function startScanning() {
        if (!isScanning) {
            isScanning = true;
            htmlscanner.render(onScanSuccess);
        }
    }

    // Add event listener to your scan button
    document.getElementById('start-scan-btn').addEventListener('click', startScanning);
});
