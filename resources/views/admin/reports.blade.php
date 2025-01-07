@extends('layouts.admin_pages')

@section('title', 'General Reports')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/job_application.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('reports-content')

    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Search bar and Add New Candidate button -->
    <div class="applicant-container mb-4">

        <!-- Tabs -->
        <div class="custom-tabs">
            <div class="custom-tab active" onclick="showTab('new-hire-info')">
                <i class="fa-solid fa-circle-info me-2"></i>Official Reports
            </div>
            <div class="custom-tab" onclick="showTab('submitted-documents')">
                <i class="fas fa-file-alt me-2"></i>Submitted Documents
            </div>
            <div class="ms-auto">
                <div class="export-buttons">
                    <button class="export-button"><i class="fa-solid fa-file-excel me-2"></i>Excel</button>
                </div>
            </div>
        </div>

        <!-- New Hire Info Content -->
        <div id="new-hire-info" style="display: block;">
            <!-- New Hire Reports Table -->
            <div id="report-section" class="table-responsive">
                <table id="newHireTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>Email Address</th>
                            <th>Type of Work</th>
                            <th>Company Department</th>
                            <th>Department Manager</th>
                            <th>Hire Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newHire as $hire)
                        <tr>
                            <td>{{$hire->first_name}} {{$hire->last_name}}</td>
                            <td>{{$hire->official_emp_id}}</td>
                            <td>{{$hire->emp_email}}</td>
                            <td>{{$hire->work_status}}</td>
                            <td>{{$hire->project_department}}</td>
                            <td>{{$hire->dept_manager}}</td>
                            <td>{{$hire->hire_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submitted Documents Content -->
        <div id="submitted-documents" style="display: none;">
            <!-- Submitted Documents Table -->
            <div class="table-responsive">
                <table id="submittedDocsTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee Name</th>
                            <th>Job Title</th>
                            <th>2x2 Photo</th>
                            <th>Birth Certificate</th>
                            <th>Tin Number</th>
                            <th>PhilHealth</th>
                            <th>Pag-Ibig</th>
                            <th>SSS</th>
                            <th>BIR Form</th>
                            <th>Health Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newDocument as $document)
                            <tr>
                                <td>{{ $document->candidate_name }}</td>
                                <td>{{ $document->applied_job }}</td>

                                <!-- 2x2 Photo -->
                                <td>
                                    @if ($document['2x2_pic'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['2x2_pic'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download 2x2 Photo</p>
                                        </a>
                                    @else
                                        <span>No 2x2 Photo</span>
                                    @endif
                                </td>

                                <!-- Birth Certificate -->
                                <td>
                                    @if ($document['birth_certificate'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['birth_certificate'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Birth Certificate</p>
                                        </a>
                                    @else
                                        <span>No Birth Certificate</span>
                                    @endif
                                </td>

                                <!-- Tin Number -->
                                <td>
                                    @if ($document['tin_number'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['tin_number'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Tin Number</p>
                                        </a>
                                    @else
                                        <span>No Tin Number</span>
                                    @endif
                                </td>

                                <!-- PhilHealth -->
                                <td>
                                    @if ($document['philhealth_id'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['philhealth_id'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download PhilHealth</p>
                                        </a>
                                    @else
                                        <span>No PhilHealth</span>
                                    @endif
                                </td>

                                <!-- Pag-Ibig -->
                                <td>
                                    @if ($document['pagibig_membership_id'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['pagibig_membership_id'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Pag-Ibig</p>
                                        </a>
                                    @else
                                        <span>No Pag-Ibig</span>
                                    @endif
                                </td>

                                <!-- SSS -->
                                <td>
                                    @if ($document['sss'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['sss'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download SSS</p>
                                        </a>
                                    @else
                                        <span>No SSS</span>
                                    @endif
                                </td>

                                <!-- BIR Form -->
                                <td>
                                    @if ($document['bir_form'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['bir_form'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download BIR Form</p>
                                        </a>
                                    @else
                                        <span>No BIR Form</span>
                                    @endif
                                </td>

                                <!-- Health Certificate -->
                                <td>
                                    @if ($document['health_cert'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['health_cert'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Health Certificate</p>
                                        </a>
                                    @else
                                        <span>No Health Certificate</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        const newHireTable = $('#newHireTable').DataTable({
            lengthMenu: [5, 10, 15], // Set options for "Show entries"
            pageLength: 5, // Set the default number of entries
        });

        const submittedDocsTable = $('#submittedDocsTable').DataTable({
            lengthMenu: [5, 10, 15], // Set options for "Show entries"
            pageLength: 5, // Set the default number of entries
        });

        // Add custom search bar styles and behavior
        $('.dataTables_filter input')
            .addClass('form-control') // Apply Bootstrap form control class
            .attr('placeholder', 'Search') // Add placeholder
            .css({
                display: 'flex',
                width: '250px',
                'background-color': '#f2f2f2',
                'border-radius': '12px',
                'box-shadow': '0 1px 5px rgba(0, 0, 0, 0.1)',
                color: '#0c436d',
                'font-weight': '600',
                'padding-right': '35px', // Space for cancel button
                position: 'relative',
            })
            .wrap('<div class="search-container position-relative mt-2 mb-2"></div>');

        // Add magnifying glass and clear icons
        $('.dataTables_filter input')
            .parent()
            .append(
                '<i class="fa-solid fa-magnifying-glass position-absolute search-icon" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d;"></i>' +
                '<i class="fa-solid fa-xmark position-absolute clear-search" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d; opacity: 0; cursor: pointer;"></i>'
            );

        const $searchInput = $('.dataTables_filter input');
        const $searchContainer = $searchInput.parent();

        $searchInput.on('input', function() {
            const $magnifyingGlass = $searchContainer.find('.search-icon');
            const $clearButton = $searchContainer.find('.clear-search');

            if ($(this).val().length > 0) {
                $magnifyingGlass.css('opacity', '0');
                $clearButton.css('opacity', '1');
            } else {
                $magnifyingGlass.css('opacity', '1');
                $clearButton.css('opacity', '0');
            }
        });

        $searchContainer.find('.clear-search').on('click', function() {
            $searchInput.val('').trigger('input'); // Clear input and reset icons
            newHireTable.search('').draw(); // Reset table search
        });

        // Hide native cancel button
        const style = document.createElement('style');
        style.textContent = `
            .dataTables_filter input::-webkit-search-cancel-button {
                display: none;
            }
        `;
        document.head.appendChild(style);

        // Remove "Search:" label
        $('.dataTables_filter label').contents().filter(function() {
            return this.nodeType === 3; // Text nodes
        }).remove();
    });

    function showTab(tabName) {
        document.getElementById('new-hire-info').style.display = 'none';
        document.getElementById('submitted-documents').style.display = 'none';
        document.getElementById(tabName).style.display = 'block';

        const tabs = document.querySelectorAll('.custom-tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.closest('.custom-tab').classList.add('active');
    }
</script>

@endsection
