document.addEventListener("DOMContentLoaded", () => {
    const preventReload = (event) => {
        event.preventDefault();
    };

    // Pre-fill the profile summary and date of birth from server
    const profileSummary = document.querySelector("#summary-text");
    const dateOfBirth = document.querySelector("#birthdate");

    // Assuming these values are being passed from the server to the frontend
    const existingProfileSummary = profileSummary
        ? profileSummary.textContent
        : "";
    const existingDateOfBirth = dateOfBirth ? dateOfBirth.textContent : "";

    // Function to handle the AJAX request
    const updateProfileContent = (field, value) => {
        fetch(profileContentsUpdateRoute, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                field: field,
                value: value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Profile Updated",
                        text: `${field} has been successfully updated.`,
                    });

                    // Handle skills update
                    if (field === "skills") {
                        if (data.skillsHtml && Array.isArray(data.skillsHtml)) {
                            const skillsList =
                                document.querySelector("#skills-list");
                            skillsList.innerHTML = "";
                            data.skillsHtml.forEach((skill) => {
                                const skillBadge =
                                    document.createElement("span");
                                skillBadge.className =
                                    "badge text-white me-2 rounded-5";
                                skillBadge.style.cssText =
                                    "font-size: 17px; background-color: #1b6280; font-weight: 500; padding: 10px;";
                                skillBadge.textContent = skill;
                                skillsList.appendChild(skillBadge);
                            });
                        } else {
                            console.warn(
                                "Invalid or missing skillsHtml from the server response."
                            );
                        }
                    }

                    // Handle profile summary update
                    if (field === "profile_summary") {
                        const summaryDisplay =
                            document.querySelector("#summary-text");
                        if (summaryDisplay) {
                            summaryDisplay.textContent =
                                value || "No summary provided.";
                        }
                    }

                    // Handle date of birth update
                    if (field === "date_of_birth") {
                        const dobDisplay = document.querySelector("#birthdate");
                        if (dobDisplay) {
                            dobDisplay.textContent =
                                value || "Date of birth not set.";
                        }
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: data.message || "Something went wrong.",
                    });
                }
            })
            .catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again.",
                });
            });
    };

    // Handle the date-of-birth button click
    document
        .querySelector(".date-of-birth-btn")
        .addEventListener("click", (e) => {
            preventReload(e);
            Swal.fire({
                title: "Add or Update Birthdate",
                html: `
                <div>
                    <label for="birthdate-input" class="form-label">Enter your birthdate:</label>
                    <input type="date" id="birthdate-input" class="form-control" value="${
                        existingDateOfBirth || ""
                    }">
                </div>
            `,
                confirmButtonText: "Save",
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                preConfirm: () => {
                    const birthdate = document
                        .getElementById("birthdate-input")
                        .value.trim();
                    updateProfileContent(
                        "date_of_birth",
                        birthdate === "" ? null : birthdate
                    );
                },
            });
        });

    // Handle the summary button click
    document.querySelector(".summary-btn").addEventListener("click", (e) => {
        preventReload(e);
        Swal.fire({
            title: "Edit Personal Summary",
            html: `
            <div class="w-100">
                <label for="summary-input" class="form-label w-100" style="text-align: left;">Your Summary</label>
                <textarea id="summary-input" class="form-control w-100" rows="10" placeholder="Highlight your personal experiences, goals, and strengths;" style="text-align: left; padding-left: 0px; margin-left: 0px; border: 1px solid #ccc;">${existingProfileSummary}</textarea> 
            </div>
        `,
            confirmButtonText: "Save",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
            preConfirm: () => {
                const summary = document
                    .getElementById("summary-input")
                    .value.trim();
                updateProfileContent(
                    "profile_summary",
                    summary === "" ? null : summary
                );
            },
        });
    });

    // Handle the skills button click
    document.querySelector(".skills-btn").addEventListener("click", (e) => {
        preventReload(e);
        const existingSkills = document.querySelectorAll("#skills-list .badge");
        const skillList = Array.from(existingSkills).map((skill) =>
            skill.textContent.trim()
        );

        let addedSkillsHtml = "";
        if (skillList.length > 0) {
            addedSkillsHtml = skillList
                .map(
                    (skill) =>
                        `<span class="badge text-white mt-2 me-2 rounded-5" style="font-size: 16px; background-color: #1b6280; font-weight:500; padding: 10px;">
                    ${skill} <button type="button" class="btn-close btn-close-white ms-1 remove-skill" data-skill="${skill}" style="font-size: 11px;"></button>
                </span>`
                )
                .join("");
        } else {
            addedSkillsHtml = `<span class="text-muted" style="font-size: 17px;">No skills have been added.</span>`;
        }

        Swal.fire({
            title: "Edit Skills",
            html: `
                <div>
                    <label for="skill-input" class="form-label">Add new skill:</label>
                    <input type="text" id="skill-input" class="form-control mb-2" placeholder="Type a skill...">
                </div>
                <h5 class="mt-4">Your Skills</h5>
                <div id="added-skills" class="mt-2 text-center text-muted">
                    ${addedSkillsHtml}
                </div>
            `,
            confirmButtonText: "Save",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
            didOpen: () => {
                const skillInput = document.getElementById("skill-input");
                const addedSkills = document.getElementById("added-skills");
                window.addedSkillList = skillList.slice();

                const updateAddedSkills = () => {
                    if (window.addedSkillList.length === 0) {
                        addedSkills.innerHTML = "No skills have been added.";
                        addedSkills.classList.add("text-muted");
                    } else {
                        addedSkills.innerHTML = window.addedSkillList
                            .map(
                                (skill, index) =>
                                    `<span class="badge text-white me-2 rounded-5" style="font-size: 16px; background-color: #1b6280; font-weight:500; padding: 10px;">
                                    ${skill} <button type="button" class="btn-close btn-close-white ms-1 remove-skill" data-skill="${skill}" style="font-size: 11px;"></button>
                                </span>`
                            )
                            .join("");
                        addedSkills.classList.remove("text-muted");
                    }
                };

                skillInput.addEventListener("keydown", (e) => {
                    if (e.key === "Enter") {
                        const skill = skillInput.value.trim();
                        const validSkill = /^[a-zA-Z\s]+$/.test(skill); // Allows only letters and spaces
                        if (
                            skill.length > 0 &&
                            !window.addedSkillList.includes(skill) &&
                            validSkill
                        ) {
                            window.addedSkillList.push(skill);
                            updateAddedSkills();
                        } else if (!validSkill) {
                            Swal.fire({
                                icon: "error",
                                title: "Invalid Input",
                                text: "Skills can only contain letters and spaces.",
                            });
                        }
                        skillInput.value = "";
                        e.preventDefault();
                    }
                });

                addedSkills.addEventListener("click", (e) => {
                    if (e.target.classList.contains("remove-skill")) {
                        const skill = e.target.getAttribute("data-skill");
                        window.addedSkillList = window.addedSkillList.filter(
                            (s) => s !== skill
                        );
                        updateAddedSkills();
                    }
                });
            },
            preConfirm: () => {
                const skills =
                    window.addedSkillList.length > 0
                        ? window.addedSkillList.join(", ")
                        : null;
                updateProfileContent("skills", skills);
            },
        });
    });

    const removeSkillButtons = document.querySelectorAll(".remove-skill");
    removeSkillButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            const skill = e.target.getAttribute("data-skill");
            const skillSpan = e.target.closest("span");
            skillSpan.remove();
            updateSkillsList();
        });
    });

    const updateSkillsList = () => {
        const skillsList = [
            ...document.querySelectorAll(".skills-display .badge"),
        ];
        const skillsArray = skillsList.map((skill) => skill.textContent.trim());

        fetch(profileContentsUpdateRoute, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                field: "skills",
                value: skillsArray.join(", "),
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Skills Updated",
                        text: "Your skills have been successfully updated.",
                    });
                    document.querySelector("#skills-list").innerHTML =
                        data.skillsHtml;
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: data.message || "Something went wrong.",
                    });
                }
            })
            .catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred. Please try again.",
                });
            });
    };
});
