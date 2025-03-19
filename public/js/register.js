// public\js\register.js
$(document).ready(function () {
    // Function to add user to the table dynamically
    function addAccountToTable(user) {
        let roleBadge = user.role === "admin" ? "bg-success" : "bg-primary";

        let newRow = `
        <tr>
            <td class="px-3 py-2">${user.name}</td>
            <td class="px-3 py-2">${user.email}</td>
            <td class="px-3 py-2">${user.phoneNumber}</td>
            <td class="px-3 py-2"><span class="badge ${roleBadge}">${user.role}</span></td>
            <td class="px-3 py-2"><span class="badge ${roleBadge}">active</span></td>
            <td class="px-3 py-2">
                <div class="d-flex gap-2">
                    <div class="editButton d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-primary editAccBtn" 
                                style="font-size:0.6rem; width:100px; height:25px; border-radius:3px" 
                                data-id="${user.id}">
                            <i class="fa-regular fa-pen-to-square" style="margin-right: 5px;"></i>Edit
                        </button>
                    </div>
                    <div class="deleteButton d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-danger" 
                                style="font-size:0.6rem; width:100px; height:25px; border-radius:3px" 
                                data-id="${user.id}">
                            <i class="fa-solid fa-trash" style="margin-right: 5px;"></i>Delete
                        </button>
                    </div>
                </div>
            </td>
        </tr>
        `;

        $("tbody").prepend(newRow); // Add the new row at the top
    }

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


    // Function to populate Edit Account Modal
    $(document).on("click", ".editAccBtn", function () {
        let userId = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `/account/user/${userId}`, // Route to fetch user data
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                let user = response.user;

                // Populate form fields
                $("#name").val(user.name);
                $("#email").val(user.email);
                $("#phoneNumber").val(user.phoneNumber);
                $("#role").val(user.role);
                $("#status").val(user.status);

                $("#editAccForm").data("id", userId);

                // Show the modal
                $("#editAccountModal").modal("show");
            },
            error: function (xhr) {
                toastr.error("Failed to fetch user details.");
            },
        });
    });

    // Handle Edit Account Form Submission
    $("#editAccForm").on("submit", function (e) {
        e.preventDefault();
        let userId = $(this).data("id");
        let formData = $(this).serialize();

        // Button UI updates
        const editButton = $("#editBtn-edit");
        const buttonTextedit = $("#buttonText-edit");
        const buttonSpinneredit = $("#buttonSpinner-edit");

        editButton.prop("disabled", true);
        buttonTextedit.text("Updating...");
        buttonSpinneredit.removeClass("d-none");

        $.ajax({
            type: "PUT", // Use PUT for updating data
            url: `/account/update/${userId}`, // Update route
            data: formData,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    toastr.success("User updated successfully!");

                    editButton.prop("disabled", false);
                    buttonTextedit.text("Save Changes");
                    buttonSpinneredit.addClass("d-none");
                    
                    addAccountToTable(response.user);

                    // Close modal and reset form
                    $("#editAccountModal").modal("hide");
                    $("#editAccForm")[0].reset();
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    $("#nameError").text(errors.name || "");
                    $("#emailError").text(errors.email || "");
                    $("#pNumberError").text(errors.phoneNumber || "");
                    $("#passwordError").text(errors.password || "");
                    $("#passwordConfirmationError").text(
                        errors.password_confirmation || ""
                    );
                }
                toastr.error("Update failed.");

                editButton.prop("disabled", false);
                buttonTextedit.text("Save Changes");
                buttonSpinneredit.addClass("d-none");
            },
            complete: function () {
                editButton.prop("disabled", false);
                buttonTextedit.text("Save Changes");
                buttonSpinneredit.addClass("d-none");
            },
        });
    });

    //delete acc
    $(document).on("click", ".deleteButton button", function (e) {
        e.stopPropagation();
        const accID = $(this).data("id"); // Get ID from clicked button
        const itemElement = $(this).closest("tr"); // Get the row to remove

        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to delete this account?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/account/destroy/${accID}`,
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
                    },
                    error: function (xhr) {
                        toastr.error("Failed to delete.");
                        console.error("Error:", xhr.responseText);
                    },
                });
            }
        });
    });
});
