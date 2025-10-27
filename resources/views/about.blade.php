<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>About Us - DWIN Insurance</title>

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
                        class="text-primary font-medium px-3 py-2 relative group transition duration-300">
                        About Us
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary"></span>
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
                <a href="/about" class="block px-3 py-2 text-primary font-medium">About Us</a>
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
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold mb-4">About DWIN Insurance</h1>
            <p class="text-lg md:text-xl max-w-3xl mb-6">Your trusted partner in protecting what matters most. We've been serving Kenya with excellence since 2008.</p>
        </div>

        <!-- Company Story Section -->
        <div class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-serif font-bold text-primary mb-6">Our Story</h2>
                    <p class="text-gray-700 mb-4">
                        Founded in 2010, DWIN Insurance Agency began with a simple mission: to provide comprehensive, 
                        affordable insurance solutions to Kenyan families and businesses. What started as a small 
                        agency in Nairobi has grown into one of Kenya's most trusted insurance partners.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Over the years, we've built strong relationships with leading insurance companies and 
                        developed innovative products that meet the unique needs of our diverse clientele. Our 
                        commitment to excellence and customer satisfaction has earned us recognition as a 
                        reliable partner in risk management.
                    </p>
                    <p class="text-gray-700">
                        Today, we continue to expand our services while maintaining the personal touch that 
                        has defined us from the beginning. Every client relationship is built on trust, 
                        transparency, and a genuine commitment to their financial security.
                    </p>
                </div>
                <div class="bg-gray-100 rounded-xl p-8">
                    <img src="{{ asset('imgs/insurance.jpeg') }}" alt="DWIN Insurance Office" 
                         class="w-full h-64 object-cover rounded-lg shadow-md">
                </div>
            </div>
        </div>

        <!-- Mission, Vision, Values -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-12">Our Foundation</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Mission -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="h-16 w-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-4">Our Mission</h3>
                        <p class="text-gray-700">
                            To provide comprehensive insurance solutions that protect our clients' assets, 
                            families, and businesses while delivering exceptional service and peace of mind.
                        </p>
                    </div>
                </div>

                <!-- Vision -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="h-16 w-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-4">Our Vision</h3>
                        <p class="text-gray-700">
                            To be Kenya's leading insurance agency, known for innovation, integrity, and 
                            unwavering commitment to our clients' financial security and well-being.
                        </p>
                    </div>
                </div>

                <!-- Values -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <div class="h-16 w-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-4">Our Values</h3>
                        <p class="text-gray-700">
                            Integrity, transparency, customer focus, innovation, and community responsibility 
                            guide everything we do in serving our clients and building lasting relationships.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-12">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                        <div class="h-24 w-24 bg-white rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary">ES</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary mb-2">Edwin Essendi</h3>
                        <p class="text-accent font-semibold mb-2">Managing Director</p>
                        <p class="text-gray-700 text-sm">
                            With over 15 years in insurance, Edwin leads our team with vision and expertise 
                            in risk management and client relations.
                        </p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-accent to-secondary flex items-center justify-center">
                        <div class="h-24 w-24 bg-white rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary">MW</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary mb-2">Mary Essendi</h3>
                        <p class="text-accent font-semibold mb-2">Head of Operations</p>
                        <p class="text-gray-700 text-sm">
                            Mary ensures smooth operations and exceptional customer service, bringing 
                            5 years of insurance experience to our team.
                        </p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gradient-to-br from-secondary to-primary flex items-center justify-center">
                        <div class="h-24 w-24 bg-white rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary">PM</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-primary mb-2">Peter Munene</h3>
                        <p class="text-accent font-semibold mb-2">IT & Dev Consultant</p>
                        <p class="text-gray-700 text-sm">
                            Peter specializes in IT and Dev Consulting and has a background in software development in over 5 years. Also Peter, is our IT & Dev Consultant
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="bg-gray-100 rounded-xl p-8 mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-12">Why Choose DWIN Insurance?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="h-16 w-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Licensed & Regulated</h3>
                    <p class="text-gray-700 text-sm">Fully licensed by the Insurance Regulatory Authority of Kenya</p>
                </div>

                <div class="text-center">
                    <div class="h-16 w-16 bg-accent rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">24/7 Support</h3>
                    <p class="text-gray-700 text-sm">Round-the-clock customer support for all your insurance needs</p>
                </div>

                <div class="text-center">
                    <div class="h-16 w-16 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Competitive Rates</h3>
                    <p class="text-gray-700 text-sm">Best-in-market rates with flexible payment options</p>
                </div>

                <div class="text-center">
                    <div class="h-16 w-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-primary mb-2">Personalized Service</h3>
                    <p class="text-gray-700 text-sm">Tailored insurance solutions that fit your unique needs</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary text-white rounded-xl p-8 md:p-12 text-center">
            <h2 class="text-3xl font-serif font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg mb-6 max-w-2xl mx-auto">
                Join thousands of satisfied customers who trust DWIN Insurance for their protection needs.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/contact"
                    class="bg-secondary hover:bg-yellow-600 text-primary font-bold py-3 px-6 rounded-lg transition duration-300">
                    Get a Quote
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
    </script>
</body>

</html>
