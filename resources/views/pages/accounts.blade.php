@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Accounts')

@section('content')

  {{-- Add Accounts --}}
  <div class="addAccount d-flex align-items-center justify-content-end mb-2">
    <button type="button" class="btn btn-success saveButton" data-bs-toggle="modal" data-bs-target="#addAccountModal"
      style="font-size:0.8rem;">
      <i class="fa-solid fa-plus" style="margin-right: 5px;"></i>
      <small>Add Account</small>
    </button>
  </div>

  <!-- Table -->
  <div class="accounts-container table-responsive border rounded p-3" style="height:80vh;">
    <table class="table table-hover align-middle overflow-auto custom-scrollbar">
      <thead class="text-white">
        <tr>
          <th class="px-3 py-2">Name</th>
          <th class="px-3 py-2">Phone No.</th>
          <th class="px-3 py-2">Email</th>
          <th class="px-3 py-2">Role</th>
          <th class="px-3 py-2">Status</th>
          <th class="px-3 py-2">Action</th>
        </tr>
      </thead>
      <tbody class="bg-light">
        @foreach ($accounts as $account)
          <tr>
            <td class="px-3 py-2">{{ $account->name }}</td>
            <td class="px-3 py-2">{{ $account->phoneNumber }}</td>
            <td class="px-3 py-2">{{ $account->email }}</td>
            <td class="px-3 py-2"><span class="badge bg-success">{{ $account->role }}</span></td>
            <td class="px-3 py-2"><span class="badge bg-success">{{ $account->status }}</span></td>
            <td class="px-3 py-2">
              <div class="d-flex gap-2">
                <!-- Edit -->
                <div class="editButton d-flex align-items-center justify-content-center">
                  <button type="button" class="btn btn-primary editAccBtn"
                    style="font-size:0.6rem; width:100px; height:25px; border-radius:3px" data-id="{{ $account->id }}">
                    <i class="fa-regular fa-pen-to-square" style="margin-right: 5px;"></i>Edit
                  </button>
                </div>

                <!-- Delete -->
                <div class="deleteButton d-flex align-items-center justify-content-center">
                  <button type="button" class="btn btn-danger"
                    style="font-size:0.6rem; width:100px; height:25px; border-radius:3px" id="deleteAccBtn"
                    data-id="{{ $account->id }}">
                    <i class="fa-solid fa-trash" style="margin-right: 5px;"></i>Delete
                  </button>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
      {{ $accounts->links('pagination::bootstrap-5') }}
    </div>
  </div>


  <!-- Add Account Modal -->
  @include('modal.edit_account')
  @include('auth.register')

  <script src="{{ asset('js/register.js') }}"></script>



@endsection
