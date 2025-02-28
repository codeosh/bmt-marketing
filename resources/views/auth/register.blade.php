 <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="registerForm" >
                        @csrf
                        <div class="modal-header text-black">
                            <h5 class="modal-title" id="addAccountModalLabel">Add New Account</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="successMessage" class="alert alert-success d-none"></div> <!-- Success message -->
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
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <span class="text-danger" id="passwordError"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        <span class="text-danger" id="passwordConfirmationError"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="saveBtn-register" form="registerForm" class="btn btn-primary">
                                <span id="buttonText-register">{{ __('Save') }}</span>
                                    <span id="buttonSpinner-register" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </div>
                            </button>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
