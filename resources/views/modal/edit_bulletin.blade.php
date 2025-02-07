<!-- Edit Bulletin Modal -->
<div class="modal fade" id="editBulletinModal" tabindex="-1" aria-labelledby="editBulletinModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBulletinModalLabel">Edit Bulletin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBulletinForm">
                    <input type="hidden" id="editBulletinId">

                    <div class="mb-3">
                        <label for="editBulletinName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="editBulletinName" required>
                    </div>

                    <div class="mb-3">
                        <label for="editBulletinContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editBulletinContent" rows="4" required></textarea>
                    </div>

                    <button type="submit" id="editsaveBtnBulletin" class="btn btn-primary">
                    <span id="editbuttonTextBulletin">{{ __('Save Changes') }}</span>
                    <span id="editbuttonSpinnerBulletin" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>