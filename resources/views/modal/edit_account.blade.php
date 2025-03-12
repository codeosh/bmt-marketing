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

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
