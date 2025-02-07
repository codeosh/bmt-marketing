<!-- Edit replyTemplate Modal -->
<div class="modal fade" id="editReplyModal" tabindex="-1" aria-labelledby="editPricelistModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPricelistModalLabel">Edit Reply Templates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editReplyForm">
                    <input type="hidden" id="editReplyId">

                    <div class="mb-3">
                        <label for="editPricelistName" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="editReplyName" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPricelistContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editReplyContent" rows="4" required></textarea>
                    </div>

                    <button type="submit" id="editsaveBtnReply" class="btn btn-primary">
                    <span id="editbuttonTextReply">{{ __('Save Changes') }}</span>
                    <span id="editbuttonSpinnerReply" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>