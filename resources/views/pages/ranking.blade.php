{{-- resources/views/pages/ranking.blade.php --}}
@extends('admin.admin-dashboard')

@section('title', 'Staff Ranking')

@section('content')
    <div class="container">
        <div style="display: flex; justify-content:center;">
            <h3 style="font-weight: bold;">Salesman Sales and Ranking</h3>
        </div>

        <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
            <input type="month" id="monthYear" name="monthYear" class="form-control" style="width: 170px; height: 25px;">
        </div>

        <div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="input-group" style="width: 15rem;">
                <span class="input-group-text border-1" style="height: 30px;" id="search-addon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" class="form-control" id="searchInput" name="searchInput" placeholder="Search staff..."
                    style="background:white; height: 30px; border-left: 0;" autocomplete="off"
                    aria-describedby="search-addon">
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" class="btn btn-sm btn-primary" style="width: 50px !important;" data-bs-toggle="modal"
                    data-bs-target="#addSalesModal">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-sm btn-secondary" style="width: 50px !important;" id="printButton">
                    <i class="fa-solid fa-print"></i>
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div id="successMessage" class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <!-- Rankings Table -->
        <div class="shadow p-3 rounded" style="height: 450px; max-height: 450px; overflow-y: auto;">
            <table class="table table-striped" id="rankingsTable">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Sales Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rankings as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-end">{{ number_format($user->sales_amount, 2) }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i> <!-- Vertical ellipsis icon -->
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-success add-action" href="#"
                                                data-user-id="{{ $user->id }}"
                                                data-sales-amount="{{ $user->sales_amount }}" data-bs-toggle="modal"
                                                data-bs-target="#plusSalesModal">
                                                <i class="fas fa-plus"></i> Add
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger minus-action" href="#"
                                                data-user-id="{{ $user->id }}"
                                                data-sales-amount="{{ $user->sales_amount }}" data-bs-toggle="modal"
                                                data-bs-target="#minusSalesModal">
                                                <i class="fas fa-minus"></i> Minus
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No users available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for adding sales -->
    <div class="modal fade" id="addSalesModal" tabindex="-1" aria-labelledby="addSalesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSalesModalLabel">Add Sales Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rankings.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select Staff:</label>
                            <select name="user_id" id="user_id" class="form-control" style="height: 45px;" required>
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sales_amount" class="form-label">Sales Amount</label>
                            <input type="number" name="sales_amount" id="sales_amount" class="form-control"
                                step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Overwrite</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Minus Sales Modal -->
    <div class="modal fade" id="minusSalesModal" tabindex="-1" aria-labelledby="minusSalesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="minusSalesModalLabel">Subtract Sales Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="minusSalesForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="minusUserId">
                        <div class="mb-3">
                            <label for="minusAmount" class="form-label">Amount to Subtract</label>
                            <input type="number" name="minus_amount" id="minusAmount" class="form-control"
                                step="0.01" min="0" required>
                        </div>
                        <p>Current Sales Amount: <span id="currentSalesAmount">0.00</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Subtract</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Plus Sales Modal -->
    <div class="modal fade" id="plusSalesModal" tabindex="-1" aria-labelledby="plusSalesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="plusSalesModalLabel">Add Sales Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="plusSalesForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="addUserId">
                        <div class="mb-3">
                            <label for="addAmount" class="form-label">Amount to Add</label>
                            <input type="number" name="add_amount" id="addAmount" class="form-control" step="0.01"
                                min="0" required>
                        </div>
                        <p>Current Sales Amount: <span id="addCurrentSalesAmount">0.00</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthYearInput = document.getElementById("monthYear");

            // Load saved month/year from localStorage
            const savedMonthYear = localStorage.getItem("selectedMonthYear");
            if (savedMonthYear) {
                monthYearInput.value = savedMonthYear;
            }

            // Save the selected value to localStorage when changed
            monthYearInput.addEventListener("change", function() {
                localStorage.setItem("selectedMonthYear", this.value);
            });

            const successMessage = document.getElementById("successMessage");
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = "opacity 0.5s ease";
                    successMessage.style.opacity = "0";
                    setTimeout(() => successMessage.remove(), 500);
                }, 3000);
            }

            const modalElement = document.getElementById('addSalesModal');
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);

                // Open modal on button click
                const modalButton = document.querySelector('[data-bs-target="#addSalesModal"]');
                if (modalButton) {
                    modalButton.addEventListener('click', function() {
                        modal.show();
                    });
                }

                // Ensure modal hides properly
                modalElement.addEventListener('hidden.bs.modal', function() {
                    document.body.classList.remove('modal-open'); // Remove modal-open class
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop
                        .remove()); // Remove any remaining backdrop
                });
            }

            // New Search Functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.trim().toLowerCase();

                    // Get all rows in the table body
                    const rows = document.querySelectorAll('#rankingsTable tbody tr');

                    rows.forEach(row => {
                        const name = row.querySelector('td:nth-child(2)')?.textContent
                            .toLowerCase() || '';
                        row.style.display = name.includes(searchTerm) ? '' : 'none';
                    });
                });
            } else {
                console.error('Search input not found');
            }

            // Add print-specific CSS to the page
            const style = document.createElement('style');
            style.id = 'printStyles';
            style.textContent = `
                @media print {
                    body * { visibility: hidden; }
                    #printContainer, #printContainer * { visibility: visible; }
                    #printContainer { position: absolute; top: 0; left: 0; width: 100%; padding: 20px; }
                    #printContainer h3 { text-align: center; margin-bottom: 20px; font-weight: bold; }
                    #printContainer .month-year { text-align: center; margin-bottom: 1.5rem; }
                    #printContainer table { width: 100%; border-collapse: collapse; }
                    #printContainer th, #printContainer td { border: 1px solid #ddd; padding: 8px; }
                    #printContainer th { background-color: #f2f2f2; }
                    #printContainer tr:nth-child(even) { background-color: #f9f9f9; }
                    #printContainer td:nth-child(4), #printContainer th:nth-child(4) { display: none; } /* Hide Action column */
                }
            `;
            document.head.appendChild(style);

            // Print Button Handler
            const printButton = document.getElementById('printButton');
            if (printButton) {
                printButton.addEventListener('click', function() {

                    // Get elements to print
                    const title = document.querySelector('h3');
                    const monthYearDiv = document.querySelector(
                        'div[style*="justify-content: center; margin-bottom: 1.5rem"]');
                    const table = document.getElementById('rankingsTable');


                    if (!title || !monthYearDiv || !table) {
                        console.error('One or more elements to print not found');
                        alert('Error: Could not find all elements to print');
                        return;
                    }

                    // Create a temporary container for printing
                    const printContainer = document.createElement('div');
                    printContainer.id = 'printContainer';

                    // Clone and adjust elements
                    const titleClone = title.cloneNode(true);
                    const monthYearClone = monthYearDiv.cloneNode(true);
                    monthYearClone.classList.add('month-year'); // Add class for styling
                    const tableClone = table.cloneNode(true);

                    // Remove Action column from table clone
                    const rows = tableClone.querySelectorAll('tr');
                    rows.forEach(row => {
                        const actionCell = row.querySelector('td:nth-child(4)') || row
                            .querySelector('th:nth-child(4)');
                        if (actionCell) actionCell.remove();
                    });

                    // Build print content
                    printContainer.appendChild(titleClone);
                    printContainer.appendChild(monthYearClone);
                    printContainer.appendChild(tableClone);

                    // Append to body
                    document.body.appendChild(printContainer);

                    // Print
                    window.print();

                    // Clean up
                    setTimeout(() => {
                        document.body.removeChild(printContainer);
                        console.log('Print container removed');
                    }, 100);
                });
            } else {
                console.error('Print button not found');
            }

            // Minus Action Handler
            const minusButtons = document.querySelectorAll('.minus-action');
            const minusModal = document.getElementById('minusSalesModal');
            const minusForm = document.getElementById('minusSalesForm');
            const minusUserIdInput = document.getElementById('minusUserId'); // Updated ID
            const minusAmountInput = document.getElementById('minusAmount');
            const currentSalesAmountSpan = document.getElementById('currentSalesAmount');

            minusButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-user-id'); // Updated attribute
                    const salesAmount = this.getAttribute('data-sales-amount');


                    minusUserIdInput.value = userId;
                    currentSalesAmountSpan.textContent = parseFloat(salesAmount).toFixed(2);
                    minusAmountInput.value = '';
                });
            });

            // Handle form submission with AJAX
            minusForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const minusAmount = parseFloat(minusAmountInput.value);
                const currentAmount = parseFloat(currentSalesAmountSpan.textContent);
                const userId = minusUserIdInput.value;

                if (minusAmount > currentAmount) {
                    alert('Subtract amount cannot exceed current sales amount!');
                    return;
                }

                const formData = new FormData(minusForm);
                formData.append('_method', 'PATCH');

                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }

                fetch('{{ route('rankings.minus') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(
                                    `Server returned ${response.status}: ${text.substring(0, 100)}...`
                                );
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const row = document.querySelector(
                                `.minus-action[data-user-id="${userId}"]`).closest('tr');
                            const salesCell = row.querySelector('td:nth-child(3)');
                            salesCell.textContent = parseFloat(data.new_sales_amount).toFixed(2);
                            currentSalesAmountSpan.textContent = parseFloat(data.new_sales_amount)
                                .toFixed(2);
                            bootstrap.Modal.getInstance(minusModal).hide();
                            alert(data.message);
                        } else {
                            alert(data.error || 'Something went wrong');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Failed to subtract sales amount: ' + error.message);
                    });
            });
        });

        // Add Action Handler
        const addButtons = document.querySelectorAll('.add-action');
        const addModal = document.getElementById('plusSalesModal');
        const addForm = document.getElementById('plusSalesForm');
        const addUserIdInput = document.getElementById('addUserId');
        const addAmountInput = document.getElementById('addAmount');
        const addCurrentSalesAmountSpan = document.getElementById('addCurrentSalesAmount');

        addButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                const salesAmount = this.getAttribute('data-sales-amount');

                console.log('Add clicked - User ID:', userId, 'Sales Amount:', salesAmount);

                addUserIdInput.value = userId;
                addCurrentSalesAmountSpan.textContent = parseFloat(salesAmount).toFixed(2);
                addAmountInput.value = '';
            });
        });

        // Handle Add Form Submission
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const addAmount = parseFloat(addAmountInput.value);
            const currentAmount = parseFloat(addCurrentSalesAmountSpan.textContent);
            const userId = addUserIdInput.value;

            console.log('Add submitting - User ID:', userId, 'Add Amount:', addAmount, 'Current Amount:',
                currentAmount);

            const formData = new FormData(addForm);
            formData.append('_method', 'PATCH');

            fetch('{{ route('rankings.add') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(
                                `Server returned ${response.status}: ${text.substring(0, 100)}...`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Add response:', data);
                    if (data.success) {
                        const row = document.querySelector(`.add-action[data-user-id="${userId}"]`).closest(
                            'tr');
                        const salesCell = row.querySelector('td:nth-child(3)');
                        salesCell.textContent = parseFloat(data.new_sales_amount).toFixed(2);
                        addCurrentSalesAmountSpan.textContent = parseFloat(data.new_sales_amount).toFixed(2);
                        bootstrap.Modal.getInstance(addModal).hide();
                        alert(data.message);
                    } else {
                        alert(data.error || 'Something went wrong');
                    }
                })
                .catch(error => {
                    console.error('Add fetch error:', error);
                    alert('Failed to add sales amount: ' + error.message);
                });
        });
    </script>
@endsection
