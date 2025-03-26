document.addEventListener("DOMContentLoaded", function() {
    // Generate options for graduation year
    const startYear = 1992;
    const currentYear = new Date().getFullYear();
    const graduationYearSelect = document.getElementById("graduationYear");

    // Loop to generate year ranges and append options
    for (let year = startYear; year < currentYear; year++) {
        const nextYear = year + 1;
        const option = document.createElement("option");
        option.value = `${year}-${nextYear}`;
        option.textContent = `${year}-${nextYear}`;
        graduationYearSelect.appendChild(option);
    }
});
