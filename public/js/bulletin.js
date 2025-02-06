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

                $("#bulletinList").empty();
                $("#templateList").empty();

                response.forEach(function (item) {
                    let listItem = `
                    <div class="d-flex justify-content-between align-items-center btn btn-light text-start shadow-sm p-2 rounded bulletin-item text-truncate"
                        data-id="${item.id}" data-content="${item.content}" style="border: 1px solid #ddd;">
                        <span class="text-truncate">${item.pname}</span>
                        <div class="d-flex gap-1"  style="height:25px;">
                            <button class="btn btn-sm btn-primary edit-bulletin h-100 d-flex justify-content-between align-items-center" data-id="${item.id}" data-content="${item.content}" data-pname="${item.pname}">
                                <i class="fas fa-edit" style="font-size:0.8rem"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-bulletin h-100 d-flex justify-content-between align-items-center" data-pname="${item.pname}" data-id="${item.id}">
                                <i class="fas fa-trash" style="font-size:0.8rem;"></i>
                            </button>
                        </div>
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
                    let pname = $(this).text().trim();

                    content = content.replace(/\n/g, "<br>");
                    content = content.replace(/ /g, "&nbsp;");

                    $(".content-display").html(content);
                    $(".display-item-name").text(pname);
                });

                // Attach edit event to dynamically added edit buttons
                $(".edit-bulletin").click(function (e) {
                    e.stopPropagation(); // Prevent triggering the click event on .bulletin-item

                    let id = $(this).data("id");
                    let pname = $(this).data("pname");
                    let content = $(this).data("content");

                    // Populate the edit form (assuming you have a modal with input fields)
                    $("#editBulletinId").val(id);
                    $("#editBulletinName").val(pname);
                    $("#editBulletinContent").val(content);

                    // Show the modal
                    $("#editBulletinModal").modal("show");
                });

                // Attach delete event to dynamically added delete buttons
                $(".delete-bulletin").click(function (e) {
                    e.stopPropagation();
                    let id = $(this).data("id");
                    let pname = $(this).data("pname");
                    Swal.fire({
                        title: "Are you sure?",
                        text: `Are you sure you want to delete: ${pname}`,
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

                                    // Clear the content display
                                    $(".content-display").html("");
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

    $("#editBulletinForm").submit(function (e) {
        e.preventDefault();

        let id = $("#editBulletinId").val();
        let pname = $("#editBulletinName").val();
        let content = $("#editBulletinContent").val();

        $.ajax({
            url: `/admin-bulletin/${id}`,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                pname: pname,
                content: content,
            },
            success: function () {
                toastr.success("Bulletin updated successfully!");
                $("#editBulletinModal").modal("hide");
                fetchBulletins();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);
            },
        });
    });

    $(".copyContents button").click(function () {
        let content = $(".content-display").html().trim();

        if (navigator.clipboard) {
            navigator.clipboard
                .writeText(content)
                .then(() => {
                    let tempDiv = document.createElement("div");
                    tempDiv.innerHTML = content;
                    document.body.appendChild(tempDiv);

                    let range = document.createRange();
                    range.selectNodeContents(tempDiv);

                    let selection = window.getSelection();
                    selection.removeAllRanges();
                    selection.addRange(range);

                    document.execCommand("copy");
                    document.body.removeChild(tempDiv);

                    toastr.success("Copied with formatting!");
                })
                .catch((err) => {
                    toastr.error("Failed to copy.");
                    console.error("Copy error:", err);
                });
        } else {
            toastr.error("Clipboard API not supported.");
        }
    });
});
