$(document).ready(function () {
    $("#registerForm").on("submit", function (e) {
        e.preventDefault();

        const saveButtonregister = $("#saveBtn-register");
        const buttonTextregister = $("#buttonText-register");
        const buttonSpinnerregister = $("#buttonSpinner-register");

        const formData = $(this).serialize();

        saveButtonregister.prop("disabled", true);
        buttonTextregister.text("Saving...");
        buttonSpinnerregister.removeClass("d-none");

        $.ajax({
            type: "POST",
            url: "/admin-register",
            data: formData,
            dataType: "json", // Ensure JSON response
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    toastr.success("Added Successfully!");

                    $("#addAccountModal").modal("hide");
                    $("#registerForm")[0].reset();

                    // Add new account to table dynamically
                    addAccountToTable(response.user);

                    // Reset button states
                    saveButtonregister.prop("disabled", false);
                    buttonTextregister.text("Save");
                    buttonSpinnerregister.addClass("d-none");
                }
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || "An error occurred.");
                console.log(xhr);

                saveButtonregister.prop("disabled", false);
                buttonTextregister.text("Save");
                buttonSpinnerregister.addClass("d-none");
            },
        });
    });
});

// Function to add user to the table dynamically
function addAccountToTable(user) {
    let roleBadge = user.role === "admin" ? "bg-success" : "bg-primary";

    let newRow = `
        <tr>
            <td class="px-3 py-2">${user.name}</td>
            <td class="px-3 py-2">${user.email}</td>
            <td class="px-3 py-2">${user.phoneNumber}</td>
            <td class="px-3 py-2"><span class="badge ${roleBadge}">${user.role}</span></td>
            <td class="px-3 py-2">
                <div class="d-flex gap-2">
                    <div class="editButton d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-primary" style="font-size:0.6rem; width:100px; height:25px; border-radius:3px" data-id="${$user.id}">
                            <i class="fa-regular fa-pen-to-square" style="margin-right: 5px;"></i>Edit
                        </button>
                    </div>
                    <div class="deleteButton d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-danger" style="font-size:0.6rem; width:100px; height:25px; border-radius:3px" data-id="${$user.id}>
                            <i class="fa-solid fa-trash" style="margin-right: 5px;"></i>Delete
                        </button>
                    </div>
                </div>
            </td>
        </tr>
    `;

    $("tbody").prepend(newRow); // Add the new row at the top
}
