<?php
include_once '../CAPs/templates/nav.php';


?>
<form action="http://localhost/Caps/validate/education.php" method="post">
    <div class="p-4 border rounded shadow-sm bg-white">
        <div class="block-heading text-center">
            <h3 class="mb-3">B. Educational Background</h3>
        </div>

        <p class="text-center font-weight-bold">12. Educational Attainment (Baccalaureate Degree only) *</p>
        <div id="d1" class="input-group d-flex">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="degree"
                placeholder="Degree & Specialization" id="deg1">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="college"
                placeholder="College / University" id="col1">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="year"
                placeholder="Year Graduated" id="year1">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="honors"
                placeholder="Honors / Awards Received" id="hon1">
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-primary" onclick="addFields()">Add More Fields</button>
            <button type="button" class="btn btn-danger" onclick="removeFields()">Remove Field</button>
        </div>

        <p class="text-center font-weight-bold mt-4">13. Professional Examination(s) Passed</p>
        <div id="d2" class="input-group d-flex">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="exam_name"
                placeholder="Name Of Examination" id="name1">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="exam_date"
                placeholder="YYY-MMM-DDD" id="date1">
            <input class="form-control" type="text" style="font-family: Roboto, sans-serif;" name="exam_rating"
                placeholder="Rating" id="rating1">
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-primary" onclick="addFields2()">Add More Fields</button>
            <button type="button" class="btn btn-danger" onclick="removeFields2()">Remove Field</button>
        </div>

        <label for="card_holder" style="font-family: 'Roboto Slab', serif;">
            <br>
            "14. Reason(s) for taking the course(s) or pursuing degree(s). You may check (/) more than one answer."
            <br><br>
        </label>

        <!-- Checkbox section remains unchanged -->
        <div class="row align-items-center border-bottom py-2">
            <div class="col-8">High grades in the course or subject area(s) related to the course</div>
            <div class="col-2 text-left"><input type="checkbox" name="reason1[]" value="Undergraduate/AB/BS"></div>
            <div class="col-2 text-left"><input type="checkbox" name="reason1[]" value="Graduate/MS/MA/PhD"></div>
        </div>

        <div class="row align-items-center border-bottom py-2">
            <div class="col-8">Good grades in high school</div>
            <div class="col-2 text-left"><input type="checkbox" name="reason2[]" value="Undergraduate/AB/BS"></div>
            <div class="col-2 text-left"><input type="checkbox" name="reason2[]" value="Graduate/MS/MA/PhD"></div>
        </div>

        <div class="row align-items-center border-bottom py-2">
            <div class="col-8">Influence of parents or relatives</div>
            <div class="col-2 text-left"><input type="checkbox" name="reason3[]" value="Undergraduate/AB/BS"></div>
            <div class="col-2 text-left"><input type="checkbox" name="reason3[]" value="Graduate/MS/MA/PhD"></div>
        </div>

        <div class="row align-items-center border-bottom py-2">
            <div class="col-8">Peer Influence</div>
            <div class="col-2 text-left"><input type="checkbox" name="reason4[]" value="Undergraduate/AB/BS"></div>
            <div class="col-2 text-left"><input type="checkbox" name="reason4[]" value="Graduate/MS/MA/PhD"></div>
        </div>

        <div class="text-right mt-4">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
</form>