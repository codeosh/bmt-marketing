//function to automatically calculate the line amount and total amount
function calculateLineAmount(element) {
    let row = element.closest("tr");

    // Get input values and remove commas if present
    let quantity = parseFloat(row.querySelector(".quantity").value.replace(/,/g, "")) || 0;
    let unitPrice = parseFloat(row.querySelector(".unit-price").value.replace(/,/g, "")) || 0;
    let lineAmount = quantity * unitPrice;

    // Format line amount with commas
    row.querySelector(".line-amount").value = lineAmount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    calculateTotal();
}

//for total
function calculateTotal() {
    let total = 0;
    
    document.querySelectorAll(".line-amount").forEach(input => {
        total += parseFloat(input.value.replace(/,/g, "")) || 0; // Remove commas before summing
    });

    // Format total with commas
    document.getElementById("totalAmount").value = total.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Automatically format user input to include commas
document.querySelectorAll(".quantity, .unit-price").forEach(input => {
    input.addEventListener("input", function() {
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

        // Submit data via AJAX to Laravel backend
        $.ajax({
            url: "/admin-quotation", // API endpoint
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
                toastr.error("Something went wrong! Try again later"); // Show error message
                stopLoading(); // Reset UI
            }
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

        // Get the Save button and text elements
        const saveBtnquote = document.getElementById("saveBtn-customers");
        const buttonTextcustomer = document.getElementById("buttonText-customer");

        // Disable the Save button to prevent multiple clicks while loading
        saveBtnquote.disabled = true;
        buttonTextcustomer.textContent = "...."; // Indicate that data is loading

        // Make an AJAX GET request to fetch the quotation data based on the clicked row's ID
        $.ajax({
            url: `/admin-quotation/${quoteId}`, // API endpoint to fetch the quotation data
            type: "GET",
            success: function (data) {
                console.log("Fetched data:", data); // Debugging: Log fetched data to the console

                // Check if data is missing or contains an error
                if (!data || data.error) {
                    console.error("No data found for this ID.");
                    return;
                }

                // Populate customer details in the input fields
                $("#customerContact").val(data.customerContact);
                $("#customerQNumber").val(data.quotationNo);
                $("#customerAddress").val(data.address);
                $("#customerName").val(data.customerName);
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
                        $(row).find(".unit-price").val(item.unit_price ? parseFloat(item.unit_price).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "");//kaning naa sud na taas ge convert niya ag way kama na numbers from db to naanay comma nig display);
                        $(row).find(".line-amount").val(item.line_amount ? parseFloat(item.line_amount).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "");//kaning naa sud na taas ge convert niya ag way kama na numbers from db to naanay comma nig display
                        
                        // Add line amount to the total amount calculation
                        totalAmount += parseFloat(item.line_amount) || 0;

                    } else {
                        // If there's no corresponding item, clear the row fields
                        $(row).find("input, select").val("");
                    }
                });

                // Update the total amount field with the calculated total (formatted with commas)
                $("#totalAmount").val(totalAmount.toLocaleString("en-US", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
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
            url: "/get-latest-quotation", // Laravel route
            type: "GET",
            dataType: "json",
            success: function (response) {
                // Set the new quotation number in the input field
                $("#customerQNumber").val(response.quotation_no);
            },
            error: function () {
                alert("Failed to fetch latest quotation number.");
            },
        });
        
        
        //addnew start loading 
        addnewBtnquote.disabled = true;
        adnewwbuttonTextcustomer.textContent = "";
        adnewwbuttonSpinner.classList.remove("d-none");
        adnewwIcon.classList.add("d-none");

        $("input").val(""); // Clears all input fields on the page
        $("select").val("");
        
        //for the date
        let today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
        $("#customerDateIssued").val(today);
        

        //add new stop loading
        addnewBtnquote.disabled = false;
        adnewwbuttonTextcustomer.textContent = "Add new";
        adnewwbuttonSpinner.classList.add("d-none");
        adnewwIcon.classList.remove("d-none");

        saveBtnquote.disabled = false;
        buttonTextcustomer.textContent = "Save";
        
        
    });

    //quotation search
    $("#search").on("keyup", function () {
        let searchTerm = $(this).val().toLowerCase(); // Convert input to lowercase

        $(".quote-row").each(function () {
            let customerName = $(this).find("td:eq(1)").text().toLowerCase(); // Get customer name from second column

            // Show/hide row based on search term
            if (customerName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});



