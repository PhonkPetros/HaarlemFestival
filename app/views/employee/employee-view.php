<?php include __DIR__ . '/../general_views/employeeheader.php'; ?>

<div class="container-wrapper">
    <div class="container">
        <h1>Scan QR Codes</h1>
        <div class="section">
            <div id="my-qr-reader"></div>
            <button id="start-scan-btn">Start Scanning</button>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="script.js"></script>
<script src="/js/qrscanner.js"></script>

<?php include __DIR__ . '/../general_views/footer.php'; ?>
