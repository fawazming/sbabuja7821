<div class="col-lg-6 d-flex flex-column content-right">
	<div class="container my-auto py-5">
		<div class="row mb-5">
			<div class="col-12">
				<marquee behavior="" direction="">The Online Payment Service is not available for now, kindly pay to the SB Abuja account number and request for registration PIN from any of the vendors</marquee>
				<a hx-get="<?=base_url('vendors')?>" hx-target="#app" hx-swap="replace"><button type="button" class="forward">Buy Pin via Vendors</button></a>
				<a href="<?=base_url('sbidsearch')?>"><button type="button" class="forward">Search for SB ID</button></a>
				<!-- <a href="<?=base_url('payonline')?>"><button type="button" class="forward">Buy Pin Online</button></a> -->
			</div>
			
		</div>
        <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            min-height: 100vh;
            font-family: ' інтер', sans-serif;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            display: none;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8 text-shadow-lg">SEARCH FOR DELEGATE BY SB ID OR FULLNAME OR AREA COUNCIL OR GENDER</h1>
        
        <form id="searchForm" class="bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl p-6 shadow-2xl max-w-4xl mx-auto mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium mb-2">Name:</label>
                    <input type="text" id="name" class="w-full px-3 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name">
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium mb-2">Gender:</label>
                    <select id="gender" class="w-full px-3 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="class" class="block text-sm font-medium mb-2">Class:</label>
                    <select id="class" class="w-full px-3 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Class</option>
                        <option value="JSS">JSS</option>
                        <option value="SSS">SSS</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="zones" class="block text-sm font-medium mb-2">Zones:</label>
                    <input type="text" id="zones" class="w-full px-3 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter zones">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium mb-2">Category:</label>
                    <select id="category" class="w-full px-3 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        <option value="Junior">Junior</option>
                        <option value="Senior">Senior</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="view" class="block text-sm font-medium mb-2">View:</label>
                    <select id="view" class="w-full px-3 py-2 rounded-lg bg-gray-100 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select View</option>
                        <option value="List">List</option>
                        <option value="Grid">Grid</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Search</button>
        </form>

        <div class="text-center mb-4">
            <div id="loader" class="loader"></div>
            <p id="loadingText" class="hidden">Searching...</p>
        </div>

        <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-2xl shadow-2xl max-w-6xl mx-auto overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-gray-900">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SBID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SURNAME</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FIRST NAME</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CATEGORY</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ZONES</th>
                    </tr>
                </thead>
                <tbody id="resultsBody" class="bg-white bg-opacity-50 divide-y divide-gray-200">
                    <!-- Data rows will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const gender = document.getElementById('gender').value;
            const classVal = document.getElementById('class').value;
            const zones = document.getElementById('zones').value;
            const category = document.getElementById('category').value;
            const view = document.getElementById('view').value;
            
            const queryParams = new URLSearchParams();
            if (name) queryParams.append('name', name);
            if (gender) queryParams.append('gender', gender);
            if (classVal) queryParams.append('class', classVal);
            if (zones) queryParams.append('lb', zones);
            if (category) queryParams.append('category', category);
            if (view) queryParams.append('view', view);
            
            const url = '<?=base_url()?>/idsearch?' + queryParams.toString();
            
            document.getElementById('loader').style.display = 'block';
            document.getElementById('loadingText').style.display = 'block';
            document.getElementById('resultsBody').innerHTML = '';
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        const tbody = document.getElementById('resultsBody');
                        data.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">${index + 1}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">SBB00${String(item.id).padStart(3, '0') || ''}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">${item.lname || ''}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">${item.fname || item.firstname || ''}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">${item.category || ''}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">${item.lb || ''}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        console.error('No results found or invalid response.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    console.error('An error occurred during search.');
                })
                .finally(() => {
                    document.getElementById('loader').style.display = 'none';
                    document.getElementById('loadingText').style.display = 'none';
                });
        });
    </script>


		</div>
	</div>
	<div class="container copy">
		<span class="float-start">© SB HIC</span>
		<a class="btn_help float-end" href="https://wa.me/+2347034282245" target="_blank"><i
				class="bi bi-question-circle"></i>Help</a>
		<a class="btn_help float-end" href="#modal-pStatus" id="modal_p"><i class="bi bi-question-circle"></i>Pin Status
			&nbsp; &nbsp; &nbsp;</a>
		<br>
	</div>
	<center style="margin-top: 0px;">Designed with ❤️ by <a href="https://rayyantech.sgm.ng">Rayyan Technologies</a>
	</center>

</div>