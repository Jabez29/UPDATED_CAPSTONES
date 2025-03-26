<?php
include_once '../CAPs/templates/nav.php';


?>


<div class="p-4 border rounded shadow-sm bg-white">
    <div class="block-heading text-center">
        <h3 class="mb-3">C. TRAINING(S)/ADVANCE STUDIES ATTENDED AFTER COLLEGE</h3>
    </div>

    <p class="text-center font-weight-bold">15. Please list down all professional or work-related training program(s),
        including advanced studies you have attended after college.</p>
    <form action="http://localhost/Caps/validate/training.php" method="POST">
        <div id="trainingFields" class="input-group d-flex">
            <input class="form-control" type="text" name="training_title"
                placeholder="Title of Training or Advanced Study">
            <input class="form-control" type="text" name="duration" placeholder="Duration and Credits Earned">
            <input class="form-control" type="text" name="institution" placeholder="Name of Training Institution">
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-primary" onclick="addFields('trainingFields')">Add More
                Fields</button>
            <button type="button" class="btn btn-danger" onclick="removeFields('trainingFields')">Remove
                Field</button>
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>