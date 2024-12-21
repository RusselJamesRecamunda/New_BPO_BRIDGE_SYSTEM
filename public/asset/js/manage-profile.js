// Function to handle the file selection and display preview
function handleFileSelect(event) {
    var file = event.target.files[0];

    if (file) {
        var reader = new FileReader();

        // Update the image preview immediately when a file is selected
        reader.onload = function (e) {
            var profileImage = document.getElementById("profileImage");
            profileImage.src = e.target.result; // Display the selected image instantly
        };

        reader.readAsDataURL(file);

        // Show the SweetAlert confirmation dialog
        Swal.fire({
            title: "Do you want to save the changes?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            denyButtonText: `Don't save`,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire("Saving...", "", "info");
                // Automatically submit the form via AJAX after confirmation
                submitImage(file);
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
                // Clear the selected file if not saved
                document.getElementById("imageUpload").value = "";
            }
        });
    }
}

// Function to submit the image via AJAX
if (profileUpdateRoute === null) {
    console.log("Guest users cannot update the profile.");
} else {
    function submitImage(file) {
        var formData = new FormData();
        formData.append("user_photo", file);
        formData.append("_method", "PUT"); // To simulate PUT request
        formData.append("_token", csrfToken);

        fetch(profileUpdateRoute, {
            method: "POST", // Using POST method since we added _method as PUT in formData
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire(
                        "Profile photo updated successfully!",
                        "",
                        "success"
                    );
                    // You can update the profile photo preview here as needed
                } else {
                    Swal.fire(
                        data.error || "An unknown error occurred",
                        "",
                        "error"
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire(
                    "An error occurred. Please try again later.",
                    "",
                    "error"
                );
            });
    }
}
