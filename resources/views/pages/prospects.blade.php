@extends('admin.admin-dashboard')

@section('title', 'BMTMarketing - Prospects')
<style>
    /* Ensure table is responsive */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    /* Set width for the checkbox column (preserving its original space) */
    th:first-child,
    td:first-child {
        width: 50px;
        /* Keep space for the checkbox */
        min-width: 50px;
        max-width: 50px;
        text-align: center;
    }

    /* Ensure the Actions column has enough space */
    th:nth-child(2),
    td:nth-child(2) {
        width: 80px;
        min-width: 80px;
        max-width: 80px;
        text-align: center;
    }

    /* Expand the important columns to take full screen width */
    th:nth-child(3),
    td:nth-child(3),
    /* Company Name */
    th:nth-child(4),
    td:nth-child(4),
    /* Contact Person */
    th:nth-child(5),
    td:nth-child(5),
    /* Contact No */
    th:nth-child(6),
    td:nth-child(6),
    /* Email */
    th:nth-child(7),
    td:nth-child(7),
    /* Address */
    th:nth-child(8),
    td:nth-child(8),
    /* Notes */
    th:nth-child(9),
    td:nth-child(9)

    /* Status */
        {
        min-width: 90px;
        /* Ensures they take up full space */
        max-width: 90px;
        width: auto;
        /* Let it adjust dynamically */
        white-space: nowrap;
    }

    /* Keep other columns scrollable */
    th,
    td {
        min-width: 80px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Ensure table fits in larger screens */
    @media (min-width: 1200px) {

        th:nth-child(3),
        td:nth-child(3),
        th:nth-child(4),
        td:nth-child(4),
        th:nth-child(5),
        td:nth-child(5),
        th:nth-child(6),
        td:nth-child(6),
        th:nth-child(7),
        td:nth-child(7),
        th:nth-child(8),
        td:nth-child(8),
        th:nth-child(9),
        td:nth-child(9) {
            min-width: 187px;
        }
    }

    /* Print styles */
    @media print {
        body * {
            visibility: hidden;
        }

        #companiesTable,
        #companiesTable * {
            visibility: visible;
        }

        #companiesTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@section('content')
    <div style="width: 1500px; padding: 10px;">
        <!-- Title Section -->
        <div class="row">
            <div class="col-12 text-center text-md-left justifi-content-end">
                <h3><i class="fas fa-user me-2"></i>Prospects List</h3>
            </div>
        </div>

        <!-- Search Bar & Action Buttons -->
        <div class="row align-items-center mt-5">
            <!-- Search Bar (Left Side) -->
            <div class="col-md-6 mb-2">
                <div class="position-relative" style="max-width: 460px;">
                    <i class="fas fa-search"
                        style="position: absolute; top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                    <input type="text" id="mainSearchBar" class="form-control" placeholder="Search"
                        style="height: 48px; padding-left: 40px;">
                </div>
            </div>

            <!-- Buttons (Right Side) -->
            <div class="col-md-6 d-flex justify-content-md-end justify-content-center gap-2">
                <a href="{{ route('admin-prospects.create') }}" class="btn btn-light" style="border: 1px solid #dee2e6;">
                    <i class="fas fa-plus mx-2"></i>
                </a>
                <!-- Print Button -->
                <button type="button" class="btn btn-light" style="border: 1px solid #dee2e6;" id="printSelectedBtn">
                    <i class="fas fa-print"></i> Selected
                </button>
                <!-- New Print All Button -->
                <button type="button" class="btn btn-light" style="border: 1px solid #dee2e6;" id="printAllBtn">
                    <i class="fas fa-print"></i> All
                </button>
                <!-- Settings -->
                <button type="button" class="btn btn-light" style="border: 1px solid #dee2e6;" id="settingsBtn">
                    <i class="fas fa-cog"></i>
                </button>
                <form id="deleteForm" action="{{ route('companies.deleteSelected') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Delete -->
                    <input type="hidden" name="selected_ids" id="selectedIdsInput">
                    <button type="button" class="btn btn-light" style="border: 1px solid #dee2e6;" id="deleteSelectedBtn">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Status Filter Checkboxes -->
        <div class="row mt-3">
            <div class="col-12 d-flex flex-wrap gap-2">
                <label><input type="checkbox" class="statusFilter" value="Contacted"> Contacted</label>
                <label><input type="checkbox" class="statusFilter" value="To ReContact"> To ReContact</label>
                <label><input type="checkbox" class="statusFilter" value="To Email"> To Email</label>
                <label><input type="checkbox" class="statusFilter" value="To Propose"> To Propose</label>
                <label><input type="checkbox" class="statusFilter" value="Visited"> Visited</label>
                <label><input type="checkbox" class="statusFilter" value="EC/Ordered1"> EC/Ordered1</label>
                <label><input type="checkbox" class="statusFilter" value="Problematic"> Problematic</label>
                <label><input type="checkbox" class="statusFilter" value="Acct-Active"> Acct-Active</label>
            </div>
        </div>

        <!-- Companies Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered w-100" id="companiesTable">
                <thead class="text-nowrap">
                    <tr>
                        <td><input type="checkbox" id="selectAll"></td>
                        <td>Actions</td>
                        <td>
                            Industry
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="2">
                        </td>
                        <td>
                            Company Name
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="3">
                        </td>
                        <td>
                            Contact Person
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="4">
                        </td>
                        <td>
                            Contact No
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="5">
                        </td>
                        <td>
                            Email
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="6">
                        </td>
                        <td>
                            Address
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="7">
                        </td>
                        <td>
                            Notes
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="8">
                        </td>
                        <td>
                            Status
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="19">
                        </td>
                        <td>
                            Other Digi-Contact Platform
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="9">
                        </td>
                        <td>
                            Terms of Payment
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="10">
                        </td>
                        <td>
                            Contacted
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="11">
                        </td>
                        <td>
                            To ReContact
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="12">
                        </td>
                        <td>
                            To Email
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="13">
                        </td>
                        <td>
                            To Propose
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="14">
                        </td>
                        <td>
                            Visited
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="15">
                        </td>
                        <td>
                            EC/Ordered 1
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="16">
                        </td>
                        <td>
                            Problematic
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="17">
                        </td>
                        <td>
                            Acct-Active
                            <input type="text" class="form-control form-control-sm columnSearch" data-column="18">
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <tr data-status="{{ $company->status }}">
                            <td><input type="checkbox" name="selected_ids[]" value="{{ $company->id }}"></td>
                            <td>
                                <!-- Edit Button with Edit Icon -->
                                <a href="{{ route('admin-prospects.edit', $company->id) }}" class="btn btn-light"
                                    style="border: 1px solid #dee2e6;">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>{{ $company->industry_group }}</td>
                            <td>{{ $company->company_name }}</td>
                            <td>{{ $company->contact_person }}</td>
                            <td>{{ $company->contact_number }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->address }}</td>
                            <td>{{ $company->notes }}</td>
                            <td>{{ $company->status }}</td>
                            <td>{{ $company->other_digi_contact_platform }}</td>
                            <td>{{ $company->terms_of_payment }}</td>
                            <td>{{ $company->contacted }}</td>
                            <td>{{ $company->to_recontact }}</td>
                            <td>{{ $company->to_email }}</td>
                            <td>{{ $company->to_propose }}</td>
                            <td>{{ $company->visited }}</td>
                            <td>{{ $company->ec_ordered1 }}</td>
                            <td>{{ $company->problematic }}</td>
                            <td>{{ $company->acct_active }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                    {{ $companies->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
        </div>
    </div>


    {{-- Print script --}}
    <script>
        // Function to generate table content for printing
        function generatePrintTable(rows) {
            let printContent = `
                    <html>
                    <head>
                        <title>Company List</title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid black; padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                        </style>
                    </head>
                    <body>
                        <h2 style="text-align:center;">Company List</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Industry</th>
                                    <th>Company Name</th>
                                    <th>Contact Person</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>`;

            rows.forEach(row => {
                let columns = row.children;
                printContent += `
                        <tr>
                            <td>${columns[2].innerHTML}</td>  <!-- Industry -->
                            <td>${columns[3].innerHTML}</td>  <!-- Company Name -->
                            <td>${columns[4].innerHTML}</td>  <!-- Contact Person -->
                            <td>${columns[5].innerHTML}</td>  <!-- Contact No -->
                            <td>${columns[6].innerHTML}</td>  <!-- Email -->
                            <td>${columns[7].innerHTML}</td>  <!-- Address -->
                            <td>${columns[8].innerHTML}</td>  <!-- Notes -->
                            <td>${columns[9].innerHTML}</td>  <!-- Status -->
                        </tr>`;
            });

            printContent += `</tbody></table></body></html>`;
            return printContent;
        }

        // Print Selected Rows
        document.getElementById('printSelectedBtn').addEventListener('click', function() {
            let selectedRows = document.querySelectorAll('input[name="selected_ids[]"]:checked');
            if (selectedRows.length === 0) {
                alert("Please select at least one row to print.");
                return;
            }
            let rowsToPrint = Array.from(selectedRows).map(row => row.closest('tr'));
            let printContent = generatePrintTable(rowsToPrint);
            let printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        });

        // Print All Rows
        document.getElementById('printAllBtn').addEventListener('click', function() {
            let allRows = document.querySelectorAll('#companiesTable tbody tr');
            let printContent = generatePrintTable(allRows);
            let printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        });

        // Search
        $(document).ready(function() {
            // Main search bar functionality (searches across all columns)
            $('#mainSearchBar').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#companiesTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Column-specific search functionality
            $('.columnSearch').on('keyup', function() {
                var column = $(this).data('column');
                var value = $(this).val().toLowerCase();
                $('#companiesTable tbody tr').each(function() {
                    var rowText = $(this).find('td').eq(column).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(value) > -1);
                });
            });

            // Status filter functionality
            $('.statusFilter').on('change', function() {
                var selectedStatuses = $('.statusFilter:checked').map(function() {
                    return this.value;
                }).get();

                $('#companiesTable tbody tr').each(function() {
                    var row = $(this);
                    var showRow = selectedStatuses.length === 0;

                    selectedStatuses.forEach(function(status) {
                        var columnIndex = getColumnIndex(status);
                        if (columnIndex !== -1) {
                            var cellValue = row.find('td').eq(columnIndex).text().trim();
                            if (cellValue === '1') {
                                showRow = true;
                            }
                        }
                    });

                    row.toggle(showRow);
                });
            });

            // Helper function to get column index based on status
            function getColumnIndex(status) {
                var headers = $('#companiesTable th').map(function() {
                    return $(this).text().trim();
                }).get();

                return headers.indexOf(status);
            }

            // Select all checkboxes functionality
            $('#selectAll').on('change', function() {
                $('input[name="selected_ids[]"]').prop('checked', this.checked);
            });

            // Delete selected functionality/ 
            /*$('#deleteSelectedBtn').on('click', function() {
                var selectedIds = $('input[name="selected_ids[]"]:checked').map(function() {
                    return this.value;
                }).get();

                if (selectedIds.length > 0) {
                    $('#selectedIdsInput').val(selectedIds);
                    $('#deleteForm').submit();
                } else {
                    Swal.fire('Error', 'Please select at least one company to delete.', 'error');
                }
            });*/
        });
        // END

        // Settings
        document.getElementById('settingsBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Enter Password',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    return fetch("{{ route('verify.password') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                password: password
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect_url;
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.message,
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                            });
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });

        // Select All Checkbox
        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Delete Selected Button
        document.getElementById('deleteSelectedBtn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting automatically

            const selectedIds = Array.from(document.querySelectorAll('input[name="selected_ids[]"]:checked')).map(
                checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'No companies selected for deletion.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete selected companies.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the selected IDs in the hidden input
                    document.getElementById('selectedIdsInput').value = selectedIds.join(',');
                    // Submit the form programmatically
                    document.getElementById('deleteForm').submit();
                }
            });
        });

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
@endsection
