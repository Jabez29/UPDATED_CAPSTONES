<div class="modal fade modal-lg" id="user-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input id="id" type="hidden">
                <div class="container">
                    <div>
                        <div class="col-md-4">
                            <label class="form-label" for="role">Select User Role:</label>
                            <input type="text" class="form-control" name="role" id="role">
                            <div class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="firstName">Firstname:</label>
                            <input type="text" class="form-control" name="firstName" placeholder="Enter Firstname"
                                required id="firstName">
                            <div class="text-danger"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="middleName">Middlename:</label>
                            <input type="text" class="form-control" name="middleName" placeholder="Enter Middlename"
                                required id="middleName">
                            <div class="text-danger"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="lastName">Lastname:</label>
                            <input type="text" class="form-control" name="lastName" placeholder="Enter Lastname"
                                required id="lastName">
                            <div class="text-danger"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" for="userName">Username:</label>
                            <input type="text" class="form-control" name="userName" placeholder="Enter Username"
                                required id="userName">
                            <div class="text-danger"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="email">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email" required
                                id="email">
                            <div class="text-danger"></div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Password"
                                required id="password">
                            <div class="text-danger"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="frm-submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>