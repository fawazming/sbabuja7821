<main class="max-w-4xl flex justify-center mx-auto p-4 h-90">

  <!-- Main Container -->
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-semibold text-center mb-6">Enter Registration PIN</h2>

    <!-- Input -->
    <div class="mb-4">
      <label for="pin" class="block text-gray-700 mb-2">Registration PIN</label>
      <input id="pin" type="text" placeholder="Enter your PIN"
        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Verify Button -->
    <button id="verifyBtn"
      class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
      Verify PIN
    </button>

    <!-- Spinner -->
    <div id="spinner" class="hidden flex justify-center mt-4">
      <svg class="animate-spin h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
          d="M4 12a8 8 0 018-8v8z"></path>
      </svg>
    </div>

    <!-- Links -->
    <div class="mt-6 text-center space-x-4">
      <button onclick="openModal('infoModal')" class="text-blue-600 hover:underline">How to get PIN?</button>
      <button onclick="openModal('statusModal')" class="text-blue-600 hover:underline">Check PIN status</button>
    </div>
  </div>

  <!-- Info Modal -->
  <div id="infoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-lg relative">
      <h3 class="text-xl font-semibold mb-4">How to Get a Registration PIN</h3>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
          <h4 class="font-medium">Contact Persons</h4>
          <p>Jane Doe – 0801 234 5678</p>
          <p>John Smith – 0812 345 6789</p>
        </div>
        <div>
          <h4 class="font-medium">Account Details</h4>
          <p>Bank: Example Bank</p>
          <p>Acct No: 1234567890</p>
          <p>Name: Registration Team</p>
        </div>
      </div>
      <button onclick="closeModal('infoModal')" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800">✕</button>
    </div>
  </div>

  <!-- Status Modal -->
  <div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md relative">
      <h3 class="text-xl font-semibold mb-4">Check PIN Status</h3>
      <input id="statusPin" type="text" placeholder="Enter PIN to check"
        class="w-full border px-3 py-2 rounded-md mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <button id="checkStatusBtn"
        class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition">
        Check Status
      </button>
      <div id="statusResult" class="mt-4 text-center text-gray-700"></div>
      <button onclick="closeModal('statusModal')" class="absolute top-2 right-3 text-gray-500 hover:text-gray-800">✕</button>
    </div>
  </div>

</main>
  <!-- JS Logic -->
  <script>
    const verifyBtn = document.getElementById('verifyBtn');
    const spinner = document.getElementById('spinner');
    const pinInput = document.getElementById('pin');
    const statusResult = document.getElementById('statusResult');

    function openModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }

    // Verify PIN
    verifyBtn.addEventListener('click', async () => {
      const pin = pinInput.value.trim();
      if (!pin) return alert('Please enter your PIN');

      spinner.classList.remove('hidden');
      verifyBtn.disabled = true;

      try {
        // Simulated API call — replace URL with your backend endpoint
        const res = await fetch(`<?=base_url()?>/api/verify-pin?pin=${encodeURIComponent(pin)}`);
        const data = await res.json();

        if (data.valid) {
          window.location.href = `<?=base_url()?>/regc?ref=${pin}`;
        } else {
          alert('Invalid or expired PIN.');
        }
      } catch (err) {
        alert('Network error. Try again.');
      } finally {
        spinner.classList.add('hidden');
        verifyBtn.disabled = false;
      }
    });

    // Check PIN status
    document.getElementById('checkStatusBtn').addEventListener('click', async () => {
      const pin = document.getElementById('statusPin').value.trim();
      if (!pin) return alert('Enter a PIN first');
      statusResult.textContent = 'Checking...';

      try {
        const res = await fetch(`<?=base_url()?>/api/pin-status?pin=${encodeURIComponent(pin)}`);
        const data = await res.json();

        console.log(data)
        statusResult.textContent = data.message;
          // ? '❌ This PIN has already been used.'
          // : '✅ This PIN is available.';
      } catch (err) {
        statusResult.textContent = 'Error checking status.';
      }
    });
  </script>
