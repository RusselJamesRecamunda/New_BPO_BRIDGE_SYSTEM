@extends('layouts.admin_pages')

@section('title', 'Manage Users')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/users.css') }}">
    <style>
        .blurred {
            opacity: 0.3;
            pointer-events: none;
        }
    </style>
@endsection

@section('users-content')
    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-users-gear me-3"></i>User Management</h2>
    <div class="users-container mb-4">
        <!-- Search bar and Add New Candidate button -->
        <div class="mb-1">
            <div class="d-flex justify-content-between align-items-center" style="margin-top: -15px">
                <h2 class="mb-4 fw-bold text-dark">Listed Users</h2>
                <div class="d-flex align-items-center">
                    <!-- Search Bar -->
                    <div class="custom-search-bar me-2">
                        <input type="text" id="searchInput" placeholder="Search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <!-- Filter Button -->
                    <button class="btn btn-secondary fw-bold" id="filterButton">
                        <i class="fa-solid fa-sliders me-2"></i>Filter
                    </button>
                    <button class="btn btn-primary">Add HR Admin</button>
                   <!-- Filter Modal -->
                    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center fw-bold" id="filterModalLabel">Select Columns to Display</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Available Columns Section -->
                                        <div class="col-md-6">
                                            <h6 class="text-center">Available Columns</h6>
                                            <div id="availableColumnsList">
                                                <!-- Available columns checkboxes will be added here by JavaScript -->
                                            </div>
                                        </div>

                                        <!-- Saved Columns Section -->
                                        <div class="col-md-6">
                                            <h6 class="text-center">Saved Columns</h6>
                                            <ul id="savedColumnsList">
                                                <!-- Selected columns will be shown here in real-time -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeModalButton" class="btn btn-secondary">Close</button>
                                    <button type="button" id="saveColumnsButton" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <!-- Total Session Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0 fs-5">Sessions</h6>
                        </div>
                        <canvas id="sessionChart" width="80" height="80"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Total Users Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0 fs-5">Overall Users</h6>
                        </div>
                        <canvas id="allUsersChart" width="80" height="80"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Active Users Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0 fs-5">Active</h6>
                        </div>
                        <canvas id="activeUsersChart" width="80" height="80"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Suspended Users Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0 fs-5">Offline</h6>
                        </div>
                        <canvas id="offlineUsersChart" width="80" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>
    

        <!-- User Management Table -->
        <div id="user-management-section" class="table-responsive" style="margin-top: -30px;">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th data-column="user_id">User ID</th>
                        <th data-column="first_name">User Name</th>
                        <th data-column="email">Email</th>
                        <th data-column="role">Role</th>
                        <th data-column="email_verified_at">Date Verified</th>
                        <th data-column="activity_status">Activity Status</th>
                        <!-- <th data-column="user_status">User Status</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td data-column="user_id">{{ $user->user_id }}</td>
                            <td data-column="first_name">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td data-column="email">{{ $user->email }}</td>
                            <td data-column="role">{{ $user->role }}</td>
                            <td data-column="email_verified_at">{{ $user->email_verified_at ? $user->email_verified_at->format('F d, Y') : 'N/A' }}</td>
                            <td data-column="activity_status">
                                @if($user->activity_status === 'Online')
                                    <span class="text-success" style="font-size: 0.9rem;">
                                        <i class="bi bi-circle-fill"></i>
                                    </span>
                                    <span class="fw-bold">{{ $user->activity_status }}</span>
                                @elseif($user->activity_status === 'Offline')
                                    <span class="text-danger" style="font-size: 0.9rem;">
                                        <i class="bi bi-circle-fill"></i>
                                    </span>
                                    <span class="fw-bold">{{ $user->activity_status }}</span>
                                @else
                                    <span class="fw-bold">{{ $user->activity_status }}</span> <!-- Handle any other statuses if needed -->
                                @endif
                            </td>
                            <!-- <td data-column="user_status">
                                <select class="status-select badge-status" data-id="{{ $user->userID }}">
                                    <option value="Active" class="badge-active" {{ $user->user_status == 'Active' ? 'selected' : '' }}>Activate</option>
                                    <option value="Suspended" class="badge-suspended" {{ $user->user_status == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </td> -->
                        </tr>
                    @endforeach 
                </tbody>
            </table>

            <!-- Pagination controls -->
            <div class="pagination-controls" style="margin-top: 0;">
                <!-- Dropdown to select items per page -->
                <div class="pagination-dropdown">
                    Showing
                    <select onchange="window.location.href=this.value;">
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 5]) }}" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ request()->fullUrlWithQuery(['per_page' => 15]) }}" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                    </select>
                </div>

                <!-- Record count summary -->
                <div class="pagination-info">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} out of {{ $users->total() }} records
                </div>

                <!-- Pagination links -->
                <ul class="custom-pagination fw-bold">
                    @if ($users->onFirstPage())
                        <li class="disabled"><a href="#">&lt;</a></li>
                    @else
                        <li><a href="{{ $users->previousPageUrl() }}">&lt;</a></li>
                    @endif

                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <li class="{{ $page == $users->currentPage() ? 'active' : '' }}"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endforeach

                    @if ($users->hasMorePages())
                        <li><a href="{{ $users->nextPageUrl() }}">&gt;</a></li>
                    @else
                        <li class="disabled"><a href="#">&gt;</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Generate percentage data for the charts
    function generatePercentageData(total, value) {
        const validValue = Math.min(value, total); // Ensure value does not exceed total
        return [validValue, total - validValue]; // Create data for filled and empty sections
    }

    // Initialize a doughnut chart with a percentage in the center
    function initializeDoughnutChart(ctx, color, total, value) {
        return new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Filled', 'Remaining'],
                datasets: [{
                    label: 'Data',
                    backgroundColor: [color, 'rgba(211, 211, 211, 0.5)'], // Main color and gray for remaining
                    borderColor: ['transparent', 'transparent'], // Remove borders
                    data: generatePercentageData(total, value),
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                cutout: '70%', // Create space for the percentage text
                plugins: {
                    legend: {
                        display: false // Hide legend
                    },
                    tooltip: {
                        enabled: false // Disable tooltips
                    }
                }
            },
            plugins: [{
                id: 'centerTextPlugin',
                beforeDraw: function (chart) {
                    const { width } = chart;
                    const { ctx } = chart;
                    ctx.save();

                    // Dynamically adjust font size
                    const fontSize = (width / 5).toFixed(2);
                    ctx.font = `${fontSize}px Arial`;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    // Calculate percentage
                    const percentage = total > 0 ? Math.min(100, Math.round((value / total) * 100)) : 0;
                    const text = `${percentage}%`;

                    // Get chart center coordinates
                    const centerX = chart.getDatasetMeta(0).data[0].x;
                    const centerY = chart.getDatasetMeta(0).data[0].y;

                    // Draw percentage text
                    ctx.fillStyle = color;
                    ctx.fillText(text, centerX, centerY);
                    ctx.restore();
                }
            }]
        });
    }

    // Initialize charts for each card with dynamic data
    const sessionChart = initializeDoughnutChart(
        document.getElementById('sessionChart'),
        'rgba(54, 162, 235, 1)',
        {{ $totalSessions > 100 ? $totalSessions : 100 }},
        {{ $totalSessions }}
    );
    const allUsersChart = initializeDoughnutChart(
        document.getElementById('allUsersChart'),
        'rgba(75, 192, 192, 1)',
        {{ $totalUsers > 100 ? $totalUsers : 100 }},
        {{ $totalUsers }}
    );
    const activeUsersChart = initializeDoughnutChart(
        document.getElementById('activeUsersChart'),
        'rgba(153, 102, 255, 1)',
        {{ $totalUsers > 100 ? $totalUsers : 100 }},
        {{ $activeUsers }}
    );
    const offlineUsersChart = initializeDoughnutChart(
        document.getElementById('offlineUsersChart'),
        'rgba(255, 159, 64, 1)',
        {{ $totalUsers > 100 ? $totalUsers : 100 }},
        {{ $offlineUsers }}
    );
</script>



<script>
    // Pass Laravel variables to JavaScript
    const csrfToken = '{{ csrf_token() }}';
    const searchUrl = "{{ route('users.index') }}?search=";
</script>
<script src="{{ asset('asset/js/user-search.js') }}"></script>
<script>
   $(document).ready(function () {
       $('#filterButton').on('click', function () {
           $('#filterModal').modal('show');

           // Fetch available and saved columns
           $.ajax({
               url: "{{ route('users.index') }}",
               method: 'GET',
               data: { action: 'get_columns' },
               success: function (data) {
                   // Populate the available columns list
                   $('#availableColumnsList').empty();
                   data.availableColumns.forEach(column => {
                       const checked = data.savedColumns.includes(column) ? 'checked' : '';
                       $('#availableColumnsList').append(`
                           <div>
                               <input type="checkbox" class="column-checkbox" value="${column}" ${checked}> ${column}
                           </div>
                       `);
                   });

                   // Update saved columns list
                   $('#savedColumnsList').empty();
                   data.savedColumns.forEach(column => {
                       $('#savedColumnsList').append(`<li>${column}</li>`);
                   });
               }
           });
       });

       // Save selected columns
       $('#saveColumnsButton').on('click', function () {
           const selectedColumns = [];
           $('.column-checkbox:checked').each(function () {
               selectedColumns.push($(this).val());
           });

           $.ajax({
               url: "{{ route('users.index') }}",
               method: 'POST',
               data: {
                   _token: csrfToken,
                   action: 'save_columns',
                   columns: selectedColumns
               },
               success: function () {
                   $('#filterModal').modal('hide');
                   // Update the table based on selected columns
                   updateTableColumns(selectedColumns);
               }
           });
       });

       // Function to update the table based on selected columns
       function updateTableColumns(selectedColumns) {
           // Hide all columns first
           $('table thead th, table tbody td').hide();

           // Show only the selected columns
           selectedColumns.forEach(function(column) {
               $('table thead th[data-column="' + column + '"]').show();
               $('table tbody td[data-column="' + column + '"]').show();
           });
       }

       // Close modal function
       function closeModal() {
           $('#filterModal').modal('hide');
       }

       // Initialize with saved columns on page load
       $.ajax({
           url: "{{ route('users.index') }}",
           method: 'GET',
           data: { action: 'get_saved_columns' },
           success: function (data) {
               const columns = data.savedColumns;
               $('table thead th, table tbody td').each(function () {
                   const columnName = $(this).data('column');
                   if (!columns.includes(columnName)) {
                       $(this).hide();
                   } else {
                       $(this).show();
                   }
               });
           }
       });

       // Attach closeModal function to the Close button
       $('#closeModalButton').on('click', closeModal);
   });
</script>
@endsection
