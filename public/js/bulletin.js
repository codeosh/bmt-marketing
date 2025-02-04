// public\js\bulletin.js
$(document).ready(function () {
    function fetchBulletins() {
        $.ajax({
            url: "/fetch-bulletins",
            type: "GET",
            success: function (response) {
                if (!Array.isArray(response)) {
                    toastr.error("Invalid data format received.");
                    return;
                }

                // Clear existing lists
                $("#bulletinList").empty();
                $("#templateList").empty();

                response.forEach(function (item) {
                    let listItem = `
                    <div class="d-flex justify-content-between align-items-center btn btn-light text-start shadow-sm p-2 rounded bulletin-item text-truncate"
                        data-id="${item.id}" data-content="${item.content}" style="border: 1px solid #ddd;">
                        <span class="text-truncate">${item.pname}</span>
                        <button class="btn btn-sm btn-danger delete-bulletin" data-id="${item.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
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

                // Attach delete event to dynamically added delete buttons
                $(".delete-bulletin").click(function (e) {
                    e.stopPropagation();
                    let id = $(this).data("id");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to undo this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin-bulletin/${id}`,
                                type: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content"),
                                },
                                success: function () {
                                    toastr.success("Deleted successfully!");
                                    fetchBulletins();
                                },
                                error: function (xhr) {
                                    toastr.error("Failed to delete.");
                                    console.error("Error:", xhr.responseText);
                                },
                            });
                        }
                    });
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
