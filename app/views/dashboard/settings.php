<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style.css">
</head>
<div x-data="setup()" :class="{ 'dark': isDark }">
    <div
        class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">

        <?php include 'header.php';?>
        <?php include 'sidebar.php';?>

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64" x-data="{darkMode: false}" :class="{ 'dark': darkMode }">

            <form class="px-5 pt-5 md:px-20" id="changePassword" method="POST" onsubmit="return changePassword()">
                <?php
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    unset($_SESSION['successMessage']);
    ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Success! </strong>
                    <span
                        class="block sm:inline"><?php echo $successMessage; ?></span>
                </div>
                <?php } ?>

                <h3 class="pb-10 text-2xl font-semibold text-gray-900 dark:text-white">Reset Password</h3>
                <div class="mb-4">
                    <label for="current_password"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Current Password</label>
                    <div class="relative">
                        <input type="password" id="current_password" name="current_password"
                            class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                            :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                        <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center"
                            onclick="togglePasswordVisibility('current_password')">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">New Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                            :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                        <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center"
                            onclick="togglePasswordVisibility('password')">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="confirm_password"
                        :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                        class="block text-sm font-medium">Confirm New Password</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password"
                            class="mt-1 p-2 border border-gray-300 dark:border-white rounded-md w-full"
                            :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                        <button type="button" class="absolute inset-y-0 right-0 px-3 flex items-center"
                            onclick="togglePasswordVisibility('confirm_password')">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Change Password
                </button>
            </form>

        </div>
    </div>
</div>
<script src="/js/darkmode.js"></script>
<script>
    function togglePasswordVisibility(fieldId) {
        var field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }

    function changePassword() {
        var currentPassword = document.getElementById('current_password').value;
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;

        if (currentPassword === "" || password === "" || confirmPassword === "") {
            alert("Please fill all fields");
            return false;
        }

        if (currentPassword === password) {
            alert("New password cannot be the same as the current password");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match");
            return false;
        }

        return true;
    }
</script>