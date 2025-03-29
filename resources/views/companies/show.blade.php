<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Company Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $company->company_name }}</h5>
                <p class="card-text"><strong>Contact Person:</strong> {{ $company->contact_person }}</p>
                <p class="card-text"><strong>Contact Number:</strong> {{ $company->contact_number }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $company->email }}</p>
                <p class="card-text"><strong>Address:</strong> {{ $company->address }}</p>
                <p class="card-text"><strong>Status:</strong> {{ $company->status }}</p>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</body>
</html>