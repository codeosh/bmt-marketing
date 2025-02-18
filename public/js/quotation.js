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



//save cusstomer and ilang items ge palit
$(document).ready(function () {
    $("#saveBtn-customers").on("click", function (e) {
        e.preventDefault();

        let formData = new FormData();

        // CSRF Token
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        // Collect customer data
        let customerName = ($("#customerName").val() ?? "").trim();
        let nos = ($("#customerQNumber").val() ?? "").trim();
        let address = ($("#customerAddress").val() ?? "").trim();
        let contact = ($("#customerContact").val() ?? "").trim();
        let attn = ($("#customerATN").val() ?? "").trim();
        let terms = ($("#customerTerms").val() ?? "").trim();

        if (!customerName) {
            toastr.error("Please enter the: customer name.");
            return;
        }
        if (!nos) {
            toastr.error("Please enter the: Q no.");
            return;
        }


        // Append customer data to formData
        formData.append("customer_name", customerName);
        formData.append("nos", nos);
        formData.append("address", address);
        formData.append("contact", contact);
        formData.append("attn", attn);
        formData.append("terms", terms);

        let itemsValid = false; // Flag to check if at least one valid item is present

        $(".table tbody tr").each(function (index) {
            let quantity = ($(this).find(".quantity").val() ?? "").trim();
            let unit = ($(this).find("select").val() ?? "").trim();
            let itemName = ($(this).find(".item-name").val() ?? "").trim();
            let unitPrice = ($(this).find(".unit-price").val() ?? "").trim();
            let lineAmount = ($(this).find(".line-amount").val() ?? "").trim();

            console.log(`Row ${index} - Quantity: ${quantity}, Unit: ${unit}, Item Name: ${itemName}, Unit Price: ${unitPrice}`);

            if (itemName && quantity && unitPrice) {
                itemsValid = true;
                formData.append(`items[${index}][quantity]`, quantity);
                formData.append(`items[${index}][unit]`, unit);
                formData.append(`items[${index}][item_name]`, itemName);
                formData.append(`items[${index}][unit_price]`, unitPrice);
                formData.append(`items[${index}][line_amount]`, parseFloat(lineAmount) || 0);
            }
        });


        // Validate if at least one item is present
        if (!itemsValid) {
            toastr.error("Please add at least one valid item.");
            return;
        }

        // Submit form via AJAX
        $.ajax({
            url: "/admin-quotation",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert(response.success);
                location.reload();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                toastr.error("Something went wrong!, Try again later");
            }
        });
    });
});


