<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voxa AI - Futuristic Conversational Assistant</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#6366f1',
                        secondary: '#a855f7',
                        dark: '#0f172a',
                    },
                    animation: {
                        // Animations removed
                    },
                    keyframes: {
                        // Keyframes removed
                    }
                }
            }
        }
    </script>

    <style type="text/css">
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .dark .glass {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-mesh {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }

        .light-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,100%,95%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,100%,95%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,100%,95%,1) 0, transparent 50%);
        }
    </style>
</head>
<body class="transition-colors duration-500 bg-mesh dark:text-white text-dark overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center glass rounded-2xl px-6 py-3 shadow-2xl">
            <div class="flex items-center gap-2">
                <div class="bg-primary p-2 rounded-lg">
                    <i class="fas fa-robot text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold tracking-tight dark:text-white">Voxa<span class="text-primary">AI</span></span>
            </div>
            
            <div class="flex items-center gap-4">
                <button id="theme-toggle" class="p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <i id="theme-icon" class="fas fa-moon text-xl text-gray-400"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 px-6 overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-1/4 -left-20 w-72 h-72 bg-primary/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-secondary/20 rounded-full blur-[100px]"></div>

        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left space-y-8 relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm font-medium text-primary">
                    <i class="fas fa-sparkles"></i>
                    <span>Next-Gen Conversational AI</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
                    Welcome to <span class="gradient-text">Voxa AI</span><br>
                    Your Personal Assistant
                </h1>
                
                <p class="text-xl text-gray-400 max-w-xl mx-auto lg:mx-0">
                    Your fun AI assistant for voice and text conversations. 
                    Chat, speak, and explore ideas instantly with Voxa AI 🚀
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-primary hover:bg-indigo-600 text-white rounded-2xl font-bold text-lg transition-all transform hover:scale-105 shadow-xl shadow-primary/30 flex items-center justify-center gap-3">
                        <i class="fas fa-paper-plane"></i>
                        Start Chatbot
                    </a>
                </div>
                
                <div class="flex items-center justify-center lg:justify-start gap-8 pt-8 opacity-50">
                    <div class="text-center">
                        <div class="text-2xl font-bold">99%</div>
                        <div class="text-xs uppercase tracking-widest">Accuracy</div>
                    </div>
                    <div class="w-px h-10 bg-gray-700"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">24/7</div>
                        <div class="text-xs uppercase tracking-widest">Availability</div>
                    </div>
                    <div class="w-px h-10 bg-gray-700"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">Fast</div>
                        <div class="text-xs uppercase tracking-widest">Response</div>
                    </div>
                </div>
            </div>

            <div class="relative lg:block flex justify-center">
                <div class="relative w-full max-w-lg">
                    <!-- Image Backdrop -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-secondary rounded-full blur-[80px] opacity-30"></div>
                    <!-- Main Bot Image -->
                    <img src="{{ asset('voxa_bot.png') }}" alt="Voxa Bot" class="relative z-10 w-full drop-shadow-[0_35px_35px_rgba(99,102,241,0.5)]">
                </div>
                
                <!-- Floating Elements -->
                <div class="absolute top-10 right-0 glass p-4 rounded-2xl shadow-2xl">
                    <i class="fas fa-message text-primary text-2xl"></i>
                </div>
                <div class="absolute bottom-10 left-0 glass p-4 rounded-2xl shadow-2xl">
                    <i class="fas fa-microphone text-secondary text-2xl"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 px-6 relative z-10">
        <div class="max-w-7xl mx-auto border-t border-gray-800 pt-8 flex flex-col md:row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold">Voxa<span class="text-primary">AI</span></span>
            </div>
            <p class="text-gray-500 text-sm">
                Powered by Laravel 12 & AI
            </p>
            <div class="flex gap-6 text-gray-500">
                <a href="#" class="hover:text-primary transition-colors"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-primary transition-colors"><i class="fab fa-github"></i></a>
                <a href="#" class="hover:text-primary transition-colors"><i class="fab fa-discord"></i></a>
            </div>
        </div>
    </footer>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'light') {
            body.classList.add('light-mode');
            body.classList.remove('bg-mesh');
            body.classList.add('light-mesh');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }

        themeToggleBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                body.classList.remove('light-mesh');
                body.classList.add('bg-mesh');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('bg-mesh');
                body.classList.add('light-mesh');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>
</html>
