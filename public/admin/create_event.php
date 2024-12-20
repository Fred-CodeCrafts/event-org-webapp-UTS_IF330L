<?php
session_start();
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != "true") {
  header("Location: ../aut/login/admin.php");
}
?>
<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <title>Create Event</title>
  </head>
  <body class="bg-gray-200 min-h-screen flex items-center justify-center p-4">
    <form id="eventForm" action="create_process.php" method="post" enctype="multipart/form-data">
      <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
          <h2 class="text-base font-semibold leading-7 text-gray-900">Create event</h2>
          <div class="flex mt-1">
            <div class="flex-1">
              <p class="text-sm text-gray-600">Please write the event details below.</p>
            </div>
            <div class="text-sm font-semibold text-gray-900"><a href="admin_dashboard.php">Back</a></div>
          </div>
          <div class="mt-10 grid gap-x-6 gap-y-8 grid-cols-6">
            <div class="col-span-6">
              <label for="event_name" class="block text-sm font-medium leading-6 text-gray-900">Event name</label>
              <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500">
                  <input type="text" required name="event_name" id="event_name" autocomplete="event_name" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6">
                </div>
              </div>
            </div>
            <div class="col-span-6">
              <label for="cap" class="block text-sm font-medium leading-6 text-gray-900">Capacity</label>
              <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500">
                  <input oninput="validateCapacity()" type="number" required name="cap" id="cap" autocomplete="cap" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6">
                </div>
              </div>
            </div>
            <div class="col-span-6">
              <label for="loc" class="block text-sm font-medium leading-6 text-gray-900">Location</label>
              <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500">
                  <input type="text" required name="loc" id="loc" autocomplete="loc" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6" placeholder="ex : jl. menuju roma">
                </div>
              </div>
            </div>
            <div class="col-span-6">
              <label for="desc" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
              <p class="mt-1 text-sm leading-6 text-gray-600">Write some words to describe the event.</p>
              <div class="mt-2">
                <textarea id="desc" name="desc" rows="3" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"></textarea>
              </div>
            </div>
            <div class="col-span-6">
              <div id="date-range-picker" class="flex items-center">
                  <div class="relative">
                    <label for="datepicker-range-start" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="datepicker-range-start" name="start_date" type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required readonly>
                    </div>
                  </div>
                  <span class="mx-4 text-gray-500">to</span>
                  <div class="relative">
                    <label for="datepicker-range-end" class="block text-sm font-medium text-gray-700">End Date</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="datepicker-range-end" name="end_date" type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required readonly>
                    </div>
                  </div>
              </div>
            </div>
            <div class="col-span-3">
              <div>
                <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start time:</label>
                <div class="relative">
                  <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
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
                      <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
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
                  <div id="icon-and-text">
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
          <div class="text-sm font-semibold leading-6 text-gray-900"><a href="admin_dashboard.php">Back</a></div>
          <button type="button" onclick="openConfirmModal()" class="rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500">Add event</button>
        </div>
    </form>
    
    <dialog id="confirmModal" class="modal">
        <form method="dialog" class="modal-box">
            <h3 class="font-bold text-lg">Confirm Submission</h3>
            <p class="py-4">Are you sure you want to add this event?</p>
            <div class="modal-action">
                <button class="text-white mr-2" onclick="closeConfirmModal()">Cancel</button>
                <button id="confirmSubmit" class="btn btn-primary" onclick="submitForm()">Submit</button>
            </div>
        </form>
    </dialog>

    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
      let deleteEventId = null;
      
      function openConfirmModal() {
        const form = document.getElementById('eventForm');
        const capacityInput = document.getElementById('cap');
        const capacityValue = parseInt(capacityInput.value, 10);
        const startDateInput = document.getElementById('datepicker-range-start');
        const endDateInput = document.getElementById('datepicker-range-end');

        if (!(form.checkValidity())){
          alert("Please fill all the fields!"); 
          return;
        }

        if (!startDateInput.value) {
          alert('Please select a start date.');
          return;
        }

        if (!endDateInput.value) {
          alert('Please select an end date.');
          return;
        }
        
        if (capacityValue && capacityValue < 10) {
          alert("Capacity must be at least 10.");
          return;
        }

        document.getElementById('confirmModal').showModal();
      }

      function closeConfirmModal() {
        document.getElementById('confirmModal').close();
      }

      function submitForm() {
        const form = document.getElementById('eventForm');
        form.submit(); 
      }

      
      document.addEventListener("DOMContentLoaded", function() {
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
        const iconAndText = document.getElementById('icon-and-text');

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (file && !allowedTypes.includes(file.type)) {
            alert("Please upload a valid image file (JPEG, PNG, GIF, WebP).");
            fileInput.value = ''; 
            previewImg.classList.add('hidden');
            iconAndText.style.display = 'block';
            return;
        }

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                iconAndText.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden');
            iconAndText.style.display = 'block';
        }
    }


      document.addEventListener("DOMContentLoaded", function () {
        const today = new Date().toISOString().split('T')[0];

        const startDateInput = document.getElementById('datepicker-range-start');
        const endDateInput = document.getElementById('datepicker-range-end');

        startDateInput.min = today;
        endDateInput.min = today;

        startDateInput.addEventListener('change', function () {
            if (startDateInput.value < today) {
                startDateInput.value = today; 
            }
        });

        endDateInput.addEventListener('change', function () {
            if (endDateInput.value < today) {
                endDateInput.value = today; 
            }
        });
      });
      
      document.addEventListener("DOMContentLoaded", function() {
        const startDateInput = document.getElementById("datepicker-range-start");
        const endDateInput = document.getElementById("datepicker-range-end");
        const startTimeInput = document.getElementById("start-time");
        const endTimeInput = document.getElementById("end-time");

        new Pikaday({
          field: startDateInput,
          format: 'MM/DD/YYYY', 
          minDate: new Date(),  
          onSelect: function() {
            endDatePicker.setMinDate(this.getDate());  
          }
        });

        const endDatePicker = new Pikaday({
          field: endDateInput,
          format: 'MM/DD/YYYY',
          minDate: new Date(),  
          onSelect: function() {
            if (startDateInput.value > endDateInput.value) {
              endDateInput.value = startDateInput.value;
            }
          }
        });

        function validateDates() {
          const startDate = new Date(startDateInput.value);
          const endDate = new Date(endDateInput.value);

          if (startDate > endDate) {
            endDateInput.value = startDateInput.value;
          }

          validateTimes();
        }

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
          }
        }

        startTimeInput.addEventListener("change", validateTimes);
        endTimeInput.addEventListener("change", validateTimes);
      });
    </script>
  </body>
</html>