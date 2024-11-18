document.addEventListener('DOMContentLoaded', function () {
    // Modal functionality
    const loginModal = document.getElementById('loginModal');

    if (loginModal) {
        loginModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const jobType = button.getAttribute('data-job-type');
            const jobTitle = button.getAttribute('data-job-title');
            const modalTitle = loginModal.querySelector('.modal-title');

            if (modalTitle && jobType && jobTitle) {
                modalTitle.innerHTML = `Applying for: ${jobTitle} (${jobType.charAt(0).toUpperCase() + jobType.slice(1)})`;
            }
        });
    }

    // Save job functionality
    window.saveJob = function (button) {
        const jobId = button.getAttribute('data-job-id');
        const jobType = button.getAttribute('data-job-type');

        if (!jobId || !jobType) {
            alert('Invalid job data. Please try again.');
            return;
        }

        $.ajax({
            url: window.saveJobRoute, // Defined dynamically in the Blade template
            type: 'POST',
            data: {
                job_id: jobId,
                job_type: jobType,
                _token: window.csrfToken, // Defined dynamically in the Blade template
            },
            success: function (response) {
                if (response.success) {
                    alert('Job saved successfully!');
                } else {
                    alert(response.message || 'Failed to save the job. Please try again.');
                }
            },
            error: function (error) {
                alert('An error occurred. Please try again.');
                console.error(error);
            },
        });
    };
});
