<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased bg-gray-600 min-h-screen">
    <nav class="bg-gray-900 shadow">
        <div class="container mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/home" class="font-serif text-3xl text-amber-400">E-Library</a>
                </div>

                <!-- Navigation Links -->
                <div class="flex justify-center">
                    <ul class="flex space-x-4">
                        <li><a href="/home" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded">Home</a></li>
                        <li><a href="/published-research" class="text-amber-400 hover:bg-gray-800 py-2 px-4 rounded">Research</a></li>
                        <li><a href="/about" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded">About</a></li>
                        <li><a href="#footer" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded">Contact</a></li>
                        <li><a href="/login" class="text-gray-100 hover:bg-gray-800 py-2 px-4 rounded ">Login</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>
      <main class="flex-1 bg-gray-600">

          {{ $slot }}
      </main>

        @livewire('notifications')

        @filamentScripts
        @vite('resources/js/app.js')
        <footer id="footer" class="bg-gray-900 text-gray-100 py-6 ">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-4 gap-5  ">
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
                        <h3 class="text-lg font-semibold mb-2 text-amber-500">Supervise by</h3>
                        <p>MS.Nawroze</p>
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
