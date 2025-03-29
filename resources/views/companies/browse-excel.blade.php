<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5 shadow-lg p-4 rounded w-50">
        <h1 class="text-center">Upload Excel File</h1>
        
        <!-- Note for Users -->
        <div class="alert alert-secondary">
            <strong>Note:</strong> The uploaded file must be in the following format:  
            <br><strong>Industry, Company Name, Contact Person, Contact No, Email, Address, Notes.</strong>.
        </div>

        <form action="{{ route('companies.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Choose Excel File</label>
                <input type="file" name="file" class="form-control" accept=".xls, .xlsx" required>
            </div>
            <button type="submit" class="btn btn-outline-secondary">Upload</button>
            <a href="{{ route('companies.settings') }}" class="btn btn-outline-secondary">Back to Settings</a>
        </form>
    </div>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#3085d6',
            });
        @endif

        @if(session('error'))
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
