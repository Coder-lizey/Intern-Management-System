@extends('layouts.intern')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script id="tailwind-custom-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        "colors": {
                "tertiary-fixed-dim": "#b7c8e1",
                "on-tertiary": "#ffffff",
                "surface-dim": "#d8dadc",
                "primary-container": "#4353ff",
                "primary": "#2333e7",
                "on-primary": "#ffffff",
                "error-container": "#ffdad6",
                "surface": "#f7f9fb",
                "on-primary-fixed-variant": "#0a1fdd",
                "surface-container-highest": "#e0e3e5",
                "background": "#f7f9fb",
                "tertiary": "#44546a",
                "on-surface": "#191c1e",
                "secondary-fixed-dim": "#bec6e0",
                "primary-fixed": "#e0e0ff",
                "on-tertiary-container": "#e3edff",
                "on-primary-fixed": "#000668",
                "inverse-on-surface": "#eff1f3",
                "error": "#ba1a1a",
                "surface-bright": "#f7f9fb",
                "on-secondary": "#ffffff",
                "inverse-primary": "#bdc2ff",
                "primary-fixed-dim": "#bdc2ff",
                "on-background": "#191c1e",
                "on-tertiary-fixed-variant": "#38485d",
                "tertiary-fixed": "#d3e4fe",
                "surface-container": "#eceef0",
                "secondary-container": "#dae2fd",
                "surface-container-lowest": "#ffffff",
                "on-surface-variant": "#454556",
                "on-secondary-fixed": "#131b2e",
                "inverse-surface": "#2d3133",
                "on-error": "#ffffff",
                "surface-tint": "#3444f2",
                "outline": "#757688",
                "on-tertiary-fixed": "#0b1c30",
                "on-error-container": "#93000a",
                "surface-container-low": "#f2f4f6",
                "secondary": "#565e74",
                "on-secondary-fixed-variant": "#3f465c",
                "tertiary-container": "#5c6c83",
                "on-secondary-container": "#5c647a",
                "surface-container-high": "#e6e8ea",
                "secondary-fixed": "#dae2fd",
                "surface-variant": "#e0e3e5",
                "on-primary-container": "#eceaff",
                "outline-variant": "#c5c5d9"
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
                "gutter": "24px",
                "section-margin": "40px",
                "container-padding": "32px",
                "card-gap": "20px",
                "sidebar-width": "260px"
        },
        "fontFamily": {
                "headline-lg": ["Hanken Grotesk"],
                "label-xs": ["Hanken Grotesk"],
                "body-md": ["Hanken Grotesk"],
                "label-sm": ["Hanken Grotesk"],
                "headline-md": ["Hanken Grotesk"],
                "body-lg": ["Hanken Grotesk"]
        },
        "fontSize": {
                "headline-lg": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                "label-xs": ["11px", {"lineHeight": "14px", "fontWeight": "500"}],
                "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
        }
      },
    },
  }
</script>

<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .locked-overlay {
        backdrop-filter: blur(8px);
        background: rgba(255, 255, 255, 0.4);
    }
    .certificate-paper {
        aspect-ratio: 1.414/1;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        background-image: radial-gradient(circle at 10% 20%, rgba(35, 51, 231, 0.02) 0%, transparent 20%),
                          radial-gradient(circle at 90% 80%, rgba(35, 51, 231, 0.02) 0%, transparent 20%);
    }
    .border-pattern {
        border: 20px solid transparent;
        border-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h40v40H0V0zm2 2v36h36V2H2z' fill='%232333e7' fill-opacity='0.1'/%3E%3C/svg%3E") 20 stretch;
    }
</style>

<div class="p-container-padding max-w-6xl mx-auto block overflow-visible min-h-screen pb-12">
    
    <div class="mb-section-margin">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Official Certification</h2>
        <p class="text-on-surface-variant font-body-md mt-1">Claim and download your verified internship certificate upon completion.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant">
                <div class="flex items-center justify-between">
                    <span class="text-label-sm font-label-sm text-on-surface-variant font-semibold">Verification Status:</span>
                    @if(isset($certificate->is_unlocked) && $certificate->is_unlocked)
                        <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide">Unlocked by Mentor</span>
                    @else
                        <span class="bg-error-container text-on-error-container px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide">Locked</span>
                    @endif
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-3xl shadow-sm border border-outline-variant transition-all duration-500 {{ !(isset($certificate->is_unlocked) && $certificate->is_unlocked) ? 'opacity-50 pointer-events-none grayscale' : '' }}">
                
                <form action="{{ route('certificates.generate', $certificate->id ?? 0) }}" method="POST" id="cert-generation-form">
                    @csrf
                    <label class="block text-label-sm font-label-sm text-on-surface-variant mb-2">FULL NAME FOR CERTIFICATE</label>
                    
                    <input class="w-full p-4 rounded-xl border border-outline-variant focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all mb-6 text-body-lg" 
                           id="name-input" 
                           name="name_on_certificate"
                           oninput="updateName()" 
                           placeholder="Enter your full name" 
                           type="text"
                           value="{{ $certificate->name_on_certificate ?? auth()->user()->name ?? '' }}"
                           {{ (isset($certificate->is_generated) && $certificate->is_generated) ? 'disabled' : 'required' }} />

                    <div class="space-y-4">
                        @if(!(isset($certificate->is_generated) && $certificate->is_generated))
                            <button type="submit" class="w-full py-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all active:scale-95">
                                <span class="material-symbols-outlined">verified</span>
                                Generate Certificate
                            </button>
                            
                            <button type="button" class="w-full py-3 border border-outline text-on-surface-variant rounded-xl font-label-sm flex items-center justify-center gap-2 opacity-40 cursor-not-allowed" disabled>
                                <span class="material-symbols-outlined">download</span>
                                Download PDF
                            </button>
                        @else
                            <div class="bg-surface-container-low p-3 rounded-xl text-center text-xs text-on-surface-variant mb-2 font-medium">
                                <span class="text-emerald-600 font-bold">✓ Generated Successfully.</span> Changes are now locked.
                            </div>
                            
                            <button type="button" class="w-full py-4 bg-emerald-600 text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all" onclick="downloadPDF()">
                                <span class="material-symbols-outlined">download</span>
                                Download PDF
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-surface-container-low p-6 rounded-2xl border border-outline-variant/50">
                <h4 class="font-label-sm text-label-sm text-on-surface mb-4">Guidelines</h4>
                <ul class="space-y-3">
                    <li class="flex gap-3 text-body-md text-on-surface-variant">
                        <span class="material-symbols-outlined text-primary text-lg">info</span>
                        Ensure your name matches your government ID.
                    </li>
                    <li class="flex gap-3 text-body-md text-on-surface-variant">
                        <span class="material-symbols-outlined text-primary text-lg">history</span>
                        Once generated, you can access this anytime.
                    </li>
                </ul>
            </div>
        </div>

        <div class="lg:col-span-8 relative">
            
            @if(!(isset($certificate->is_unlocked) && $certificate->is_unlocked))
            <div class="absolute inset-0 z-20 rounded-3xl flex flex-col items-center justify-center p-12 text-center locked-overlay border-2 border-dashed border-outline-variant" id="locked-overlay">
                <div class="w-20 h-20 bg-surface-container-highest rounded-full flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant">lock</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Certificate Locked</h3>
                <p class="text-on-surface-variant max-w-xs mx-auto">Your certificate will be available once unlocked by your mentor after completion of the program.</p>
            </div>
            @endif

            <div class="certificate-paper w-full bg-white rounded-lg relative overflow-hidden transition-all duration-700 {{ !(isset($certificate->is_unlocked) && $certificate->is_unlocked) ? 'blur-[3px]' : '' }}" id="certificate-canvas">
                <div class="absolute inset-0 border-pattern"></div>
                <div class="relative h-full w-full p-16 flex flex-col items-center text-center">
                    
                    <img alt="Verge Systems Logo" class="h-12 object-contain mb-12" src="{{ asset('images/vergelogo.png') }}"/>
                    
                    <div class="flex-1 flex flex-col items-center">
                        <span class="text-primary font-bold tracking-[0.3em] uppercase text-xs mb-4">Certificate of Completion</span>
                        <h1 class="font-headline-lg text-4xl text-on-surface mb-2">Verge Systems Internship Program</h1>
                        <p class="text-on-surface-variant font-body-md italic mb-10">This is to certify that</p>
                        
                        <h2 class="font-serif italic text-5xl text-primary border-b-2 border-primary/20 px-12 pb-4 mb-8 min-w-[300px]" id="cert-name-display">
                            {{ $certificate->name_on_certificate ?? auth()->user()->name ?? '[Intern Full Name]' }}
                        </h2>
                        
                        <p class="text-on-surface-variant font-body-md max-w-lg leading-relaxed mb-12">
                            has successfully completed a 6-month intensive Software Engineering Internship at Verge Systems, 
                            demonstrating exceptional technical proficiency and professional excellence.
                        </p>
                    </div>

                    <div class="w-full flex justify-between items-end px-12">
                        <div class="text-left">
                            <div class="w-48 h-px bg-outline mb-3"></div>
                            <p class="font-bold text-on-surface text-sm">Sarah Mitchell</p>
                            <p class="text-on-surface-variant text-[11px] uppercase">Lead Mentor, Verge Systems</p>
                        </div>
                        <div class="relative">
                            
                            <div class="text-center">
                                <p class="font-mono text-[10px] text-outline mb-2">VERIFIED ID: VRG-2024-{{ auth()->id() ?? '8842' }}</p>
                                <p class="text-on-surface-variant text-[11px]">Issued on: {{ isset($certificate->updated_at) && $certificate->updated_at ? ($certificate->updated_at instanceof \Carbon\Carbon ? $certificate->updated_at->format('M d, Y') : date('M d, Y', strtotime($certificate->updated_at))) : date('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="w-48 h-px bg-outline mb-3"></div>
                            <p class="font-bold text-on-surface text-sm">David Chen</p>
                            <p class="text-on-surface-variant text-[11px] uppercase">CTO, Verge Systems</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
        // Synchronizes typing text onto the canvas preview live
        function updateName() {
            const input = document.getElementById('name-input');
            const display = document.getElementById('cert-name-display');
            display.innerText = input.value.trim() || '[Intern Full Name]';
        }

        // Clean single target direct PDF compilation download
        function downloadPDF() {
            const element = document.getElementById('certificate-canvas');
            const nameInput = document.getElementById('name-input').value || 'Intern_Certificate';
            
            const opt = {
                margin:       0,
                filename:     `Verge_Systems_Certificate_${nameInput.replace(/\s+/g, '_')}.pdf`,
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { scale: 3, useCORS: true, logging: false },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
            };
            
            html2pdf().set(opt).from(element).save();
        }

        // Trigger confetti automatically on page load if user just successfully generated it
        @if(isset($certificate->is_generated) && $certificate->is_generated && session('success'))
            window.addEventListener('DOMContentLoaded', () => {
                confetti();
            });
        @endif

        function confetti() {
            const container = document.body;
            for (let i = 0; i < 60; i++) {
                const confetto = document.createElement('div');
                confetto.style.position = 'fixed';
                confetto.style.width = '10px';
                confetto.style.height = '10px';
                confetto.style.backgroundColor = ['#2333e7', '#4353ff', '#10b981'][Math.floor(Math.random() * 3)];
                confetto.style.left = Math.random() * 100 + 'vw';
                confetto.style.top = '-10px';
                confetto.style.borderRadius = '50%';
                confetto.style.zIndex = '100';
                confetto.style.pointerEvents = 'none';
                container.appendChild(confetto);

                const animation = confetto.animate([
                    { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
                    { transform: `translateY(100vh) rotate(${Math.random() * 360}deg)`, opacity: 0 }
                ], {
                    duration: Math.random() * 3000 + 2000,
                    easing: 'cubic-bezier(0, .9, .57, 1)'
                });

                animation.onfinish = () => confetto.remove();
            }
        }
</script>
@endsection