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
        height: 820,
        contentHeight: "500px",
        slotLabelFormat: {
            hour: "numeric",
            minute: "2-digit",
            meridiem: "short",
        },
        slotMinTime: "06:00:00",
        slotMaxTime: "20:00:00",
        events: function (fetchInfo, successCallback, failureCallback) {
            $.when(
                $.ajax({
                    url: "/admin/interviews",
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

                    var interviewEvents = interviewResponse[0].map(function (
                        interview
                    ) {
                        return {
                            id: interview.id,
                            title: interview.title,
                            start: interview.start,
                            end: interview.end,
                            backgroundColor: interview.selected_color,
                            extendedProps: {
                                applied_job: interview.applied_job,
                                interview_mode: interview.interview_mode,
                                email: interview.email,
                                phone: interview.phone,
                            },
                        };
                    });

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

            let html = `
                <div>
                    <strong>${startTime}</strong><br>
                    <strong>${candidateName}</strong><br>
                    <span>${appliedJob}</span><br>
                    <em>${interviewMode}</em>
                </div>
            `;

            return { html: html };
        },
        dayMaxEvents: 2,
        eventLimitClick: "popover",
        editable: true,
        selectable: true,

        select: function (info) {
            openModal(info.startStr);
        },

        eventClick: function (info) {
            $("#interviewModal").show();
            $(".modal-backdrop").show();

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

            $("#interviewForm")
                .off("submit")
                .on("submit", function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: `/admin/interviews/${info.event.id}`,
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

            $("#deleteInterviewBtn")
                .off("click")
                .on("click", function () {
                    if (
                        confirm(
                            "Are you sure you want to delete this interview?"
                        )
                    ) {
                        $.ajax({
                            url: `/admin/interviews/${info.event.id}`,
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

        // Functionality for dragging and dropping events
        eventDrop: function (info) {
            var newStartDate = info.event.start.toISOString(); // New start date after drag
            var newEndDate = info.event.end
                ? info.event.end.toISOString()
                : null; // Optional: Update end date if applicable

            $.ajax({
                url: `/admin/interviews/${info.event.id}`, // Assuming the update URL is structured like this
                type: "PUT",
                data: {
                    candidate_name: info.event.title, // Pass the candidate name
                    applied_job: info.event.extendedProps.applied_job, // Pass applied job
                    interview_mode: info.event.extendedProps.interview_mode, // Pass interview mode
                    email: info.event.extendedProps.email, // Pass email
                    phone: info.event.extendedProps.phone, // Pass phone number
                    start: newStartDate, // Pass the new start date
                    end: newEndDate, // Pass the new end date (optional)
                    interview_date: newStartDate.split("T")[0], // Pass interview date
                    interview_time: newStartDate.split("T")[1].substring(0, 5), // Pass interview time
                    _method: "PUT", // In case you are using a PUT method
                },
                success: function () {
                    alert("Interview date updated successfully.");
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("Failed to update interview date.");
                    info.revert(); // Revert the event to the original date if the update fails
                },
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
                    url: "/admin/interviews",
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
