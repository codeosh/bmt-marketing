<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEditing ? 'Edit Company' : 'Company Details' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>{{ $isEditing ? 'Edit Company' : 'Company Details' }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                @if($isEditing)
                    <!-- Edit Form -->
                    <form action="{{ route('companies.update', $company->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ $company->company_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" value="{{ $company->contact_person }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ $company->contact_number }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $company->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $company->address }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="active" {{ $company->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $company->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                @else
                    <!-- View Mode -->
                    <h5 class="card-title">{{ $company->company_name }}</h5>
                    <p class="card-text"><strong>Contact Person:</strong> {{ $company->contact_person }}</p>
                    <p class="card-text"><strong>Contact Number:</strong> {{ $company->contact_number }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $company->email }}</p>
                    <p class="card-text"><strong>Address:</strong> {{ $company->address }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ $company->status }}</p>
                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>