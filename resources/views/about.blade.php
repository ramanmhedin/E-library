<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Include Tailwind CSS -->
    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="bg-black h-full flex flex-col">
<!-- Header -->
<nav class="bg-gray-900 shadow ">
    <div class="container mx-auto px-4 ">
        <div class="flex justify-between h-16 items-center ">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/home" class="font-serif text-3xl text-amber-400">E-Library</a>
            </div>

            <!-- Navigation Links -->
            <div class="flex justify-end ">
                <ul class="flex space-x-4">
                    <li><a href="/home" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded">Home</a></li>
                    <li><a href="/about" class="text-amber-400 hover:bg-gray-800 py-2 px-4  rounded">About</a></li>
                    <li><a href="#footer" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded">Contact</a></li>
                    <li><a href="/login" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded ">Login</a></li>
                </ul>
            </div>

        </div>

    </div>
</nav>

<!-- Main content -->
<main class="flex-1 bg-gray-600 w-3/5 mx-auto">
    <section class="container  py-8 flex justify-start">
        <div class="max-w-2xl  shadow-md p-6 rounded-lg bg-amber-50">
            <h1 class="text-3xl font-semibold text-gray-800 mb-4">Who We Are?</h1>
            <p class="text-2xl text-amber-400 font-bold mb-4">Abdurahman & Mabast</p>
            <p class="text-lg text-gray-700 mb-4">
                We are fourth-grade students at Salahadin University, College of Engineering, Software Department.
            </p>
            <p class="text-lg text-gray-700 mb-4">
                We have dedicated our efforts to developing a system management solution for academic research at the university.
            </p>
            <p class="text-lg text-gray-700 mb-4">
                This project was developed using Laravel and Filament V3. We have worked diligently to create a professional and efficient system to meet the needs of our academic community.
            </p>
            <p class="text-lg text-gray-700">
                Thank you for your interest in our project!
            </p>
        </div>
    </section>
    <section class="container mr-60 py-8 flex justify-end">
        <div class="max-w-2xl shadow-md p-6 rounded-lg bg-amber-50">
            <h1 class="text-3xl font-semibold text-gray-800 mb-4"> Our Project !</h1>
            <p class="text-2xl text-amber-400 font-bold mb-4">E-Library</p>
            <p class="text-lg text-gray-700 mb-4">Our project is a comprehensive solution aimed at enhancing the management of academic research at Salahadin University.</p>
            <p class="text-lg text-gray-700 mb-4">With a focus on usability and efficiency, we have developed a user-friendly platform that allows researchers, faculty members, and students to seamlessly access, organize, and collaborate on research projects.</p>
            <p class="text-lg text-gray-700 mb-4">Through extensive research and collaboration with stakeholders, we have identified key pain points in the current research management process and have tailored our solution to address these challenges effectively.</p>
            <p class="text-lg text-gray-700">Our project leverages the latest technologies and best practices to provide a robust and scalable solution that meets the diverse needs of the academic community at Salahadin University.</p>
        </div>
    </section>



</main>

<!-- Footer -->

<footer id="footer" class="bg-gray-900 text-gray-100 py-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-4 gap-5">
            <!-- Company Information -->
            <div class="text-center md:text-left">
                <h3 class="text-lg font-semibold text-amber-500 mb-2"> Information</h3>
                <p>&copy; 2024 Final Project</p>
                <p>Salahadin University, Engineering College, Software Department</p>
                <p>Street Karkuk, Erbil, Kurdistan Iraq</p>
            </div>

            <!-- Creator Information -->
            <div class="text-center md:text-left">
                <h3 class="text-lg font-semibold mb-2 text-amber-500">Created by</h3>
                <p>Abdurahman Yassin</p>
                <p>Mabast Abdulqadir</p>
            </div>
            <div class="text-center md:text-left">
                <h3 class="text-lg font-semibold mb-2 text-amber-500">Supervised by</h3>
                <p>MS. Nawroze</p>
            </div>

            <!-- Contact Information -->
            <div class="text-center md:text-left">
                <h3 class="text-lg font-semibold mb-2 text-amber-500">Contact Us</h3>
                <p>Email: info@finalproject.com</p>
                <p>Phone: +1234567890</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
