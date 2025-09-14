<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Standard Bearer Abuja - 2025 Holiday Islamic Course</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 text-gray-800">

  <!-- Navbar -->
  <header class="bg-green-600 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <!-- Logo -->
        <div class="text-2xl font-bold tracking-wide">Standard Bearer</div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex space-x-6 font-medium">
          <a href="#" class="hover:text-yellow-300">Home</a>
          <a href="#" class="hover:text-yellow-300">Re-print Slip</a>
          <a href="<?=base_url('sbidsearch')?>" class="hover:text-yellow-300">Check SBID</a>
          <a href="<?=base_url('register')?>" class="hover:text-yellow-300">Register</a>
          <a href="#" class="hover:text-yellow-300">FAQ</a>
          <a href="#" class="hover:text-yellow-300">More</a>
        </nav>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button id="menu-btn" class="focus:outline-none">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Dropdown -->
    <div id="menu" class="hidden md:hidden bg-green-500">
      <nav class="flex flex-col space-y-2 p-4">
        <a href="#" class="hover:text-yellow-200">Home</a>
        <a href="#" class="hover:text-yellow-200">Re-print Slip</a>
        <a href="<?=base_url('sbidsearch')?>" class="hover:text-yellow-200">Check SBID</a>
        <a href="<?=base_url('register')?>" class="hover:text-yellow-200">Register</a>
        <a href="#" class="hover:text-yellow-200">FAQ</a>
        <a href="#" class="hover:text-yellow-200">More</a>
      </nav>
    </div>
  </header>
