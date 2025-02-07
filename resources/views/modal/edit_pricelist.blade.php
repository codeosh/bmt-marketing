<!-- Edit Pricelist Modal -->
<div class="modal fade" id="editPricelistModal" tabindex="-1" aria-labelledby="editPricelistModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPricelistModalLabel">Edit Pricelist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPricelistForm">
                    <input type="hidden" id="editPricelistId">

                    <div class="mb-3">
                        <label for="editPricelistName" class="form-label">Bulletin Name</label>
                        <input type="text" class="form-control" id="editPricelistName" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPricelistContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editPricelistContent" rows="4" required></textarea>
                    </div>

                  <button type="submit" id="editsaveBtnPricelist" class="btn btn-primary">
                    <span id="editbuttonTextPricelist">{{ __('Save Changes') }}</span>
                    <span id="editbuttonSpinnerPricelist" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>