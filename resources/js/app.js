import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import multiMonthPlugin from "@fullcalendar/multimonth";
import interactionPlugin from "@fullcalendar/interaction";

document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new Calendar(calendarEl, {
        initialView: "dayGridMonth",
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
            listPlugin,
            multiMonthPlugin,
            interactionPlugin,
        ],
        editable: true,
        selectable: true,
    });
    calendar.render();
});
