// public\js\postTemplate.js
$(document).ready(function () {
    let ReplyTemplateData = []; // Store fetched data globally

    let url =
        Laravel.user_role === "admin"
            ? "/fetch-post-template"
            : "/fetch-user-post-template";

    //get the data to automatically display on the bulletin and template container
    function fetchReplyTemplate() {
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (!Array.isArray(response)) {
                    toastr.error("Invalid data format received.");
                    return;
                }

                ReplyTemplateData = response; // Store data globally
                displayReplyTemplate(ReplyTemplateData); // Render data
            },
            error: function () {
                toastr.error("Failed to fetch data.");
            },
        });
    }

    function displayReplyTemplate(data) {
        $("#bulletinList").empty();
        $("#templateList").empty();

        if (data.length === 0) {
            //mao nani ang data na ge renderan from fetchReplyTemplate(). so, if walay data, mo execute ni.
            $("#bulletinList").html(
                '<div class="text-center text-red-500">No records found</div>'
            );
            $("#templateList").html(
                '<div class="text-center text-red-500">No records found</div>'
            );
            return;
        }

        //if naay data.  Mo exceute ni na set of codes
        data.forEach(function (item) {
            let escapedContent = item.content.replace(/"/g, "&quot;");
            let listItem = `
            <div class="d-flex justify-content-between align-items-center btn btn-light text-start shadow-sm p-2 rounded bulletin-item text-truncate"
                data-id="${
                    item.id
                }" data-content="${escapedContent}" style="border: 1px solid #ddd;">
                <span class="text-truncate" style="font-size:0.8rem"  title="${
                    item.pname
                }">${item.pname}</span>
                ${
                    Laravel.user_role === "admin"
                        ? `
                <div class="d-flex gap-1" style="height:25px;">
                    <button class="btn btn-sm btn-secondary edit-replyTemplate h-100 d-flex justify-content-between align-items-center" 
                        data-id="${item.id}" data-content="${escapedContent}" data-pname="${item.pname}">
                        <i class="fas fa-edit" style="font-size:10px;"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary delete-replyTemplate h-100 d-flex justify-content-between align-items-center" 
                        data-pname="${item.pname}" data-id="${item.id}">
                        <i class="fas fa-trash" style="font-size:10px;"></i>
                    </button>
                </div>
                    `
                        : ``
                }
            </div>
        `;

            if (item.kind === "Bulletin") {
                $("#bulletinList").append(listItem);
            } else if (item.kind === "Template") {
                $("#templateList").append(listItem);
            }
        });

        attachEvents(); // mao ni Attach event listeners to dynamically generated elements like katong edit, delete
    }

    //mao ni na function for dynamically search in which tawgon ni sya sa #searchBulletins which has keyup
    function filterReplyTemplate() {
        let searchTerm = $("#search").val().toLowerCase(); //kuhaon niya agg ge input then i convert into lowercase weather it already upper or lower case
        let filteredData = ReplyTemplateData.filter((item) =>
            item.pname.toLowerCase().includes(searchTerm)
        ); //arrow function para i filter ang searchterm na

        displayReplyTemplate(filteredData); //then i pasa ang na filter out na didtos displayReplyTemplate na function para ma display na sya
    }

    //function para sudlanan sa edit, click events and delete
    function attachEvents() {
        // Attach click event to list items para ma sudlan ag content
        $(".bulletin-item").click(function () {
            let content = $(this).data("content");
            let pname = $(this).text().trim();

            content = content.replace(/\n/g, "<br>").replace(/ /g, "&nbsp;");
            $(".content-display").html(content);
            $(".display-item-name").text(pname);
        });

        // Edit event
        $(".edit-replyTemplate").click(function (e) {
            e.stopPropagation();
            let id = $(this).data("id");
            let pname = $(this).data("pname");
            let content = $(this).data("content");

            // Populate the edit form (assuming you have a modal with input fields)
            $("#editPostTemplateId").val(id);
            $("#editPostTemplateName").val(pname);
            $("#editPostTemplateContent").val(content);

            // Show the modal
            $("#editPostTemplateModal").modal("show");
        });

        // Delete event
        $(".delete-replyTemplate").click(function (e) {
            e.stopPropagation();
            let id = $(this).data("id");
            let pname = $(this).data("pname");
            let itemElement = $(this).closest(".bulletin-item");

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
                        url: `/admin-postTemplate/${id}`,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function () {
                            toastr.success("Deleted successfully!");

                            // Fade out and remove the item smoothly
                            itemElement.fadeOut(300, function () {
                                $(this).remove();
                            });

                            fetchReplyTemplate(); //refresh data if needed
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
    }

    // Fetch data on page load
    fetchReplyTemplate();

    //i-trigger na niya ag Search input then para ma execute na this functionality
    $("#search").on("keyup", function () {
        filterReplyTemplate();
    });

    // Submit form for adding a bulletin
    $("#postTemplateForm").on("submit", function (e) {
        e.preventDefault();

        const saveButtonPostTemplate = document.getElementById(
            "saveBtnPostTemplate"
        );
        const buttonTextPostTemplate = document.getElementById(
            "buttonTextPostTemplate"
        );
        const buttonSpinnerPostTemplate = document.getElementById(
            "buttonSpinnerPostTemplate"
        );
        const formData = $(this).serialize();

        // Show loader effect
        saveButtonPostTemplate.disabled = true;
        buttonTextPostTemplate.textContent = "Saving...";
        buttonSpinnerPostTemplate.classList.remove("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-postTemplate",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                toastr.success("Added Successfully!");

                saveButtonPostTemplate.disabled = false;
                buttonTextPostTemplate.textContent = "Save";
                buttonSpinnerPostTemplate.classList.add("d-none");

                fetchReplyTemplate();
                $("#PostTemplateModal").modal("hide");
                $("#postTemplateForm")[0].reset();
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || "An error occurred.");

                saveButtonPostTemplate.disabled = false;
                buttonTextPostTemplate.textContent = "Save";
                buttonSpinnerPostTemplate.classList.add("d-none");
            },
        });
    });

    // Submit form for editing a bulletin
    $("#editPostTemplateForm").submit(function (e) {
        e.preventDefault();

        const saveButtonPostTemplate = document.getElementById(
            "editsaveBtnPostTemplate"
        );
        const buttonTextPostTemplate = document.getElementById(
            "editbuttonTextPostTemplate"
        );
        const buttonSpinnerPostTemplate = document.getElementById(
            "editbuttonSpinnerPostTemplate"
        );

        let id = $("#editPostTemplateId").val();
        let pname = $("#editPostTemplateName").val();
        let content = $("#editPostTemplateContent").val();

        // Show loader effect
        saveButtonPostTemplate.disabled = true;
        buttonTextPostTemplate.textContent = "Saving...";
        buttonSpinnerPostTemplate.classList.remove("d-none");

        $.ajax({
            url: `/admin-postTemplate/${id}`,
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

                // sttop loader effect
                saveButtonPostTemplate.disabled = false;
                buttonTextPostTemplate.textContent = "Save Changes";
                buttonSpinnerPostTemplate.classList.add("d-none");

                $("#editPostTemplateModal").modal("hide");
                fetchReplyTemplate();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);

                // sttop loader effect
                saveButtonPostTemplate.disabled = false;
                buttonTextPostTemplate.textContent = "Save Changes";
                buttonSpinnerPostTemplate.classList.add("d-none");
            },
        });
    });

    //copy
    $(".copyContents button").click(function () {
        let content = $(".content-display").html().trim();

        const CopysaveButton = document.getElementById("CopysaveBtn");
        const CopybuttonText = document.getElementById("CopybuttonText");
        const CopybuttonSpinner = document.getElementById("CopybuttonSpinner");

        // Show loader effect
        CopysaveButton.disabled = true;
        CopybuttonText.textContent = "Copying..";
        CopybuttonSpinner.classList.remove("d-none");

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

                    // sttop loader effect
                    CopysaveButton.disabled = false;
                    CopybuttonText.textContent = "Copy";
                    CopybuttonSpinner.classList.add("d-none");
                })
                .catch((err) => {
                    toastr.error("Failed to copy.");
                    console.error("Copy error:", err);

                    // sttop loader effect
                    CopysaveButton.disabled = false;
                    CopybuttonText.textContent = "Copy";
                    CopybuttonSpinner.classList.add("d-none");
                });
        } else {
            toastr.error("Clipboard API not supported.");

            // sttop loader effect
            CopysaveButton.disabled = false;
            CopybuttonText.textContent = "Copy";
            CopybuttonSpinner.classList.add("d-none");
        }
    });
});
