<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contact Us - DWIN Insurance</title>

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
                        class="text-primary font-medium px-3 py-2 relative group transition duration-300">
                        Contact Us
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary"></span>
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
                <a href="/contact" class="block px-3 py-2 text-primary font-medium">Contact Us</a>
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
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif font-bold mb-4">Contact Us</h1>
            <p class="text-lg md:text-xl max-w-3xl mb-6">Get in touch with our insurance experts. We're here to help you find the perfect coverage for your needs.</p>
        </div>

        <!-- Contact Information and Form -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-serif font-bold text-primary mb-8">Get in Touch</h2>
                
                <!-- Office Information -->
                <div class="bg-white rounded-xl p-8 shadow-md mb-8">
                    <h3 class="text-xl font-bold text-primary mb-6">Our Office</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-accent mr-4 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Head Office</h4>
                                <p class="text-gray-700">Victoria Plaza, 3rd Floor<br>Moi Avenue, Nairobi, Kenya</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-accent mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Phone</h4>
                                <p class="text-gray-700">+254 700 123 456</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-accent mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-700">info@dwininsurance.co.ke</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="bg-white rounded-xl p-8 shadow-md mb-8">
                    <h3 class="text-xl font-bold text-primary mb-6">Business Hours</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-700">Monday - Friday</span>
                            <span class="font-semibold text-gray-900">8:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Saturday</span>
                            <span class="font-semibold text-gray-900">9:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Sunday</span>
                            <span class="font-semibold text-gray-900">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="bg-accent rounded-xl p-8 text-white">
                    <h3 class="text-xl font-bold mb-4">Emergency Claims</h3>
                    <p class="mb-4">For urgent claims and emergencies outside business hours:</p>
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-lg font-bold">+254 700 123 999</span>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <h3 class="text-2xl font-bold text-primary mb-6">Send us a Message</h3>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" id="firstName" name="firstName" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" id="lastName" name="lastName" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300">
                        </div>

                        <div>
                            <label for="service" class="block text-sm font-medium text-gray-700 mb-2">Service Interested In</label>
                            <select id="service" name="service"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300">
                                <option value="">Select a service</option>
                                <option value="motor">Motor Insurance</option>
                                <option value="health">Health Insurance</option>
                                <option value="life">Life Insurance</option>
                                <option value="property">Property Insurance</option>
                                <option value="travel">Travel Insurance</option>
                                <option value="business">Business Insurance</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition duration-300"
                                placeholder="Tell us about your insurance needs..."></textarea>
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" id="newsletter" name="newsletter" 
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded mt-1">
                            <label for="newsletter" class="ml-2 text-sm text-gray-700">
                                I would like to receive updates about new insurance products and offers.
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-primary hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-8">Find Us</h2>
            <div class="bg-gray-200 rounded-xl p-8 text-center">
                <div class="bg-white rounded-lg p-8 shadow-md">
                    <svg class="h-16 w-16 text-primary mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="text-xl font-bold text-primary mb-2">Victoria Plaza, 3rd Floor</h3>
                    <p class="text-gray-700 mb-4">Moi Avenue, Nairobi, Kenya</p>
                    <p class="text-sm text-gray-600">
                        Located in the heart of Nairobi's business district, easily accessible by public transport and private vehicles.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-serif font-bold text-center text-primary mb-12">Frequently Asked Questions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-bold text-primary mb-3">How do I file a claim?</h3>
                    <p class="text-gray-700">
                        You can file a claim by calling our claims hotline at +254 700 123 999, visiting our office, 
                        or through our online portal. We'll guide you through the entire process.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-bold text-primary mb-3">What documents do I need?</h3>
                    <p class="text-gray-700">
                        Required documents vary by insurance type. Generally, you'll need ID, proof of ownership, 
                        and relevant certificates. Our team will provide a complete checklist.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-bold text-primary mb-3">How long does it take to process claims?</h3>
                    <p class="text-gray-700">
                        Most claims are processed within 7-14 business days, depending on the complexity and 
                        completeness of documentation provided.
                    </p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md">
                    <h3 class="text-lg font-bold text-primary mb-3">Can I get a quote online?</h3>
                    <p class="text-gray-700">
                        Yes! Use our contact form above or call us directly. We'll provide personalized quotes 
                        based on your specific needs and circumstances.
                    </p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-primary text-white rounded-xl p-8 md:p-12 text-center">
            <h2 class="text-3xl font-serif font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg mb-6 max-w-2xl mx-auto">
                Don't wait to protect what matters most. Contact us today for a free consultation and personalized quote.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:+254700123456"
                    class="bg-secondary hover:bg-yellow-600 text-primary font-bold py-3 px-6 rounded-lg transition duration-300">
                    Call Us Now
                </a>
                <a href="mailto:info@dwininsurance.co.ke"
                    class="border-2 border-white hover:bg-white hover:text-primary font-semibold py-3 px-6 rounded-lg transition duration-300">
                    Send Email
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

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Simple validation
            if (!data.firstName || !data.lastName || !data.email || !data.message) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Simulate form submission
            alert('Thank you for your message! We will get back to you within 24 hours.');
            this.reset();
        });
    </script>
</body>

</html>

