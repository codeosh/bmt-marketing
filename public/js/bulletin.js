// public\js\bulletin.js
$(document).ready(function () {
    function fetchBulletins() {
        $.ajax({
            url: "/fetch-bulletins",
            type: "GET",
            success: function (response) {
                console.log("Response received:", response); // Debugging log

                if (!Array.isArray(response)) {
                    toastr.error("Invalid data format received.");
                    return;
                }

                // Clear existing lists
                $("#bulletinList").empty();
                $("#templateList").empty();

                response.forEach(function (item) {
                    let listItem = `
                        <button class="btn btn-light text-start shadow-sm p-2 rounded bulletin-item"
                            data-id="${item.id}" data-content="${item.content}" style="border: 1px solid #ddd;">
                            ${item.pname}
                        </button>
                    `;

                    if (item.kind === "Bulletin") {
                        $("#bulletinList").append(listItem);
                    } else if (item.kind === "Template") {
                        $("#templateList").append(listItem);
                    }
                });

                // Attach click event to dynamically added list items
                $(".bulletin-item").click(function () {
                    let content = $(this).data("content");
                    $(".w-100.overflow-auto.rounded").html(content);
                });
            },
            error: function (xhr) {
                toastr.error("Failed to fetch data.");
                console.error("Error:", xhr.responseText);
            },
        });
    }

    // Fetch the data when the page loads
    fetchBulletins();

    // Submit form via AJAX
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
                fetchBulletins();

                // Close the modal
                $("#bulletinModal").modal("hide");

                // Reset the form
                $("#bulletinForm")[0].reset();
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
