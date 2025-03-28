document.querySelectorAll('input[name="pass_type"]').forEach((elem) => {
  elem.addEventListener("change", function () {
    var passType = this.value;
    var passDetailsContainer = document.getElementById("passDetails");
    var passForm = document.getElementById("passForm");
    passDetailsContainer.innerHTML = ""; // Clear previous pass details

    if (passType === "gate_pass") {
      // Display fields for gate pass
      passDetailsContainer.innerHTML = `
      
                <label  class="form-label" for="timeOut">From<span class="text-danger">*</span></label><br>
                <input class="form-control" type="datetime-local" id="timeOut" name="time_out"   style="width:100%" class='container-fluid' required><br>

                <label for="timeIn">To<span class="text-danger">*</span></label><br>
                <input class="form-control" type="datetime-local" id="timeIn" name="time_in" style="width:100%" class='container-fluid' required><br>

                <label  for="address">Address<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="address" name="address" style="width:100%" required><br>
                
                 <label  class="form-label" for="reason">Reason<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="reason" name="reason" style="width:100%" required><br>

                <input type="hidden" name="passType" value="gatePass">
            `;
      // out pass date fixing
      function updateMinTime() {
        const now = new Date();
        now.setSeconds(0, 0);
        now.setMilliseconds(0);

        const currentDateTime = now.toISOString().slice(0, 16);
        const todayDate = new Date().toISOString().slice(0, 10);
        const maxTime = todayDate + "T23:59";

        const timeOutInput = document.getElementById('timeOut');
        const timeInInput = document.getElementById('timeIn');

        timeOutInput.setAttribute('min', currentDateTime);
        timeOutInput.setAttribute('max', maxTime);

        timeInInput.setAttribute('min', currentDateTime);
        timeInInput.setAttribute('max', maxTime);
      }
      updateMinTime();
      setInterval(updateMinTime, 60000);
    } else if (passType === "college_working_days") {
      // Display fields for college working days home pass
      passDetailsContainer.innerHTML = `
               

                <label  class="form-label" for="tutorName">Tutor Name<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="tutorName" name="tutor_name" style="width:100%" required><br>

                <label  class="form-label" for="academicCoordinatorName">Academic Coordinator Name<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="academicCoordinatorName" name="academic_coordinator_name" style="width:100%" required><br>

                <label  class="form-label" for="timeOfLeaving">From<span class="text-danger">*</span></label><br>
                <input class="form-control" type="datetime-local" id="timeOfLeaving" name="time_of_leaving" style="width:100%" required><br>

                <label  class="form-label" for="timeOfEntry">To<span class="text-danger">*</span></label><br>
                <input class="form-control" type="datetime-local" id="timeOfEntry" name="time_of_entry" style="width:100%" required><br>

                <label  class="form-label" for="address">Address<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="address" name="address" style="width:100%" required><br>
                
                <label  class="form-label" for="reason">Reason<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="reason" name="reason" style="width:100%" required><br>

                <label  class="form-label" for="permissionLetter">Permission Letter<span class="text-danger">*</span></label><br>
                <input class="form-control" type="file" id="permissionLetter" name="permission_letter" required><br>
                

                <input type="hidden" name="passType" value="workingDays">

            `;
      function updateDateTimeLimits() {
        const now = new Date();
        const sixDaysLater = new Date();
        sixDaysLater.setDate(now.getDate() + 6);
        now.setSeconds(0, 0);
        now.setMilliseconds(0);
        const minDateTime = now.toISOString().slice(0, 16);
        const maxDateTime = sixDaysLater.toISOString().slice(0, 16);
        const timeOutInput = document.getElementById('timeOfLeaving');
        const timeInInput = document.getElementById('timeOfEntry');
        timeOutInput.setAttribute('min', minDateTime);
        timeOutInput.setAttribute('max', maxDateTime);
        timeInInput.setAttribute('min', minDateTime);
        timeInInput.setAttribute('max', maxDateTime);
      }
      updateDateTimeLimits()
    } else if (passType === "general_holidays") {
      // Display fields for general holidays home pass
      passDetailsContainer.innerHTML = `
               
                <label  class="form-label" for="timeOfLeaving">From<span class="text-danger">*</span></label><br>
                <input class="form-control" type="datetime-local" id="timeOfLeaving" name="time_of_leaving" style="width:100%" required><br>

                <label  class="form-label" for="timeOfEntry">To<span class="text-danger">*</span></label><br>
                <input class="form-control" type="datetime-local" id="timeOfEntry" name="time_of_entry" style="width:100%" required><br>


                <label  class="form-label" for="address">Address<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="address" name="address"style="width:100%" required><br>
                
                 <label  class="form-label" for="reason">Reason<span class="text-danger">*</span></label><br>
                <input class="form-control" type="text" id="reason" name="reason" style="width:100%" required><br>

                <input type="hidden" name="passType" value="generalDays">

            `;
      function updateDateTimeLimits() {
        const now = new Date();
        const sixDaysLater = new Date();
        sixDaysLater.setDate(now.getDate() + 6);
        now.setSeconds(0, 0);
        now.setMilliseconds(0);
        const minDateTime = now.toISOString().slice(0, 16);
        const maxDateTime = sixDaysLater.toISOString().slice(0, 16);
        const timeOutInput = document.getElementById('timeOfLeaving');
        const timeInInput = document.getElementById('timeOfEntry');
        timeOutInput.setAttribute('min', minDateTime);
        timeOutInput.setAttribute('max', maxDateTime);
        timeInInput.setAttribute('min', minDateTime);
        timeInInput.setAttribute('max', maxDateTime);
      }
      updateDateTimeLimits()
    }
  });
});

