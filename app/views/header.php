<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mohamed D - Fitness</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="flex flex-col min-h-screen">
	<!-- Navigation Bar -->
	<nav>
		<div class="bg-white text-black p-4 shadow-lg fixed top-0 w-full z-50">
			<div class="container mx-auto flex justify-between items-center">
				<a href="/">
					<img src="/img/Mohamed_D.png" class="h-9 cursor-pointer md:h-8" alt="MD Logo" /></a>
				<div class="lg:hidden cursor-pointer" onclick="toggleMenu()">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M4 6h16M4 12h16m-7 6h7">
						</path>
					</svg>
				</div>

				<div class="hidden lg:flex space-x-7 items-center">
					<a href="/home/about" class="hover:text-gray-300">About</a>
					<!-- Login Button -->
					<button class="bg-black py-1 px-5 rounded-xl text-white hover:opacity-60"
						onclick="redirectToLoginPage()">
						Login
					</button>
				</div>
			</div>
		</div>

		<div class="lg:hidden fixed inset-0 bg-white bg-opacity-75 z-50 hidden" id="mobileMenu" onclick="toggleMenu()">
		</div>

		<div class="lg:hidden fixed inset-y-0 left-0 transform translate-x-full bg-white p-4 w-64 z-50 hidden"
			id="mobileNav">
			<div class="flex justify-end">
				<div class="cursor-pointer" onclick="toggleMenu()">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
						xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
						</path>
					</svg>
				</div>
			</div>

			<div class="mt-4">
				<a href="/about" class="block text-black hover:text-gray-300 py-2">About</a>
				<!-- Login Button -->
				<button onclick="redirectToLoginPage()"
					class="bg-black mt-2 py-1 px-5 rounded-xl text-white hover:opacity-60">
					Login
				</button>
			</div>
		</div>
	</nav>

	<script>
		function toggleMenu() {
			const mobileNav = document.getElementById('mobileNav');
			const mobileMenu = document.getElementById('mobileMenu');

			mobileNav.classList.toggle('hidden');
			mobileMenu.classList.toggle('hidden');
		}

		function redirectToLoginPage() {
			window.location.href = '/user/login';
		}
	</script>
</body