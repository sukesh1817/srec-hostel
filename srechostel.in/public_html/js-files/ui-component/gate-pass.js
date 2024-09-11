document.querySelectorAll('input[name="pass_type"]').forEach((elem) => {
  elem.addEventListener("change", function () {
    var passType = this.value;
    var passDetailsContainer = document.getElementById("passDetails");
    var passForm = document.getElementById("passForm");
    passDetailsContainer.innerHTML = ""; // Clear previous pass details

    if (passType === "gate_pass") {
      // Display fields for gate pass
      passDetailsContainer.innerHTML = `
      
                <label  class="form-label" for="timeOut">From</label><br>
                <input class="form-control" type="datetime-local" id="timeOut" name="time_out"   style="width:100%" class='container-fluid' required><br>

                <label for="timeIn">To</label><br>
                <input class="form-control" type="datetime-local" id="timeIn" name="time_in" style="width:100%" class='container-fluid' required><br>

                <label  for="address">Address</label><br>
                <input class="form-control" type="text" id="address" name="address" style="width:100%" required><br>
                
                 <label  class="form-label" for="reason">Reason</label><br>
                <input class="form-control" type="text" id="reason" name="reason" style="width:100%" required><br>

                <input type="hidden" name="passType" value="gatePass">
            `;
      // out pass date fixing
      function setMinTime() {
        const now = new Date();
        now.setSeconds(0, 0);
        if (now.getMilliseconds() > 0) {
          now.setMinutes(now.getMinutes() + 1);
        }
        const currentDateTime = now.toISOString().slice(0, 16);
        const todayDate = new Date().toISOString().slice(0, 10);
        const maxTime = todayDate + "T23:59";
        const timeOutInput = document.getElementById('timeOut');
        timeOutInput.setAttribute('min', currentDateTime);
        timeOutInput.setAttribute('max', maxTime);
      }

      setMinTime();
      setInterval(setMinTime, 60000);
    } else if (passType === "college_working_days") {
      // Display fields for college working days home pass
      passDetailsContainer.innerHTML = `
               

                <label  class="form-label" for="tutorName">Tutor Name</label><br>
                <input class="form-control" type="text" id="tutorName" name="tutor_name" style="width:100%" required><br>

                <label  class="form-label" for="academicCoordinatorName">Academic Coordinator Name</label><br>
                <input class="form-control" type="text" id="academicCoordinatorName" name="academic_coordinator_name" style="width:100%" required><br>

                <label  class="form-label" for="timeOfLeaving">From</label><br>
                <input class="form-control" type="datetime-local" id="timeOfLeaving" name="time_of_leaving" style="width:100%" required><br>

                <label  class="form-label" for="timeOfEntry">To</label><br>
                <input class="form-control" type="datetime-local" id="timeOfEntry" name="time_of_entry" style="width:100%" required><br>

                <label  class="form-label" for="address">Address</label><br>
                <input class="form-control" type="text" id="address" name="address" style="width:100%" required><br>
                
                <label  class="form-label" for="reason">Reason</label><br>
                <input class="form-control" type="text" id="reason" name="reason" style="width:100%" required><br>

                <label  class="form-label" for="permissionLetter">Permission Letter</label><br>
                <input class="form-control" type="file" id="permissionLetter" name="permission_letter" required><br>
                

                <input type="hidden" name="passType" value="workingDays">

            `;
    } else if (passType === "general_holidays") {
      // Display fields for general holidays home pass
      passDetailsContainer.innerHTML = `
               
                <label  class="form-label" for="timeOfLeaving">From</label><br>
                <input class="form-control" type="datetime-local" id="timeOfLeaving" name="time_of_leaving" style="width:100%" required><br>

                <label  class="form-label" for="timeOfEntry">To</label><br>
                <input class="form-control" type="datetime-local" id="timeOfEntry" name="time_of_entry" style="width:100%" required><br>


                <label  class="form-label" for="address">Address</label><br>
                <input class="form-control" type="text" id="address" name="address"style="width:100%" required><br>
                
                 <label  class="form-label" for="reason">Reason</label><br>
                <input class="form-control" type="text" id="reason" name="reason" style="width:100%" required><br>

                <input type="hidden" name="passType" value="generalDays">

            `;
    }
  });
});

