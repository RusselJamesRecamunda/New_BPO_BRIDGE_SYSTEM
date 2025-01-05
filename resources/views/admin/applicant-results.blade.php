@extends('layouts.admin_pages')

@section('title', 'Applicant Result')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/applicant-results.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
@endsection

@section('result-content')

    <!-- Top Bar -->
    @include('components.topbar')

    <div class="applicant-container mb-4">
        <!-- Tabs -->
        <div class="custom-tabs">
            <div class="custom-tab active" onclick="showTab('applicant-result-section')">
                <i class="fa-solid fa-square-poll-vertical me-2"></i>Applicant Results
            </div>
            <div class="custom-tab" onclick="showTab('interview-notes-section')">
                <i class="fa-regular fa-comment-dots me-2"></i>Interview Notes
            </div>
            <!-- Add Evaluate button -->
            <button class="btn btn-primary" id="evaluate-candidate-btn"><i class="fa-solid fa-list-check me-2"></i>Evaluate Candidate</button>
        </div>

        <!-- Applicant Result Table -->
<div id="applicant-result-section" class="table-responsive" style="display: block;">
    <table id="applicantTable" class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Candidate Name</th>
                <th>Applying For</th>
                <th>Phone</th>
                <th>Resume/CV</th>
                <th>Interview Date</th>
                <th>Interview Score</th>
                <th style="white-space: nowrap;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interviewResults as $result)
                <tr>
                    <td>{{ $result->candidate_name }}</td>
                    <td>{{ $result->applied_job }}</td>
                    <td>{{ $result->phone }}</td>
                    <td>
                        @if ($result->resume_cv)
                            <a href="{{ asset('storage/' . str_replace('public/', '', $result->resume_cv)) }}" target="_blank" download>
                                <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Resume/CV</p>
                            </a>
                        @else
                            <span>No Resume</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($result->interview_date)->format('F j, Y') }}</td>
                    <td>
                        <span class="badge badge-interview-score">{{ $result->interview_score }}</span>
                    </td>
                    <td style="white-space: nowrap;">
                        <span 
                            class="status-badge 
                                {{ 
                                    $result->result_status === '1st Round Passed' ? 'badge-1st-round' : 
                                    ($result->result_status === '2nd Round Passed' ? 'badge-2nd-round' : 
                                    ($result->result_status === 'On-Hold' ? 'badge-on-hold' : 
                                    ($result->result_status === 'Hired' ? 'badge-hired' : 
                                    ($result->result_status === 'Rejected' ? 'badge-rejected' : '')))) 
                                }}"
                        >
                            {{ $result->result_status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


        <!-- Interview Notes Table -->
        <div id="interview-notes-section" class="table-responsive" style="display: none;">
            <table id="interviewNotesTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Interviewer</th>
                        <th>Candidate Name</th>
                        <th>Applied Job</th>
                        <th>Mode of Interview</th>
                        <th>Interview Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interviewResults as $result)
                        <tr>
                            <td>{{ $result->interviewer }}</td>
                            <td>{{ $result->candidate_name }}</td>
                            <td>{{ $result->applied_job }}</td>
                            <td>{{ $result->interview_mode }}</td>
                            <td>{{ $result->interview_notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
    $(document).ready(function () {
        // Initialize DataTables for Applicant Results and Interview Notes
        const applicantTable = $("#applicantTable").DataTable();
        const interviewNotesTable = $("#interview-notes-section table").DataTable();

        // Add Bootstrap styling to the DataTables search input
        customizeDataTableSearch(applicantTable);
        customizeDataTableSearch(interviewNotesTable);

        function customizeDataTableSearch(table) {
            const $searchInput = $(table.table().container())
                .find(".dataTables_filter input");

            // Add styles and wrap the search input
            $searchInput
                .addClass("form-control") // Apply Bootstrap form control class
                .attr("placeholder", "Search") // Add a placeholder to the input
                .css({
                    display: "flex",
                    width: "250px",
                    "background-color": "#f2f2f2",
                    "border-radius": "12px",
                    "box-shadow": "0 1px 5px rgba(0, 0, 0, 0.1)",
                    color: "#0c436d",
                    "font-weight": "600",
                    "padding-right": "35px", // Space for the cancel button
                    position: "relative",
                });

            // Wrap input field in a container for better positioning of the icons
            $searchInput.wrap(
                '<div class="search-container position-relative mt-2 mb-2"></div>'
            );

            // Add the magnifying glass icon to the right
            $searchInput
                .parent()
                .append(
                    '<i class="fa-solid fa-magnifying-glass position-absolute search-icon" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d;"></i>'
                );

            // Add the custom cancel button
            $searchInput
                .parent()
                .append(
                    '<i class="fa-solid fa-xmark position-absolute clear-search" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d; opacity: 0; cursor: pointer;"></i>'
                );

            const $searchContainer = $searchInput.parent();

            // Add an event listener to toggle magnifying glass visibility based on input
            $searchInput.on("input", function () {
                const $magnifyingGlass = $searchContainer.find(".search-icon");
                const $clearButton = $searchContainer.find(".clear-search");

                if ($(this).val().length > 0) {
                    // Hide magnifying glass and show cancel button
                    $magnifyingGlass.css("opacity", "0");
                    $clearButton.css("opacity", "1");
                } else {
                    // Show magnifying glass and hide cancel button
                    $magnifyingGlass.css("opacity", "1");
                    $clearButton.css("opacity", "0");
                }
            });

            // Clear the search input when the cancel button is clicked
            $searchContainer.find(".clear-search").on("click", function () {
                $searchInput.val("").trigger("input"); // Clear the input and trigger the event to reset icons
                table.search("").draw(); // Clear the DataTable search and redraw the table
            });

            // Hide the native cancel button provided by DataTables
            const style = document.createElement("style");
            style.textContent = `
                .dataTables_filter input::-webkit-search-cancel-button {
                    display: none; /* Hide the native cancel button */
                }
            `;
            document.head.appendChild(style);

            // Remove the "Search:" label
            $(table.table().container())
                .find(".dataTables_filter label")
                .contents()
                .filter(function () {
                    return this.nodeType === 3; // Node type 3 is text nodes
                })
                .remove();
        }
    });

    // Tab switching logic
    function showTab(tabName) {
        document.getElementById("applicant-result-section").style.display = "none";
        document.getElementById("interview-notes-section").style.display = "none";

        document.getElementById(tabName).style.display = "block";

        var tabs = document.querySelectorAll(".custom-tab");
        tabs.forEach((tab) => tab.classList.remove("active"));
        event.target.closest(".custom-tab").classList.add("active");
    }
</script>
<script>
   document.getElementById('evaluate-candidate-btn').addEventListener('click', function() {
    Swal.fire({
        title: 'Evaluate Candidate',
        html: `
            <form id="evaluateForm">
                <div class="mb-3 d-flex justify-content-between">
                    <div class="me-2" style="flex: 1;">
                        <label for="interviewerName" class="form-label text-start d-block">Name of Interviewer</label>
                        <input type="text" class="form-control" id="interviewerName" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="candidateName" class="form-label text-start d-block">Select Candidate</label>
                        <select class="form-control" id="candidateName" required>
                            <option value="">Select Candidate</option>
                            @foreach($interviewResults as $result)
                                <option value="{{ $result->candidate_name }}">{{ $result->candidate_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="interviewScore" class="form-label text-start d-block">Interview Score</label>
                    <input type="number" class="form-control" id="interviewScore" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label text-start d-block">Status</label>
                    <select class="form-control status-select badge-on-hold" id="status-select" onchange="updateStatusStyle(this)">
                        <option value="1st Round Passed" class="badge-1st-round">1st Round Passed</option>
                        <option value="2nd Round Passed" class="badge-2nd-round">2nd Round Passed</option>
                        <option value="On-Hold" class="badge-on-hold" selected>On-Hold</option>
                        <option value="Hired" class="badge-hired">Hired</option>
                        <option value="Rejected" class="badge-rejected">Rejected</option>
                    </select>
                </div>
                <div>
                    <label for="interviewNote" class="form-label text-start d-block">Interview Note</label>
                    <textarea class="form-control" id="interviewNote" rows="4" style="resize: none; overflow: hidden;" required></textarea>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const candidateName = document.getElementById('candidateName').value;
            const interviewScore = document.getElementById('interviewScore').value;
            const status = document.getElementById('status-select').value;
            const interviewerName = document.getElementById('interviewerName').value;
            const interviewNote = document.getElementById('interviewNote').value;

            // Validate if the required fields are filled
            if (!candidateName || !interviewScore || !status || !interviewerName || !interviewNote) {
                Swal.showValidationMessage('Please fill in all fields');
                return false;
            }

            // Return data for submission
            return { candidateName, interviewScore, status, interviewerName, interviewNote };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Send the validated data to the server (via AJAX request)
            axios.post('/admin/applicant-results', {
                candidate_name: result.value.candidateName,
                interview_score: result.value.interviewScore,
                result_status: result.value.status,  // This will send the selected status
                interviewer: result.value.interviewerName,
                interview_notes: result.value.interviewNote
            })
            .then(response => {
                Swal.fire('Success!', 'Candidate evaluation submitted!', 'success');
            })
            .catch(error => {
                Swal.fire('Error!', 'An error occurred while submitting the evaluation.', 'error');
            });
        }
    });
});

function updateStatusStyle(selectElement) {
    // Remove previous class
    selectElement.classList.remove('badge-1st-round', 'badge-2nd-round', 'badge-on-hold', 'badge-hired', 'badge-rejected');

    // Add the class corresponding to the selected option
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const selectedClass = selectedOption.classList[0]; // This will get the class like 'badge-1st-round'
    selectElement.classList.add(selectedClass);
}

</script>

@endsection
