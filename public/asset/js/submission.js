document.addEventListener("DOMContentLoaded", function () {
    const fileInputs = document.querySelectorAll(
      ".file-upload input[type='file']"
    );
  
    fileInputs.forEach((input) => {
      input.addEventListener("change", function () {
        const fileName = this.files[0]
          ? this.files[0].name
          : "Upload a File<br><small>Drag and drop files here</small>";
        const fileUploadContainer = this.closest(".file-upload");
        fileUploadContainer.innerHTML = `<img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                                                <p>${fileName}</p>`;
      });
    });
  });
  
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("applicationForm");
    const confirmationModal = document.getElementById("confirmationModal");
    const modalOkButton = document.getElementById("modalOkButton");
  
    // Form submission event
    form.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent default form submission
  
      // Ensure modal is displayed
      if (confirmationModal) {
        confirmationModal.style.display = "flex"; // Show modal
      } else {
        console.error("Modal element not found!"); // Debugging
      }
    });
  
    // Modal "OK" button event
    modalOkButton.addEventListener("click", function () {
      confirmationModal.style.display = "none"; // Hide modal
      window.close(); // Reset the form
  
      // Reset file upload containers
      document.querySelectorAll(".file-upload").forEach((container) => {
        container.innerHTML = `<img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                          <p>Upload a File<br><small>Drag and drop files here</small></p>`;
      });
    });
  });
  