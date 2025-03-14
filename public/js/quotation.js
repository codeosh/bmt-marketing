//function to automatically calculate the line amount and total amount
function calculateLineAmount(element) {

    let row = element.closest("tr");

    // Get input values and remove commas if present
    let quantity = parseFloat(row.querySelector(".quantity").value.replace(/,/g, "")) || 0;
    let unitPrice = parseFloat(row.querySelector(".unit-price").value.replace(/,/g, "")) || 0;
    let lineAmount = quantity * unitPrice;

    // Format line amount with commas
    row.querySelector(".line-amount").value = lineAmount.toLocaleString("en-US",{ minimumFractionDigits: 2, maximumFractionDigits: 2 });

    calculateTotal();
}

//for total
function calculateTotal() {
    let total = 0;

    document.querySelectorAll(".line-amount").forEach((input) => {
        total += parseFloat(input.value.replace(/,/g, "")) || 0; // Remove commas before summing
    });

    // Format total with commas
    document.getElementById("totalAmount").value = total.toLocaleString("en-US",{ minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Automatically format user input to include commas
document.querySelectorAll(".quantity, .unit-price").forEach((input) => {
    input.addEventListener("input", function () {
        let value = this.value.replace(/,/g, ""); // Remove existing commas
        if (!isNaN(value) && value !== "") {
            this.value = parseFloat(value).toLocaleString("en-US");
        }
    });
});



$(document).ready(function () {
    //save customer and ilang items ge palit
    // Listen for click event on Save button
    $("#saveBtn-customers").on("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        let saveCustomerINfo = Laravel.user_role === "admin" ? "/admin-quotation" : "/user-quotation";

        // Get button elements for UI feedback during submission
        const saveBtnquote = document.getElementById("saveBtn-customers");
        const buttonTextcustomer = document.getElementById("buttonText-customer");
        const buttonSpinnercustomer = document.getElementById("buttonSpinner-customer");
        const buttonTextsaveIcon = document.getElementById("saveIcon");

        // Start loading animation (disable button and show spinner)
        saveBtnquote.disabled = true;
        buttonTextcustomer.textContent = "";
        buttonSpinnercustomer.classList.remove("d-none");
        buttonTextsaveIcon.classList.add("d-none");

        // Create FormData object to send data via AJAX
        let formData = new FormData();

        // Append CSRF token for Laravel validation
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        // Collect customer input values and trim spaces
        let customerName = ($("#customerName").val() ?? "").trim();
        let nos = ($("#customerQNumber").val() ?? "").trim();
        let address = ($("#customerAddress").val() ?? "").trim();
        let contact = ($("#customerContact").val() ?? "").trim();
        let attn = ($("#customerATN").val() ?? "").trim();
        let terms = ($("#customerTerms").val() ?? "").trim();

        let Condition = ($("#Condition").val() ?? "").trim();
        let Warranty = ($("#Warranty").val() ?? "").trim();
        let vat = ($("#VAT").val() ?? "").trim();
        let Availability = ($("#Availability").val() ?? "").trim();
        let rd = ($("#RD").val() ?? "").trim();
        let PriceEffectivity = ($("#PriceEffectivity").val() ?? "").trim();

        // Validate required customer fields (Customer Name and Q Number are required)
        if (!customerName) {
            toastr.error("Please enter the: customer name.");
            stopLoading(); // Reset UI on error
            return;
        }
        if (!nos) {
            toastr.error("Please enter the: Q no.");
            stopLoading();
            return;
        }

        // Append customer data to FormData
        formData.append("customer_name", customerName);
        formData.append("nos", nos);
        formData.append("address", address);
        formData.append("contact", contact);
        formData.append("attn", attn);
        formData.append("terms", terms);

        // Track first and last valid item row
        let foundFirstValidItem = false;
        let lastValidIndex = -1;
        let tempRows = []; // Temporary array for row data

        // Loop through table rows to collect valid item data
        $(".table tbody tr").each(function (index) {
            let quantity = ($(this).find(".quantity").val() ?? "").trim();
            let unit = ($(this).find("select").val() ?? "").trim();
            let itemName = ($(this).find(".item-name").val() ?? "").trim();
            let unitPrice = ($(this).find(".unit-price").val() ?? "").trim().replace(/,/g, "");
            let lineAmount = ($(this).find(".line-amount").val() ?? "").trim().replace(/,/g, "");

            // Check if row contains any valid data
            let isRowValid = quantity || unit || itemName || unitPrice || lineAmount;

            if (isRowValid) {
                foundFirstValidItem = true;
                lastValidIndex = tempRows.length; // Store last valid row index
            }

            // If at least one valid item exists, store row data
            if (foundFirstValidItem) {
                tempRows.push({
                    quantity: quantity || "",
                    unit: unit || "",
                    itemName: itemName || "",
                    unitPrice: unitPrice || "",
                    lineAmount: parseFloat(lineAmount) || "",
                });
            }
        });

        // Remove trailing empty rows
        let validRows = tempRows.slice(0, lastValidIndex + 1);

        // Prevent submission if no valid items
        if (validRows.length === 0) {
            toastr.error("Please enter at least one valid item before saving.");
            stopLoading();
            return;
        }

        // Append valid items to FormData
        validRows.forEach((row, index) => {
            formData.append(`items[${index}][quantity]`, row.quantity);
            formData.append(`items[${index}][unit]`, row.unit);
            formData.append(`items[${index}][item_name]`, row.itemName);
            formData.append(`items[${index}][unit_price]`, row.unitPrice);
            formData.append(`items[${index}][line_amount]`, row.lineAmount);
        });

        // Append customer data to FormData
        formData.append("Condition", Condition);
        formData.append("Warranty", Warranty);
        formData.append("vat", vat);
        formData.append("Availability", Availability);
        formData.append("rd", rd);
        formData.append("PriceEffectivity", PriceEffectivity);

        // Submit data via AJAX to Laravel backend
        $.ajax({
            url: saveCustomerINfo, // API endpoint
            type: "POST", // HTTP request method
            data: formData, // Form data
            processData: false, // Prevent jQuery from processing data
            contentType: false, // Prevent jQuery from setting content-type header
            success: function (response) {
                toastr.success(response.success); // Show success message
                stopLoading(); // Reset UI
                location.reload(); // Refresh page
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log error to console
                toastr.error("Something went wrong! Refresh or Try again later"); // Show error message
                stopLoading(); // Reset UI
            },
        });

        // Function to reset UI after loading
        function stopLoading() {
            saveBtnquote.disabled = false;
            buttonTextcustomer.textContent = "Save";
            buttonSpinnercustomer.classList.add("d-none");
            buttonTextsaveIcon.classList.remove("d-none");
        }
    });

    // Show the information of the clicked row
    // Handle row click event
    $("#quotationTable tbody").on("click", ".quote-row", function () {
        
        // Get the quotation ID from the clicked row's data attribute
        let quoteId = $(this).data("id");

        let showCustomerINfo = Laravel.user_role === "admin" ? `/admin-quotation/${quoteId}` : `/user-quotation/${quoteId}`;

        $("#updateBtn-customers").removeClass("d-none"); //show the edit btn
        $("#CopyBtn-customers").removeClass("d-none"); //show the edit btn

        // Get the Save button and text elements
        const saveBtnquote = document.getElementById("saveBtn-customers");

        // Disable the Save button to prevent multiple clicks while loading
        saveBtnquote.disabled = true;

        // Make an AJAX GET request to fetch the quotation data based on the clicked row's ID
        $.ajax({
            url: showCustomerINfo, // API endpoint to fetch the quotation data
            type: "GET",
            success: function (data) {
                console.log("Fetched data:", data); // Debugging: Log fetched data to the console

                // Check if data is missing or contains an error
                if (!data || data.error) {
                    console.error("No data found for this ID.");
                    return;
                }

                // Populate the edit button with the quotation ID
                $("#updateBtn-customers").attr("data-is", quoteId);
                // Populate the copy button with the quotation ID
                $("#CopyBtn-customers").attr("data-copyID", quoteId);

                // Populate customer details in the input fields
                $("#customerName").val(data.customerName);
                $("#customerContact").val(data.customerContact);
                $("#customerQNumber").val(data.quotationNo);
                $("#customerAddress").val(data.address);
                $("#customerATN").val(data.attn);
                $("#customerDateIssued").val(data.date);
                $("#customerTerms").val(data.terms);

                let totalAmount = 0; // Initialize total amount variable

                // Loop through each row in the items table to populate data
                $("#items-table tbody tr").each(function (index, row) {
                    // Check if there is corresponding item data for this row
                    if (data.items[index]) {
                        let item = data.items[index]; // Get the current item data

                        // Populate row fields with item data
                        $(row).find(".quantity").val(item.quantity);
                        $(row).find("select").val(item.unit);
                        $(row).find(".item-name").val(item.item_name);
                        // Convert and display unit price and line amount with commas
                        $(row).find(".unit-price").val(item.unit_price ? parseFloat( item.unit_price).toLocaleString("en-US", {minimumFractionDigits: 2, maximumFractionDigits: 2,}) : "" ); //kaning naa sud na taas ge convert niya ag way kama na numbers from db to naanay comma nig display);
                        $(row).find(".line-amount").val(item.line_amount ? parseFloat( item.line_amount).toLocaleString("en-US", {minimumFractionDigits: 2, maximumFractionDigits: 2,}): "" ); //kaning naa sud na taas ge convert niya ag way kama na numbers from db to naanay comma nig display

                        // Add line amount to the total amount calculation
                        totalAmount += parseFloat(item.line_amount) || 0;
                    } else {
                        // If there's no corresponding item, clear the row fields
                        $(row).find("input, select").val("");
                    }
                });

                // Update the total amount field with the calculated total (formatted with commas)
                $("#totalAmount").val(totalAmount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2,}));

                // Populate QoutotaionTermsCondtionRemarks in the input fields
                $("#Condition").val(data.condition);
                $("#Warranty").val(data.warranty);
                $("#VAT").val(data.vat);
                $("#Availability").val(data.availability);
                $("#RD").val(data.rd);
                $("#PriceEffectivity").val(data.price_effectivity);
            },
            error: function (xhr) {
                // Log error message in case of an AJAX failure
                console.log("Error fetching data:", xhr.responseText);
            },
        });
    });

    // Add new quotation button click event
    $("#new-Quote").on("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        let addNewQuote = Laravel.user_role === "admin" ? "/get-latest-quotation" : "/get-user-latest-quotation";

        $("#updateBtn-customers").addClass("d-none"); //hide edit btn
        $("#CopyBtn-customers").addClass("d-none"); //hide copy btn

        //save button
        const saveBtnquote = document.getElementById("saveBtn-customers");
        const buttonTextcustomer = document.getElementById("buttonText-customer");

        //add new button
        const addnewBtnquote = document.getElementById("saveBtn-customers");
        const adnewwbuttonTextcustomer = document.getElementById("buttonText-Quote");
        const adnewwbuttonSpinner = document.getElementById("buttonSpinner-Quote");
        const adnewwIcon = document.getElementById("addIcon");

        // Get latest quotation number via AJAX
        $.ajax({
            url: addNewQuote, // Laravel route
            type: "GET",
            dataType: "json",
            success: function (response) {
                // Set the new quotation number in the input field
                $("#customerQNumber").val(response.quotation_no);
            },
            error: function () {
                toastr.error("Failed to fetch latest quotation number.");
            },
        });

        //addnew start loading
        addnewBtnquote.disabled = true;
        adnewwbuttonTextcustomer.textContent = "";
        adnewwbuttonSpinner.classList.remove("d-none");
        adnewwIcon.classList.add("d-none");

        $("input").val(""); // Clears all input fields on the page
        $("select").val("");

        //put to default info
        $("#Condition").val("All Brand New 1 Year on");
        $("#Warranty").val("All");
        $("#VAT").val("Major Parts");
        $("#Availability").val("Excluded");
        $("#RD").val("Onstock");
        $("#PriceEffectivity").val("1 Week");

        //for the date
        let today = new Date().toISOString().split("T")[0]; // Format: YYYY-MM-DD
        $("#customerDateIssued").val(today);

        //add new stop loading
        addnewBtnquote.disabled = false;
        adnewwbuttonTextcustomer.textContent = "Add new";
        adnewwbuttonSpinner.classList.add("d-none");
        adnewwIcon.classList.remove("d-none");

        //change the save btn to a workable state/mogana na sya
        saveBtnquote.disabled = false;
        buttonTextcustomer.textContent = "Save";
    });

    //quotation search
    $("#search").on("keyup", function () {
        let searchTerm = $(this).val().toLowerCase(); // Convert input to lowercase
        let alert = document.getElementById("alertForNoRecordsWhenSearch");

        $(".quote-row").each(function () {
            let customerName = $(this).find("td:eq(1)").text().toLowerCase(); // Get customer name from second column

            // Show/hide row based on search term
            if (customerName.includes(searchTerm)) {
                alert.classList.add("d-none");
                $(this).show();
            } else {
                $(this).hide();
                alert.classList.remove("d-none");
            }
        });
    });

    //for delete para sa customer and their items
    // Variable to store the selected row ID
    let selectedRowId = null;
    // Handle row selection and highlight the selected row
    $(".quote-row").on("click", function () {
        selectedRowId = $(this).data("id"); // Store selected row ID

        // Remove Bootstrap highlighting from all rows and highlight the clicked one, para is rajuy ma highlight and delete, kay , if wala ni sya pedi nimo sya ma highlight tanan then ma delete tong na highligh tanan, unless if naa ni sya para nug click nimos uban kato ra ang ma highlight then mawala ag highlight sa previous one nimo para isa rajuy pedi ma delete
        $(".quote-row").removeClass("table-danger");
        $(this).addClass("table-danger"); // Bootstrap class for a red highlight
    });

    // Handle delete action
    $("#deleteBtn").on("click", function () {

        let deleteQuote = Laravel.user_role === "admin" ? `/admin-quotation/${selectedRowId}` : `/user-quotation/${selectedRowId}`;
        
        if (!selectedRowId) {
            toastr.error("Please select a record to delete.");
            return;
        }

        Swal.fire({
            title: "Are you sure?",
            text: "This will delete the customer and associated items.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteQuote,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function () {
                        toastr.success("Deleted successfully!");

                        // Remove the selected row from the table with fade effect
                        $(".quote-row.table-danger").fadeOut(300, function () {
                            $(this).remove();
                        });

                        // Reset the selectedRowId after deletion
                        selectedRowId = null;
                    },
                    error: function (xhr) {
                        toastr.error("Failed to delete.");
                        console.error("Error:", xhr.responseText);
                    },
                });
            }
        });
    });

    //for converting to PNG ni sya
    document.getElementById("convertCustomerDetailsBtnToPNG").addEventListener("click", function () {

        let element = document.getElementById("customerDetailsContainer");
        let saveBtnquote = document.getElementById("downloadImage"); // Download button
        
        let buttonTextcustomer = document.getElementById("buttonText-Quotationpng"); // Button text span
        let buttonSpinnercustomer = document.getElementById("buttonSpinner-Quotationpng"); // Loading spinner
        let buttonTextsaveIcon = document.getElementById("saveQuotaionIconpng"); // Save icon

            // Temporarily adjust styles for full capture
            let originalStyle = {
                width: element.style.width,
                maxWidth: element.style.maxWidth,
                overflow: element.style.overflow,
                height: element.style.height,
            };

            element.style.width = element.scrollWidth + "px"; // Ensure full width
            element.style.maxWidth = "none"; // Prevent width limits
            element.style.overflow = "visible"; // Show hidden content
            element.style.height = "auto"; // Ensure full height capture

            html2canvas(element, {
                scrollX: 0,
                scrollY: -window.scrollY, // Ensure it captures from the top
                windowWidth: document.documentElement.scrollWidth,
                windowHeight: element.scrollHeight, // Capture the full height
                useCORS: true, // If there are external images
            }).then((canvas) => {
                let imageURL = canvas.toDataURL("image/png");

                // Restore original styles
                element.style.width = originalStyle.width;
                element.style.maxWidth = originalStyle.maxWidth;
                element.style.overflow = originalStyle.overflow;
                element.style.height = originalStyle.height;

                // Set image preview in modal
                document.getElementById("previewImage").src = imageURL;

                // Show the modal
                let modal = new bootstrap.Modal(
                    document.getElementById("imagePreviewModal")
                );
                modal.show();

                // Set download button action
                document.getElementById("downloadImage").onclick = function () {
                    // Start loading animation (disable button and show spinner)
                    saveBtnquote.disabled = true;
                    buttonTextcustomer.textContent = "";
                    buttonSpinnercustomer.classList.remove("d-none");
                    buttonTextsaveIcon.classList.add("d-none");

                    let link = document.createElement("a");
                    link.href = imageURL;
                    link.download = "customer-details.png";
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Stop loading animation after a short delay to ensure download starts
                    setTimeout(() => {
                        saveBtnquote.disabled = false;
                        buttonTextcustomer.textContent = "Download Image";
                        buttonSpinnercustomer.classList.add("d-none");
                        buttonTextsaveIcon.classList.remove("d-none");
                    }, 500); // Adjust delay if necessary
                };
            });
        });

    // for PRINT functionality
    document.getElementById("printButton").addEventListener("click", function () {

            let customerDetailsContainer = document.getElementById("detailsForPrint");

            if (!customerDetailsContainer) {
                alert("Error: Content container not found!");
                return;
            }

            let printBtnquotep = document.getElementById("printButton");
            let buttonTextcustomerp = document.getElementById("buttonText-Quotation");
            let buttonSpinnercustomerp = document.getElementById("buttonSpinner-Quotation");
            let buttonTextsaveIconp =document.getElementById("saveQuotaionIcon");

            // Clone the container
            let clonedContent = customerDetailsContainer.cloneNode(true);

            // Remove disabled attribute from inputs and force black text
            clonedContent.querySelectorAll("input[disabled]").forEach((input) => {
                    input.removeAttribute("disabled");
                    input.style.color = "black";
                    input.style.backgroundColor = "white";
                });

            // Convert all <select> elements to their selected values
            clonedContent.querySelectorAll("select").forEach((select) => {
                // Get the latest value from the live DOM, not just the cloned version
                let liveSelect = document.querySelector(`[name="${select.name}"]`);
                let selectedValue = liveSelect ? liveSelect.value : "";

                console.log("Live Selected Value:", selectedValue);

                let selectedText = selectedValue ? Array.from(select.options).find((option) => option.value === selectedValue)?.text || selectedValue: "";

                console.log("Selected Text After Fix:", selectedText);

                let span = document.createElement("span");
                span.textContent = selectedText;
                span.style.color = "black";

                select.parentNode.replaceChild(span, select); // Replace <select> with <span>
            });

            // Start loading animation (disable button and show spinner)
            setTimeout(() => {
                printBtnquotep.disabled = true;
                buttonTextcustomerp.textContent = "";
                buttonSpinnercustomerp.classList.remove("d-none");
                buttonTextsaveIconp.classList.add("d-none");
            }, 500);

            // Create an iframe
            let iframe = document.createElement("iframe");
            iframe.style.position = "absolute";
            iframe.style.width = "0px";
            iframe.style.height = "0px";
            iframe.style.border = "none";
            document.body.appendChild(iframe);

            let doc = iframe.contentWindow.document;
            doc.open();
            doc.write(`
                <html>
                <head>
                    <title>Print Preview</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <link rel="stylesheet" href="${document.querySelector('link[href*="bootstrap"]')?.href || ""}">
                    <link rel="stylesheet" href="${document.querySelector('link[href*="style.css"]')?.href || ""}">
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
                    <style>
                        @media print {
                            body {
                                margin: 0px;
                                font-family: 'Poppins', sans-serif;
                            }
                            input {
                                color: black !important;
                                background-color: white !important;
                                -webkit-print-color-adjust: exact;
                            }
                            .bg-secondary {
                                background-color: #6c757d !important;
                                -webkit-print-color-adjust: exact;
                            }
                            th {
                                background-color: rgb(235, 208, 157) !important;
                                color: black !important;
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                        }
                    </style>
                </head>
                <body></body>
                </html>
            `);
            doc.close();

            // Ensure styles are fully loaded before appending content and printing
            iframe.onload = function () {
                requestAnimationFrame(() => {
                    doc.body.appendChild(clonedContent);
                    setTimeout(() => {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                        document.body.removeChild(iframe);
                    }, 500);
                });
            };

            // Stop loading animation
            setTimeout(() => {
                printBtnquotep.disabled = false;
                buttonTextcustomerp.textContent = "Print";
                buttonSpinnercustomerp.classList.add("d-none");
                buttonTextsaveIconp.classList.remove("d-none");
            }, 500);
        });

    
    //for changing header and footer
    // Declare selectedType globally
    let selectedType = "";

    // Open modal and set the correct image source when clicking an image
    $(document).on("click", ".img-head", function () {

        let elementPriceQuotation = $("#deatailsForHeaderAndFooter").html();
        let quotationId = $(this).data("id"); // Get quotation ID
        selectedType = $(this).data("type"); // Get type (header/footer)
        let imageUrl = $(this).attr("src"); // Get current image URL

        let imageUrlfooter = $("#foot").attr("src");
        let imageUrlHeader = $("#head").attr("src");

        $("#deatils").html(elementPriceQuotation);
        $("#quotationId").val(quotationId); // Store ID in hidden input
        $("#imageType").val(selectedType); // Store whether it's header or footer

        // Determine where to show the preview
        if (selectedType === "header") {
            $("#modalHeaderImage").attr("src", imageUrl); // Show header image in modal
            $("#modalFooterImage").attr("src", imageUrlfooter); // Clear footer preview
        } else if (selectedType === "footer") {
            $("#modalFooterImage").attr("src", imageUrl); // Show footer image in modal
            $("#modalHeaderImage").attr("src", imageUrlHeader); // Clear header preview
        }

        $("#imageModal").modal("show"); // Show modal
    });

    // image/File Input Change Event - Show Preview in Modal
    $("#fileInput").on("change", function (event) {
        let file = event.target.files[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                // Update only the correct preview section (header/footer)
                if (selectedType === "header") {
                    $("#modalHeaderImage").attr("src", e.target.result);
                } else if (selectedType === "footer") {
                    $("#modalFooterImage").attr("src", e.target.result);
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Save Image - Upload to Server
    $("#saveImageBtn").on("click", function () {

        let saveImageBtn = document.getElementById("saveImageBtn");
        let buttonTextQuotationEditHeadAndFooter = document.getElementById("buttonText-QuotationEditHeadAndFooter");
        let buttonSpinnerQuotationEditHeadAndFooter = document.getElementById("buttonSpinner-QuotationEditHeadAndFooter");
        let saveQuotaionIconEditHeadAndFooter = document.getElementById("saveQuotaionIconEditHeadAndFooter");

        let fileInput = $("#fileInput")[0].files[0];
        let quotationId = $("#quotationId").val();
        let updateIMG = Laravel.user_role === "admin" ? `/admin-update-image/${quotationId}` : `/user-update-image/${quotationId}`;

        //start loading
        saveImageBtn.disabled = true;
        buttonTextQuotationEditHeadAndFooter.textContent = "";
        buttonSpinnerQuotationEditHeadAndFooter.classList.remove("d-none");
        saveQuotaionIconEditHeadAndFooter.classList.add("d-none");

        if (!fileInput || !selectedType) {
            toastr.error("Please select an image before saving.");

            //stop loading
            saveImageBtn.disabled = false;
            buttonTextQuotationEditHeadAndFooter.textContent = "Change Image";
            buttonSpinnerQuotationEditHeadAndFooter.classList.add("d-none");
            saveQuotaionIconEditHeadAndFooter.classList.remove("d-none");

            return;
        }

        let formData = new FormData();
        formData.append("image", fileInput);
        formData.append("type", selectedType); // Pass selected type (header/footer)
        //formData.append('_method', 'PUT'); // Laravel requires this for updates

        $.ajax({
            url: updateIMG,
            type: "POST", // Laravel will interpret as PUT due to _method
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log("Response from server:", response); // Debug

                if (response.success) {
                    toastr.success("Image updated successfully!");

                    // Ensure response.image_url is correct
                    let newImageUrl = response.image_url + "?t=" + new Date().getTime();
                    //console.log("New Image URL:", newImageUrl); // Debug

                    // Select the correct image dynamically
                    let imageSelector = `.img-head[data-id="${quotationId}"][data-type="${selectedType}"]`;
                    //console.log("Targeted Image Selector:", imageSelector); // Debug

                    $(imageSelector).attr("src", newImageUrl); // Update image immediately

                    //stop loading
                    saveImageBtn.disabled = false;
                    buttonTextQuotationEditHeadAndFooter.textContent = "Change Image";
                    buttonSpinnerQuotationEditHeadAndFooter.classList.add("d-none");
                    saveQuotaionIconEditHeadAndFooter.classList.remove("d-none");

                    $("#imageModal").modal("hide"); // Close modal
                } else {

                    toastr.error("Failed to update image.");
                    //stop loading
                    saveImageBtn.disabled = false;
                    buttonTextQuotationEditHeadAndFooter.textContent ="Change Image";
                    buttonSpinnerQuotationEditHeadAndFooter.classList.add("d-none");
                    saveQuotaionIconEditHeadAndFooter.classList.remove("d-none");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText || error);
                toastr.error("Something went wrong!");

                //stop loading
                saveImageBtn.disabled = false;
                buttonTextQuotationEditHeadAndFooter.textContent = "Change Image";
                buttonSpinnerQuotationEditHeadAndFooter.classList.add("d-none");
                saveQuotaionIconEditHeadAndFooter.classList.remove("d-none");
            },
        });
    });

    // Listen for click event on EDIT button
    $("#updateBtn-customers").on("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        let quoteIdupdate = $(this).attr("data-is"); // Get the ID of the edited quotation
        let edit = Laravel.user_role === "admin" ? `/admin-quotation/${quoteIdupdate}` : `/user-quotation/${quoteIdupdate}`;

        // Ensure quoteId exists
        if (!quoteIdupdate) {
            toastr.error("Quotation ID is missing.");
            return;
        }

        // Get button elements for UI feedback during submission
        const updatesaveBtnquote = document.getElementById("updateBtn-customers");
        const updatebuttonTextcustomer = document.getElementById("updatebuttonText-customer");
        const updatebuttonSpinnercustomer = document.getElementById("updatebuttonSpinner-customer");
        const updatebuttonTextsaveIcon =document.getElementById("saveupdateIcon");

        // Start loading animation (disable button and show spinner)
        updatebuttonTextcustomer.textContent = "";
        updatebuttonSpinnercustomer.classList.remove("d-none");
        updatesaveBtnquote.disabled = true;
        updatebuttonTextsaveIcon.classList.add("d-none");

        // Create FormData object to send data via AJAX
        let formData = new FormData();

        // Append CSRF token for Laravel validation
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        formData.append("_method", "PUT"); // Laravel requires PUT/PATCH for updates

        // Collect customer input values and trim spaces
        let customerName = ($("#customerName").val() ?? "").trim();
        let nos = ($("#customerQNumber").val() ?? "").trim();
        let address = ($("#customerAddress").val() ?? "").trim();
        let contact = ($("#customerContact").val() ?? "").trim();
        let attn = ($("#customerATN").val() ?? "").trim();
        let terms = ($("#customerTerms").val() ?? "").trim();
        let date = ($("#customerDateIssued").val() ?? "").trim();

        let Condition = ($("#Condition").val() ?? "").trim();
        let Warranty = ($("#Warranty").val() ?? "").trim();
        let vat = ($("#VAT").val() ?? "").trim();
        let Availability = ($("#Availability").val() ?? "").trim();
        let rd = ($("#RD").val() ?? "").trim();
        let PriceEffectivity = ($("#PriceEffectivity").val() ?? "").trim();

        // Validate required customer fields (Customer Name and Q Number are required)
        if (!customerName) {
            toastr.error("Please enter the customer name.");

            //stop loading
            updatebuttonTextcustomer.textContent = "Edit";
            updatebuttonSpinnercustomer.classList.add("d-none");
            updatesaveBtnquote.disabled = false;
            updatebuttonTextsaveIcon.classList.remove("d-none");

            return;
        }
        if (!nos) {
            toastr.error("Please enter the Q number.");
            //stop loading
            updatebuttonTextcustomer.textContent = "Edit";
            updatebuttonSpinnercustomer.classList.add("d-none");
            updatesaveBtnquote.disabled = false;
            updatebuttonTextsaveIcon.classList.remove("d-none");

            return;
        }

        // Append customer data to FormData
        formData.append("customer_name", customerName);
        formData.append("nos", nos);
        formData.append("address", address);
        formData.append("contact", contact);
        formData.append("attn", attn);
        formData.append("date", date);
        formData.append("terms", terms);

        // Track first and last valid item row
        let foundFirstValidItem = false;
        let lastValidIndex = -1;
        let tempRows = []; // Temporary array for row data

        // Loop through table rows to collect valid item data
        $(".table tbody tr").each(function (index) {
            let quantity = ($(this).find(".quantity").val() ?? "").trim();
            let unit = ($(this).find("select").val() ?? "").trim();
            let itemName = ($(this).find(".item-name").val() ?? "").trim();
            let unitPrice = ($(this).find(".unit-price").val() ?? "").trim().replace(/,/g, "");
            let lineAmount = ($(this).find(".line-amount").val() ?? "").trim().replace(/,/g, "");

            // Check if row contains any valid data
            let isRowValid = quantity || unit || itemName || unitPrice || lineAmount;

            if (isRowValid) {
                foundFirstValidItem = true;
                lastValidIndex = tempRows.length; // Store last valid row index
            }

            // If at least one valid item exists, store row data
            if (foundFirstValidItem) {
                tempRows.push({
                    quantity: quantity || "",
                    unit: unit || "",
                    itemName: itemName || "",
                    unitPrice: unitPrice || "",
                    lineAmount: parseFloat(lineAmount) || "",
                });
            }
        });

        // Remove trailing empty rows
        let validRows = tempRows.slice(0, lastValidIndex + 1);

        // Prevent submission if no valid items
        if (validRows.length === 0) {
            toastr.error("Please enter at least one valid item before saving.");

            //stop loading
            updatebuttonTextcustomer.textContent = "Edit";
            updatebuttonSpinnercustomer.classList.add("d-none");
            updatesaveBtnquote.disabled = false;
            updatebuttonTextsaveIcon.classList.remove("d-none");

            return;
        }

        // Append valid items to FormData
        validRows.forEach((row, index) => {
            formData.append(`items[${index}][quantity]`, row.quantity);
            formData.append(`items[${index}][unit]`, row.unit);
            formData.append(`items[${index}][item_name]`, row.itemName);
            formData.append(`items[${index}][unit_price]`, row.unitPrice);
            formData.append(`items[${index}][line_amount]`, row.lineAmount);
        });

        // Append customer data to FormData
        formData.append("Condition", Condition);
        formData.append("Warranty", Warranty);
        formData.append("vat", vat);
        formData.append("Availability", Availability);
        formData.append("rd", rd);
        formData.append("PriceEffectivity", PriceEffectivity);

        // Submit data via AJAX to Laravel backend
        $.ajax({
            url: edit, // Update endpoint with ID
            type: "POST", // Laravel requires POST with _method=PUT for updates
            data: formData,
            processData: false, // Prevent jQuery from processing data
            contentType: false, // Prevent jQuery from setting content-type header
            success: function (response) {
                toastr.success(response.success); // Show success message

                //stop loading
                updatebuttonTextcustomer.textContent = "Edit";
                updatebuttonSpinnercustomer.classList.add("d-none");
                updatesaveBtnquote.disabled = false;
                updatebuttonTextsaveIcon.classList.remove("d-none");

                location.reload(); // Refresh page
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log error to console
                toastr.error(
                    "Something went wrong! Refresh or try again later"
                ); // Show error message

                //stop loading
                updatebuttonTextcustomer.textContent = "Edit";
                updatebuttonSpinnercustomer.classList.add("d-none");
                updatesaveBtnquote.disabled = false;
                updatebuttonTextsaveIcon.classList.remove("d-none");
            },
        });
    });

    //copy PRICE-QUOTATION
    $("#CopyBtn-customers").on("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        let copy = Laravel.user_role === "admin" ? `/CopyQuotation` : `/user-CopyQuotation`;

        // Get button elements for UI feedback during submission
        const CopysaveBtnquote = document.getElementById("CopyBtn-customers");
        const CopybuttonTextcustomer = document.getElementById("CopybuttonText-customer");
        const CopybuttonSpinnercustomer = document.getElementById("CopybuttonSpinner-customer");
        const CopybuttonTextsaveIcon = document.getElementById("saveCopyIcon");

        // Start loading animation (disable button and show spinner)
        CopybuttonTextcustomer.textContent = "";
        CopybuttonSpinnercustomer.classList.remove("d-none");
        CopysaveBtnquote.disabled = true;
        CopybuttonTextsaveIcon.classList.add("d-none");

        // Create FormData object to send data via AJAX
        let formData = new FormData();

        // Append CSRF token for Laravel validation
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        formData.append("_method", "PUT"); // Laravel requires PUT/PATCH for updates

        // Collect customer input values and trim spaces
        let customerName = ($("#customerName").val() ?? "").trim();
        let address = ($("#customerAddress").val() ?? "").trim();
        let contact = ($("#customerContact").val() ?? "").trim();
        let attn = ($("#customerATN").val() ?? "").trim();
        let terms = ($("#customerTerms").val() ?? "").trim();

        let Condition = ($("#Condition").val() ?? "").trim();
        let Warranty = ($("#Warranty").val() ?? "").trim();
        let vat = ($("#VAT").val() ?? "").trim();
        let Availability = ($("#Availability").val() ?? "").trim();
        let rd = ($("#RD").val() ?? "").trim();
        let PriceEffectivity = ($("#PriceEffectivity").val() ?? "").trim();

        // Validate required customer fields (Customer Name and Q Number are required)
        if (!customerName) {
            toastr.error("Please enter the customer name.");

            //stop loading
            CopybuttonTextcustomer.textContent = "Copy";
            CopybuttonSpinnercustomer.classList.add("d-none");
            CopysaveBtnquote.disabled = false;
            CopybuttonTextsaveIcon.classList.remove("d-none");

            return;
        }

        // Append customer data to FormData
        formData.append("customer_name", customerName + "- Copy");
        formData.append("address", address);
        formData.append("contact", contact);
        formData.append("attn", attn);
        formData.append("terms", terms);

        // Track first and last valid item row
        let foundFirstValidItem = false;
        let lastValidIndex = -1;
        let tempRows = []; // Temporary array for row data

        // Loop through table rows to collect valid item data
        $(".table tbody tr").each(function (index) {
            let quantity = ($(this).find(".quantity").val() ?? "").trim();
            let unit = ($(this).find("select").val() ?? "").trim();
            let itemName = ($(this).find(".item-name").val() ?? "").trim();
            let unitPrice = ($(this).find(".unit-price").val() ?? "").trim().replace(/,/g, "");
            let lineAmount = ($(this).find(".line-amount").val() ?? "").trim().replace(/,/g, "");

            // Check if row contains any valid data
            let isRowValid = quantity || unit || itemName || unitPrice || lineAmount;
            
            if (isRowValid) {
                foundFirstValidItem = true;
                lastValidIndex = tempRows.length; // Store last valid row index
            }

            // If at least one valid item exists, store row data
            if (foundFirstValidItem) {
                tempRows.push({
                    quantity: quantity || "",
                    unit: unit || "",
                    itemName: itemName || "",
                    unitPrice: unitPrice || "",
                    lineAmount: parseFloat(lineAmount) || "",
                });
            }
        });

        // Remove trailing empty rows
        let validRows = tempRows.slice(0, lastValidIndex + 1);

        // Prevent submission if no valid items
        if (validRows.length === 0) {
            toastr.error("Please enter at least one valid item before saving.");

            //stop loading
            CopybuttonTextcustomer.textContent = "Copy";
            CopybuttonSpinnercustomer.classList.add("d-none");
            CopysaveBtnquote.disabled = false;
            CopybuttonTextsaveIcon.classList.remove("d-none");

            return;
        }

        // Append valid items to FormData
        validRows.forEach((row, index) => {
            formData.append(`items[${index}][quantity]`, row.quantity);
            formData.append(`items[${index}][unit]`, row.unit);
            formData.append(`items[${index}][item_name]`, row.itemName);
            formData.append(`items[${index}][unit_price]`, row.unitPrice);
            formData.append(`items[${index}][line_amount]`, row.lineAmount);
        });

        // Append customer data to FormData
        formData.append("Condition", Condition);
        formData.append("Warranty", Warranty);
        formData.append("vat", vat);
        formData.append("Availability", Availability);
        formData.append("rd", rd);
        formData.append("PriceEffectivity", PriceEffectivity);

        // Submit data via AJAX to Laravel backend
        $.ajax({
            url: copy, // Update endpoint with ID
            type: "POST", // Laravel requires POST with _method=PUT for updates
            data: formData,
            processData: false, // Prevent jQuery from processing data
            contentType: false, // Prevent jQuery from setting content-type header
            success: function (response) {
                toastr.success(response.success); // Show success message

                //stop loading
                CopybuttonTextcustomer.textContent = "Copy";
                CopybuttonSpinnercustomer.classList.add("d-none");
                CopysaveBtnquote.disabled = false;
                CopybuttonTextsaveIcon.classList.remove("d-none");

                location.reload(); // Refresh page
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log error to console
                toastr.error(
                    "Something went wrong! Refresh or try again later"
                ); // Show error message

                //stop loading
                CopybuttonTextcustomer.textContent = "Copy";
                CopybuttonSpinnercustomer.classList.add("d-none");
                CopysaveBtnquote.disabled = false;
                CopybuttonTextsaveIcon.classList.remove("d-none");
            },
        });
    });


let selectedDropdown = null; // Store the clicked select element

// Show modal when "+ Add New" is selected
$('.unit-select').change(function () {
    if ($(this).val() === "add") {
        selectedDropdown = $(this); // Store reference to the clicked dropdown
        $('#unitModal').modal('show');
        $(this).val(''); // Reset selection
    }
});

$('#unitModalForm').on('submit', function (e) { 
    e.preventDefault();

    let quoteUnit = Laravel.user_role === "admin" ? "/quotations/add-unit" : "/quotations/user-add-unit";

     // Get button elements for UI feedback during submission
    const unitsaveBtnquote = document.getElementById("saveUnitBtn");
    const unitbuttonTextcustomer = document.getElementById("buttonText");
    const unitbuttonSpinnercustomer = document.getElementById("buttonSpinner");

        // Start loading animation (disable button and show spinner)
    unitbuttonTextcustomer.textContent = "";
    unitbuttonSpinnercustomer.classList.remove("d-none");
    unitsaveBtnquote.disabled = true;
    
    let formData = $(this).serialize();

    $.ajax({
        type: "POST",
        url: quoteUnit,
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) { // Ensure the response contains success status
                toastr.success("Added Successfully!");

                unitbuttonTextcustomer.textContent = "Save";
                unitbuttonSpinnercustomer.classList.add("d-none");
                unitsaveBtnquote.disabled = false;
                
                // Append the new unit to all .unit-select dropdowns
                $('.unit-select').each(function () {
                    $(this).append(
                        `<option value="${response.new_unit_name}">${response.new_unit_name}</option>`
                    );
                });

                // Ensure the newly added option is selected for the clicked dropdown
                if (selectedDropdown) {
                    selectedDropdown.val(response.new_unit_id).trigger("change");
                }

                // Close and reset modal
                $("#unitModal").modal("hide");
                $("#unitModalForm")[0].reset();
                selectedDropdown = null; // Reset the reference
            }
        },
        error: function (xhr) {
            toastr.error(xhr.responseJSON?.message || "An error occurred.");

            unitbuttonTextcustomer.textContent = "Save";
            unitbuttonSpinnercustomer.classList.add("d-none");
            unitsaveBtnquote.disabled = false;
        },
    });
});




});




