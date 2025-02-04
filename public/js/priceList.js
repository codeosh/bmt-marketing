$(document).ready(function () {
    // Fetch the content and bulletin and template name from the database
    $(document).on("click", 'li[data-type="bulletin"], li[data-type="template"]', function () {
        var id = $(this).data("id"); // Get the clicked item's ID

        var url = "/admin-priceList/" + id;

        $.ajax({
            url: url,
            method: "GET",
            dataType: "json", // Ensure JSON response is expected
            success: function (response) {
                $("#contentDisplay").html(response.content); // Display the content
                $("#contentName").html(response.pname); // Display the pname
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#contentDisplay").html("<p>Error loading content. Please try again.</p>");
            },
        });
    });

    // Add data for pricelist
    $("#pricelistForm").off("submit").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        const saveButton = document.getElementById("saveBtn");
        const buttonText = document.getElementById("buttonText");
        const buttonSpinner = document.getElementById("buttonSpinner");

        // Show loader effect
        saveButton.disabled = true;
        buttonText.textContent = "Saving...";
        buttonSpinner.classList.remove("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-priceList",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                toastr.success("Added Successfully!");

                // Reload the page after a short delay
                setTimeout(function () {
                    window.location.href = "/admin-priceList"; // Redirect to the index page
                    saveButton.disabled = false;
                    buttonText.textContent = "Save";
                    buttonSpinner.classList.add("d-none");
                }, 1000); // Adjust delay time as needed
            },
            error: function (xhr, status, error) {
                // Turn off loader effect (ensure it runs even on error)
                saveButton.disabled = false;
                buttonText.textContent = "Save";
                buttonSpinner.classList.add("d-none");

                if (xhr.responseJSON) {
                    toastr.error(xhr.responseJSON.message || "An error occurred.");
                    console.error("Error Details:", xhr.responseJSON);
                } else {
                    toastr.error("An unexpected error occurred.");
                }
            },
        });
    });

    // Delete data
    $(document).on("click", ".delete-priceList", function () {
        let itemId = $(this).data("id");
        let itemName = $(this).data("pname");

        Swal.fire({
            title: "Are you sure?",
            text: `Do you want to delete the item: ${itemName}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST", // also use post og mag delete
                    url: `/admin-priceList/${itemId}`, //  correct RESTful URL
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        _method: "DELETE",
                    },
                    success: function (response) {
                        toastr.success(response.message || "Deleted Successfully!");
                        $(`.item-row[data-id="${itemId}"]`).remove(); // Remove item from list
                        window.location.href = "/admin-priceList";
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error("Error: Record not found.");
                        } else {
                            toastr.error(xhr.responseJSON?.message || "An error occurred while deleting.");
                        }
                    },
                });
            }
        });
    });

    
    //copy function
    $(document).off("click", ".copyButton button").on("click", ".copyButton button", function () {
            var contentElement = document.querySelector("#contentDisplay");

            if (contentElement) {
                var contentText = contentElement.innerText.trim();

                if (contentText) {
                    navigator.clipboard
                        .writeText(contentText)
                        .then(() => {
                            toastr.success("Content copied to clipboard!");
                        })
                        .catch((err) => {
                            toastr.error(
                                "Failed to copy content. Please try again."
                            );
                            console.error("Copy Error:", err);
                        });
                } else {
                    toastr.warning("No content to copy.");
                }
            } else {
                toastr.error("Content area not found.");
            }
        });
});
