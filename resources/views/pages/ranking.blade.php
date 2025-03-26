{{-- resources/views/pages/ranking.blade.php --}}
@extends('admin.admin-dashboard')

@section('title', 'Staff Ranking')

@section('content')
    <div class="container">
        <h1>Staff Ranking</h1>

        <!-- Button to trigger the modal -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSalesModal">
                Add Sales
            </button>
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
                                <label for="user_id" class="form-label">Select Staff</label>
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
                            <button type="submit" class="btn btn-primary">Save Sales</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <!-- Rankings Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Sales Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rankings as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ number_format($user->sales_amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No users available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        // Test if Bootstrap modal is working
        document.addEventListener('DOMContentLoaded', function() {
            const modalButton = document.querySelector('[data-bs-target="#addSalesModal"]');
            modalButton.addEventListener('click', function() {
                console.log('Button clicked, attempting to show modal');
                const modal = new bootstrap.Modal(document.getElementById('addSalesModal'));
                modal.show();
            });
        });
    </script>
@endsection
