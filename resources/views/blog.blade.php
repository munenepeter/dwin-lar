<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog - DWIN Insurance</title>

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
                    <a href="/contact"
                        class="text-gray-700 hover:text-primary font-medium px-3 py-2 relative group transition duration-300">
                        Contact Us
                        <span
                            class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="/blog"
                        class="text-primary font-medium px-3 py-2 relative group transition duration-300">
                        Blog
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary"></span>
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
                <a href="/contact" class="block px-3 py-2 text-gray-700 hover:text-primary font-medium">Contact Us</a>
                <a href="/blog" class="block px-3 py-2 text-primary font-medium">Blog</a>
                <a href="#quote"
                    class="block w-full text-center bg-primary text-white font-medium px-6 py-2 rounded-lg mt-2">Get
                    Quote</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="welcome bg-gradient-to-r from-primary to-accent rounded-xl p-8 md:p-12 text-white mb-16 shadow-lg">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold mb-4">Insurance Insights & Tips</h1>
            <p class="text-lg md:text-xl max-w-3xl mb-6">Stay informed with the latest insurance news, tips, and expert advice to help you make better decisions about your protection.</p>
        </div>

        <!-- Featured Article -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-primary mb-8">Featured Article</h2>
            <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img src="{{ asset('imgs/insurance.jpeg') }}" alt="Featured Article" class="w-full h-64 md:h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-8">
                        <div class="flex items-center mb-4">
                            <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full">Featured</span>
                            <span class="text-gray-500 text-sm ml-4">December 15, 2024</span>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-4">Understanding Comprehensive Insurance: What You Need to Know</h3>
                        <p class="text-gray-700 mb-6">
                            Comprehensive insurance provides extensive coverage for your vehicle beyond basic third-party protection. 
                            Learn about the benefits, coverage limits, and when it makes sense to choose comprehensive over other 
                            insurance options.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">DM</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">David Mwangi</p>
                                    <p class="text-sm text-gray-600">Insurance Expert</p>
                                </div>
                            </div>
                            <a href="#" class="bg-primary hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Categories -->
        <div class="mb-12">
            <h2 class="text-2xl font-serif font-bold text-primary mb-6">Browse by Category</h2>
            <div class="flex flex-wrap gap-4">
                <button class="bg-primary text-white px-6 py-2 rounded-full font-medium transition duration-300">All Articles</button>
                <button class="bg-gray-200 text-gray-700 hover:bg-primary hover:text-white px-6 py-2 rounded-full font-medium transition duration-300">Motor Insurance</button>
                <button class="bg-gray-200 text-gray-700 hover:bg-primary hover:text-white px-6 py-2 rounded-full font-medium transition duration-300">Health Insurance</button>
                <button class="bg-gray-200 text-gray-700 hover:bg-primary hover:text-white px-6 py-2 rounded-full font-medium transition duration-300">Life Insurance</button>
                <button class="bg-gray-200 text-gray-700 hover:bg-primary hover:text-white px-6 py-2 rounded-full font-medium transition duration-300">Tips & Advice</button>
            </div>
        </div>

        <!-- Blog Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Article 1 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                <img src="{{ asset('imgs/GI.jpeg') }}" alt="Motor Insurance Tips" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-accent text-white text-xs font-semibold px-3 py-1 rounded-full">Motor Insurance</span>
                        <span class="text-gray-500 text-sm ml-4">December 10, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">5 Essential Tips for Choosing Motor Insurance</h3>
                    <p class="text-gray-700 mb-4">
                        Discover the key factors to consider when selecting motor insurance coverage that fits your needs and budget.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-accent rounded-full flex items-center justify-center mr-2">
                                <span class="text-white font-bold text-xs">SW</span>
                            </div>
                            <span class="text-sm text-gray-600">Sarah Wanjiku</span>
                        </div>
                        <a href="#" class="text-primary hover:text-blue-800 font-medium">Read More →</a>
                    </div>
                </div>
            </article>

            <!-- Article 2 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                <img src="{{ asset('imgs/HI.jpeg') }}" alt="Health Insurance Guide" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-secondary text-primary text-xs font-semibold px-3 py-1 rounded-full">Health Insurance</span>
                        <span class="text-gray-500 text-sm ml-4">December 8, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Understanding Health Insurance Benefits in Kenya</h3>
                    <p class="text-gray-700 mb-4">
                        A comprehensive guide to health insurance benefits, coverage options, and how to maximize your policy.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-secondary rounded-full flex items-center justify-center mr-2">
                                <span class="text-primary font-bold text-xs">JK</span>
                            </div>
                            <span class="text-sm text-gray-600">James Kiprop</span>
                        </div>
                        <a href="#" class="text-primary hover:text-blue-800 font-medium">Read More →</a>
                    </div>
                </div>
            </article>

            <!-- Article 3 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                <img src="{{ asset('imgs/LI.jpeg') }}" alt="Life Insurance Planning" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full">Life Insurance</span>
                        <span class="text-gray-500 text-sm ml-4">December 5, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Life Insurance Planning for Young Families</h3>
                    <p class="text-gray-700 mb-4">
                        Learn how to protect your family's financial future with the right life insurance strategy.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center mr-2">
                                <span class="text-white font-bold text-xs">DM</span>
                            </div>
                            <span class="text-sm text-gray-600">David Mwangi</span>
                        </div>
                        <a href="#" class="text-primary hover:text-blue-800 font-medium">Read More →</a>
                    </div>
                </div>
            </article>

            <!-- Article 4 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-accent text-white text-xs font-semibold px-3 py-1 rounded-full">Tips & Advice</span>
                        <span class="text-gray-500 text-sm ml-4">December 3, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">How to File an Insurance Claim Successfully</h3>
                    <p class="text-gray-700 mb-4">
                        Step-by-step guide to filing insurance claims efficiently and ensuring quick processing.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-accent rounded-full flex items-center justify-center mr-2">
                                <span class="text-white font-bold text-xs">SW</span>
                            </div>
                            <span class="text-sm text-gray-600">Sarah Wanjiku</span>
                        </div>
                        <a href="#" class="text-primary hover:text-blue-800 font-medium">Read More →</a>
                    </div>
                </div>
            </article>

            <!-- Article 5 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-secondary text-primary text-xs font-semibold px-3 py-1 rounded-full">Property Insurance</span>
                        <span class="text-gray-500 text-sm ml-4">November 28, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Protecting Your Home: Property Insurance Essentials</h3>
                    <p class="text-gray-700 mb-4">
                        Everything you need to know about property insurance to safeguard your most valuable asset.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-secondary rounded-full flex items-center justify-center mr-2">
                                <span class="text-primary font-bold text-xs">JK</span>
                            </div>
                            <span class="text-sm text-gray-600">James Kiprop</span>
                        </div>
                        <a href="#" class="text-primary hover:text-blue-800 font-medium">Read More →</a>
                    </div>
                </div>
            </article>

            <!-- Article 6 -->
            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full">Travel Insurance</span>
                        <span class="text-gray-500 text-sm ml-4">November 25, 2024</span>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Travel Insurance: Your Safety Net Abroad</h3>
                    <p class="text-gray-700 mb-4">
                        Why travel insurance is essential for your next trip and what coverage you should consider.
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center mr-2">
                                <span class="text-white font-bold text-xs">DM</span>
                            </div>
                            <span class="text-sm text-gray-600">David Mwangi</span>
                        </div>
                        <a href="#" class="text-primary hover:text-blue-800 font-medium">Read More →</a>
                    </div>
                </div>
            </article>
        </div>

        <!-- Newsletter Subscription -->
        <div class="bg-gray-100 rounded-xl p-8 mb-16">
            <div class="text-center">
                <h2 class="text-3xl font-serif font-bold text-primary mb-4">Stay Updated</h2>
                <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
                    Subscribe to our newsletter for the latest insurance insights, tips, and exclusive offers delivered to your inbox.
                </p>
                <form class="max-w-md mx-auto flex gap-4">
                    <input type="email" placeholder="Enter your email address" 
                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <button type="submit" 
                            class="bg-primary hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Popular Topics -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-primary mb-8">Popular Topics</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="h-12 w-12 bg-primary rounded-full flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary mb-2">Claims Process</h3>
                    <p class="text-gray-600 text-sm">Learn how to file and track your insurance claims efficiently.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="h-12 w-12 bg-accent rounded-full flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary mb-2">Premium Tips</h3>
                    <p class="text-gray-600 text-sm">Discover ways to reduce your insurance premiums without compromising coverage.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="h-12 w-12 bg-secondary rounded-full flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary mb-2">Coverage Guide</h3>
                    <p class="text-gray-600 text-sm">Understand different types of insurance coverage and what they protect.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="h-12 w-12 bg-primary rounded-full flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-primary mb-2">Family Protection</h3>
                    <p class="text-gray-600 text-sm">Essential insurance products to protect your family's financial future.</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary text-white rounded-xl p-8 md:p-12 text-center">
            <h2 class="text-3xl font-serif font-bold mb-4">Need Personalized Insurance Advice?</h2>
            <p class="text-lg mb-6 max-w-2xl mx-auto">
                Our insurance experts are ready to help you find the perfect coverage for your unique needs. 
                Get a free consultation today.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/contact"
                    class="bg-secondary hover:bg-yellow-600 text-primary font-bold py-3 px-6 rounded-lg transition duration-300">
                    Get Free Consultation
                </a>
                <a href="/products"
                    class="border-2 border-white hover:bg-white hover:text-primary font-semibold py-3 px-6 rounded-lg transition duration-300">
                    View Our Products
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

        // Category filter buttons
        document.querySelectorAll('button[class*="bg-gray-200"]').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active state from all buttons
                document.querySelectorAll('button').forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                // Add active state to clicked button
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('bg-primary', 'text-white');
            });
        });

        // Newsletter subscription
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                alert('Thank you for subscribing to our newsletter!');
                this.reset();
            }
        });
    </script>
</body>

</html>

