<div class="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-green-100 via-white to-green-50">

  <div class="w-full max-w-lg bg-white/70 backdrop-blur-lg shadow-2xl rounded-2xl p-8 border border-green-100">
    <!-- Step 1: Attend last December camp? -->
    <div id="camp-check" class="fade show space-y-6 text-center">
      <h1 class="text-3xl font-bold text-gray-800">Welcome to <span class="text-green-600">SB Registration</span></h1>
      <p class="text-gray-600">Did you attend <strong>last December camp?</strong></p>
      <div class="flex justify-center space-x-4">
        <button onclick="chooseCamp('yes')" class="px-6 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition">Yes</button>
        <button onclick="chooseCamp('no')" class="px-6 py-2 bg-red-500 text-white rounded-xl shadow hover:bg-red-600 transition">No</button>
      </div>
    </div>

    <!-- Step 2: Enter SBID -->
    <div id="sbid-section" class="fade hidden mt-6 space-y-5">
      <!-- <h2 class="text-2xl font-semibold text-gray-800">Enter Your SBID</h2> -->
      <div class="flex items-center space-x-2">
        <!-- Go Back Icon -->
        <button onclick="backCamp()" class="text-gray-600 hover:text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" 
              fill="none" viewBox="0 0 24 24" 
              stroke-width="2" stroke="currentColor" 
              class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <div class="">
          <!-- Heading -->
        <h2 class="text-2xl font-semibold text-gray-800">Enter Your SBID</h2>
        <p>Forgot SBID? <a href="<?=base_url('sbidsearch')?>" target="_blank" rel="noopener noreferrer">Search Here</a></p>
        </div>
        
      </div>

      <input type="text" id="sbid" placeholder="e.g., SB12345"
        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
      <button id="fetch-btn" onclick="fetchSBID()" 
        class="w-full px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition flex items-center justify-center space-x-2">
        <span id="fetch-text">Fetch Details</span>
        <svg id="fetch-spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
      </button>
    </div>

    <!-- Step 3: Registration Form -->
    <form id="reg-form" action="<?=base_url('registration')?>" method="post" class="fade hidden mt-6 space-y-5">
      <!-- <h2 class="text-2xl font-semibold text-gray-800">Complete Your Registration</h2> -->
      <div class="flex items-center space-x-2">
        <!-- Go Back Icon -->
        <button onclick="backCamp()" type="button" class="text-gray-600 hover:text-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" 
              fill="none" viewBox="0 0 24 24" 
              stroke-width="2" stroke="currentColor" 
              class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <!-- Heading -->
        <h2 class="text-2xl font-semibold text-gray-800">Complete Your Registration</h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Name</label>
          <input type="text" id="name" name="name" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-1">Zone</label>
          <input type="text" id="zone" name="zone" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Gender</label>
          <select id="gender" name="gender" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-1">Phone</label>
          <input type="tel" id="phone" name="phone" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Email</label>
          <input type="email" id="email" value="<?=$email?>" name="email" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
        </div>

        <div>
          <label id="sch-label" class="block text-gray-700 font-medium mb-1">School</label>
          <input type="text" id="school" name="school" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
        </div>
      </div>
      <input type="hidden" name="category" id="category" required value="<?=$category?>">
            <!-- <input type="hidden" name="category" id="category" required value="professionals"> -->
            <input type="hidden" name="txn" id="txn" required value="<?=$ref?>">

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div id="level-wrapper" class="mt-4">
          <label id="level-label" class="text-xs font-medium text-gray-600">Level / Class</label>
          <div id="level-field" class="mt-1 border-2"></div>
        </div>

        <div id="dept-wrapper" class="mt-4">
          <label id="dept-label" class="text-xs font-medium text-gray-600">Department</label>
          <div id="dept-field" class="mt-1 border-2"></div>
        </div>
      </div>

      <!-- <div>
        <label class="block text-gray-700 font-medium mb-1">Level</label>
        <input type="text" id="level" name="level" class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400"/>
      </div> -->

      <button id="submit-btn" type="submit" 
        class="w-full px-6 py-3 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition flex items-center justify-center space-x-2">
        <span id="submit-text">Submit</span>
        <svg id="submit-spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
      </button>
    </form>
  </div>

        
<script>
  const categoryEl = document.getElementById("category");
  const levelField = document.getElementById("level-field");
  const levelLabel = document.getElementById("level-label");
  const deptField = document.getElementById("dept-field");
  const deptLabel = document.getElementById("dept-label");
  const schLabel = document.getElementById("sch-label");

    const value = categoryEl.value;
    levelField.innerHTML = ""; // clear previous field
    deptField.innerHTML = ""; // clear previous field
    

    if (value === "secondary_school_student") {
      const select = document.createElement("select");
      select.name = "level";
      select.id = "level";
      select.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      levelLabel.textContent = "Class in School";

      const deptS = document.createElement("select");
      deptS.name = "dept";
      deptS.id = "dept";
      deptS.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      deptLabel.textContent = "Department in School";
      schLabel.textContent = "Name of your school";

      ["Junior_School","Science", "Humanities", "Business"].forEach(dep => {
        const opt = document.createElement("option");
        opt.value = dep;
        opt.textContent = dep;
        deptS.appendChild(opt);
      });

      ["JS1", "JS2", "JS3", "SS1", "SS2", "SS3"].forEach(lvl => {
        const opt = document.createElement("option");
        opt.value = lvl;
        opt.textContent = lvl;
        select.appendChild(opt);
      });

      levelField.appendChild(select);
      deptField.appendChild(deptS);

    } else if (value === "school_leaver") {
      const input = document.createElement("input");
      input.type = "text";
      input.name = "level";
      input.id = "level";
      schLabel.textContent = "Where do you currently work?";

      const Dinput = document.createElement("input");
      Dinput.type = "text";
      Dinput.name = "dept";
      Dinput.id = "dept";
      deptLabel.textContent = "Last School Attended";

      levelLabel.textContent = "What are you engaged with";
      input.placeholder = "As a school leaver, I'm currently engaged with...";
      input.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      Dinput.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      levelField.appendChild(input);
      deptField.appendChild(Dinput);

    } else if (value === "undergraduate") {
      const select = document.createElement("select");
      select.name = "level";
      select.id = "level";
      select.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      levelLabel.textContent = "Level in Institution"
      schLabel.textContent = "Institution Name";

      
      const Dinput = document.createElement("input");
      Dinput.type = "text";
      Dinput.name = "dept";
      Dinput.id = "dept";
      deptLabel.textContent = "Course of Study";
      Dinput.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      deptField.appendChild(Dinput);

      [" ", "100L", "200L", "300L", "400L", "500L", "600L"].forEach(lvl => {
        const opt = document.createElement("option");
        opt.value = lvl;
        opt.textContent = lvl;
        select.appendChild(opt);
      });

      levelField.appendChild(select);
    } else if (value === "graduate") {
      schLabel.textContent = "Institution Graduated From";
      const Dinput = document.createElement("input");
      Dinput.type = "text";
      Dinput.name = "dept";
      Dinput.id = "dept";
      deptLabel.textContent = "NYSC Status";
      Dinput.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      deptField.appendChild(Dinput);
      
      const input = document.createElement("input");
      input.type = "text";
      input.name = "level";
      input.id = "level";
      levelLabel.textContent = "Course of Study";
      input.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      levelField.appendChild(input);

    } else if (value === "professionals") {
      const Dinput = document.createElement("input");
      Dinput.type = "text";
      Dinput.name = "dept";
      Dinput.id = "dept";
      deptLabel.textContent = "Skills/Area of Expertise";
      Dinput.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      deptField.appendChild(Dinput);

      const input = document.createElement("input");
      input.type = "text";
      input.name = "level";
      input.id = "level";
      levelLabel.textContent = "Occupation / Job"
      schLabel.textContent = "Employer / Organization Name";
      
      input.placeholder = "Current job role...";
      input.className = "mt-1 w-full rounded-lg border-gray-700 p-3";
      levelField.appendChild(input);
    }
</script>

  <script>
    let userData = {};

    function showSection(id) {
      document.querySelectorAll(".fade").forEach(el => el.classList.remove("show"));
      setTimeout(() => {
        document.querySelectorAll(".fade").forEach(el => el.classList.add("hidden"));
        const section = document.getElementById(id);
        section.classList.remove("hidden");
        setTimeout(() => section.classList.add("show"), 50);
      }, 300);
    }

    function chooseCamp(choice) {
      if (choice === "yes") {
        showSection("sbid-section");
      } else {
        showSection("reg-form");
      }
    }

    function backCamp() {
        showSection("camp-check");
    }

    async function fetchSBID() {
      const sbid = document.getElementById("sbid").value.trim();
      const btn = document.getElementById("fetch-btn");
      const spinner = document.getElementById("fetch-spinner");
      const text = document.getElementById("fetch-text");

      if (!sbid) {
        alert("Please enter a valid SBID");
        return;
      }

      btn.disabled = true;
      spinner.classList.remove("hidden");
      text.textContent = "Fetching...";

      try {
        // Replace with your actual API endpoint
        const res = await fetch(`<?=base_url()?>/idsearch?sbid=${sbid}`);
        if (!res.ok) throw new Error("Failed to fetch");
        userData = await res.json();
        userData = userData[0];

        // Prefill form
        document.getElementById("name").value = userData.fname || "";
        document.getElementById("lname").value = userData.lname || "";
        document.getElementById("zone").value = userData.lb || "";
        document.getElementById("gender").value = userData.gender || "";
        document.getElementById("phone").value = userData.phone || "";
        document.getElementById("email").value = userData.email || "";
        document.getElementById("school").value = userData.school || "";
        document.getElementById("level").value = userData.level || "";

        showSection("reg-form");
      } catch (error) {
        alert("Error fetching details: " + error.message);
      } finally {
        btn.disabled = false;
        spinner.classList.add("hidden");
        text.textContent = "Fetch Details";
      }
    }

    // document.getElementById("reg-form").addEventListener("submit", async (e) => {
    //   e.preventDefault();
    //   const btn = document.getElementById("submit-btn");
    //   const spinner = document.getElementById("submit-spinner");
    //   const text = document.getElementById("submit-text");

    //   btn.disabled = true;
    //   spinner.classList.remove("hidden");
    //   text.textContent = "Submitting...";

    //   const formData = {
    //     name: document.getElementById("name").value,
    //     zone: document.getElementById("zone").value,
    //     gender: document.getElementById("gender").value,
    //     phone: document.getElementById("phone").value,
    //     email: document.getElementById("email").value,
    //     school: document.getElementById("school").value,
    //     level: document.getElementById("level").value
    //   };

    //   try {
    //     const res = await fetch("/api/register", {
    //       method: "POST",
    //       headers: { "Content-Type": "application/json" },
    //       body: JSON.stringify(formData)
    //     });
    //     const result = await res.json();
    //     alert("Registration successful!");
    //   } catch (error) {
    //     alert("Registration failed: " + error.message);
    //   } finally {
    //     btn.disabled = false;
    //     spinner.classList.add("hidden");
    //     text.textContent = "Submit";
    //   }
    // });
  </script>
</div>