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
				<h1 class="text-2xl pb-5 font-semibold text-gray-900 dark:text-white">Upcoming sessions</h1>
				<table class="w-full shadow-md text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
					<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th scope="col" class="px-6 py-3">
								Session Date
							</th>
							<th scope="col" class="px-6 py-3">
								Session Time
							</th>
							<th scope="col" class="px-6 py-3">
								Duration
							</th>
							<th scope="col" class="px-6 py-3">
								Trainer
							</th>
							<th scope="col" class="px-6 py-3">

							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($appointments as $appointment) {
						    $date = date('d/m/Y', strtotime($appointment->getDate()));
						    $time = date('H:i', strtotime($appointment->getDate()));
						    echo '<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">';
						    echo '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' . $date . '</th>';
						    echo '<td class="px-6 py-4">' . $time . '</td>';
						    echo '<td class="px-6 py-4">' . $appointment->getDuration() . '</td>';
						    echo '<td class="px-6 py-4">' . $appointment->getTrainerName() . '</td>';
						    echo '<td class="px-6 py-4"><button class="text-red-500 underline underline-offset-1" onclick="deleteUser(' . $appointment->getAppointmentID() . ')">Delete</button></td>';
						    echo '</tr>';
						}?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<script src="/js/darkmode.js"></script>
<script>
	function deleteUser(id) {
		if (confirm('Are you sure you want to delete this appointment?')) {
			console.log('Appointment deleted');
		}
	}
</script>