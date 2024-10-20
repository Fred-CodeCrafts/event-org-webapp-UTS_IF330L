<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <title>Tambah Event</title>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
<form action="add_process.php" method="post" enctype="multipart/form-data">
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Tambah Event</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Silahkan isi detail event di bawah ini.</p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 grid-cols-6">
                <div class="col-span-6">
                <label for="event_name" class="block text-sm font-medium leading-6 text-gray-900">Nama Event</label>
                <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 sm:max-w-md">
                    <input type="text" required name="event_name" id="event_name" autocomplete="event_name" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6">
                    </div>
                </div>    
                </div>

                <div class="col-span-6">
                <label for="cap" class="block text-sm font-medium leading-6 text-gray-900">Kapasitas</label>
                <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 sm:max-w-md">
                    <input type="text" required name="cap" id="cap" autocomplete="cap" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6" placeholder = "ex : 100">
                    </div>
                </div>    
                </div>

                <div class="col-span-6">
                <label for="loc" class="block text-sm font-medium leading-6 text-gray-900">Lokasi</label>
                <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 sm:max-w-md">
                    <input type="text" required name="loc" id="loc" autocomplete="loc" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6" placeholder = "ex : jl. menuju roma">
                    </div>
                </div>    
                </div>

                <div class="col-span-6">
                <label for="desc" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi</label>
                <div class="mt-2">
                    <textarea id="desc" name="desc" rows="3" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"></textarea>
                </div>
                <p class="mt-3 text-sm leading-6 text-gray-600">Tulis beberapa kata yang mendeskripsikan event.</p>
                </div>
                
                <div class="col-span-6">
                    <div id="date-range-picker" date-rangepicker class="flex items-center">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="datepicker-range-start" required name="start_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="MM/DD/YYYY">
                    </div>
                    <span class="mx-4 text-gray-500">to</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="datepicker-range-end" required name="end_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="MM/DD/YYYY">
                    </div>
                    </div>
                </div>

                <div class="col-span-3">
                    <div>
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start time:</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="time" required name="start_time" id="start-time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="00:00" required />
                        </div>
                    </div>
                </div>
                <div class="col-span-3">
                    <div>
                        <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End time:</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="time" required name="end_time" id="end-time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="00:00" required />
                        </div>
                    </div>
                </div>

                <div class="col-span-6">
                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover Event</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                        <div class="text-center">
                            <div id="icon-and-text"> <!-- Tambahkan id di sini -->
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                            <div class="mt-4 flex text-sm leading-6 text-gray-600 items-center justify-center">
                                <label for="img" class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                    <span>Upload an image</span>
                                    <input id="img" required name="img" type="file" class="sr-only" onchange="handleFileUpload(event)" accept="image/*">
                                </label>
                            </div>
                            <div id="image-preview" class="mt-4">
                                <img id="preview-img" src="" alt="Preview Image" class="hidden max-w-xs rounded-lg">
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <button type="submit" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
        <button type="submit" name="submit" class="rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500">Add event</button>
    </div>
</form>

<script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startDateInput = document.getElementById("datepicker-range-start");
        const endDateInput = document.getElementById("datepicker-range-end");
        const startTimeInput = document.getElementById("start-time");
        const endTimeInput = document.getElementById("end-time");

        function validateTimes() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate.getTime() === endDate.getTime()) {
                const startTime = startTimeInput.value;
                const endTime = endTimeInput.value;

                const [startHour, startMinute] = startTime.split(":").map(Number);
                const [endHour, endMinute] = endTime.split(":").map(Number);

                const startDateTime = new Date(startDate);
                startDateTime.setHours(startHour, startMinute);

                const endDateTime = new Date(endDate);
                endDateTime.setHours(endHour, endMinute);

                if (startDateTime >= endDateTime) {
                    const tempTime = startTime;
                    startTimeInput.value = endTime;
                    endTimeInput.value = tempTime;
                }

                const oneHourInMilliseconds = 60 * 60 * 1000;
                if (endDateTime - startDateTime < oneHourInMilliseconds) {
                    const adjustedEndDateTime = new Date(startDateTime.getTime() + oneHourInMilliseconds);
                    const adjustedEndHour = String(adjustedEndDateTime.getHours()).padStart(2, "0");
                    const adjustedEndMinute = String(adjustedEndDateTime.getMinutes()).padStart(2, "0");
                    endTimeInput.value = `${adjustedEndHour}:${adjustedEndMinute}`;
                }
            }
        }

        startTimeInput.addEventListener("change", validateTimes);
        endTimeInput.addEventListener("change", validateTimes);
        startDateInput.addEventListener("change", validateTimes);
        endDateInput.addEventListener("change", validateTimes);
    });

    function handleFileUpload(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const previewImg = document.getElementById('preview-img');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden'); 
            };

            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden'); 
        }
    }

    function handleFileUpload(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const previewImg = document.getElementById('preview-img');
        const iconAndText = document.getElementById('icon-and-text'); // Seleksi elemen dengan id icon-and-text

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden'); 
                
                // Sembunyikan SVG dan teks setelah gambar diunggah
                iconAndText.style.display = 'none';
            };

            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden'); 
            
            // Tampilkan kembali SVG dan teks jika tidak ada gambar
            iconAndText.style.display = 'block';
        }
    }

</script>

</body>
</html>