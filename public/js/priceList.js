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

    $("#pricelistForm")
        .off("submit")
        .on("submit", function (e) {
            e.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "/admin-priceList",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
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

// Copy Function
$(document).ready(function () {
    $(document)
        .off("click", ".copyButton button")
        .on("click", ".copyButton button", function () {
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
