<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Our Products - DWIN Insurance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(asset('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="font-sans">
    <header class="bg-white shadow-md sticky top-0 z-50 font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo and tagline -->
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{asset('imgs\logo.png')}}" alt="DWIN Insurance Logo" class="h-12 w-auto">
                    <div class="ml-3 hidden md:block">
                        <h3 class="text-primary font-bold text-lg">ALWAYS SECURE</h3>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="/"
                        class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                        Home
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="/about"
                        class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                        About Us
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <div class="relative group">
                        <a href="/products"
                            class="text-primary font-medium px-3 py-2 flex items-center transition duration-300">
                            Our Products
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary"></span>
                            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <!-- Dropdown menu -->
                        <div
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="#motor" class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Motor
                                Insurance</a>
                            <a href="#health"
                                class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Medical
                                Insurance</a>
                            <a href="#travel" class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Travel
                                Insurance</a>
                            <a href="#property"
                                class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Property
                                Insurance</a>
                        </div>
                    </div>
                    <a href="/contact"
                        class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                        Contact Us
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="/blog"
                        class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                        Blog
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="#quote"
                        class="bg-primary hover:bg-blue-800 text-white font-medium px-6 py-2 rounded-lg transition duration-300">
                        Get Quote
                    </a>
                </nav>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary focus:outline-none"
                        aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="hidden md:hidden bg-white shadow-lg" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="/" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Home</a>
                <a href="/about" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">About Us</a>
                <div>
                    <button type="button"
                        class="w-full flex justify-between items-center px-3 py-2 text-primary font-medium"
                        id="products-dropdown-button">
                        Our Products
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="pl-4" id="products-dropdown">
                        <a href="#motor" class="block px-3 py-2 text-gray-700 hover:text-primary">Motor Insurance</a>
                        <a href="#health" class="block px-3 py-2 text-gray-700 hover:text-primary">Medical Insurance</a>
                        <a href="#travel" class="block px-3 py-2 text-gray-700 hover:text-primary">Travel Insurance</a>
                        <a href="#property" class="block px-3 py-2 text-gray-700 hover:text-primary">Property Insurance</a>
                    </div>
                </div>
                <a href="/contact" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Contact Us</a>
                <a href="/blog" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Blog</a>
                <a href="#quote"
                    class="block w-full text-center bg-primary text-white font-medium px-6 py-2 rounded-lg mt-2">Get
                    Quote</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="welcome bg-gradient-to-r from-primary to-accent rounded-xl p-8 md:p-12 text-white mb-16 shadow-lg">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold mb-4">Our Insurance Products</h1>
            <p class="text-lg md:text-xl max-w-3xl mb-6">Comprehensive insurance solutions tailored to protect what matters most to you and your family.</p>
        </div>

        <!-- Products Overview -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-12">Choose Your Protection</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <a href="#motor" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300 text-center group">
                    <div class="h-16 w-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Motor Insurance</h3>
                    <p class="text-gray-600 text-sm">Protect your vehicle with comprehensive coverage</p>
                </a>

                <a href="#health" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300 text-center group">
                    <div class="h-16 w-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Health Insurance</h3>
                    <p class="text-gray-600 text-sm">Secure your family's health and well-being</p>
                </a>

                <a href="#life" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300 text-center group">
                    <div class="h-16 w-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                        <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Life Insurance</h3>
                    <p class="text-gray-600 text-sm">Long-term financial security for your loved ones</p>
                </a>

                <a href="#property" class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300 text-center group">
                    <div class="h-16 w-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Property Insurance</h3>
                    <p class="text-gray-600 text-sm">Protect your home and valuable assets</p>
                </a>
            </div>
        </div>

        <!-- Motor Insurance Section -->
        <div id="motor" class="mb-16">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img src="{{ asset('imgs/GI.jpeg') }}" alt="Motor Insurance" class="w-full h-64 md:h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-8">
                        <h2 class="text-3xl font-serif font-bold text-primary mb-4">Motor Insurance</h2>
                        <p class="text-gray-700 mb-6">
                            Comprehensive motor insurance coverage that protects your vehicle against accidents, theft, 
                            and third-party liabilities. Choose from our range of policies designed to meet different 
                            needs and budgets.
                        </p>
                        <div class="space-y-4 mb-6">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Comprehensive coverage for own damage</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Third-party liability protection</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">24/7 roadside assistance</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Fast claims processing</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button class="bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Get Quote
                            </button>
                            <button class="border border-primary text-primary hover:bg-primary hover:text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Insurance Section -->
        <div id="health" class="mb-16">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="md:flex md:flex-row-reverse">
                    <div class="md:w-1/2">
                        <img src="{{ asset('imgs/HI.jpeg') }}" alt="Health Insurance" class="w-full h-64 md:h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-8">
                        <h2 class="text-3xl font-serif font-bold text-primary mb-4">Health Insurance</h2>
                        <p class="text-gray-700 mb-6">
                            Comprehensive health insurance coverage that ensures you and your family have access to 
                            quality healthcare when you need it most. Our plans cover everything from routine check-ups 
                            to major medical procedures.
                        </p>
                        <div class="space-y-4 mb-6">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Inpatient and outpatient coverage</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Maternity and child health benefits</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Emergency medical evacuation</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Access to network hospitals nationwide</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button class="bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Get Quote
                            </button>
                            <button class="border border-primary text-primary hover:bg-primary hover:text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Life Insurance Section -->
        <div id="life" class="mb-16">
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img src="{{ asset('imgs/LI.jpeg') }}" alt="Life Insurance" class="w-full h-64 md:h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-8">
                        <h2 class="text-3xl font-serif font-bold text-primary mb-4">Life Insurance</h2>
                        <p class="text-gray-700 mb-6">
                            Secure your family's financial future with our comprehensive life insurance policies. 
                            Whether you're looking for term life, whole life, or investment-linked policies, we have 
                            solutions that provide peace of mind and financial security.
                        </p>
                        <div class="space-y-4 mb-6">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Term life insurance for affordable protection</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Whole life policies with cash value</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Investment-linked life insurance</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-accent mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Flexible payment options</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button class="bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Get Quote
                            </button>
                            <button class="border border-primary text-primary hover:bg-primary hover:text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Products -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-12">Additional Coverage Options</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Travel Insurance -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition duration-300">
                    <div class="h-16 w-16 bg-accent rounded-full flex items-center justify-center mb-6">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Travel Insurance</h3>
                    <p class="text-gray-700 mb-4">
                        Protect yourself and your belongings while traveling domestically or internationally.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Trip cancellation coverage</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Medical emergency coverage</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Baggage protection</span>
                        </li>
                    </ul>
                    <button class="w-full bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                        Learn More
                    </button>
                </div>

                <!-- Property Insurance -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition duration-300">
                    <div class="h-16 w-16 bg-secondary rounded-full flex items-center justify-center mb-6">
                        <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Property Insurance</h3>
                    <p class="text-gray-700 mb-4">
                        Comprehensive coverage for your home and valuable possessions against various risks.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Fire and natural disaster coverage</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Theft and burglary protection</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Liability coverage</span>
                        </li>
                    </ul>
                    <button class="w-full bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                        Learn More
                    </button>
                </div>

                <!-- Business Insurance -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition duration-300">
                    <div class="h-16 w-16 bg-primary rounded-full flex items-center justify-center mb-6">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-4">Business Insurance</h3>
                    <p class="text-gray-700 mb-4">
                        Comprehensive protection for your business assets, employees, and operations.
                    </p>
                    <ul class="space-y-2 mb-6">
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Professional liability coverage</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Employee compensation</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-4 w-4 text-accent mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-sm text-gray-600">Business interruption coverage</span>
                        </li>
                    </ul>
                    <button class="w-full bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                        Learn More
                    </button>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary text-white rounded-xl p-8 md:p-12 text-center">
            <h2 class="text-3xl font-serif font-bold mb-4">Ready to Get Protected?</h2>
            <p class="text-lg mb-6 max-w-2xl mx-auto">
                Contact our insurance experts today to find the perfect coverage for your needs. 
                We're here to help you make informed decisions about your protection.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/contact"
                    class="bg-secondary hover:bg-yellow-600 text-primary font-bold py-3 px-6 rounded-lg transition duration-300">
                    Get a Quote
                </a>
                <a href="tel:+254700123456"
                    class="border-2 border-white hover:bg-white hover:text-primary font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Call Us Now
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-md font-bold mb-4">DWIN Insurance</h3>
                    <p class="text-gray-400 text-sm">Your trusted partner in protecting what matters most in Kenya since
                        2010.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="text-gray-400 hover:text-white transition duration-300">Home</a></li>
                        <li><a href="/about" class="text-gray-400 hover:text-white transition duration-300">About Us</a>
                        </li>
                        <li><a href="/products" class="text-gray-400 hover:text-white transition duration-300">Services</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Claims</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">General
                                Insurance</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Health
                                Insurance</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Life
                                Insurance</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Travel
                                Insurance</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Privacy
                                Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Terms of
                                Service</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-white transition duration-300">Complaints</a></li>
                        <!-- Staff Login -->
                        <li><a href="/admin/auth" class="text-gray-400 hover:text-white transition duration-300">Staff
                                Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-xs">
                <p>&copy; 2010 - 2025 DWIN Insurance Agency. All rights reserved. Licensed by the Insurance Regulatory
                    Authority of Kenya.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const isHidden = mobileMenu.classList.contains('hidden');
            
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                this.setAttribute('aria-expanded', 'true');
            } else {
                mobileMenu.classList.add('hidden');
                this.setAttribute('aria-expanded', 'false');
            }
        });

        // Products dropdown toggle for mobile
        document.getElementById('products-dropdown-button').addEventListener('click', function() {
            const dropdown = document.getElementById('products-dropdown');
            const isHidden = dropdown.classList.contains('hidden');
            
            if (isHidden) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
