$(document).ready(function () {
    $('li[data-type="bulletin"], li[data-type="template"]').on(
        "click",
        function () {
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

    $("#pricelistForm").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/admin-priceList",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                toastr.success("Added Successfully!");
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
        });
    });
});
