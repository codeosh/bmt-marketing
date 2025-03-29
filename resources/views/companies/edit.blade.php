<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Company</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            input,
            select,
            textarea {
                height: 48px;
            }

            .close-btn {
                position: absolute;
                top: 10px;
                right: 20px;
                font-size: 24px;
                font-weight: bold;
                color: #000;
                text-decoration: none;
                z-index: 1000;
            }

            .close-btn:hover {
                color: red;
                cursor: pointer;
            }

            .form-wrapper {
                position: relative;
            }
        </style>
    </head>

    <body>
        <div class="container mt-4 rounded shadow-lg form-wrapper">
            <!-- Close Button -->
            <a class="close-btn" onclick="handleClose()">&times;</a>

            <div class="row p-4">
                <div class="col-md-12">
                    <div class="p-4">
                        <form action="{{ route('admin-prospects.update', $company->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 bg-dark py-1">
                                    <h2 class="mx-4 text-light">Contact Information</h2>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="industry_group" class="form-label">Industry/Group</label>
                                    <input type="text" name="industry_group" class="form-control"
                                        value="{{ $company->industry_group }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="{{ $company->company_name }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="contact_person" class="form-label">Contact Person</label>
                                    <input type="text" name="contact_person" class="form-control"
                                        value="{{ $company->contact_person }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="contact_number" class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control"
                                        value="{{ $company->contact_number }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ $company->email }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ $company->address }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="other_digi_contact_platform" class="form-label">Other Digi-Contact
                                        Platform</label>
                                    <input type="text" name="other_digi_contact_platform" class="form-control"
                                        value="{{ $company->other_digi_contact_platform }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="terms_of_payment" class="form-label">Terms of Payment</label>
                                    <input type="text" name="terms_of_payment" class="form-control"
                                        value="{{ $company->terms_of_payment }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" {{ $company->status == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ $company->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 bg-dark py-1">
                                    <h2 class="text-light mx-4">Actions & Remarks</h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control">{{ $company->notes }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control">{{ $company->description }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div>
                                        <input type="hidden" name="contacted" value="0">
                                        <label>
                                            <input type="checkbox" name="contacted" value="1"
                                                {{ $company->contacted == 1 ? 'checked' : '' }}> Contacted
                                        </label>
                                        <input type="hidden" name="to_recontact" value="0">
                                        <label>
                                            <input type="checkbox" name="to_recontact" value="1"
                                                {{ $company->to_recontact == 1 ? 'checked' : '' }}> To ReContact
                                        </label>
                                        <input type="hidden" name="to_email" value="0">
                                        <label>
                                            <input type="checkbox" name="to_email" value="1"
                                                {{ $company->to_email == 1 ? 'checked' : '' }}> To Email
                                        </label>
                                        <input type="hidden" name="to_propose" value="0">
                                        <label>
                                            <input type="checkbox" name="to_propose" value="1"
                                                {{ $company->to_propose == 1 ? 'checked' : '' }}> To Propose
                                        </label>
                                        <input type="hidden" name="visited" value="0">
                                        <label>
                                            <input type="checkbox" name="visited" value="1"
                                                {{ $company->visited == 1 ? 'checked' : '' }}> Visited
                                        </label>
                                        <input type="hidden" name="ec_ordered1" value="0">
                                        <label>
                                            <input type="checkbox" name="ec_ordered1" value="1"
                                                {{ $company->ec_ordered1 == 1 ? 'checked' : '' }}> EC Ordered 1
                                        </label>
                                        <input type="hidden" name="problematic" value="0">
                                        <label>
                                            <input type="checkbox" name="problematic" value="1"
                                                {{ $company->problematic == 1 ? 'checked' : '' }}> Problematic
                                        </label>
                                        <input type="hidden" name="acct_active" value="0">
                                        <label>
                                            <input type="checkbox" name="acct_active" value="1"
                                                {{ $company->acct_active == 1 ? 'checked' : '' }}> Acct-Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-light w-25"
                                style="margin-left: 900px;border: 1px solid #dee2e6; letter-spacing: 2px;">UPDATE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>

<script>
    //close window
    function handleClose() {
        window.history.back();
    }

    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonColor: '#3085d6',
        });
    @endif

    @if (session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonColor: '#3085d6',
        });
    @endif
</script>
