<?php

define('TITLE', "Signup");
include '../assets/layouts/header.php';
check_logged_out();

?>

<?php insert_csrf_token(); ?>

<form class="max-w-md mx-auto" action="inc/register.inc.php" method="post" enctype="multipart/form-data">
    <div class="picCard text-center mt-4">
        <div class="picCard text-center relative inline-block">
            <div id="preview-img" class="w-32 h-32 bg-cover bg-center rounded-full mx-auto"
                style="background-image: url('../assets/uploads/users/_defaultUser.png');">
            </div>

            <div class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-50 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">
                <label for="avatar" class="cursor-pointer text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M16.465 3a2.5 2.5 0 113.536 3.536L7.05 19.485a8.003 8.003 0 01-3.093 1.958l-2.43.809a.5.5 0 01-.637-.637l.808-2.43a8.003 8.003 0 011.958-3.093L16.465 3z"></path>
                    </svg>
                </label>
            </div>
            <div class="text-center">
                <sub class="text-red-500">
                    <?php
                        if (isset($_SESSION['ERRORS']['imageerror']))
                            echo $_SESSION['ERRORS']['imageerror'];

                    ?>
                </sub>
            </div>
            <input name="avatar" id="avatar" type="file" class="hidden" accept="image/*" onchange="handleFileUpload(event)"/>
        </div>
        <h6 class="text-center">Create an Account</h6>
    </div>
    <div class="text-center mb-3">
        <small class="text-green-500 font-bold">
            <?php
                if (isset($_SESSION['STATUS']['signupstatus']))
                    echo $_SESSION['STATUS']['signupstatus'];

            ?>
        </small>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="text" name="username" id="floating_username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="floating_username" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
        <sub class="text-red-500">
            <?php
                if (isset($_SESSION['ERRORS']['usernameerror']))
                    echo $_SESSION['ERRORS']['usernameerror'];

            ?>
        </sub>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="password" name="password" id="floating_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="floating_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
    </div>
    <div class="relative z-0 w-full mb-7 group">
        <input type="password" name="confirmpassword" id="floating_confirm_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="floating_confirm_password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm password</label>
        <sub class="text-red-500 mb-4">
            <?php
                if (isset($_SESSION['ERRORS']['passworderror']))
                    echo $_SESSION['ERRORS']['passworderror'];

            ?>
        </sub>
    </div>

    <hr class="border-2 border-gray-300">

    <span class="text-lg my-3 font-normal text-gray-500 text-center block">Optional</span>

    <div class="mt-3 grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="first_name" id="floating_first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="floating_first_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="last_name" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="floating_last_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
        </div>
    </div>
    
    <div class="relative z-0 w-full mb-5 group">
        <input type="tel" name="headline" id="floating_headline" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
        <label for="floating_headline" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Headline</label>
    </div>

    <div class="mb-4">
        <label for="bio" class="sr-only">Profile Details</label>
        <textarea id="bio" name="bio" class="w-full p-3 text-sm text-gray-700 placeholder-gray-400 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tell us about yourself..."></textarea>
    </div>


    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>

        <div class="flex items-center mb-2">
            <input type="radio" id="male" name="gender" value="m" class="mr-2 leading-tight">
            <label for="male" class="text-gray-700">Male</label>
        </div>
        
        <div class="flex items-center">
            <input type="radio" id="female" name="gender" value="f" class="mr-2 leading-tight">
            <label for="female" class="text-gray-700">Female</label>
        </div>
    </div>

    <button name='signupsubmit' type="submit" class="mb-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Register</button>
</form>

<?php include '../assets/layouts/footer.php'?>

<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#avatar").change(function() {
        console.log("here");
        readURL(this);
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
                document.getElementById('preview-img').style.backgroundImage = `url(${e.target.result})`;
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '../assets/uploads/users/_defaultUser.png';
            iconAndText.style.display = 'block';
        }
      }
</script>

