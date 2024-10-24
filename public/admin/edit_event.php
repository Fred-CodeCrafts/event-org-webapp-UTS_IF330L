<?php
require_once('../DB.php');

if (isset($_GET["event_id"])) {
	$id = $_GET["event_id"];
	$sql = "SELECT * FROM event WHERE event_id = :id";
	$stmt = connectDB()->prepare($sql);
	$stmt->bindParam(":id", $id, PDO::PARAM_INT);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$row) {
		echo "Event not found.";
		exit();
	}

}

if (isset($_POST["submit"])) {
	$id = $_POST["event_id"];

	$cap = isset($_POST["cap"])
		? filter_var($_POST["cap"], FILTER_SANITIZE_NUMBER_INT) : "";

	$event_name = isset($_POST["event_name"])
		? htmlspecialchars($_POST["event_name"]) : "";

	$loc = isset($_POST["loc"]) ? 
    htmlspecialchars($_POST["loc"]) : "";

	$start_time = isset($_POST["start_time"])
		? htmlspecialchars($_POST["start_time"]) : "";

	$end_time = isset($_POST["end_time"])
		? htmlspecialchars($_POST["end_time"]) : "";

	$start_date = isset($_POST["start_date"])
		? htmlspecialchars($_POST["start_date"]) : "";

	$end_date = isset($_POST["end_date"])
		? htmlspecialchars($_POST["end_date"]) : "";

	$desc = isset($_POST["desc"]) 
    ? htmlspecialchars($_POST["desc"]) : "";

  $oldImage = $row['gambar'];
  $status = $_POST['status'];

  if ($start_time == $end_time) {
    $end_time = date("H:i", strtotime($end_time) + 60 * 60);
  }
  
	if (!empty($start_date) && !empty($end_date)) {
    
		$startDateTime = DateTime::createFromFormat("D M d Y", $start_date);
		$endDateTime = DateTime::createFromFormat("D M d Y", $end_date);

		if ($startDateTime && $endDateTime) {
			$start_date = $startDateTime->format("m/d/Y");
			$end_date = $endDateTime->format("m/d/Y");

			if (
				preg_match(
					'/^(0[1-9]|1[0-2]|[1-9])\/(0[1-9]|[12][0-9]|3[01]|[1-9])\/\d{4}$/',
					$start_date
				) &&
				preg_match(
					'/^(0[1-9]|1[0-2]|[1-9])\/(0[1-9]|[12][0-9]|3[01]|[1-9])\/\d{4}$/',
					$end_date
				)
			) {
				$startDateTime = DateTime::createFromFormat(
					"m/d/Y",
					$start_date
				);
				$endDateTime = DateTime::createFromFormat("m/d/Y", $end_date);

				if ($startDateTime === false || $endDateTime === false) {
					echo "Invalid date provided.";
					exit();
				}

				$start_date = $startDateTime->format("Y-m-d");
				$end_date = $endDateTime->format("Y-m-d");
			} else {
				echo "Invalid date format. Please use MM/DD/YYYY.";
				exit();
			}
		} else {
			echo "Invalid date format. Please use MM/DD/YYYY.";
			exit();
		}
	} else {
		echo "Start date and end date are required.";
		exit();
	}

	$data =
		"UPDATE event SET nama=:nama, waktu_mulai=:waktu_mulai, waktu_akhir=:waktu_akhir, lokasi=:lokasi, deskripsi=:deskripsi, kapasitas=:kapasitas, tgl_mulai=:tgl_mulai, tgl_akhir=:tgl_akhir, gambar=:gambar, status_toogle=:status_toogle WHERE event_id=:id";

	$stmt = connectDB()->prepare($data);
	$params = [
		":nama" => $event_name,
		":waktu_mulai" => $start_time,
		":waktu_akhir" => $end_time,
		":lokasi" => $loc,
		":deskripsi" => $desc,
		":kapasitas" => $cap,
		":tgl_mulai" => $start_date,
		":tgl_akhir" => $end_date,
		":status_toogle" => $status,
		":id" => $id,
	];

  if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
    $fileName = $_FILES["img"]['name'];
    $tempName = $_FILES["img"]['tmp_name'];

    $fileExt = explode(".",$fileName);
    $fileExt = strtolower(end($fileExt));
    $allowedExtensions = ["jpg", "jpeg", "png", "svg", "webp", "bmp"];

    if (in_array($fileExt, $allowedExtensions)) {
      $uploadPath = "gambar/" . $fileName;
      if (move_uploaded_file($tempName, $uploadPath)) {
        $data .= ", gambar=:gambar";
        $params[":gambar"] = $fileName;
      }
    }else{
      $params[":gambar"] = $oldImage;
    }
  }else{
    $params[":gambar"] = $oldImage;
  }

  $stmt->execute($params);

  header("Location: admin_dashboard.php");
  exit();
}
?>
<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <title>Edit Event</title>
  </head>
  <body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <form id="eventForm" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="event_id" value="<?= htmlspecialchars(
      	$row["event_id"]
      ) ?>">
      <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
          <h2 class="text-base font-semibold leading-7 text-gray-900">Edit event</h2>

          <div class="flex mt-1">
            <div class="flex-1">
              <p class="text-sm text-gray-600">Change the event details below.</p>
            </div>
            <div class="text-sm font-semibold text-gray-900"><a href="admin_dashboard.php">Back</a></div>
          </div>

          <div class="mt-10 grid gap-x-6 gap-y-8 grid-cols-6">
            <div class="col-span-6">
              <label for="event_name" class="block text-sm font-medium leading-6 text-gray-900">Event name</label>
              <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500">
                  <input onclick="this.select()" type="text" name="event_name" id="event_name" autocomplete="event_name" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6" value="<?= htmlspecialchars(
                  	$row["nama"]
                  ) ?>" required>
                </div>
              </div>
            </div>

            <div class="col-span-6">
              <label for="cap" class="block text-sm font-medium leading-6 text-gray-900">Capacity</label>
              <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500">
                  <input onclick="this.select()" type="number" name="cap" id="cap" autocomplete="cap" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6" value="<?= htmlspecialchars(
                  	$row["kapasitas"]
                  ) ?>" required min="1">
                </div>
              </div>
            </div>

            <div class="col-span-6">
              <label for="loc" class="block text-sm font-medium leading-6 text-gray-900">Location</label>
              <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500">
                  <input onclick="this.select()" type="text" name="loc" id="loc" autocomplete="loc" class="block flex-1 border-0 bg-white py-1.5 pl-1 rounded-md text-gray-900 placeholder:text-white-400 focus:ring-blue-500 sm:text-sm sm:leading-6" value="<?= htmlspecialchars(
                  	$row["lokasi"]
                  ) ?>" required>
                </div>
              </div>
            </div>

            <div class="col-span-6">
              <label for="desc" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
              <p class="mt-1 text-sm leading-6 text-gray-600">Write some words to describe the event.</p>
              <div class="mt-2">
                <textarea onclick="this.select()" id="desc" name="desc" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6" required><?= htmlspecialchars(
                	$row["deskripsi"]
                ) ?></textarea>
              </div>
            </div>

            <div class="col-span-6">
              <div id="date-range-picker" class="flex items-center">
                  <div class="relative">
                    <label for="datepicker-range-start" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="datepicker-range-start" name="start_date" type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="<?= htmlspecialchars(
                              $row['tgl_mulai']
                            ) ?>" required readonly>
                    </div>
                  </div>
                  <span class="mx-4 text-gray-500">to</span>
                  <div class="relative">
                    <label for="datepicker-range-end" class="block text-sm font-medium text-gray-700">End Date</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="datepicker-range-end" name="end_date" type="text" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            value="<?= htmlspecialchars(
                              $row['tgl_akhir']
                            ) ?>" required readonly>
                    </div>
                  </div>
              </div>
            </div>

            <div class="col-span-3">
              <div>
                <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start time</label>
                <div class="relative">
                  <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <input type="time" name="start_time" id="start-time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= htmlspecialchars(
                  	$row["waktu_mulai"]
                  ) ?>" required>
                </div>
              </div>
            </div>

            <div class="col-span-3">
              <div>
                <label for="end_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End time</label>
                <div class="relative">
                  <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <input type="time" name="end_time" id="end-time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?= htmlspecialchars(
                  	$row["waktu_akhir"]
                  ) ?>" required>
                </div>
              </div>
            </div>
            
            <div class="col-span-6">
              <label for="Status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event status</label>
              <select id="Status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="1" <?= $row['status_toogle'] == 1 ? ' selected' : '' ?>>Open</option>
                <option value="0" <?= $row['status_toogle'] == 0 ? ' selected' : '' ?>>Closed</option>
                <option value="2" <?= $row['status_toogle'] == 2 ? ' selected' : '' ?>>Canceled</option>
              </select>
            </div>

            <div class="col-span-6">
              <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Cover Event</label>
              <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                  <div class="text-center">
                      <div id="image-preview" class="mt-4">
                          <img id="preview-img" src="gambar/<?= htmlspecialchars($row['gambar']); ?>" alt="Preview Image" class="max-w-xs rounded-lg">
                      </div>
                      <div class="mt-4 flex text-sm leading-6 text-gray-600 items-center justify-center">
                          <label for="img" class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-indigo-500">
                              <span>Change the image</span>
                              <input id="img" name="img" type="file" class="sr-only" onchange="handleFileUpload(event)" accept="image/*">
                          </label>
                      </div>
                  </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
          <div class="text-sm font-semibold leading-6 text-gray-900"><a href="admin_dashboard.php">Back</a></div>
          <button type="button" onclick="openConfirmModal()" class="rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500">Change event</button>
        </div>
      </div>
    </form>

    <dialog id="confirmModal" class="modal">
        <form method="dialog" class="modal-box">
            <h3 class="font-bold text-lg">Edit confirmation</h3>
            <p class="py-4">Are you sure you want to change this event?</p>
            <div class="modal-action">
                <button type="button" class="text-gray-600 mr-2" onclick="closeConfirmModal()">Cancel</button>
                <button type="button" onclick="confirmSubmit()" class="btn btn-primary">Change</button>
            </div>
        </form>
    </dialog>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script>

      function openConfirmModal() {
        const form = document.getElementById('eventForm');
        const capacityInput = document.getElementById('cap');
        const capacityValue = parseInt(capacityInput.value, 10);

        if (!(form.checkValidity())){
          alert("Please fill all the fields!"); 
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

      function confirmSubmit() {
          const myEventForm = document.getElementById('eventForm');
          if (!myEventForm) {
              console.error("Form not found!");
              return;
          }

          const submitInput = document.createElement('input');
          submitInput.type = 'hidden';
          submitInput.name = 'submit';
          submitInput.value = '1';
          myEventForm.appendChild(submitInput);

          HTMLFormElement.prototype.submit.call(myEventForm);

          closeConfirmModal();
      }

      document.getElementById('eventForm').addEventListener('submit', function(event) {
          event.preventDefault(); 
          this.submit(); 
      });

      document.addEventListener("DOMContentLoaded", function() {
        const startDateInput = document.getElementById("datepicker-range-start");
        const endDateInput = document.getElementById("datepicker-range-end");
        const startTimeInput = document.getElementById("start-time");
        const endTimeInput = document.getElementById("end-time");
        
        const startPicker = new Pikaday({
          field: startDateInput,
          format: 'MM/DD/YYYY',
          minDate: new Date(),
          onSelect: function(date) {
            if (endPicker) {
              endPicker.setMinDate(date);
              endPicker.setStartRange(date);
              
              const endDate = endPicker.getDate();
              if (endDate && date > endDate) {
                endPicker.setDate(date);
              }
            }
            
            endDateInput.removeAttribute('disabled');
            validateDates();
          }
        });

        const endPicker = new Pikaday({
          field: endDateInput,
          format: 'MM/DD/YYYY',
          minDate: new Date(),
          onSelect: function(date) {
            if (startPicker) {
              startPicker.setEndRange(date);
            }
            validateDates();
          }
        });

        endDateInput.setAttribute('disabled', 'disabled');

        function validateDates() {
          const startDate = startPicker.getDate();
          const endDate = endPicker.getDate();

          if (startDate && endDate && startDate > endDate) {
            endPicker.setDate(startDate);
          }

          validateTimes();
        }

        function validateTimes() {
          const startDate = startPicker.getDate();
          const endDate = endPicker.getDate();
          
          if (startDate && endDate && startDate.toDateString() === endDate.toDateString()) {
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;
            
            if (startTime && endTime) {
              const [startHour, startMinute] = startTime.split(":").map(Number);
              const [endHour, endMinute] = endTime.split(":").map(Number);
              
              const startDateTime = new Date(startDate);
              startDateTime.setHours(startHour, startMinute);
              
              const endDateTime = new Date(endDate);
              endDateTime.setHours(endHour, endMinute);

              if (startDateTime >= endDateTime) {
                const newEndTime = new Date(startDateTime);
                newEndTime.setHours(startDateTime.getHours() + 1);
                
                endTimeInput.value = 
                  `${String(newEndTime.getHours()).padStart(2, '0')}:${String(newEndTime.getMinutes()).padStart(2, '0')}`;
              }
            }
          }
        }

        startTimeInput.addEventListener("change", validateTimes);
        endTimeInput.addEventListener("change", validateTimes);

        if (startDateInput.value) {
          const initialStartDate = new Date(startDateInput.value);
          startPicker.setDate(initialStartDate);
          endDateInput.removeAttribute('disabled');
        }
        
        if (endDateInput.value) {
          const initialEndDate = new Date(endDateInput.value);
          endPicker.setDate(initialEndDate);
        }
      });

      function handleFileUpload(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const previewImg = document.getElementById('preview-img');
        const iconAndText = document.getElementById('icon-and-text');

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (file && !allowedTypes.includes(file.type)) {
            alert("Please upload a valid image file (JPEG, PNG, GIF, WebP).");
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
    </script>
  </body>
</html>