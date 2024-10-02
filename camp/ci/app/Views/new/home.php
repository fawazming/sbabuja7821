<div class="col-lg-9 col-xl-7 mx-auto">
    <div id="wizard_container">
        <div id="top-wizard">
            <span id="location"></span>
            <div id="progressbar"></div>
        </div>
        <!-- /top-wizard -->
        <form id="wrapped" hx-post="<?=base_url('register')?>">
            <div id="middle-wizard">
                <div class="step">
                    <h4>Personal Details</h4>
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" name="fname" id="fname" class="form-control" placeholder="" required
                            aria-describedby="first name">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" name="lname" id="lname" class="form-control" placeholder="" required
                            aria-describedby="Last name">
                    </div>
                    <div class="mb-3">
                        <label for="lb" class="form-label">Zone</label>
                        <select name="lb" id="lb" required>
                            <option value="">Select a Zone</option>
                            <option value="Ife|Olode">Ife|Olode</option>
                            <option value="Ilesha">Ilesha</option>
                            <option value="Osogbo|Ede">Osogbo|Ede</option>
                            <option value="Ikirun|Ila|Okuku">Ikirun|Ila|Okuku</option>
                            <option value="Iwo">Iwo</option>
                            <option value="Akure|Owena|Ekiti">Akure|Owena|Ekiti</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>
                <!-- /step-->
                <div class="step">
                    <h4>Contact Details</h4>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" required>
                            <option value="">Select a gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="number" name="phone" id="phone" class="form-control" placeholder="" required
                            aria-describedby="Phone Number">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="" required
                            aria-describedby="Email">
                    </div>
                </div>
                <!-- /step-->
                <div class="submit step">
                    <h4>Work/School Details</h4>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" required>
                            <option value="">Select a Category</option>
                            <option class="catg" value="Secondary School">Secondary School</option>
                            <option class="catg" value="School Leaver">School Leaver</option>
                            <option class="catg" value="Undergraduate">Undergraduate</option>
                            <option class="catg" value="Workers/Others">Workers/Others</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sch" class="form-label">School/Course/Profession (Details of the above
                            category)</label>
                        <input type="sch" name="school" required id="sch" class="form-control" placeholder=""
                            aria-describedby="sch">
                        <input type="hidden" name="ref" value=<?=$ref?> >
                        <input type="hidden" name="old" value="0">
                    </div>
                    <div class="text-center form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="transfer">
                        <label class="form-check-label" for="transfer">
                            All data provided are correct and accurate
                        </label>
                    </div>
                </div>
                <!-- /step-->
            </div>
            <!-- /middle-wizard -->
            <div id="bottom-wizard">
                <button type="button" name="backward" class="backward">Prev</button>
                <button type="button" name="forward" class="forward">Next</button>
                <button type="submit" name="process" class="submit">Submit</button>
            </div>
            <!-- /bottom-wizard -->
        </form>
    </div>
    <!-- /Wizard container -->
</div>