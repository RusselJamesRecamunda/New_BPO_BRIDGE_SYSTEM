// Ensure the function is defined before it is used
function handleFileSelect(event) {
    var file = event.target.files[0];

    if (file) {
        var reader = new FileReader();

        // Update the image preview when a file is selected
        reader.onload = function (e) {
            var profileImage = document.getElementById("profileImage");
            profileImage.src = e.target.result; // Update the profile image source
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
                Swal.fire("Saved!", "", "success");
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

// Function to automatically submit the image via AJAX
function submitImage(file) {
    var formData = new FormData();
    formData.append("user_photo", file);
    formData.append("_token", "{{ csrf_token() }}"); // Add CSRF token

    // Make AJAX request to upload the image
    fetch("{{ route('profile.upload') }}", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // You can handle success responses here, like updating the image preview or showing a success message
                Swal.fire("Profile image updated successfully!", "", "success");
            } else {
                // Only show error if something specific fails
                console.error(
                    "Error uploading image:",
                    data.error || "Unknown error"
                );
            }
        })
        .catch((error) => {
            // Only show this if there is a network error or failure
            console.error("Network error:", error);
        });
}
