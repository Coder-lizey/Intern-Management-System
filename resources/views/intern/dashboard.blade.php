
</html>

<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Verge Systems - Intern Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Load Design System Configuration -->
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-tertiary-fixed-variant": "#38485d",
                    "tertiary-fixed": "#d3e4fe",
                    "surface-dim": "#d8dadc",
                    "inverse-surface": "#2d3133",
                    "on-surface-variant": "#454556",
                    "on-tertiary-fixed": "#0b1c30",
                    "secondary-container": "#dae2fd",
                    "outline": "#757688",
                    "on-secondary": "#ffffff",
                    "tertiary-container": "#5c6c83",
                    "secondary": "#565e74",
                    "primary-container": "#4353ff",
                    "on-primary-container": "#eceaff",
                    "primary-fixed-dim": "#bdc2ff",
                    "outline-variant": "#c5c5d9",
                    "primary": "#2333e7",
                    "on-error": "#ffffff",
                    "on-primary": "#ffffff",
                    "on-secondary-fixed": "#131b2e",
                    "surface-bright": "#f7f9fb",
                    "on-secondary-fixed-variant": "#3f465c",
                    "secondary-fixed-dim": "#bec6e0",
                    "background": "#f7f9fb",
                    "secondary-fixed": "#dae2fd",
                    "on-tertiary": "#ffffff",
                    "on-surface": "#191c1e",
                    "tertiary": "#44546a",
                    "surface-container-low": "#f2f4f6",
                    "inverse-primary": "#bdc2ff",
                    "surface-tint": "#3444f2",
                    "tertiary-fixed-dim": "#b7c8e1",
                    "surface-container-high": "#e6e8ea",
                    "surface-container": "#eceef0",
                    "primary-fixed": "#e0e0ff",
                    "surface-container-highest": "#e0e3e5",
                    "on-background": "#191c1e",
                    "surface-variant": "#e0e3e5",
                    "on-primary-fixed": "#000668",
                    "inverse-on-surface": "#eff1f3",
                    "error-container": "#ffdad6"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "2xl": "1rem",
                    "3xl": "1.5rem",
                    "full": "9999px"
            },
            "spacing": {
                    "sidebar-width": "260px",
                    "container-padding": "32px",
                    "card-gap": "20px",
                    "section-margin": "40px",
                    "gutter": "24px"
            },
            "fontFamily": {
                    "headline-md": ["Hanken Grotesk"],
                    "headline-lg": ["Hanken Grotesk"],
                    "body-lg": ["Hanken Grotesk"],
                    "label-sm": ["Hanken Grotesk"],
                    "label-xs": ["Hanken Grotesk"],
                    "body-md": ["Hanken Grotesk"]
            },
            "fontSize": {
                    "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "headline-lg": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                    "label-xs": ["11px", {"lineHeight": "14px", "fontWeight": "500"}],
                    "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
<style>
        body { font-family: 'Hanken Grotesk', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .ring-chart {
            background: radial-gradient(closest-side, white 79%, transparent 80% 100%),
                        conic-gradient(var(--chart-color) var(--percentage), #e2e8f0 0);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

    
            {{-- <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                    Logout
                </button>
            </form> --}}
       




{{-- Layout ko extend kar rahe hain --}}
@extends('layouts.intern')

{{-- Layout ke @yield('content') wali jagah par yeh data jayega --}}
@section('content')
    

<body class="bg-background text-on-surface flex min-h-screen">

<!-- TopAppBar Component -->

<!-- Content Area -->
<div class="flex-1 p-container-padding flex flex-col gap-section-margin">
<!-- Greeting -->
<section>
<h2 class="font-headline-lg text-headline-lg text-on-surface">Good Morning, Alex!</h2>
<div class="flex items-center gap-2 text-on-surface-variant mt-1">
<span class="material-symbols-outlined text-[18px]">calendar_month</span>
<p class="font-body-md text-body-md">Monday, October 23rd, 2023</p>
</div>
</section>
<!-- Hero Stats Grid -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-card-gap">
<!-- Attendance Card -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.04)] border border-outline-variant/30 flex items-center justify-between group hover:translate-y-[-2px] transition-all">
<div>
<p class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Attendance</p>
<h3 class="text-headline-lg font-bold text-on-surface">94.5%</h3>
<p class="text-label-xs font-label-xs text-primary mt-2 flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">trending_up</span> Above average
                        </p>
</div>
<div class="w-20 h-20 ring-chart rounded-full flex items-center justify-center" style="--percentage: 94.5%; --chart-color: #2333e7;">
<span class="material-symbols-outlined text-primary text-[28px]">verified_user</span>
</div>
</div>
<!-- Performance Card -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.04)] border border-outline-variant/30 flex items-center justify-between group hover:translate-y-[-2px] transition-all">
<div>
<p class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Performance</p>
<h3 class="text-headline-lg font-bold text-on-surface">4.8<span class="text-headline-md text-on-surface-variant font-medium">/5.0</span></h3>
<div class="flex gap-0.5 mt-2">
<span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">star_half</span>
</div>
</div>
<div class="w-20 h-20 ring-chart rounded-full flex items-center justify-center" style="--percentage: 96%; --chart-color: #5c6c83;">
<span class="material-symbols-outlined text-tertiary-container text-[28px]">monitoring</span>
</div>
</div>
<!-- Days Left Card -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-[0_20px_25px_-5px_rgba(0,0,0,0.04)] border border-outline-variant/30 flex items-center justify-between group hover:translate-y-[-2px] transition-all">
<div>
<p class="text-label-sm font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Program Status</p>
<h3 class="text-headline-lg font-bold text-on-surface">14 Days Left</h3>
<p class="text-label-xs font-label-xs text-on-surface-variant mt-2">Final evaluation: Nov 06</p>
</div>
<div class="w-20 h-20 bg-primary-container/10 rounded-2xl flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-[32px]">hourglass_bottom</span>
</div>
</div>
</section>
<!-- Middle Section: Active Task & Quick Actions -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-card-gap">
<!-- Current Task Card -->
<div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-8 border border-outline-variant/30 shadow-[0_10px_30px_-10px_rgba(35,51,231,0.08)] relative overflow-hidden">
<div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full translate-x-16 -translate-y-16"></div>
<div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
<div class="flex-1">
<div class="inline-flex items-center px-3 py-1 bg-secondary-container text-on-secondary-container text-label-xs rounded-full mb-4 font-bold">
                                ACTIVE TASK
                            </div>
<h4 class="text-headline-md font-bold text-on-surface mb-2">Mobile UI Refinement</h4>
<p class="text-body-md text-on-surface-variant mb-6 max-w-md leading-relaxed">
                                Updating the intern portal application flows to adhere to the new Design System v2.4 standards including token alignment.
                            </p>
<div class="space-y-3">
<div class="flex items-center justify-between">
<span class="text-label-sm text-on-surface-variant">Task Progress</span>
<span class="text-label-sm font-bold text-primary">70%</span>
</div>
<div class="w-full h-2 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-primary h-full w-[70%] rounded-full transition-all duration-1000"></div>
</div>
</div>
</div>
<div class="flex flex-col gap-3">
<button class="px-6 py-3 bg-primary text-on-primary font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform active:scale-95">
<span class="material-symbols-outlined text-[18px]">play_arrow</span>
                                Resume Task
                            </button>
<button class="px-6 py-3 bg-surface-container-high text-on-surface font-semibold rounded-xl hover:bg-surface-container-highest transition-colors">
                                View Briefing
                            </button>
</div>
</div>
</div>
<!-- Recent Activity Feed -->
<div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/30 shadow-sm flex flex-col">
<h4 class="text-headline-md font-bold mb-4">Upcoming Meetings</h4>
<div class="space-y-4 overflow-y-auto max-h-[220px] no-scrollbar">
<div class="flex items-start gap-4 p-3 hover:bg-surface-container-low rounded-xl transition-colors cursor-pointer group">
<div class="w-10 h-10 rounded-full bg-error-container text-on-error-container flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-[20px]">groups</span>
</div>
<div>
<p class="text-label-sm font-bold text-on-surface">Weekly Intern Sync</p>
<p class="text-label-xs text-on-surface-variant">10:30 AM • In 20 mins</p>
</div>
<span class="material-symbols-outlined ml-auto text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
</div>
<div class="flex items-start gap-4 p-3 hover:bg-surface-container-low rounded-xl transition-colors cursor-pointer group">
<div class="w-10 h-10 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-[20px]">person</span>
</div>
<div>
<p class="text-label-sm font-bold text-on-surface">Mentor 1:1 Check-in</p>
<p class="text-label-xs text-on-surface-variant">02:00 PM • Today</p>
</div>
<span class="material-symbols-outlined ml-auto text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
</div>
<div class="flex items-start gap-4 p-3 hover:bg-surface-container-low rounded-xl transition-colors cursor-pointer group">
<div class="w-10 h-10 rounded-full bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-[20px]">palette</span>
</div>
<div>
<p class="text-label-sm font-bold text-on-surface">Design Review</p>
<p class="text-label-xs text-on-surface-variant">09:00 AM • Tomorrow</p>
</div>
<span class="material-symbols-outlined ml-auto text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
</div>
</div>
<button class="mt-4 w-full text-label-sm text-primary font-bold hover:underline py-2">View Calendar</button>
</div>
</section>
<!-- Leaderboard Table Section -->
<section class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden mb-12">
<div class="px-8 py-6 border-b border-outline-variant flex items-center justify-between">
<div>
<h4 class="text-headline-md font-bold text-on-surface">Intern Rankings</h4>
<p class="text-label-sm text-on-surface-variant mt-1">October Performance Cycle</p>
</div>
<button class="flex items-center gap-2 text-label-sm font-bold text-primary border border-primary/20 px-4 py-2 rounded-lg hover:bg-primary/5 transition-colors">
<span class="material-symbols-outlined text-[18px]">download</span> Export Report
                    </button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-low">
<tr>
<th class="px-8 py-4 font-label-sm text-label-sm text-on-surface-variant">Rank</th>
<th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant">Intern Name</th>
<th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant">Status</th>
<th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant text-center">Attendance %</th>
<th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant text-center">Performance %</th>
<th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant text-right">Stars</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/30">
<!-- Alex (User) -->
<tr class="hover:bg-primary-container/5 transition-colors group">
<td class="px-8 py-4 font-bold text-primary">#1</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<img class="w-10 h-10 rounded-full border-2 border-primary object-cover" data-alt="Close-up portrait of a male intern with dark hair, very detailed skin texture, corporate headshot style, light-mode background with soft shadows, 8k resolution, professional lighting." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB2fZGHeUADzmI-Qw_HSQj7FMu9nHwAJDdNjfm3qCBh_TvFyWEMeFbXw271bFmkssawRIY_dnzOh1IzqLJYK1zuox2q_snIQf1l1mszhyCkrDhC9vrkDRwiiFOsKaV1gsh60ebx4kXdE_cEoJmgpsysG5Wp6OzlzdNiVJN3XeRl0IjVhzHRNP6Bso7dQSc7-JHZ9Bsy8E4uYpil4BxVZ-ZgoG-w7pwXLRWVQGGK35mDwhTYzCVd4xhPL7d8Oi4pb0bm8SwAwOQDF8TV"/>
<div>
<p class="text-label-sm font-bold text-on-surface">Alex Rivera</p>
<p class="text-label-xs text-on-surface-variant">Product Design</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-label-xs font-bold rounded-full uppercase">
<span class="w-1.5 h-1.5 bg-green-600 rounded-full animate-pulse"></span> Active
                                    </span>
</td>
<td class="px-6 py-4 text-center font-body-md">94.5%</td>
<td class="px-6 py-4 text-center">
<div class="flex items-center justify-center gap-2">
<div class="w-16 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-primary h-full w-[96%]"></div>
</div>
<span class="text-label-sm font-bold">96%</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<div class="flex items-center justify-end gap-1 text-primary">
<span class="text-label-sm font-bold mr-1">4.8</span>
<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</td>
</tr>
<!-- Sarah -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-8 py-4 font-bold text-on-surface-variant">#2</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<img class="w-10 h-10 rounded-full object-cover" data-alt="High quality professional corporate headshot of a female intern with glasses and pulled-back hair, soft neutral lighting, 8k professional studio photography, minimalistic background with a light blue tint, representing tech industry excellence." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1e4_A5KwLbDffmZX3Fg3INhX_eBFlFpJdBM37sDB2ee2xaG006j0O9D_Y7Fd8zHgmqzQlEfBuoU6Bwqq6e_1j92otqFDPFa1VZhc52wvGttzPM1LT-6lFN92E-yEYpYFwOQQ-T0D1W7UjvwKCpOuontcCSfHwKz8eO9K3JvIarq-qIUzJjh6MsrSFRxLiAidRIB7zVl1xbHq00U1WJYEwZ7oCypEH0Kf4_znA60MQiaCr7oHf22-3BZD3EyfP6p397nzR9qS15jSF"/>
<div>
<p class="text-label-sm font-bold text-on-surface">Sarah Chen</p>
<p class="text-label-xs text-on-surface-variant">Backend Eng</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-label-xs font-bold rounded-full uppercase">
<span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span> Active
                                    </span>
</td>
<td class="px-6 py-4 text-center font-body-md">98.2%</td>
<td class="px-6 py-4 text-center">
<div class="flex items-center justify-center gap-2">
<div class="w-16 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-tertiary-container h-full w-[94%]"></div>
</div>
<span class="text-label-sm font-bold">94%</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<div class="flex items-center justify-end gap-1 text-primary">
<span class="text-label-sm font-bold mr-1">4.7</span>
<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</td>
</tr>
<!-- Jordan -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-8 py-4 font-bold text-on-surface-variant">#3</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<img class="w-10 h-10 rounded-full object-cover" data-alt="A portrait of a young professional male with a short beard, wearing a polo shirt, studio lighting, soft corporate aesthetic, blurred office window in the distance, high definition, modern styling consistent with a tech company internship profile." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCeYJd2w5-dfLXMfmkADarzKapeBeUuJ0oha9N7QhfE6hgWHxn2nrPnPu1QbsWAbk53GxmNCgX7rx_akMDrZhD9PMLauFIYa-pUE5So5ZpfOzLPdTRuDMizKnCFy-bIQUtrxhtrVopwCLCRU09EC7hP337JC3BC9rYMJsnBO2CdFXr1GdJSFVPSB64BLcNehh4JocxICWWklsqZ6uFTHyTXAswC2mD8ag1utA22U39IwM6euYXXEEA_ESM3pFKwmhbIb7rjnhONtcnE"/>
<div>
<p class="text-label-sm font-bold text-on-surface">Jordan Smith</p>
<p class="text-label-xs text-on-surface-variant">QA Testing</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-surface-container-high text-on-surface-variant text-label-xs font-bold rounded-full uppercase">
<span class="w-1.5 h-1.5 bg-outline rounded-full"></span> Idle
                                    </span>
</td>
<td class="px-6 py-4 text-center font-body-md">89.0%</td>
<td class="px-6 py-4 text-center">
<div class="flex items-center justify-center gap-2">
<div class="w-16 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-tertiary-container h-full w-[91%]"></div>
</div>
<span class="text-label-sm font-bold">91%</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<div class="flex items-center justify-end gap-1 text-primary">
<span class="text-label-sm font-bold mr-1">4.5</span>
<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</td>
</tr>
<!-- Maya -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-8 py-4 font-bold text-on-surface-variant">#4</td>
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<img class="w-10 h-10 rounded-full object-cover" data-alt="Professional profile photo of a young woman with a pleasant expression, modern corporate style, softly lit clean office background, highly detailed rendering, high quality photograph, professional intern headshot for a leading tech firm portal." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOvTE9zmKl7EByTVVa3q3JdWHlH4yNHpvwYVfILnT4ZULj9SKaneKSZ67zGC6WwCk0kUNoLfnUAaD8SNwX0cwA6rILHVLZVyX5_dpb0Sv-B3r72WdmDD6U_F8oxMA-fytU0RwCEPnjISirITWi5TAQ8OJZftznEb8lQgLbNWHrcUV-pbp4ZT3CSMp2S3Z179zWKwKCezBYga0YqDv6TT1ikLh6YHDOi0MzGTPmL-8ostJ4YqMNIs21Stt_ZBo83OubJQTEIsqLf3pn"/>
<div>
<p class="text-label-sm font-bold text-on-surface">Maya Patel</p>
<p class="text-label-xs text-on-surface-variant">Data Analysis</p>
</div>
</div>
</td>
<td class="px-6 py-4">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-label-xs font-bold rounded-full uppercase">
<span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span> Active
                                    </span>
</td>
<td class="px-6 py-4 text-center font-body-md">92.1%</td>
<td class="px-6 py-4 text-center">
<div class="flex items-center justify-center gap-2">
<div class="w-16 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-tertiary-container h-full w-[88%]"></div>
</div>
<span class="text-label-sm font-bold">88%</span>
</div>
</td>
<td class="px-8 py-4 text-right">
<div class="flex items-center justify-end gap-1 text-primary">
<span class="text-label-sm font-bold mr-1">4.4</span>
<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</td>
</tr>
</tbody>
</table>
</div>
</section>
</div>
<!-- Sticky FAB (Suppressed on Details, but appropriate for Home Dashboard according to mandate) -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-on-primary rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 group">
<span class="material-symbols-outlined text-[28px]">chat_bubble</span>
<div class="absolute right-full mr-4 bg-inverse-surface text-on-primary text-label-sm px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity whitespace-nowrap">
                Contact Mentor
            </div>
</button>


@endsection
<script>
        // Micro-interaction: Progress Bar Animation on Load
        document.addEventListener('DOMContentLoaded', () => {
            const bars = document.querySelectorAll('.bg-primary.h-full, .bg-tertiary-container.h-full');
            bars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });

        // Micro-interaction: Stats Card Hover Effect
        const cards = document.querySelectorAll('.shadow-\\[0_20px_25px_-5px_rgba\\(0\\,0\\,0\\,0\\.04\\)\\]');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.borderColor = 'rgba(35, 51, 231, 0.4)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.borderColor = 'rgba(197, 197, 217, 0.3)';
            });
        });
    </script>
</body></html>
