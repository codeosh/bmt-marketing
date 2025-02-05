// public\js\bulletin.js
$(document).ready(function () {
    function fetchBulletins() {
        $.ajax({
            url: "/fetch-pricelist",
            type: "GET",
            success: function (response) {
                if (!Array.isArray(response)) {
                    toastr.error("Invalid data format received.");
                    return;
                }

                $("#PriceListbulletinList").empty();
                $("#PriceListtemplateList").empty();

                response.forEach(function (item) {
                    let listItem = `
                    <div class="d-flex justify-content-between align-items-center btn btn-light text-start shadow-sm p-2 rounded bulletin-item text-truncate"
                        data-id="${item.id}" data-content="${item.content}" style="border: 1px solid #ddd;">
                        <span class="text-truncate">${item.pname}</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary PriceList-edit" data-pricelistid="${item.id}" data-pricelistcontent="${item.content}" data-pricelistpname="${item.pname}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger PriceList-delete" data-pname="${item.pname}" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;

                    if (item.kind === "Bulletin") {
                        $("#PriceListbulletinList").append(listItem);
                    } else if (item.kind === "Template") {
                        $("#PriceListtemplateList").append(listItem);
                    }
                });

                // Attach click event to dynamically added list items
                $(".PriceList-bulletin-item").click(function () {
                    let content = $(this).data("content");
                    let pname = $(this).text().trim();

                    content = content.replace(/\n/g, "<br>");
                    content = content.replace(/ /g, "&nbsp;");

                    $(".content-display").html(content);
                    $(".display-item-name").text(pname);
                });

                // Attach edit event to dynamically added edit buttons
                $(".PriceList-edit").click(function (e) {
                    e.stopPropagation(); // Prevent triggering the click event on .bulletin-item

                    let pricelistid = $(this).data("pricelistid");
                    let pricelistpname = $(this).data("pricelistpname");
                    let pricelistcontent = $(this).data("pricelistcontent");

                    // Populate the edit form 
                    $("#editPricelistId").val(pricelistid);
                    $("#editPricelistName").val(pricelistpname);
                    $("#editPricelistContent").val(pricelistcontent);

                    // Show the modal
                    $("#editPricelistModal").modal("show");
                });

                // Attach delete event to dynamically added delete buttons
                $(".PriceList-delete").click(function (e) {
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
                                url: `/admin-pricelist/${id}`,
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

        const saveButtonpricelist = document.getElementById("saveBtn-pricelist");
        const buttonTextpricelist = document.getElementById("buttonText-pricelist");
        const buttonSpinnerpricelist = document.getElementById("buttonSpinner-pricelist");
        const formData = $(this).serialize();

        // Show loader effect
        saveButtonpricelist.disabled = true;
        buttonTextpricelist.textContent = "Saving...";
        buttonSpinnerpricelist.classList.remove("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-priceList",
            data: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                toastr.success("Added Successfully!");

                saveButtonpricelist.disabled = false;
                buttonTextpricelist.textContent = "Save";
                buttonSpinnerpricelist.classList.add("d-none");
                
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
        });
    });

    //edit
    $("#editPricelistForm").submit(function (e) {
        e.preventDefault();

        let PricelistId = $("#editPricelistId").val();
        let Pricelistpname = $("#editPricelistName").val();
        let Pricelistcontent = $("#editPricelistContent").val();

        $.ajax({
            url: `/admin-pricelist/${PricelistId}`,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                pname: Pricelistpname,
                content: Pricelistcontent,
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
});
