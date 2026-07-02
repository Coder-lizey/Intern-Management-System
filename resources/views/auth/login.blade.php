

<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>InternSync - Internship Management System</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "primary": "#1e60d4",
                      "primary-hover": "#164fa8",
                      "error": "#ba1a1a",
                      "input-bg": "#f0f4fd",
                      "input-bg-dark": "#161920"
              },
              "fontFamily": {
                      "sans": ["Hanken Grotesk", "sans-serif"]
              }
            },
          },
        }
    </script>
    <style>
        .dark body { background-color: #0b0f19 !important; }
        .login-input { transition: all 0.2s ease; }
        .login-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(30, 96, 212, 0.2); }
        .wave-layer { position: absolute; top: 0; right: -1px; height: 100%; width: 80px; fill: #ffffff; transition: fill 0.3s ease; }
        .dark .wave-layer { fill: #11141d; }
    </style>
</head>
<body class="bg-[#eef4ff] dark:bg-[#0b0f19] min-h-screen flex items-center justify-center p-4 md:p-8 transition-colors duration-300">

<div class="fixed top-6 right-6 z-50">
    <button aria-label="Toggle theme" class="p-2.5 rounded-full bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 hover:border-primary dark:hover:border-blue-500 transition-all duration-200 shadow-sm flex items-center justify-center" id="theme-toggle">
        <span class="material-symbols-outlined text-[20px] dark:hidden text-slate-600">dark_mode</span>
        <span class="material-symbols-outlined text-[20px] hidden dark:block text-blue-400">light_mode</span>
    </button>
</div>

<div class="w-full max-w-5xl min-h-[620px] bg-white dark:bg-[#11141d] rounded-[32px] shadow-2xl overflow-hidden flex flex-col md:flex-row transition-all duration-300">
    
    <div class="relative w-full md:w-[45%] bg-gradient-to-b from-blue-600 to-primary p-8 md:p-12 flex flex-col justify-between items-start text-left text-white overflow-hidden select-none z-10">
        <div class="w-full flex items-center justify-start gap-3 mt-2 z-20">
            <img src="{{ asset('images/Verge.png') }}" alt="Verge Systems Logo" class="h-8 w-auto object-contain drop-shadow-md" />
            <span class="font-serif text-xl font-bold tracking-wide text-white drop-shadow-sm">Verge Systems</span>
        </div>

        <div class="flex flex-col items-start my-auto py-8 z-20 max-w-sm">
            <span class="text-[10px] font-bold uppercase tracking-[0.25em] bg-white/15 px-3 py-1 rounded-md mb-5 backdrop-blur-sm text-blue-100 block">Enterprise Workspace</span>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight text-white font-sans">
                Intern Management <br /> System <span class="text-blue-200 font-bold">(IMS)</span>
            </h1>
            <p class="text-xs md:text-sm opacity-90 mt-5 leading-relaxed font-normal text-blue-50/90 pr-4">
                A premium, centralized workspace engineering core talent alignment. Seamlessly submit daily milestones, track logic-building exercises, and report weekly performance analytics directly to project mentors.
            </p>
        </div>

        <div class="text-[11px] font-semibold opacity-75 flex items-center gap-4 mt-2 z-20 tracking-wider">
            <a href="#" class="hover:text-white hover:underline transition-all uppercase">Create Here</a>
            <span class="opacity-30">|</span>
            <a href="#" class="hover:text-white hover:underline transition-all uppercase">Discover Here</a>
        </div>

        <div class="hidden md:block absolute right-0 top-0 bottom-0 w-12 pointer-events-none z-0">
            <svg class="h-full w-full fill-white dark:fill-[#11141d] transition-colors duration-300" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M100,0 C30,20 70,50 0,100 L100,100 Z"></path>
            </svg>
        </div>
    </div>

    <div class="flex-1 p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white dark:bg-[#11141d] transition-all duration-300 z-20">
        
        <div class="flex bg-slate-100 dark:bg-zinc-900 p-1 rounded-xl max-w-xs mx-auto mb-8 w-full shadow-inner">
            <button type="button" class="flex-1 py-2 text-xs font-bold rounded-lg bg-primary text-white shadow transition-all duration-300" id="mentor-toggle">Mentor</button>
            <button type="button" class="flex-1 py-2 text-xs font-bold rounded-lg text-slate-600 dark:text-zinc-400 transition-all duration-300" id="intern-toggle">Intern</button>
        </div>
         
        <div class="text-center md:text-left mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white tracking-tight" id="login-title">Mentor Login</h2>
            <p class="text-body-md text-on-surface-variant dark:text-zinc-400 mt-1 font-normal">Choose your role to access your dashboard</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 max-w-md mx-auto md:mx-0 w-full text-xs text-red-600 bg-red-50 dark:bg-red-950/30 dark:text-red-400 p-3 rounded-xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="space-y-4 max-w-md mx-auto md:mx-0 w-full" id="login-form" method="POST" action="{{ route('custom.login') }}">
            @csrf
            <input type="hidden" name="role" id="role-input" value="mentor">

            <div class="space-y-1">
                <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400">Email Address</label>
                <div class="relative group">
                    <input id="email-input" name="email" class="w-full h-11 px-4 rounded-xl border-none font-medium bg-[#f0f4fd] dark:bg-zinc-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all duration-200 login-input" placeholder="name@company.com" type="email" value="{{ old('email') }}" required/>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center justify-center">
                        <span id="email-valid-icon" class="material-symbols-outlined text-green-500 text-[20px] hidden">check_circle</span>
                        <span id="email-invalid-icon" class="material-symbols-outlined text-error text-[20px] hidden">cancel</span>
                    </div>
                </div>
                <p id="email-error" class="text-xs text-error hidden mt-1">This email address is invalid.</p>
            </div>

            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <label class="block text-xs font-semibold text-slate-600 dark:text-zinc-400">Password</label>
                    <a class="text-xs text-primary dark:text-blue-400 hover:underline font-medium" href="#">Forgot Password?</a>
                </div>
                <div class="relative group">
                    <input id="password-input" name="password" class="w-full h-11 px-4 pr-10 rounded-xl border-none font-medium bg-[#f0f4fd] dark:bg-zinc-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all duration-200 login-input" placeholder="••••••••" type="password" required/>
                    <button id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors flex items-center justify-center" type="button">
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-2 pt-1">
                <input type="checkbox" name="remember" id="terms" class="rounded text-primary focus:ring-primary border-slate-300 dark:border-zinc-700 bg-[#f0f4fd] dark:bg-zinc-800 h-4 w-4"/>
                <label for="terms" class="text-xs text-slate-500 dark:text-zinc-400 select-none">Remember login device</label>
            </div>

            <button class="w-full h-12 mt-4 bg-gradient-to-r from-primary to-blue-500 hover:from-primary-hover hover:to-blue-600 text-white rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg transform active:scale-[0.99]" type="submit">
                Sign In
            </button>
        </form>

        <div class="max-w-md mx-auto md:mx-0 w-full mt-6">
            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-slate-200 dark:border-zinc-800"></div>
                <span class="flex-shrink mx-4 text-slate-400 dark:text-zinc-500 text-xs font-medium">System Access</span>
                <div class="flex-grow border-t border-slate-200 dark:border-zinc-800"></div>
            </div>
            <div class="text-center mt-6">
                <p class="text-xs text-slate-500 dark:text-zinc-400">Don't have an account? <a class="text-primary dark:text-blue-400 hover:underline font-bold" href="#">Contact Administrator</a></p>
            </div>
        </div>

    </div>
</div>

<script>
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    const mentorToggle = document.getElementById('mentor-toggle');
    const internToggle = document.getElementById('intern-toggle');
    const loginTitle = document.getElementById('login-title');
    const roleInput = document.getElementById('role-input');
    const passwordInput = document.getElementById('password-input');
    const togglePassword = document.getElementById('toggle-password');

    themeToggle.addEventListener('click', () => {
        if (htmlElement.classList.contains('dark')) {
            htmlElement.classList.remove('dark'); htmlElement.classList.add('light');
            localStorage.setItem('theme', 'light');
        } else {
            htmlElement.classList.remove('light'); htmlElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    });

    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark'); htmlElement.classList.remove('light');
    }

    mentorToggle.addEventListener('click', () => {
        mentorToggle.className = "flex-1 py-2 text-xs font-bold rounded-lg bg-primary text-white shadow transition-all duration-300";
        internToggle.className = "flex-1 py-2 text-xs font-bold rounded-lg text-slate-600 dark:text-zinc-400 transition-all duration-300";
        loginTitle.textContent = 'Mentor Login';
        roleInput.value = 'mentor'; // Set context to mentor
    });

    internToggle.addEventListener('click', () => {
        internToggle.className = "flex-1 py-2 text-xs font-bold rounded-lg bg-primary text-white shadow transition-all duration-300";
        mentorToggle.className = "flex-1 py-2 text-xs font-bold rounded-lg text-slate-600 dark:text-zinc-400 transition-all duration-300";
        loginTitle.textContent = 'Intern Login';
        roleInput.value = 'intern'; // Set context to intern
    });

    togglePassword.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        togglePassword.querySelector('span').textContent = isPassword ? 'visibility_off' : 'visibility';
    });

    const emailInput = document.getElementById('email-input');
    const emailError = document.getElementById('email-error');
    const validIcon = document.getElementById('email-valid-icon');
    const invalidIcon = document.getElementById('email-invalid-icon');
    let isEmailVerified = true;

    emailInput.addEventListener('input', () => {
        const email = emailInput.value.trim();
        if (!email) {
            validIcon.classList.add('hidden'); invalidIcon.classList.add('hidden');
            emailError.classList.add('hidden'); return;
        }
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (regex.test(email)) {
            validIcon.classList.remove('hidden'); invalidIcon.classList.add('hidden');
            emailError.classList.add('hidden'); isEmailVerified = true;
        } else {
            validIcon.classList.add('hidden'); invalidIcon.classList.remove('hidden');
            isEmailVerified = false;
        }
    });

    document.getElementById('login-form').addEventListener('submit', (e) => {
        if (!isEmailVerified) {
            e.preventDefault();
            emailError.classList.remove('hidden');
        }
    });
</script>
</body>
</html>