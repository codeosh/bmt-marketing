// public\js\bulletin.js
$(document).ready(function () {
<<<<<<< HEAD
    function fetchBulletins() {
        $.ajax({
            url: "/fetch-pricelist",
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
                            <button class="btn btn-sm btn-primary edit-pricelist h-100 d-flex justify-content-between align-items-center" data-id="${item.id}" data-content="${item.content}" data-pname="${item.pname}">
                                <i class="fas fa-edit" style="font-size:10px;"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-pricelist h-100 d-flex justify-content-between align-items-center" data-pname="${item.pname}" data-id="${item.id}">
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
                $(".edit-pricelist").click(function (e) {
                    e.stopPropagation(); // Prevent triggering the click event on .bulletin-item

                    let id = $(this).data("id");
                    let pname = $(this).data("pname");
                    let content = $(this).data("content");

                    // Populate the edit form (assuming you have a modal with input fields)
                    $("#editPricelistId").val(id);
                    $("#editPricelistName").val(pname);
                    $("#editPricelistContent").val(content);

                    // Show the modal
                    $("#editPricelistModal").modal("show");
                });

                // Attach delete event to dynamically added delete buttons
                $(".delete-pricelist").click(function (e) {
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
                                url: `/admin-priceList/${id}`,
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

    // Submit form via AJAX fro bulletin add
    $("#pricelistForm").on("submit", function (e) {
        e.preventDefault();

        const saveButtonPricelist = document.getElementById("saveBtn-pricelist");
        const buttonTextPricelist= document.getElementById("buttonText-pricelist");
        const buttonSpinnerPricelist= document.getElementById("buttonSpinner-pricelist");
        const formData = $(this).serialize();

        // Show loader effect
        saveButtonPricelist.disabled = true;
        buttonTextPricelist.textContent = "Saving...";
        buttonSpinnerPricelist.classList.remove("d-none");
=======
    // Fetch the content and bulletin and template name from the database
    $(document).on(
        "click",
        'li[data-type="bulletin"], li[data-type="template"]',
        function () {
            var id = $(this).data("id"); // Get the clicked item's ID

            var url = "/admin-priceList/" + id;

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json", // Ensure JSON response is expected
                success: function (response) {
                    $("#contentDisplay").html(response.content); // Display the content
                    $("#contentName").html(response.pname); // Display the pname
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

    // Add data for pricelist
    $("#pricelistForm")
        .off("submit")
        .on("submit", function (e) {
            e.preventDefault();

            const formData = $(this).serialize();

            const saveButton = document.getElementById("saveBtn");
            const buttonText = document.getElementById("buttonText");
            const buttonSpinner = document.getElementById("buttonSpinner");

            // Show loader effect
            saveButton.disabled = true;
            buttonText.textContent = "Saving...";
            buttonSpinner.classList.remove("d-none");
>>>>>>> c3392b091e2979d1493f8504a78976c421c65522

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

<<<<<<< HEAD
                saveButtonPricelist.disabled = false;
                buttonTextPricelist.textContent = "Save";
                buttonSpinnerPricelist.classList.add("d-none");
                
                fetchBulletins();

                // Close the modal
                $("#PriceListModal").modal("hide");

                // Reset the form
                $("#pricelistForm")[0].reset();
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
=======
                    // Reload the page after a short delay
                    setTimeout(function () {
                        window.location.href = "/admin-priceList"; // Redirect to the index page
                        saveButton.disabled = false;
                        buttonText.textContent = "Save";
                        buttonSpinner.classList.add("d-none");
                    }, 1000); // Adjust delay time as needed
                },
                error: function (xhr, status, error) {
                    // Turn off loader effect (ensure it runs even on error)
                    saveButton.disabled = false;
                    buttonText.textContent = "Save";
                    buttonSpinner.classList.add("d-none");

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
>>>>>>> c3392b091e2979d1493f8504a78976c421c65522
        });

    $("#editPricelistForm").submit(function (e) {
        e.preventDefault();

<<<<<<< HEAD
        let id = $("#editPricelistId").val();
        let pname = $("#editPricelistName").val();
        let content = $("#editPricelistContent").val();

        $.ajax({
            url: `/admin-priceList/${id}`,
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
                $("#editPricelistModal").modal("hide");
                fetchBulletins();
            },
            error: function (xhr) {
                toastr.error("Failed to update.");
                console.error("Error:", xhr.responseText);
            },
        });
    });
=======
        Swal.fire({
            title: "Are you sure?",
            text: `Do you want to delete the item: ${itemName}?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST", // also use post og mag delete
                    url: `/admin-priceList/${itemId}`, //  correct RESTful URL
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        _method: "DELETE",
                    },
                    success: function (response) {
                        toastr.success(
                            response.message || "Deleted Successfully!"
                        );
                        $(`.item-row[data-id="${itemId}"]`).remove(); // Remove item from list
                        window.location.href = "/admin-priceList";
                    },
                    error: function (xhr) {
                        if (xhr.status === 404) {
                            toastr.error("Error: Record not found.");
                        } else {
                            toastr.error(
                                xhr.responseJSON?.message ||
                                    "An error occurred while deleting."
                            );
                        }
                    },
                });
            }
        });
    });

    //copy function
    $(document)
        .off("click", ".copyButton button")
        .on("click", ".copyButton button", function () {
            var contentElement = document.querySelector("#contentDisplay");

            // const copyButton = document.getElementById("copyBtn");
            // const buttonText = document.getElementById("buttonText");
            // const buttonSpinner = document.getElementById("buttonSpinner");

            if (contentElement) {
                var contentText = contentElement.innerText.trim();

                if (contentText) {
                    navigator.clipboard
                        .writeText(contentText)
                        .then(() => {
                            // Show loader effect
                            // copyButton.disabled = true;
                            // buttonText.textContent = "Copying...";
                            // buttonSpinner.classList.remove("d-none");

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
>>>>>>> c3392b091e2979d1493f8504a78976c421c65522
});
