<head>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
	<link rel="stylesheet" href="/css/style.css">
</head>
<!-- component -->
<div x-data="setup()" :class="{ 'dark': isDark }">
	<div
		class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-700 text-black dark:text-white">

		<?php include 'header.php';?>
		<?php include 'sidebar.php';?>

		<div class="h-full ml-14 mt-14 mb-10 md:ml-64">
			<div class="flex p-10 justify-center">
				<div>
					<label for="selectDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
						a date</label>
					<div class="relative">
						<div class="pl-1 absolute inset-y-0 start-0 flex items-center pointer-events-none">
							<svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
								xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
								<path
									d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
							</svg>
						</div>
						<input id="selectDate" datepicker datepicker-autohide datepicker-buttons
							datepicker-autoselect-today datepicker-format="dd/mm/yyyy" type="text"
							class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block ps-10 py-2 px-7 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
							placeholder="Select date" />
					</div>

					<label for="selectTrainer"
						class="pt-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
						a trainer</label>
					<select id="selectTrainer"
						class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
						<option selected>Choose a trainer</option>
						<?php foreach ($trainers as $trainer) {
						    echo '<option value="' . $trainer['UserId'] . '">' . $trainer['Username'] . '</option>';
						}?>
					</select>

					<label for="selectTime"
						class="pt-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a time</label>
					<select id="selectTime"
						class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
						<option selected disabled>Choose a time</option>
						<!-- Generating time options from 7:00 AM to 9:00 PM with 30-minute difference -->
					</select>

					<label for="selectDuration"
						class="pt-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
						duration</label>
					<select id="selectDuration"
						class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
						<option selected>Choose a duration</option>
						<option value="30">30 minutes</option>
						<option value="60">1 hour</option>
						<option value="90">1 hour 30 minutes</option>
					</select>

					<label for="notes" class="pt-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add a
						note (Optional)</label>
					<textarea id="notes" name="notes"
						class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
						placeholder="Add a note"></textarea>

					<button onclick=bookSession()
						class="mt-4 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
						Book
					</button>

				</div>
			</div>
		</div>
	</div>
</div>

<script src="/js/darkmode.js"></script>
<script>
	var selectTime = document.getElementById('selectTime');
	var hours, minutes, ampm, time;

	for (var i = 7; i <= 21; i++) {
		for (var j = 0; j < 60; j += 30) {
			hours = (i % 12 || 12);
			minutes = (j < 10 ? '0' : '') + j;
			ampm = (i < 12) ? 'AM' : 'PM';
			time = hours + ':' + minutes + ' ' + ampm;
			var option = document.createElement('option');
			option.text = time;
			selectTime.add(option);
		};
	}

	function bookSession() {
		const userId = <?php echo $userId?> ;
		var dateInput = document.getElementById('selectDate').value;
		var trainer = document.getElementById('selectTrainer').value;
		var timeInput = document.getElementById('selectTime').value;
		var duration = document.getElementById('selectDuration').value;
		var notes = document.getElementById('notes').value;

		if (dateInput === '' || trainer === 'Choose a trainer' || time === 'Choose a time' || duration ===
			'Choose a duration') {
			alert('Please fill all fields');
			return;
		};

		var parts = dateInput.split('/');
		var day = parseInt(parts[0], 10);
		var month = parseInt(parts[1], 10) - 1;
		var year = parseInt(parts[2], 10);

		var timeParts = timeInput.split(':');
		var hours = parseInt(timeParts[0], 10);
		var minutes = parseInt(timeParts[1], 10);


		var selectDate = new Date(year, month, day, hours, minutes);

		var currentDate = new Date();

		console.log(selectDate, currentDate);

		if (selectDate < currentDate) {
			alert('Selected date is a past date');
			return;
		};

		var session = {
			"trainerId": trainer,
			"clientId": userId,
			"date": selectDate,
			"duration": duration,
			"notes": notes
		};

		console.log(session);

		fetch('/api/booking/create', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(session),
			})
			.then(response => response.json())
			.then(data => {
				console.log('Success:', data);
				alert('Session booked successfully');
			})
			.catch((error) => {
				console.error('Error:', error);
				alert('Error booking session');
			});
	}
</script>