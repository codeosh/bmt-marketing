{{-- resources\views\modal\edit_account.blade.php --}}
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-labelledby="editAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-black">
        <h5 class="modal-title" id="addAccountModalLabel">Edit Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editAccForm">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input id="name" class="form-control" type="text" name="name" required autofocus>
                <span class="text-danger" id="nameError"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" required>
                <span class="text-danger" id="emailError"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone number</label>
                <input id="phoneNumber" class="form-control" type="text" name="phoneNumber" required>
                <span class="text-danger" id="pNumberError"></span>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role" style="height:100%;">
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" style="height:100%;">
                  <option value="">Select status</option>
                  <option value="active">Active</option>
                  <option value="frozen">Frozen</option>
                  <option value="deactivated">Deactivated</option>
                </select>
              </div>
            </div>

          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" form="editAccForm">Save changes</button>
      </div>
    </div>
  </div>
</div>
