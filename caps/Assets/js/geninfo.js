$(document).ready(function () {
    // Load regions
    $.get("../caps/fetch/fetch_regions.php", function (data) {
        let regions = JSON.parse(data);
        regions.forEach(region => {
            $("#region").append(new Option(region.name, region.reg_code));
        });
    });

    // Load provinces when region changes
    $("#region").change(function () {
        let reg_code = $(this).val();
        $("#province").html('<option value="">Select Province</option>').prop("disabled", !reg_code);
        $("#city").html('<option value="">Select City</option>').prop("disabled", true);
        $("#barangay").html('<option value="">Select Barangay</option>').prop("disabled", true);
        
        if (reg_code) {
            $.get("../caps/fetch/fetch_provinces.php", { reg_code }, function (data) {
                let provinces = JSON.parse(data);
                provinces.forEach(province => {
                    $("#province").append(new Option(province.name, province.prv_code));
                });
            });
        }
    });

    // Load municipalities when province changes
    $("#province").change(function () {
        let prv_code = $(this).val();
        $("#city").html('<option value="">Select City</option>').prop("disabled", !prv_code);
        $("#barangay").html('<option value="">Select Barangay</option>').prop("disabled", true);
        
        if (prv_code) {
            $.get("../caps/fetch/fetch_municipalities.php", { prv_code }, function (data) {
                let municipalities = JSON.parse(data);
                municipalities.forEach(municipality => {
                    $("#city").append(new Option(municipality.name, municipality.mun_code));
                });
            });
        }
    });

    // Load barangays when city changes
    $("#city").change(function () {
        let mun_code = $(this).val();
        $("#barangay").html('<option value="">Select Barangay</option>').prop("disabled", !mun_code);
        
        if (mun_code) {
            $.get("../caps/fetch/fetch_barangays.php", { mun_code }, function (data) {
                let barangays = JSON.parse(data);
                barangays.forEach(barangay => {
                    $("#barangay").append(new Option(barangay.name, barangay.bgy_code));
                });
            });
        }
    });
});