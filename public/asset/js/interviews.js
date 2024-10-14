document.addEventListener("DOMContentLoaded", function () {
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
        },
        slotLabelFormat: {
            hour: "numeric",
            minute: "2-digit",
            meridiem: "short",
        },
        slotMinTime: "06:00:00",
        slotMaxTime: "20:00:00",
        events: function (fetchInfo, successCallback, failureCallback) {
            // Fetch interviews and holidays simultaneously
            $.when(
                $.ajax({
                    url: "/admin/interviews", // Updated for external JS context
                    method: "GET",
                }),
                $.ajax({
                    url: "https://calendarific.com/api/v2/holidays",
                    type: "GET",
                    data: {
                        api_key: "0yJOVpJywiRcySCVdn36Ubll3LJToZmj",
                        country: "PH",
                        year: new Date().getFullYear(),
                    },
                })
            )
                .done(function (interviewResponse, holidayResponse) {
                    console.log(interviewResponse[0]);
                    console.log(holidayResponse[0]);

                    // Map interviews to FullCalendar event format
                    var interviewEvents = interviewResponse[0].map(function (
                        interview
                    ) {
                        return {
                            id: interview.id,
                            title: interview.title,
                            start: interview.start,
                            end: interview.end,
                            extendedProps: {
                                applied_job: interview.applied_job,
                                interview_mode: interview.interview_mode,
                                email: interview.email,
                                phone: interview.phone,
                            },
                        };
                    });

                    // Map holidays to FullCalendar event format
                    var holidayEvents =
                        holidayResponse[0].response.holidays.map(function (
                            holiday
                        ) {
                            return {
                                title: holiday.name,
                                start: holiday.date.iso,
                                backgroundColor: "#f44336",
                                borderColor: "#f44336",
                                textColor: "white",
                            };
                        });

                    // Combine both interview and holiday events
                    var allEvents = interviewEvents.concat(holidayEvents);
                    successCallback(allEvents);
                })
                .fail(function (xhr) {
                    console.error(xhr.responseText);
                    failureCallback();
                });
        },
        eventContent: function (arg) {
            let startTime = new Date(arg.event.start).toLocaleTimeString([], {
                hour: "numeric",
                minute: "2-digit",
                meridiem: "short",
            });
            let candidateName = arg.event.title;
            let appliedJob = arg.event.extendedProps.applied_job || "";
            let interviewMode = arg.event.extendedProps.interview_mode || "";

            // Render custom event content
            let html = `
                <div>
                    <strong>${startTime}</strong><br>
                    <strong>${candidateName}</strong><br>  <!-- Bold text without a line -->
                    <span>${appliedJob}</span><br>
                    <em>${interviewMode}</em>
                </div>
            `;

            return { html: html };
        },
        dayMaxEvents: 2, // Limits visible events to 2 per day
        eventLimitClick: "popover", // Display more events in a popover when clicked
        editable: true,
        selectable: true,

        select: function (info) {
            openModal(info.startStr);
        },

        eventClick: function (info) {
            $("#interviewModal").show();
            $(".modal-backdrop").show();

            // Populate modal fields with event details
            $("#candidate_name").val(info.event.title);
            $("#applied_job").val(info.event.extendedProps.applied_job || "");
            $("#interview_mode").val(
                info.event.extendedProps.interview_mode || ""
            );
            $("#email").val(info.event.extendedProps.email || "");
            $("#phone").val(info.event.extendedProps.phone || "");
            $("#interview_date").val(
                info.event.start.toISOString().split("T")[0]
            );
            $("#interview_time").val(
                info.event.start.toTimeString().split(" ")[0].substring(0, 5)
            );

            // Bind update form submission
            $("#interviewForm")
                .off("submit")
                .on("submit", function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: `/admin/interviews/${info.event.id}`, // Updated route for the event
                        type: "PUT",
                        data: formData,
                        success: function () {
                            alert("Interview updated successfully.");
                            calendar.refetchEvents();
                            closeModal();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert("Failed to update interview.");
                        },
                    });
                });

            // Bind delete button click
            $("#deleteInterviewBtn")
                .off("click")
                .on("click", function () {
                    if (
                        confirm(
                            "Are you sure you want to delete this interview?"
                        )
                    ) {
                        $.ajax({
                            url: `/admin/interviews/${info.event.id}`, // Update route for deletion
                            type: "DELETE",
                            success: function () {
                                alert("Interview deleted successfully.");
                                calendar.refetchEvents();
                                closeModal();
                            },
                            error: function (xhr) {
                                console.error(xhr.responseText);
                                alert("Failed to delete interview.");
                            },
                        });
                    }
                });
        },
    });

    calendar.render();

    $("#closeModalBtn").on("click", function () {
        closeModal();
    });

    function openModal(startDate) {
        $("#interviewModal").show();
        $(".modal-backdrop").show();
        $("#interviewForm")[0].reset();
        $("#interview_date").val(startDate.split("T")[0]);
        $("#interview_time").val("09:00");

        $("#interviewForm")
            .off("submit")
            .on("submit", function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "/admin/interviews", // Ensure this route points to the correct location
                    type: "POST",
                    data: formData,
                    success: function () {
                        alert("Interview scheduled successfully.");
                        calendar.refetchEvents();
                        closeModal();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert("Failed to schedule interview.");
                    },
                });
            });
    }

    function closeModal() {
        $("#interviewModal").hide();
        $(".modal-backdrop").hide();
    }
});
