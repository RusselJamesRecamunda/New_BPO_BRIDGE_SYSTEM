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
            fetchEvents(
                fetchInfo.start,
                fetchInfo.end,
                successCallback,
                failureCallback
            );
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
            let zoomLink = arg.event.extendedProps.zoom_link || "";

            let html = `
                <div>
                    <strong>${startTime}</strong><br>
                    <strong>${candidateName}</strong><br>
                    <span>${appliedJob}</span><br>
                    <em>${interviewMode}</em><br>
                    ${
                        zoomLink
                            ? `<a class="text-success text-decoration-none fw-bold" href="${zoomLink}" target="_blank">Zoom Meeting Link</a>`
                            : ""
                    }                    
                </div>
            `;

            return { html: html };
        },
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
            $("#zoom_link").val(info.event.extendedProps.zoom_link || "");
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
                        success: function (data) {
                            if (data.success) {
                                alert(
                                    data.message ||
                                        "Interview updated successfully."
                                );
                                updateEvent(info.event.id, formData); // Update the specific event instead of refetching all events
                                closeModal();
                            } else {
                                alert(
                                    data.message ||
                                        "Failed to update interview."
                                );
                            }
                        },
                        error: function (xhr) {
                            console.error("Error Response:", xhr.responseText);
                            let errorMessage;
                            try {
                                const errorResponse = JSON.parse(
                                    xhr.responseText
                                );
                                errorMessage =
                                    errorResponse.message ||
                                    "Failed to update interview.";
                            } catch (e) {
                                errorMessage = "Failed to update interview.";
                            }
                            alert(errorMessage);
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
                                calendar.getEventById(info.event.id).remove(); // Remove the specific event from the calendar
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

        eventDrop: function (info) {
            var newStartDate = info.event.start.toISOString();
            var newEndDate = info.event.end
                ? info.event.end.toISOString()
                : null;

            $.ajax({
                url: `/admin/interviews/${info.event.id}`,
                type: "PUT",
                data: {
                    candidate_name: info.event.title,
                    applied_job: info.event.extendedProps.applied_job,
                    interview_mode: info.event.extendedProps.interview_mode,
                    email: info.event.extendedProps.email,
                    phone: info.event.extendedProps.phone,
                    start: newStartDate,
                    end: newEndDate,
                    interview_date: newStartDate.split("T")[0],
                    interview_time: newStartDate.split("T")[1].substring(0, 5),
                    _method: "PUT",
                },
                success: function () {
                    alert("Interview date updated successfully.");
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("Failed to update interview date.");
                    info.revert();
                },
            });
        },
    });

    calendar.render();

    $("#closeModalBtn").on("click", function () {
        closeModal();
    });

    function fetchEvents(start, end, successCallback, failureCallback) {
        $.ajax({
            url: "/admin/interviews",
            method: "GET",
            data: {
                start: start.toISOString(),
                end: end.toISOString(),
            },
        })
            .done(function (interviewResponse) {
                console.log("Interview Response:", interviewResponse);

                var interviewEvents = Array.isArray(interviewResponse)
                    ? interviewResponse.map(function (interview) {
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
                                  zoom_link: interview.zoom_link,
                              },
                          };
                      })
                    : interviewResponse.data
                    ? interviewResponse.data.map(function (interview) {
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
                                  zoom_link: interview.zoom_link,
                              },
                          };
                      })
                    : []; // Default to an empty array if no valid data is found

                successCallback(interviewEvents); // Send only interview events to calendar
            })
            .fail(function (xhr) {
                console.error(xhr.responseText);
                failureCallback();
            });
    }

    function openModal(startDate) {
        $("#interviewModal").show();
        $(".modal-backdrop").show();
        $("#interviewForm")[0].reset();
        $("#interview_date").val(startDate.split("T")[0]);
        $("#interview_time").val("09:00");
        $("#zoom_link").show();

        $("#interviewForm")
            .off("submit")
            .on("submit", function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "/admin/interviews",
                    type: "POST",
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            alert(
                                data.message ||
                                    "Interview scheduled successfully."
                            );
                            addNewEvent(data.newEvent); // Directly add the new event to the calendar
                            closeModal();
                        } else {
                            alert(
                                data.message || "Failed to schedule interview."
                            );
                        }
                    },
                    error: function (xhr) {
                        console.error("Error Response:", xhr.responseText);
                        let errorMessage;
                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            errorMessage =
                                errorResponse.message ||
                                "Failed to schedule interview.";
                        } catch (e) {
                            errorMessage = "Failed to schedule interview.";
                        }
                        alert(errorMessage);
                    },
                });
            });
    }

    function closeModal() {
        $("#interviewModal").hide();
        $(".modal-backdrop").hide();
    }

    function addNewEvent(newEventData) {
        const newEvent = {
            id: newEventData.id,
            title: newEventData.title,
            start: newEventData.start,
            end: newEventData.end,
            extendedProps: {
                applied_job: newEventData.applied_job,
                interview_mode: newEventData.interview_mode,
                email: newEventData.email,
                phone: newEventData.phone,
                zoom_link: newEventData.zoom_link,
            },
        };
        calendar.addEvent(newEvent); // Add new event directly to the calendar
    }

    // Poll for new events every 30 seconds
    setInterval(function () {
        fetchEvents(
            new Date(),
            new Date(new Date().getTime() + 7 * 24 * 60 * 60 * 1000),
            function (events) {
                calendar.removeAllEvents(); // Clear existing events
                events.forEach((event) => calendar.addEvent(event)); // Add all events
            },
            function () {
                console.error("Failed to fetch events during polling.");
            }
        );
    }, 30000); // Check every 30 seconds
});
