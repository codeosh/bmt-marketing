
                // Close the modal
                $("#PriceListModal").modal("hide");

                // Reset the form
                $("#pricelistForm")[0].reset();
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON) {
                    toastr.error(
                        xhr.responseJSON.message || "An error occurred."
                    );
                    console.error("Error Details:", xhr.responseJSON);
                } else {
                    toastr.error("An unexpected error occurred.");
                }
            },
=======
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
                        toastr.error(
                            xhr.responseJSON.message || "An error occurred."
                        );
                        console.error("Error Details:", xhr.responseJSON);
                    } else {
                        toastr.error("An unexpected error occurred.");
                    }
                },
            });
        });

    $("#editPricelistForm").submit(function (e) {
        e.preventDefault();

        let id = $("#editPricelistId").val();
        let pname = $("#editPricelistName").val();
        let content = $("#editPricelistContent").val();

        $.ajax({
            url: `/admin-priceList/${id}`,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                pname: pname,
                content: content,
            },
            success: function () {
                toastr.success("Updated successfully!");
                $("#editPricelistModal").modal("hide");
                fetchBulletins();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);
            },
        });
    });
});
