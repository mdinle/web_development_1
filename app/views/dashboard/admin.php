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

        <div class="h-full ml-14 mt-14 mb-10 md:ml-64">
            <div class="relative p-10 overflow-x-auto sm:rounded-lg">
                <h1 class="text-2xl pb-5 font-semibold text-gray-900 dark:text-white">Admin Panel</h1>
                <table class="w-full shadow-md text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                User Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                User Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                User Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                User Type
                            </th>
                            <th scope="col" class="px-6 py-3">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) {
                            echo '<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">';
                            echo '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
                            echo $user->getUserId();
                            echo '</th>';
                            echo '<td class="px-6 py-4">';
                            echo $user->getUserName();
                            echo '</td>';
                            echo '<td class="px-6 py-4">';
                            echo $user->getEmail();
                            echo '</td>';
                            echo '<td class="px-6 py-4">';
                            echo $user->getUserType();
                            echo '</td>';
                            echo '<td class="px-6 py-4">';
                            echo '<button class="text-red-500 underline underline-offset-1" onclick="deleteUser(' . $user->getUserId() . ')">Delete</button>';
                            echo '</td>';
                            echo '</tr>';
                        }?>
                    </tbody>
                </table>
            </div>

            <form id="deleteForm" method="post">
                <input type="hidden" name="form_identifier" value="deleteUserForm">
                <input type="hidden" id="deleteUserId" name="userId">
            </form>

            <div x-data="{ isOpenEditModal: false, isOpenAddUserModal: false, darkMode: false }"
                :class="{ 'dark': darkMode }">
                <!-- Modal -->
                <div id="addModal" x-show="isOpenAddUserModal" class="fixed z-10 inset-0 overflow-y-auto">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-black dark:opacity-80"></div>
                        </div>

                        <!-- Modal content -->
                        <div
                            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="w-full bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                                        Add User</h3>
                                    <!-- User edit form goes here -->
                                    <form id="addUser" method="POST" onsubmit="return validateForm()">
                                        <input type="hidden" name="form_identifier" value="addUserForm">
                                        <div class="mb-4">
                                            <label for="username"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Username</label>
                                            <input type="text" id="username" name="username"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Email</label>
                                            <input type="email" id="email" name="email"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                        </div>
                                        <div class="mb-4">
                                            <label for="password"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Password</label>
                                            <input type="password" id="password" name="password"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                        </div>
                                        <div class="mb-4">
                                            <label for="userType"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Type</label>
                                            <select id="userType" name="userType"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                                <option selected>User Type</option>
                                                <option value="trainer">Trainer</option>
                                                <option value="client">Client</option>
                                            </select>
                                        </div>
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Add User
                                        </button>
                                        <button type="button" @click="isOpenAddUserModal = false"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-white hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="editModal" x-show="isOpenEditModal" class="fixed z-10 inset-0 overflow-y-auto">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-black dark:opacity-80"></div>
                        </div>

                        <!-- Modal content -->
                        <div
                            class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="w-full bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                                        Edit User</h3>
                                    <!-- User edit form goes here -->
                                    <form id="editForm" method="post" onsubmit="return updateValidateForm()">
                                        <input type="hidden" name="form_identifier" value="editUserForm">
                                        <div class="mb-4">
                                            <label for="user"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Choose User</label>
                                            <select id="userId" name="userId"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                                <option selected>User</option>
                                                <?php foreach ($users as $user) {
                                                    echo '<option value="' . $user->getUserId() . '">' . $user->getUserName() . '</option>';
                                                }?>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="username"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Username</label>
                                            <input type="text" id="editUsername" name="username"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Email</label>
                                            <input type="email" id="editEmail" name="email"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                        </div>
                                        <div class="mb-4">
                                            <label for="password"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Password</label>
                                            <input type="password" id="editPassword" name="password"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                        </div>
                                        <div class="mb-4">
                                            <label for="userType"
                                                :class="{ 'text-gray-700 dark:text-white': !darkMode, 'text-gray-400 dark:text-gray-600': darkMode }"
                                                class="block text-sm font-medium">Type</label>
                                            <select id="editUserType" name="userType"
                                                class="mt-1 p-2 border border-gray-300 dark:border-gray-700 rounded-md w-full"
                                                :class="{ 'text-gray-900 dark:text-white bg-white dark:bg-gray-700': !darkMode, 'text-gray-400 dark:text-gray-600 bg-gray-800': darkMode }">
                                                <option selected>User Type</option>
                                                <option value="trainer">Trainer</option>
                                                <option value="client">Client</option>
                                            </select>
                                        </div>
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Edit User
                                        </button>
                                        <button type="button" @click="isOpenEditModal = false"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-white hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                        <!-- Other fields to edit -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Button to open the modal -->
                <button type="button" @click="isOpenAddUserModal = true"
                    class="mx-10 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add New User
                </button>

                <button type="button" @click="isOpenEditModal = true"
                    class="mx-10 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Edit User
                </button>
            </div>
        </div>
    </div>
</div>
<script src="/js/darkmode.js"></script>
<script>
    function validateForm() {
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var userType = document.getElementById("userType").value;

        if (!username || !email || !password || userType === "User Type") {
            alert("Please fill in all fields.");
            return false;
        }
        return true;
    }

    function updateValidateForm() {
        var userId = document.getElementById("userId").value;

        if (userId === "User") {
            alert("Plese select a user");
            return false;
        }
        return true;
    }

    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            document.getElementById("deleteUserId").value = userId;
            document.getElementById("deleteForm").submit();
        }
    }
</script>