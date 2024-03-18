<div class="container mt-4 item-container">
    <h3>Select Payment Method</h3>
    <div class="row">

        <div class="col-sm-6 mb-3">
            <div class="payment-option card shadow-sm">
                <label for="ideal-banks" class="payment-label d-flex align-items-center">
                    <img src="/../img/IDEAL_Logo.png" class="img-fluid" alt="iDEAL">
                    <select id="ideal-banks" name="paymentMethod" class="form-control">
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
<button class="btn btn-success" style="width: 100%; padding: 10px; margin-top: 20px;"><h3>Check out</h3></button>


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
.payment-option{
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
