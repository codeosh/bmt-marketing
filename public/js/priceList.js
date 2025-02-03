//fetch the content and bulletin and template name from database
$(document).ready(function () {
    $('li[data-type="bulletin"], li[data-type="template"]').on("click", function () {
            var id = $(this).data("id"); // Get the clicked item's ID

            var url = "/admin-priceList/" + id;

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json", // Ensure JSON response is expected
                success: function (response) {
                    $("#contentDisplay").html(response.content); // Display the content
                    $("#contentName").html(response.pname); // Display the panme
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    $("#contentDisplay").html(
                        "<p>Error loading content. Please try again.</p>"
                    );
                },
            });
        }
    );


// Add data for pricelist
$("#pricelistForm").off("submit").on("submit", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();

    const saveButton = document.getElementById('saveBtn');
    const buttonText = document.getElementById('buttonText');
    const buttonSpinner = document.getElementById('buttonSpinner');

    // Show loader effect
    saveButton.disabled = true;
    buttonText.textContent = "Saving...";
    buttonSpinner.classList.remove('d-none');

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
                buttonSpinner.classList.add('d-none');
            }, 1000); // Adjust delay time as needed
        },
        error: function (xhr, status, error) {
            // Turn off loader effect (ensure it runs even on error)
            saveButton.disabled = false;
            buttonText.textContent = "Save";
            buttonSpinner.classList.add('d-none');

            if (xhr.responseJSON) {
                toastr.error(xhr.responseJSON.message || "An error occurred.");
                console.error("Error Details:", xhr.responseJSON);
            } else {
                toastr.error("An unexpected error occurred.");
            }
        }
    });
});

});

