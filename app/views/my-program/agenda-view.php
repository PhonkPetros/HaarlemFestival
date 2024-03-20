<div class="container mt-4 item-container">
    <div class="row justify-content-between align-items-center mb-3 ">
        <div class="col-auto">
            <h3 style="text-decoration: underline;">Agenda</h3>
        </div>
    </div>

    <?php if (empty ($structuredOrderedItems)): ?>
        <div style="justify-content: center; text-align: center; color: black;">
            <h2>No Ticket Have Been Purchased.</h2>
        </div>
    <?php endif; ?>

    <div id="calendar" class="row row-cols-1 row-cols-md-8 g-9"></div>

    <div id="successPopup" class="modal" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div id="successPopupContent">
                        <div class="checkmark-circle">
                            <div class="background"></div>
                        </div>
                        <h3></h3>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>