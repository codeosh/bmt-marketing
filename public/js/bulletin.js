// public\js\bulletin.js
$(document).ready(function () {
    let BulletinData = []; // Store fetched data globally

    let url = Laravel.user_role === 'admin' ? "/fetch-bulletins" : "/fetch-user-bulletins";

    //get the data to automatically display on the bulletin and template container
    function fetchBulletin() {
        $.ajax({
            url: url, // this wil chooses which route to access base on the result sa ternary above
            type: "GET",
            success: function (response) {
                if (!Array.isArray(response)) {
                    toastr.error("Invalid data format received.");
                    return;
                }

                BulletinData = response; // Store data globally
                displayBulletin(BulletinData); // Render data
            },
            error: function () {
                toastr.error("Failed to fetch data.");
            },
        });
    }

    function displayBulletin(data) {
        $("#bulletinList").empty();
        $("#templateList").empty();

        if (data.length === 0) {
            //mao nani ang data na ge renderan from fetchBulletin() og filterPricelist(). so, if walay data, mo execute ni.
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
            let listItem = `
            <div class="d-flex justify-content-between align-items-center btn btn-light text-start shadow-sm p-2 rounded bulletin-item text-truncate"
                data-id="${item.id}" data-content="${item.content}" style="border: 1px solid #ddd;">
                <span class="text-truncate">${item.pname}</span>

                ${Laravel.user_role === 'admin' ? `
                <div class="d-flex gap-1" style="height:25px;">
                    <button class="btn btn-sm btn-primary edit-bulletin h-100 d-flex justify-content-between align-items-center" 
                        data-id="${item.id}" data-content="${item.content}" data-pname="${item.pname}">
                        <i class="fas fa-edit" style="font-size:10px;"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-bulletin h-100 d-flex justify-content-between align-items-center" 
                        data-pname="${item.pname}" data-id="${item.id}">
                        <i class="fas fa-trash" style="font-size:10px;"></i>
                    </button>
                </div>
                ` : ``}
                
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
    function filterPricelist() {
        let searchTerm = $("#search").val().toLowerCase(); //kuhaon niya agg ge input then i convert into lowercase weather it already upper or lower case
        let filteredData = BulletinData.filter((item) =>
            item.pname.toLowerCase().includes(searchTerm)
        ); //arrow function para i filter ang searchterm na

        displayBulletin(filteredData); //then i pasa ang na filter out na didtos displayBulletin na function para ma display na sya
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
        $(".edit-bulletin").click(function (e) {
            e.stopPropagation();
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

        // Delete event
        $(".delete-bulletin").click(function (e) {
            e.stopPropagation();

            let id = $(this).data("id");
            let pname = $(this).data("pname");
            let itemElement = $(this).closest(".bulletin-item"); //get the class bulletin-item gekan listItem naas babaw

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

                            fetchBulletin(); //refresh data if needed
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
    fetchBulletin();

    //i-trigger na niya ag Search input then para ma execute na this functionality
    $("#search").on("keyup", function () {
        filterPricelist();
    });

    // Submit form for adding a bulletin
    $("#bulletinForm").on("submit", function (e) {
        e.preventDefault();

        const saveButtonBulletin = document.getElementById("saveBtnBulletin");
        const buttonTextBulletin =
            document.getElementById("buttonTextBulletin");
        const buttonSpinnerBulletin = document.getElementById(
            "buttonSpinnerBulletin"
        );
        const formData = $(this).serialize();

        // Show loader effect
        saveButtonBulletin.disabled = true;
        buttonTextBulletin.textContent = "Saving...";
        buttonSpinnerBulletin.classList.remove("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-bulletin",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                toastr.success("Added Successfully!");

                saveButtonBulletin.disabled = false;
                buttonTextBulletin.textContent = "Save";
                buttonSpinnerBulletin.classList.add("d-none");

                fetchBulletin();
                $("#bulletinModal").modal("hide");
                $("#bulletinForm")[0].reset();
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || "An error occurred.");

                //stop loader
                saveButtonBulletin.disabled = false;
                buttonTextBulletin.textContent = "Save";
                buttonSpinnerBulletin.classList.add("d-none");
            },
        });
    });

    // Submit form for editing a bulletin
    $("#editBulletinForm").submit(function (e) {
        e.preventDefault();

        const saveButtonBulletin = document.getElementById(
            "editsaveBtnBulletin"
        );
        const buttonTextBulletin = document.getElementById(
            "editbuttonTextBulletin"
        );
        const buttonSpinnerBulletin = document.getElementById(
            "editbuttonSpinnerBulletin"
        );

        let id = $("#editBulletinId").val();
        let pname = $("#editBulletinName").val();
        let content = $("#editBulletinContent").val();

        // Show loader effect
        saveButtonBulletin.disabled = true;
        buttonTextBulletin.textContent = "Saving...";
        buttonSpinnerBulletin.classList.remove("d-none");

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
                toastr.success("Updated successfully!");

                // sttop loader effect
                saveButtonBulletin.disabled = false;
                buttonTextBulletin.textContent = "Save Changes";
                buttonSpinnerBulletin.classList.add("d-none");

                $("#editBulletinModal").modal("hide");
                fetchBulletin();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);

                // sttop loader effect
                saveButtonBulletin.disabled = false;
                buttonTextBulletin.textContent = "Save Changes";
                buttonSpinnerBulletin.classList.add("d-none");
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
