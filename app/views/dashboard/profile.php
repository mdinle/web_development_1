<head>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div
        class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">

        <?php include 'header.php';?>
        <?php include 'sidebar.php';?>

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64" x-data="{darkMode: false}"  :class="{ 'dark': darkMode }">



            <form class="px-20 pt-5" id="editProfile" method="POST" onsubmit="return validateForm()">
                <h3 class="pb-10 text-2xl font-semibold text-gray-900 dark:text-white">Profile</h3>
                <p class="pb-5 text-red-400 <?php if(!$fillOutProfile) {
                    echo "hidden";
                }?>">
                    Fill your profile information before you continue</p>
                <div class="mb-4">
                    <label for="fullname"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Fullname</label>
                    <input type="text" id="fullname" name="fullname"
                        class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                        :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                </div>
                <div class="mb-4">
                    <label for="age"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Age</label>
                    <input type="number" id="age" name="age"
                        class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                        :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                </div>
                <div class="mb-4">
                    <label for="gender"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Select your gender</label>
                    <select id="gender" name="gender"
                        class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                        :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                        <option selected>Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="address"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Address</label>
                    <input type="text" id="address" name="address"
                        class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                        :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                </div>
                <div class="mb-4">
                    <label for="phonenumber"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Phone Number</label>
                    <input type="number" id="phonenumber" name="phonenumber"
                        class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                        :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                </div>
                <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Update Profile
                </button>
                <button type="button" @click="isOpenAddUserModal = false"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-white hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </form>

        </div>
    </div>
</div>
<script src="/js/darkmode.js"></script>
<script>
    function validateForm() {
        var fullname = document.forms["editProfile"]["fullname"].value;
        var age = document.forms["editProfile"]["age"].value;
        var gender = document.forms["editProfile"]["gender"].value;
        var address = document.forms["editProfile"]["address"].value;
        var phonenumber = document.forms["editProfile"]["phonenumber"].value;

        if (fullname == "" || age == "" || address == "" || phonenumber == "" || gender == "Gender") {
            alert("All fields must be filled out");
            return false;
        }

    }
</script>