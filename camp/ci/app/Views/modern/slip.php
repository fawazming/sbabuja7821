
    <style>
        /* Define A6 size for printing */
        @media print {
            body > * {
                /* margin: 0; */
                /* display: none; */
                visibility: hidden;
            }
            .a6-ticket, .a6-ticket * {
                /* display: block !important; */
                visibility: visible;
            }
            .a6-ticket {
                display: flex;
                width: 105mm; /* A6 width */
                height: 148mm; /* A6 height */
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }
            #details > .fl{
                display: flex;
            }
        }
    </style>

<!-- Ticket container -->
<div class="flex justify-center items-center h-screen bg-gray-100 p-4">
    <div class="a6-ticket bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row relative">

        <!-- Ticket branding and header -->
        <div class="p-6 md:p-8 bg-gray-800 text-white flex flex-col justify-between md:w-1/3">
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold uppercase tracking-widest">
                    SB Abuja HIC
                </h1>
                <p class="text-sm text-gray-400 mt-1 uppercase"><?=$category?></p>
            </div>
            <div class="mt-8 md:mt-0 text-center md:text-left">
                <p class="text-xs text-gray-400">...</p>
                <div class="mt-1">
                    <p class="text-lg font-semibold"><?=$txn?></p>
                </div>
            </div>
        </div>

        <!-- Ticket details and info -->
        <div class="flex-1 p-6 md:p-8 flex flex-col justify-between">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-800" style="text-align: center;">Holiday Islamic Course 2025</h2>
                <div class="mt-4 text-sm text-gray-600" id="details">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Name: <span class="font-medium text-gray-800"><?=$fname.' '.$lname?></span></span>
                    </div>
                    <!-- <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Date: <span class="font-medium text-gray-800">Oct 26, 2025</span></span>
                    </div> -->
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Gender: <span class="font-medium text-gray-800 capitalize"><?=$gender?></span></span>
                    </div>
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>House: <span class="font-medium text-gray-800"><?=$house?></span></span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Category: <span class="font-medium text-gray-800 capitalize"><?=$category?></span></span>
                    </div>
                </div>
            </div>

            <!-- QR Code section -->
            <div class="mt-6 flex flex-col items-center justify-center">
                <!-- A placeholder for an actual QR code image -->
                <?php $qrdata = urlencode('Name: '.$fname.' '.$lname.' '.'TXN: '.$txn); ?>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?=$qrdata?>" alt="QR Code" class="w-24 h-24">
                <p class="text-xs text-gray-500 mt-2">Scan for entry</p>
            </div>
        </div>

    </div>
</div>
