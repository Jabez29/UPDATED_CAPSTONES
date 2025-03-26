
// no.17
document.addEventListener("DOMContentLoaded", function () {
    const reasonSelect = document.querySelector('[name="reason_not_employed"]');
    const otherReasonInput = document.querySelector('[name="other_reason_specify"]');

    if (reasonSelect) {
        reasonSelect.addEventListener('change', function() {
            if (this.value === 'other_reasons') {
                otherReasonInput.style.display = 'block';
            } else {
                otherReasonInput.style.display = 'none';
            }
        });
    } else {
        console.error("Dropdown element not found in DOM");
    }
});

//no.20
document.addEventListener("DOMContentLoaded", function() {
    const businessTypeSelect = document.querySelector('[name="business_type"]');
    const otherBusinessInput = document.querySelector('[name="other_business_type"]');

    if (businessTypeSelect) {
        businessTypeSelect.addEventListener('change', function() {
            otherBusinessInput.style.display = this.value === 'other' ? 'block' : 'none';
        });
    } else {
        console.error("Dropdown element not found in DOM");
    }
});
// no. 25
document.addEventListener("DOMContentLoaded", function() {
    const breakDurationSelect = document.querySelector('[name="break_duration"]');
    const otherBreakInput = document.querySelector('[name="other_break_duration"]');

    if (breakDurationSelect) {
        breakDurationSelect.addEventListener('change', function() {
            otherBreakInput.style.display = this.value === 'other' ? 'block' : 'none';
        });
    } else {
        console.error("Dropdown element not found in DOM");
    }
});

//no.28
document.addEventListener("DOMContentLoaded", function() {
    // Selecting the correct elements
    const reasonForChangingSelect = document.querySelector('[name="reason_for_changing"]');
    const otherChangingReasonInput = document.querySelector('[name="other_changing_reason"]');

    // Ensure the elements exist before adding event listeners
    if (reasonForChangingSelect) {
        reasonForChangingSelect.addEventListener('change', function() {
            otherChangingReasonInput.style.display = this.value === 'other' ? 'block' : 'none';
        });
    } else {
        console.error("Dropdown for reason_for_changing not found in DOM.");
    }
});

// no. 37
document.addEventListener("DOMContentLoaded", function() {
    const selectField = document.querySelector('[name="competencies_used_in_first_job"]');
    const otherInput = document.querySelector('[name="other_skills_specify"]');

    if (selectField) {
        selectField.addEventListener('change', function() {
            otherInput.style.display = this.value === 'other_skills' ? 'block' : 'none';
        });
    } else {
        console.error("Dropdown for competencies_used_in_first_job not found in DOM.");
    }
});

//no.30
document.addEventListener("DOMContentLoaded", function() {
    const promotionSelect = document.querySelector('[name="time_before_promotion"]');
    const otherPromotionInput = document.querySelector('[name="other_promotion_time"]');

    if (promotionSelect) {
        promotionSelect.addEventListener('change', function() {
            otherPromotionInput.style.display = this.value === 'other' ? 'block' : 'none';
        });
    } else {
        console.error("Dropdown for time_before_promotion not found in DOM.");
    }
});