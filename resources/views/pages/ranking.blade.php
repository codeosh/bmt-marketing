{{-- resources\views\pages\ranking.blade.php --}}
@extends('admin.admin-dashboard')

@section('title', 'Staff Ranking')

@section('content')
    <div class="container">
        <h1>Staff Ranking</h1>

        <!-- Form to add sales amount -->
        <form action="{{ route('rankings.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="form-row align-items-end">
                <div class="col-md-4">
                    <label for="user_id">Select Staff</label>
                    <select name="user_id" id="user_id" class="form-control" style="height: 45px;">
                        <option value="">-- Select User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sales_amount">Sales Amount</label>
                    <input type="number" name="sales_amount" id="sales_amount" class="form-control" step="0.01"
                        min="0" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Add Sales</button>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
        </form>

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
                @forelse ($rankings as $index => $ranking)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ranking->user->name }}</td>
                        <td>{{ number_format($ranking->sales_amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No rankings available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
