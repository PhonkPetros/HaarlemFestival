<div class="container mt-4 item-container" style="margin-top: 20px;">
    <h3>Select Payment Method</h3>
    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="payment-option card shadow-sm" style="background-color: white; border: 1px black; padding: 12px;">
                <label for="ideal-banks" class="payment-label d-flex align-items-center" style="display: flex; align-items: center;">
                    <img src="/../img/IDEAL_Logo.png" class="img-fluid" alt="iDEAL" style="max-width: 80px; height: auto; margin-right: 10px;">
                    <select id="ideal-banks" name="paymentMethod" class="form-control payment-method" style="background-color: white; -webkit-appearance: none; -moz-appearance: none; appearance: none; padding: 5px 10px; cursor: pointer;">
                        <option value="">Choose a Bank</option>
                        <option value="abn_amro">ABN AMRO</option>
                        <option value="ing">ING</option>
                        <option value="rabobank">Rabobank</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-sm-6 mb-3">
            <div class="payment-option card shadow-sm" style="background-color: white; border: 1px black; padding: 12px;">
                <button type="button" class="payment-label d-flex align-items-center" style="width: 100%; border: none; background: transparent; padding: 10px; text-align: left;">
                    <img class="img-fluid" src="/../img/visa.jpg" alt="Credit / Debit card" style="max-width: 80px; height: auto; margin-right: 10px;">
                    <span>Credit / Debit card</span>
                </button>
            </div>
        </div>
    </div>
</div>
<button id="checkout-button" class="btn btn-success" style="width: 100%; padding: 10px; margin-top: 20px;">
    <h3>Check out</h3>
</button>


<script src="/js/payement-choice.js"></script>