<?php
include __DIR__ . '/../header.php';
?>
<!-- Body Section 1 -->
<section class="relative">
	<img class="object-cover h-1/2 md:h-screen w-screen" src="../img/homepageImage.jpeg">

	<div class="absolute top-1/2 text-center left-1/2 transform -translate-x-1/2">
		<div class="bg-black bg-opacity-40 p-4 rounded-lg space-y-4">

			<p class=" text-white font-bold md:text-2xl">Get Shredded for the Summer!</p>

			<button onclick="redirectToBookingPage()" class="bg-black p-2 rounded-xl text-white hover:opacity-60">
				<p class=" text-white text-xs md:text-sm">Book a Session</p>
			</button>
		</div>
	</div>
</section>

<!--Body Section 2 -->
<section class="pt-10 px-5 pb-5">
	<div class="flex flex-col bg-white m-auto p-auto">
		<h1 class="flex py-4 px-3 font-bold text-4xl text-gray-800"> Our Results </h1>

		<div class="flex overflow-x-scroll pb-10 hide-scroll-bar">

			<div class="flex flex-nowrap">

				<div class="inline-block px-3">
					<div
						class="w-80 h-96 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
						<img class="object-cover w-full h-full" src="img/ba_1.jpeg" />
					</div>
				</div>
				<div class="inline-block px-3">
					<div
						class="w-80 h-96 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
						<img class="object-cover w-full h-full" src="img/ba_1.jpeg" />
					</div>
				</div>
				<div class="inline-block px-3">
					<div
						class="w-80 h-96 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
						<img class="object-cover w-full h-full" src="img/ba_1.jpeg" />
					</div>
				</div>
				<div class="inline-block px-3">
					<div
						class="w-80 h-96 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
						<img class="object-cover w-full h-full" src="img/ba_1.jpeg" />
					</div>
				</div>
				<div class="inline-block px-3">
					<div
						class="w-80 h-96 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
						<img class="object-cover w-full h-full" src="img/ba_1.jpeg" />
					</div>
				</div>
				<div class="inline-block px-3">
					<div
						class="w-80 h-96 max-w-xs overflow-hidden rounded-lg shadow-md bg-white hover:shadow-xl transition-shadow duration-300 ease-in-out">
						<img class="object-cover w-full h-full" src="img/ba_1.jpeg" />
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
include __DIR__ . '/../footer.php';
?>