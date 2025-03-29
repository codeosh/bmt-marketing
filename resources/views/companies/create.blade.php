<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Company</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            input {
                height: 48px;
            }

            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background: none;
                border: none;
                font-size: 24px;
                cursor: pointer;
                color: #000;
            }

            .container {
                position: relative;
            }
        </style>
    </head>

    <body>
        <div class="container mt-1 bg-white shadow-lg p-3 w-55 rounded" id="prospectForm">
            <button class="close-btn" style="font-size: 35px; margin-right: 20px;" onclick="closeForm()">&times;</button>
            <h1 class="text-center mb-5" style="margin-right: 750px;">Add New Prospect Customer</h1>
            <form action="{{ route('admin-prospects.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 rounded">
                        <div class="mb-3">
                            <label for="industry_group" class="form-label">Industry/Group</label>
                            <input type="text" name="industry_group" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 rounded">
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact No</label>
                            <input type="text" name="contact_number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="other_digi_contact_platform" class="form-label">Other Digi-Contact
                                Platform</label>
                            <input type="text" name="other_digi_contact_platform" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="terms_of_payment" class="form-label">Terms of Payment</label>
                            <input type="text" name="terms_of_payment" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <div>
                                <label><input type="checkbox" name="contacted" value="1"> Contacted</label>
                                <label><input type="checkbox" name="to_recontact" value="1"> To
                                    ReContact</label>
                                <label><input type="checkbox" name="to_email" value="1"> To Email</label>
                                <label><input type="checkbox" name="to_propose" value="1"> To Propose</label>
                                <label><input type="checkbox" name="visited" value="1"> Visited</label>
                                <label><input type="checkbox" name="ec_ordered1" value="1"> EC Ordered 1</label>
                                <label><input type="checkbox" name="problematic" value="1"> Problematic</label>
                                <label><input type="checkbox" name="acct_active" value="1"> Acct-Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold" style="height: 48px;">ADD</button>
            </form>
        </div>


        <script>
            function closeForm() {
                window.location.href = "{{ route('admin-prospects.index') }}"; // Redirects to index page
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
    </body>

</html>
