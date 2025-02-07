<!-- Edit Post Template Modal -->
<div class="modal fade" id="editPostTemplateModal" tabindex="-1" aria-labelledby="editPostTemplateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostTemplateModalLabel">Edit Post Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPostTemplateForm">
                    <input type="hidden" id="editPostTemplateId">

                    <div class="mb-3">
                        <label for="editPostTemplateName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="editPostTemplateName" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPostTemplateContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editPostTemplateContent" rows="4" required></textarea>
                    </div>

                    <button type="submit" id="editsaveBtnPostTemplate" class="btn btn-primary">
                    <span id="editbuttonTextPostTemplate">{{ __('Save Changes') }}</span>
                    <span id="editbuttonSpinnerPostTemplate" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>