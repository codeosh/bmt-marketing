// public\js\replyTemplates.js
$(document).ready(function () {
    let ReplyTemplateData = []; // Store fetched data globally

    //get the data to automatically display on the bulletin and template container
    function fetchReplyTemplate() {
        $.ajax({
            url: "/fetch-replyTemplate",
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

        if (data.length === 0) { //mao nani ang data na ge renderan from fetchReplyTemplate(). so, if walay data, mo execute ni.
            $("#bulletinList").html('<div class="text-center text-red-500">No records found</div>');
            $("#templateList").html('<div class="text-center text-red-500">No records found</div>');
            return;
        }

        //if naay data.  Mo exceute ni na set of codes
        data.forEach(function (item) {
            let listItem = `
            <div class="d-flex justify-content-between align-items-center btn btn-light text-start shadow-sm p-2 rounded bulletin-item text-truncate"
                data-id="${item.id}" data-content="${item.content}" style="border: 1px solid #ddd;">
                <span class="text-truncate">${item.pname}</span>
                <div class="d-flex gap-1" style="height:25px;">
                    <button class="btn btn-sm btn-primary edit-replyTemplate h-100 d-flex justify-content-between align-items-center" 
                        data-id="${item.id}" data-content="${item.content}" data-pname="${item.pname}">
                        <i class="fas fa-edit" style="font-size:10px;"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-replyTemplate h-100 d-flex justify-content-between align-items-center" 
                        data-pname="${item.pname}" data-id="${item.id}">
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

        attachEvents(); // mao ni Attach event listeners to dynamically generated elements like katong edit, delete
    }

    //mao ni na function for dynamically search in which tawgon ni sya sa #searchBulletins which has keyup
    function filterReplyTemplate() {
        let searchTerm = $("#search").val().toLowerCase();//kuhaon niya agg ge input then i convert into lowercase weather it already upper or lower case
        let filteredData = ReplyTemplateData.filter(item =>
            item.pname.toLowerCase().includes(searchTerm)
        );//arrow function para i filter ang searchterm na

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
            $("#editReplyId").val(id);
            $("#editReplyName").val(pname);
            $("#editReplyContent").val(content);

            // Show the modal
            $("#editReplyModal").modal("show");
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
                        url: `/admin-replyTemplate/${id}`,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        success: function () {
                            toastr.success("Deleted successfully!");

                            // Fade out and remove the item smoothly
                            itemElement.fadeOut(300, function () {
                                $(this).remove();
                            });

                            fetchReplyTemplate();//refresh data if needed
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
    $("#replyTemplateForm").on("submit", function (e) {
        e.preventDefault();

        const saveButtonBulletin = document.getElementById("saveBtn-replyTemplate");
        const buttonTextBulletin = document.getElementById("buttonText-replyTemplate");
        const buttonSpinnerBulletin = document.getElementById("buttonSpinner-replyTemplate");
        const formData = $(this).serialize();

        // Show loader effect
        saveButtonBulletin.disabled = true;
        buttonTextBulletin.textContent = "Saving...";
        buttonSpinnerBulletin.classList.remove("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-replyTemplate",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                toastr.success("Added Successfully!");

                saveButtonBulletin.disable = false;
                buttonTextBulletin.textContent = "Save";
                buttonSpinnerBulletin.classList.add("d-none");

                fetchReplyTemplate();
                $("#ReplyTemplateModal").modal("hide");
                $("#replyTemplateForm")[0].reset();
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || "An error occurred.");
            },
        });
    });


    // Submit form for editing a bulletin
    $("#editReplyForm").submit(function (e) {
        e.preventDefault();

        const saveButtonReply  = document.getElementById("editsaveBtnReply");
        const buttonTextReply = document.getElementById("editbuttonTextReply");
        const buttonSpinnerReply = document.getElementById("editbuttonSpinnerReply");

        let id = $("#editReplyId").val();
        let pname = $("#editReplyName").val();
        let content = $("#editReplyContent").val();

        // Show loader effect
        saveButtonReply.disabled = true;
        buttonTextReply.textContent = "Saving...";
        buttonSpinnerReply.classList.remove("d-none");

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

                // sttop loader effect
                saveButtonReply.disabled = false;
                buttonTextReply.textContent = "Save Changes";
                buttonSpinnerReply.classList.add("d-none");
                
                $("#editReplyModal").modal("hide");
                fetchReplyTemplate();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);

                // sttop loader effect
                saveButtonReply.disabled = false;
                buttonTextReply.textContent = "Save Changes";
                buttonSpinnerReply.classList.add("d-none");
            },
        });
    });

    //copy
    $(".copyContents button").click(function () {
        let content = $(".content-display").text().trim();

        if (navigator.clipboard) {
            navigator.clipboard
                .writeText(content)
                .then(() => {
                    toastr.success("Copied to clipboard!");
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

