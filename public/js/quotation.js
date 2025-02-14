//function to automatically calculate the line amount and total amount
function calculateLineAmount(element) {
    let row = element.closest("tr");
    let quantity = parseFloat(row.querySelector(".quantity").value) || 0;
    let unitPrice = parseFloat(row.querySelector(".unit-price").value) || 0;
    let lineAmount = quantity * unitPrice;
            
    row.querySelector(".line-amount").value = lineAmount.toFixed(2);

    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll(".line-amount").forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById("totalAmount").value = total.toFixed(2);
}

//save cusstomer and ilang items ge palit
$(document).ready(function () {
    $("#submitBtn").on("click", function (e) {
        e.preventDefault();

        let formData = new FormData();
        
        // Collect Customer Details
        formData.append("nos", $("#nos").val());
        formData.append("customer_name", $("#customerName").val());
        formData.append("address", $("#customerAddress").val());
        formData.append("contact", $("#customerContact").val());
        formData.append("terms", $("#terms").val());
        formData.append("quotation_no", $("#quotation_no").val());

        // Collect Item Data (Loop through each row in the table)
        $(".table tbody tr").each(function () {
            formData.append("quantity[]", $(this).find(".quantity").val());
            formData.append("unit[]", $(this).find("select").val());
            formData.append("item_name[]", $(this).find("input[name='item_name[]']").val());
            formData.append("unit_price[]", $(this).find(".unit-price").val());
            formData.append("line_amount[]", $(this).find(".line-amount").val());
        });

        $.ajax({
            url: "/admin-quotation",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert(response.success);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});



