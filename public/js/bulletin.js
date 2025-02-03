// public\js\bulletin.js
$(document).ready(function () {
    $("#bulletinForm").on("submit", function (e) {
        e.preventDefault();

        const formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/admin-bulletin",
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
