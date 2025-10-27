<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DWIN Insurance Agency - Kenya's Trusted Insurance Partner</title>

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
                <a href="about.html"
                    class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                    About Us
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>
                <div class="relative group">
                    <a href="/products"
                        class="text-gray-700 hover:text-primary font-medium px-3 py-2 flex items-center transition duration-300">
                        Our Products
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    <!-- Dropdown menu -->
                    <div
                        class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Motor
                            Insurance</a>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Medical
                            Insurance</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Travel
                            Insurance</a>
                        <a href="#"
                            class="block px-4 py-2 text-gray-700 hover:bg-primary hover:text-white">Property
                            Insurance</a>
                    </div>
                </div>
                <a href="contact.html"
                    class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                    Contact Us
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="blog.html"
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
            <a href="index.html" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Home</a>
            <a href="about.html" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">About Us</a>
            <div>
                <button type="button"
                    class="w-full flex justify-between items-center px-3 py-2 text-gray-700 hover:text-primary font-medium"
                    id="products-dropdown-button">
                    Our Products
                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="hidden pl-4" id="products-dropdown">
                    <a href="#" class="block px-3 py-2 text-gray-700 hover:text-primary">Motor Insurance</a>
                    <a href="#" class="block px-3 py-2 text-gray-700 hover:text-primary">Medical Insurance</a>
                    <a href="#" class="block px-3 py-2 text-gray-700 hover:text-primary">Travel Insurance</a>
                    <a href="#" class="block px-3 py-2 text-gray-700 hover:text-primary">Property Insurance</a>
                </div>
            </div>
            <a href="contact.html" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Contact Us</a>
            <a href="blog.html" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Blog</a>
            <a href="#quote"
                class="block w-full text-center bg-primary text-white font-medium px-6 py-2 rounded-lg mt-2">Get
                Quote</a>
        </div>
    </div>
</header>
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 ">
    <!-- Hero Section -->
    <div class="welcome bg-gradient-to-r from-primary to-accent rounded-xl p-8 md:p-12 text-white mb-16 shadow-lg">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold mb-4">Welcome to DWIN Insurance Agency</h2>
        <p class="text-lg md:text-xl max-w-3xl mb-6">Your trusted partner in protecting what matters most. Get the best
            insurance covers tailored to your needs.</p>
        <div class="flex flex-wrap gap-4">
            <a href="#contact"
                class="bg-secondary hover:bg-yellow-600 text-primary font-bold py-3 px-6 rounded-lg transition duration-300">Get
                a Quote</a>
            <a href="#services"
                class="border-2 border-white hover:bg-white hover:text-primary font-semibold py-3 px-6 rounded-lg transition duration-300">Our
                Services</a>
        </div>
    </div>

    <!-- Services Section -->
    <h2 id="services" class="text-3xl font-serif font-bold text-center text-primary mb-12">Our Insurance Services
    </h2>
    <div class="services-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
        <!-- General Insurance -->
        <div class="service-box bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
            <img src="{{ asset('imgs/GI.jpg') }}" alt="General Insurance"
                class="service-image w-full h-48 object-cover">
            <div class="service-content p-6">
                <h3 class="text-xl font-bold text-primary mb-2">General Insurance</h3>
                <i class="text-gray-600 block mb-3">(Non-Life Insurance)</i>
                <p class="text-gray-700 mb-4">Insurance coverage for assets, liabilities, and risks other than human
                    life.</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Short-term risks (usually 1 year)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Property damage (e.g., homes, vehicles)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Liability claims (e.g., accidents, lawsuits)</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Travel, fire, theft, or natural disasters</span>
                    </li>
                </ul>
                <button
                    class="mt-2 bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300 w-full">Learn
                    More</button>
            </div>
        </div>

        <!-- Health Insurance -->
        <div class="service-box bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
            <img src="{{ asset('imgs/HI.jpg') }}" alt="Health Insurance"
                class="service-image w-full h-48 object-cover">
            <div class="service-content p-6">
                <h3 class="text-xl font-bold text-primary mb-2">Health Insurance</h3>
                <p class="text-gray-700 mb-4">Secure your family's Coverage for medical expenses incurred due to
                    illnesses, injuries, or preventive care.</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Financial protection for dependents</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Income replacement</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Funeral costs/debts</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Some policies include savings/investment components</span>
                    </li>
                </ul>
                <button
                    class="mt-2 bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300 w-full">Learn
                    More</button>
            </div>
        </div>

        <!-- Life Insurance -->
        <div class="service-box bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
            <img src="{{ asset('imgs/LI.jpg') }}" alt="Life Insurance"
                class="service-image w-full h-48 object-cover">
            <div class="service-content p-6">
                <h3 class="text-xl font-bold text-primary mb-2">Life Insurance</h3>
                <p class="text-gray-700 mb-4">A contract where an insurer guarantees payment to beneficiaries upon the
                    policyholder's death or after a set period.</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Long-term financial security</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Medical expense coverage</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Emergency care protection</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-accent mr-2 mt-0.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Preventive care benefits</span>
                    </li>
                </ul>
                <button
                    class="mt-2 bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300 w-full">Learn
                    More</button>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-gray-100 rounded-xl p-8 mb-16">
        <h2 class="text-3xl font-serif font-bold text-center text-primary mb-8">What Our Clients Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center mb-4">
                    <div
                        class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold mr-4">
                        JM</div>
                    <div>
                        <h4 class="font-bold">James Mwangi</h4>
                        <p class="text-gray-600 text-sm">Nairobi</p>
                    </div>
                </div>
                <p class="text-gray-700">"DWIN helped me find affordable health insurance that covers my whole family.
                    Their service is exceptional!"</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center mb-4">
                    <div
                        class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold mr-4">
                        AW</div>
                    <div>
                        <h4 class="font-bold">Amina Wambui</h4>
                        <p class="text-gray-600 text-sm">Mombasa</p>
                    </div>
                </div>
                <p class="text-gray-700">"After my car accident, DWIN's motor insurance made the claims process so
                    smooth. Highly recommended!"</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center mb-4">
                    <div
                        class="h-12 w-12 rounded-full bg-primary flex items-center justify-center text-white font-bold mr-4">
                        KO</div>
                    <div>
                        <h4 class="font-bold">Kevin Ochieng</h4>
                        <p class="text-gray-600 text-sm">Kisumu</p>
                    </div>
                </div>
                <p class="text-gray-700">"The life insurance policy I got gives me peace of mind knowing my family will
                    be taken care of."</p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="bg-primary text-white rounded-xl p-8 md:p-12 mb-16">
        <h2 class="text-3xl font-serif font-bold mb-6">Get in Touch</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Contact Information</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-secondary mr-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Victoria Plaza, 3rd Floor, Moi Avenue, Nairobi, Kenya</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-secondary mr-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+254 700 123 456</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-secondary mr-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>info@dwininsurance.co.ke</span>
                    </div>
                </div>
                <div class="mt-8">
                    <h4 class="font-bold mb-3">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary transition duration-300">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary transition duration-300">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary transition duration-300">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#"
                            class="h-10 w-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary transition duration-300">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4">Request a Quote</h3>
                <form class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" id="name"
                            class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" id="email"
                            class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium mb-1">Phone</label>
                        <input type="tel" id="phone"
                            class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-secondary">
                    </div>
                    <div>
                        <label for="service" class="block text-sm font-medium mb-1">Service Interested In</label>
                        <select id="service"
                            class="w-full px-4 py-2 rounded-lg bg-white bg-opacity-20 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-secondary">
                            <option>General Insurance</option>
                            <option>Health Insurance</option>
                            <option>Life Insurance</option>
                            <option>Not Sure</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full bg-secondary hover:bg-yellow-600 text-primary font-bold py-3 px-4 rounded-lg transition duration-300">Submit
                        Request</button>
                </form>
            </div>
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
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Home</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">About Us</a>
                    </li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Services</a>
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
                    <li><a href="/login" class="text-gray-400 hover:text-white transition duration-300">Staff
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

</html>
