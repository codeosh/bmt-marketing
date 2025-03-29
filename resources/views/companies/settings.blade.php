<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Center the container both horizontally and vertically */
        html, body {
            height: 100%;
            margin: 0;
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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 10px; /* Space between buttons */
        }
        h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 10%;
        }
        /* Hide elements when SweetAlert is displayed */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div>
    <a class="close-btn" style="margin-right: 200px; margin-top: 35px; font-size: 50px;" onclick="closeForm()">&times;</a>
    </div>
    <h1 id="pageTitle">Settings</h1>
    <div class="container">
        <div class="btn-container" id="buttonsContainer" style="margin-right: 200px;">
            <h4 class="text-secondary">Import Contacts</h4>
            <a href="{{ route('companies.browse.excel') }}" class="btn btn-light" style="border: 1px solid #dee2e6; width: 200px; height: 50px;">Upload from Excel</a>
            
        </div>
        <div class="btn-container" id="buttonsContainer" style="margin-left: 200px;">
            <h4 class="text-secondary">Data Reset</h4>
        <button type="button" class="btn btn-light" style="border: 1px solid #dee2e6; width: 200px; height: 50px;" id="deleteAllBtn">Reset</button>
        </div>
    </div>

    <script>
    //close button
    function closeForm() {
        window.location.href = "{{ route('companies.index') }}"; // Redirects to index page
    }

    // Function to hide elements
    function hideElements() {
        document.getElementById('pageTitle').classList.add('hidden');
        document.getElementById('buttonsContainer').classList.add('hidden');
    }

    // Function to show elements
    function showElements() {
        document.getElementById('pageTitle').classList.remove('hidden');
        document.getElementById('buttonsContainer').classList.remove('hidden');
    }

    // Reset button click event
    document.getElementById('deleteAllBtn').addEventListener('click', function() {
        // Hide the title and buttons
        hideElements();

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to reset all data. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            // Show the title and buttons again after the dialog is closed
            showElements();

            if (result.isConfirmed) {
                // Step 2: Ask for password
                Swal.fire({
                    title: 'Enter Password',
                    input: 'password',
                    inputPlaceholder: 'Enter your password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        required: true
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    preConfirm: (password) => {
                        if (!password) {
                            Swal.showValidationMessage('Password is required!');
                        } else if (password !== 'Bizmatech') {  // Replace with actual validation logic
                            Swal.showValidationMessage('Incorrect password!');
                        }
                        return password; // Return password if correct
                    }
                }).then((passwordResult) => {
                    if (passwordResult.isConfirmed) {
                        // Step 3: Send Reset Request if password is correct
                        fetch("{{ route('companies.reset') }}", {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                }).then(() => {
                                    window.location.href = "{{ route('companies.index') }}";
                                });
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
                                text: 'An error occurred while resetting the data.',
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                            });
                        });
                    }
                });
            }
        });
    });
</script>

</body>
</html>