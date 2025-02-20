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

        const saveBtnquote = document.getElementById("saveBtn-customers");
        const buttonTextcustomer = document.getElementById("buttonText-customer");
        const buttonSpinnercustomer = document.getElementById("buttonSpinner-customer");

        //start loading
        saveBtnquote.disabled = true;
        buttonTextcustomer.textContent = "Saving...";
        buttonSpinnercustomer.classList.remove("d-none");

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
        
        // Validate required customer fields
        if (!customerName) {
            toastr.error("Please enter the: customer name.");

            //stop loading
            saveBtnquote.disabled = false;
            buttonTextcustomer.textContent = "Save";
            buttonSpinnercustomer.classList.add("d-none");

            return;
        }
        if (!nos) {
            toastr.error("Please enter the: Q no.");

            //stop loading
            saveBtnquote.disabled = false;
            buttonTextcustomer.textContent = "Save";
            buttonSpinnercustomer.classList.add("d-none");
            
            return;
        }
        
        // Append customer data to FormData
        formData.append("customer_name", customerName);
        formData.append("nos", nos);
        formData.append("address", address);
        formData.append("contact", contact);
        formData.append("attn", attn);
        formData.append("terms", terms);
        
        // Flag to track if we have found a valid item_name
        let foundValidItem = false;

        // Loop through table rows to collect item data
        $(".table tbody tr").each(function (index) {
            let quantity = ($(this).find(".quantity").val() ?? "").trim();
            let unit = ($(this).find("select").val() ?? "").trim();
            let itemName = ($(this).find(".item-name").val() ?? "").trim();
            let unitPrice = ($(this).find(".unit-price").val() ?? "").trim();
            let lineAmount = ($(this).find(".line-amount").val() ?? "").trim();

            // Check if the current row has an item name
            if (itemName) {
                foundValidItem = true; // Mark that we found an item
            }

            // If we have already found a valid item, save all rows below
            if (foundValidItem) {
                itemsValid = true;
                formData.append(`items[${index}][quantity]`, quantity || ""); // Allow empty
                formData.append(`items[${index}][unit]`, unit || "");
                formData.append(`items[${index}][item_name]`, itemName || ""); // Required
                formData.append(`items[${index}][unit_price]`, unitPrice || "");
                formData.append(`items[${index}][line_amount]`, parseFloat(lineAmount) || "");
            }
        });

        
        // Submit data via AJAX
        $.ajax({
            url: "/admin-quotation", // Laravel backend URL
            type: "POST", // Request method
            data: formData, // FormData object
            processData: false, // Prevent jQuery from processing data
            contentType: false, // Ensure proper encoding
            success: function (response) {
                toastr.success(response.success); // Show success message

                //stop loading
                saveBtnquote.disabled = false;
                buttonTextcustomer.textContent = "Save";
                buttonSpinnercustomer.classList.add("d-none");

                location.reload(); // Reload the page
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log error message
                toastr.error("Something went wrong! Try again later");

                //stop loading
                saveBtnquote.disabled = false;
                buttonTextcustomer.textContent = "Save";
                buttonSpinnercustomer.classList.add("d-none");

            }
        });
    });

    //show ang info sa ge click na row
    // Handle row click event
    $("#quotationTable tbody").on("click", ".quote-row", function () {
        let quoteId = $(this).data("id");
        const saveBtnquote = document.getElementById("saveBtn-customers");
        const buttonTextcustomer = document.getElementById("buttonText-customer");

        saveBtnquote.disabled = true;
        buttonTextcustomer.textContent = "....";

        $.ajax({
            url: `/admin-quotation/${quoteId}`,
            type: "GET",
            success: function (data) {

                console.log("Fetched data:", data); // Debugging

                if (!data || data.error) {
                    console.error("No data found for this ID.");
                    return;
                }

                // Update customer details
                $("#customerContact").val(data.customerContact);
                $("#customerQNumber").val(data.quotationNo);
                $("#customerAddress").val(data.address);
                $("#customerName").val(data.customerName);
                $("#customerATN").val(data.attn);
                $("#customerDateIssued").val(data.date);
                $("#customerTerms").val(data.terms);

                let totalAmount = 0; // Initialize total amount

                // Select all existing rows and populate them
                $("#items-table tbody tr").each(function (index, row) {
                    if (data.items[index]) {
                        let item = data.items[index];

                        $(row).find(".quantity").val(item.quantity);
                        $(row).find("select").val(item.unit);
                        $(row).find(".item-name").val(item.item_name);
                        $(row).find(".unit-price").val(item.unit_price);
                        $(row).find(".line-amount").val(item.line_amount);

                        // Calculate total amount
                        totalAmount += parseFloat(item.line_amount) || 0;
                    } else {
                        // If there's no corresponding item, clear the row
                        $(row).find("input, select").val("");
                    }
                });

                // Update total amount field
                $("#totalAmount").val(totalAmount.toFixed(2));
            },
            error: function (xhr) {
                console.log("Error fetching data:", xhr.responseText);
            },
        });
    });


    // Add new quotation button click event
    $("#new-Quote").on("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        e.preventDefault(); // Prevent default action

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
        
        //save button
        const saveBtnquote = document.getElementById("saveBtn-customers");
        const buttonTextcustomer = document.getElementById("buttonText-customer");


        //add new button
        const addnewBtnquote = document.getElementById("saveBtn-customers");
        const adnewwbuttonTextcustomer = document.getElementById("buttonText-Quote");
        const adnewwbuttonSpinner = document.getElementById("buttonSpinner-Quote");
        const adnewwIcon= document.getElementById("addIcon");
        
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


});



