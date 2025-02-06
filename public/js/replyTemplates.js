// public\js\bulletin.js
$(document).ready(function () {
    function fetchBulletins() {
        $.ajax({
            url: "/fetch-replyTemplate",
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
                            <button class="btn btn-sm btn-primary edit-replyTemplate h-100 d-flex justify-content-between align-items-center" data-id="${item.id}" data-content="${item.content}" data-pname="${item.pname}">
                                <i class="fas fa-edit" style="font-size:10px;"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-replyTemplate h-100 d-flex justify-content-between align-items-center" data-pname="${item.pname}" data-id="${item.id}">
                                <i class="fas fa-trash" style="font-size:10px;"></i>
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
                $(".bulletin-item").click(function () {//this is not supposed to be name as bulletin-item kay ge copy raman ni if i have time i-change ra namo ag name for proper naming convention
                    let content = $(this).data("content");
                    let pname = $(this).text().trim();

                    content = content.replace(/\n/g, "<br>");
                    content = content.replace(/ /g, "&nbsp;");

                    $(".content-display").html(content);
                    $(".display-item-name").text(pname);
                });

                // Attach edit event to dynamically added edit buttons
                $(".edit-replyTemplate").click(function (e) {
                    e.stopPropagation(); // Prevent triggering the click event on .bulletin-item

                    let id = $(this).data("id");
                    let pname = $(this).data("pname");
                    let content = $(this).data("content");

                    // Populate the edit form (assuming you have a modal with input fields)
                    $("#editReplyId").val(id);
                    $("#editReplyName").val(pname);
                    $("#editReplyContent").val(content);

                    // Show the modal
                    $("#editReplyModal").modal("show");
                });

                // Attach delete event to dynamically added delete buttons
                $(".delete-replyTemplate").click(function (e) {
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
                                url: `/admin-replyTemplate/${id}`,
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

    // Submit form via AJAX for add
    $("#replyTemplateForm").on("submit", function (e) {
        e.preventDefault();

        const saveButtonreplyTemplate = document.getElementById("saveBtn-replyTemplate");
        const buttonTextreplyTemplate= document.getElementById("buttonText-replyTemplate");
        const buttonSpinnerreplyTemplate= document.getElementById("buttonSpinner-replyTemplate");
        const formData = $(this).serialize();

        // Show loader effect
        saveButtonreplyTemplate.disabled = true;
        buttonTextreplyTemplate.textContent = "Saving...";
        buttonSpinnerreplyTemplate.classList.remove("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-replyTemplate",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                toastr.success("Added Successfully!");

                saveButtonreplyTemplate.disabled = false;
                buttonTextreplyTemplate.textContent = "Save";
                buttonSpinnerreplyTemplate.classList.add("d-none");
                
                fetchBulletins();

                // Close the modal
                $("#ReplyTemplateModal").modal("hide");

                // Reset the form
                $("#replyTemplateForm")[0].reset();
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

    //edit
    $("#editReplyForm").submit(function (e) {
        e.preventDefault();

        let id = $("#editReplyId").val();
        let pname = $("#editReplyName").val();
        let content = $("#editReplyContent").val();

        $.ajax({
            url: `/admin-replyTemplate/${id}`,
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
                $("#editReplyModal").modal("hide");
                fetchBulletins();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);
            },
        });
    });
});
