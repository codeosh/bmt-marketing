@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Accounts')

@section('content')

        {{-- Add Accounts --}}
        <div class="addAccount d-flex align-items-center justify-content-end mb-2">
            <button type="button" class="btn btn-success saveButton" data-bs-toggle="modal" data-bs-target="#addAccountModal" style="font-size:0.8rem;">
                <i class="fa-solid fa-plus" style="margin-right: 5px;"></i> 
                <small>Add Account</small>
            </button>
        </div>

        <!-- Table -->
        <div class="accounts-container table-responsive border rounded p-3">
            <table class="table table-hover align-middle">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Email</th>
                        <th class="px-3 py-2">Role</th>
                    </tr>
                </thead>
                <tbody class="bg-light">
                    <tr>
                        <td class="px-3 py-2">John Doe</td>
                        <td class="px-3 py-2">john.doe@example.com</td>
                        <td class="px-3 py-2"><span class="badge bg-success">Admin</span></td>
                    </tr>
                    <tr>
                        <td class="px-3 py-2">Jane Smith</td>
                        <td class="px-3 py-2">jane.smith@example.com</td>
                        <td class="px-3 py-2"><span class="badge bg-primary">User</span></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Add Account Modal -->
        <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-black">
                        <h5 class="modal-title" id="addAccountModalLabel">Add New Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Confirm Password</label>
                                        <input type="confirmPassword" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection