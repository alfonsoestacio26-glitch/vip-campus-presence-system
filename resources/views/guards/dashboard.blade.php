<x-guard-layout>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-stone-500 mb-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Gate Terminal • {{ now()->format('l, F j, Y') }}
                </div>

                <h1 class="text-2xl font-bold text-[#155d36]">
                    QR Attendance Scanner
                </h1>

                <p class="text-sm text-stone-500 mt-1 font-medium">
                    Scan student QR badges for automated campus entry (Time In) and departure (Time Out) verification.
                </p>
            </div>

            {{-- Live Clock & Terminal Status Pill --}}
            <div class="flex items-center gap-3">
                <div class="bg-white border border-stone-200/80 px-4 py-2.5 rounded-xl flex items-center gap-3 shadow-xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <div>
                        <p class="text-[10px] font-bold text-stone-400 uppercase tracking-wider leading-none">System Time</p>
                        <p id="live-time" class="text-sm font-bold text-[#155d36] font-mono mt-0.5">{{ now()->format('h:i:s A') }}</p>
                    </div>
                </div>

                <a
                    href="{{ route('guard.history') }}"
                    class="inline-flex items-center gap-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold px-4 py-2.5 rounded-xl transition border border-stone-200"
                >
                    <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>View Presence Logs</span>
                </a>
            </div>

        </div>


        {{-- Scanner Main Terminal Workspace --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

            {{-- Left Column: Camera Viewfinder (7 cols) --}}
            <div class="lg:col-span-7 bg-white rounded-2xl border border-stone-200/80 p-6 sm:p-7 shadow-xs flex flex-col justify-between">

                <div>

                    {{-- Card Header --}}
                    <div class="flex items-center justify-between pb-4 border-b border-stone-100 mb-6">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#155d36] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-[#155d36]">Camera Scanner Terminal</h2>
                                <p class="text-xs text-stone-400">Position student QR code in front of the lens</p>
                            </div>
                        </div>

                        <div id="camera-status-pill" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Camera Online</span>
                        </div>
                    </div>


                    {{-- Viewfinder Frame Container --}}
                    <div class="relative bg-stone-900/5 rounded-2xl border-2 border-dashed border-stone-200 p-8 flex flex-col items-center justify-center min-h-[340px] overflow-hidden">

                        {{-- Center Viewport with Reticle Corners --}}
                        <div class="relative w-64 h-64 flex items-center justify-center">

                            {{-- Reticle Corner Brackets --}}
                            <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-[#155d36] rounded-tl-lg pointer-events-none z-10"></div>
                            <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-[#155d36] rounded-tr-lg pointer-events-none z-10"></div>
                            <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-[#155d36] rounded-bl-lg pointer-events-none z-10"></div>
                            <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-[#155d36] rounded-br-lg pointer-events-none z-10"></div>

                            {{-- HTML5 QR Code Mount --}}
                            <div id="reader" class="w-full h-full overflow-hidden rounded-xl"></div>

                            {{-- Default QR Silhouette Graphic (Visible until camera streams) --}}
                            <div id="default-qr-graphic" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none bg-stone-100/60 rounded-xl">
                                <svg class="w-28 h-28 text-stone-400/80" viewBox="0 0 100 100" fill="currentColor">
                                    <rect x="8" y="8" width="28" height="28" fill="none" stroke="currentColor" stroke-width="6"/>
                                    <rect x="17" y="17" width="10" height="10" fill="currentColor"/>
                                    <rect x="64" y="8" width="28" height="28" fill="none" stroke="currentColor" stroke-width="6"/>
                                    <rect x="73" y="17" width="10" height="10" fill="currentColor"/>
                                    <rect x="8" y="64" width="28" height="28" fill="none" stroke="currentColor" stroke-width="6"/>
                                    <rect x="17" y="73" width="10" height="10" fill="currentColor"/>
                                    <rect x="42" y="10" width="6" height="6"/>
                                    <rect x="50" y="18" width="6" height="6"/>
                                    <rect x="42" y="26" width="6" height="6"/>
                                    <rect x="10" y="42" width="6" height="6"/>
                                    <rect x="26" y="42" width="6" height="6"/>
                                    <rect x="42" y="42" width="8" height="8"/>
                                    <rect x="56" y="42" width="6" height="6"/>
                                    <rect x="70" y="42" width="6" height="6"/>
                                    <rect x="84" y="42" width="6" height="6"/>
                                    <rect x="18" y="50" width="6" height="6"/>
                                    <rect x="50" y="50" width="6" height="6"/>
                                    <rect x="64" y="50" width="6" height="6"/>
                                    <rect x="42" y="58" width="6" height="6"/>
                                    <rect x="58" y="58" width="6" height="6"/>
                                    <rect x="78" y="58" width="6" height="6"/>
                                    <rect x="42" y="72" width="6" height="6"/>
                                    <rect x="56" y="72" width="6" height="6"/>
                                    <rect x="72" y="72" width="6" height="6"/>
                                    <rect x="50" y="84" width="6" height="6"/>
                                    <rect x="64" y="84" width="6" height="6"/>
                                    <rect x="82" y="84" width="6" height="6"/>
                                </svg>
                                <span class="text-xs font-semibold text-stone-500 mt-3">Connecting video feed...</span>
                            </div>

                        </div>

                        {{-- Text instructions below frame --}}
                        <div class="mt-5 text-center">
                            <p class="text-sm font-bold text-[#155d36]">
                                Align Student QR Code Within the Reticle
                            </p>
                            <p class="text-xs text-stone-400 mt-0.5">
                                Automated high-speed verification for entries and exits
                            </p>
                        </div>

                        {{-- Hidden Input for Keyboard Wedge / USB 2D Barcode Scanners --}}
                        <input
                            type="text"
                            id="barcode-input"
                            placeholder="Barcode gun input..."
                            class="opacity-0 absolute pointer-events-none w-1 h-1"
                            autocomplete="off"
                        >

                    </div>

                </div>

                {{-- Camera Tools Footer --}}
                <div class="mt-6 pt-4 border-t border-stone-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-stone-500">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-stone-100 font-mono text-[11px] text-stone-700 font-semibold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            USB 2D Scanner Ready
                        </span>
                        <span>Hardware scanners supported</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            onclick="resetScanner(true)"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-stone-200 hover:bg-stone-50 font-semibold text-stone-700 transition"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Reset Terminal</span>
                        </button>
                    </div>
                </div>

            </div>


            {{-- Right Column: Verification Result Panel (5 cols) --}}
            <div class="lg:col-span-5 bg-white rounded-2xl border border-stone-200/80 p-6 sm:p-7 shadow-xs flex flex-col justify-between space-y-6">

                <div class="space-y-5">

                    {{-- Panel Header --}}
                    <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-[#155d36]">Verification Result</h2>
                                <p class="text-xs text-stone-400">Live attendance verification feedback</p>
                            </div>
                        </div>

                        <span class="px-2.5 py-1 rounded-md bg-stone-100 text-stone-600 text-xs font-semibold">
                            Auto-sync
                        </span>
                    </div>


                    {{-- Attendance Status Badge Card --}}
                    <div id="status-card" class="rounded-xl border p-5 text-center transition-all duration-300 bg-stone-50 border-stone-200 text-stone-700">

                        <div id="status-circle" class="w-12 h-12 rounded-full border-2 border-stone-400 text-stone-600 flex items-center justify-center mx-auto mb-2.5 transition">
                            <svg id="status-icon-svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>

                        <h3 id="status-text" class="text-lg font-bold tracking-wide uppercase">
                            Ready to Scan
                        </h3>

                        <p id="status-subtext" class="text-xs text-stone-500 mt-1">
                            Awaiting student QR code at gate terminal
                        </p>

                    </div>


                    {{-- Student Empty State (Displayed initially before any scan) --}}
                    <div id="student-empty-state" class="rounded-xl border-2 border-dashed border-stone-200 p-8 text-center bg-stone-50/50 flex flex-col items-center justify-center space-y-2.5">
                        <div class="w-12 h-12 rounded-full bg-white border border-stone-200 text-stone-400 flex items-center justify-center mx-auto shadow-2xs">
                            <svg class="w-6 h-6 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-stone-700">Awaiting Student Scan</h4>
                            <p class="text-xs text-stone-400 mt-1 max-w-[260px] mx-auto leading-relaxed">
                                Present student QR badge to the camera or barcode scanner to verify identity and record presence.
                            </p>
                        </div>
                    </div>

                    {{-- Student Information Card (Hidden initially, revealed upon scan) --}}
                    <div id="student-details-card" class="hidden rounded-xl border border-stone-200 p-5 bg-white shadow-2xs space-y-4">

                        {{-- Name and Student ID row --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="overflow-hidden">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-stone-400">Student Name</p>
                                <h4 id="student-name" class="text-lg font-bold text-[#155d36] leading-tight truncate mt-0.5">
                                    —
                                </h4>
                            </div>

                            <span id="student-no" class="px-2.5 py-1 rounded bg-stone-100 text-stone-700 text-xs font-mono font-bold flex-shrink-0">
                                —
                            </span>
                        </div>

                        {{-- Academic Level and Section --}}
                        <div class="flex items-center gap-2 text-xs text-stone-500">
                            <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                            <span id="student-section" class="font-semibold text-stone-700">
                                —
                            </span>
                        </div>

                        {{-- Key-Value Details Grid --}}
                        <div class="pt-3 border-t border-stone-100 grid grid-cols-2 gap-3 text-xs">
                            <div class="p-2.5 rounded-lg bg-stone-50">
                                <p id="student-time-label" class="text-[10px] uppercase font-bold text-stone-400">Time In</p>
                                <p id="student-time-in" class="font-bold text-[#155d36] font-mono mt-0.5">
                                    —
                                </p>
                            </div>

                            <div class="p-2.5 rounded-lg bg-stone-50">
                                <p class="text-[10px] uppercase font-bold text-stone-400">Attendance Status</p>
                                <p id="student-status-text" class="font-bold text-emerald-600 mt-0.5">
                                    —
                                </p>
                            </div>
                        </div>

                        {{-- Guard verification stamp --}}
                        <div class="pt-2 border-t border-stone-100 flex items-center justify-between text-[11px] text-stone-400">
                            <span>Verified By:</span>
                            <span class="font-semibold text-stone-600">{{ auth()->user()->name ?? 'Duty Security Officer' }}</span>
                        </div>

                    </div>

                    {{-- Dynamic Feedback Message Toast --}}
                    <div id="scan-feedback" class="hidden p-3 rounded-xl text-xs font-semibold text-center transition">
                    </div>

                </div>

                {{-- Action Button: Ready for Next Scan --}}
                <div class="pt-2">
                    <button
                        type="button"
                        id="btn-scan-another"
                        onclick="resetScanner()"
                        class="w-full inline-flex items-center justify-center gap-2 bg-[#155d36] hover:bg-[#0f4628] text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-sm transition duration-150"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Scan Next Student</span>
                    </button>
                </div>

            </div>

        </div>


        {{-- Recent Today Scans Live Log Table --}}
        <div class="bg-white rounded-2xl border border-stone-200/80 shadow-xs overflow-hidden">

            <div class="p-6 border-b border-stone-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#155d36]">Recent Gate Scans Today</h3>
                    <p class="text-xs text-stone-400 mt-0.5">Live feed of the latest student arrival and departure logs</p>
                </div>

                <a
                    href="{{ route('guard.history') }}"
                    class="text-xs font-bold text-[#155d36] hover:underline flex items-center gap-1.5"
                >
                    <span>View All Scan History</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-stone-100 bg-stone-50/50">
                            <th class="table-heading">Student</th>
                            <th class="table-heading">Student ID</th>
                            <th class="table-heading">Time In</th>
                            <th class="table-heading">Time Out</th>
                            <th class="table-heading text-right">Status</th>
                        </tr>
                    </thead>

                    <tbody id="recent-scans-tbody" class="divide-y divide-stone-100">
                        @if($recentScans && $recentScans->count() > 0)
                            @foreach($recentScans as $att)
                                <tr class="hover:bg-stone-50/70 transition">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-stone-100 border border-stone-200 text-[#155d36] font-bold text-xs flex items-center justify-center flex-shrink-0">
                                                {{ strtoupper(substr($att->student->first_name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-stone-800">
                                                    {{ $att->student->first_name ?? '' }} {{ $att->student->last_name ?? '' }}
                                                </p>
                                                @if(!empty($att->student->grade_level) || !empty($att->student->section))
                                                    <p class="text-[11px] text-stone-400">
                                                        Grade {{ $att->student->grade_level ?? '—' }} - {{ $att->student->section ?? '—' }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-3.5 text-xs font-mono text-stone-600">
                                        <span class="px-2 py-0.5 rounded bg-stone-100 text-stone-700">
                                            {{ $att->student->student_no ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-3.5 text-xs font-medium text-stone-600">
                                        @if($att->time_in)
                                            <span class="inline-flex items-center gap-1 text-stone-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#4d88df]"></span>
                                                {{ $att->time_in->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-stone-300">—</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-3.5 text-xs font-medium text-stone-600">
                                        @if($att->time_out)
                                            <span class="inline-flex items-center gap-1 text-stone-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                {{ $att->time_out->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-stone-300">—</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-3.5 text-right">
                                        @if($att->time_out)
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700">
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                On Campus
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="empty-recent-row">
                                <td colspan="5" class="py-8 text-center text-xs text-slate-400">
                                    No scans logged yet today. Student entries will appear here in real-time.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>


    {{-- HTML5 QR Code Scanner Library --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let html5QrCode = null;
        let isProcessing = false;

        // Audio Beep for successful scan
        const beepSound = new Audio("data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU9vT18A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A/38A");

        // Live Real-Time Clock
        function updateLiveClock() {
            const now = new Date();
            let hours = now.getHours();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            const hoursStr = String(hours).padStart(2, '0');
            const minutesStr = String(now.getMinutes()).padStart(2, '0');
            const secondsStr = String(now.getSeconds()).padStart(2, '0');
            const timeStr = `${hoursStr}:${minutesStr}:${secondsStr} ${ampm}`;

            const tEl = document.getElementById('live-time');
            if (tEl) tEl.innerText = timeStr;
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();

        // Initialize Camera Scanner
        function initScanner() {
            const readerDiv = document.getElementById('reader');
            if (!readerDiv) return;

            html5QrCode = new Html5Qrcode("reader");

            const config = {
                fps: 15,
                qrbox: { width: 220, height: 220 },
                aspectRatio: 1.0
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanFailure
            ).then(() => {
                const graphic = document.getElementById('default-qr-graphic');
                if (graphic) graphic.style.display = 'none';

                const statusPill = document.getElementById('camera-status-pill');
                if (statusPill) {
                    statusPill.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span><span>Camera Streaming</span>';
                }
            }).catch(err => {
                console.log("Camera access not available or permission denied:", err);
                const statusPill = document.getElementById('camera-status-pill');
                if (statusPill) {
                    statusPill.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-xs font-semibold';
                    statusPill.innerHTML = '<span class="w-2 h-2 rounded-full bg-amber-500"></span><span>Barcode Reader Active</span>';
                }
            });
        }

        // On Successful QR Code Scan
        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            try {
                beepSound.play().catch(() => {});
            } catch(e) {}

            processQrCode(decodedText);
        }

        function onScanFailure(error) {
            // Scanning frames in progress
        }

        // Send Scan to Backend
        function processQrCode(qrString) {
            showFeedback('Verifying student credential at gate...', 'text-blue-700', 'bg-blue-50 border border-blue-200');

            fetch("{{ route('attendance.scan') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_code: qrString })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200 && body.success) {
                    showVerifiedResult(body);
                } else if (status === 409) {
                    showAlreadyCompleted(body);
                } else {
                    showError(body.message || 'Student QR Code not recognized.');
                }
            })
            .catch(err => {
                console.error(err);
                showError('Network error while recording gate attendance.');
            });
        }

        // Display Verified Attendance Result
        function showVerifiedResult(data) {
            const isTimeIn = data.type === 'time_in';
            const statusCard = document.getElementById('status-card');
            const statusCircle = document.getElementById('status-circle');
            const statusText = document.getElementById('status-text');
            const statusSubtext = document.getElementById('status-subtext');

            if (isTimeIn) {
                statusCard.className = 'rounded-xl border p-5 text-center transition-all duration-300 bg-emerald-50 border-emerald-200 text-emerald-800';
                statusCircle.className = 'w-12 h-12 rounded-full border-2 border-emerald-600 text-emerald-600 flex items-center justify-center mx-auto mb-2.5 transition';
                statusCircle.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
                statusText.innerText = 'TIME IN • PRESENT';
                statusSubtext.innerText = 'Campus arrival verified and recorded';

                const timeLabel = document.getElementById('student-time-label');
                if (timeLabel) timeLabel.innerText = 'Time In';
                document.getElementById('student-time-in').innerText = data.attendance.time_in;
                document.getElementById('student-status-text').innerText = 'Present';
                document.getElementById('student-status-text').className = 'font-bold text-emerald-600 mt-0.5';

                showFeedback('Time In recorded successfully.', 'text-emerald-700', 'bg-emerald-50 border border-emerald-200');
            } else {
                statusCard.className = 'rounded-xl border p-5 text-center transition-all duration-300 bg-blue-50 border-blue-200 text-blue-800';
                statusCircle.className = 'w-12 h-12 rounded-full border-2 border-blue-600 text-blue-600 flex items-center justify-center mx-auto mb-2.5 transition';
                statusCircle.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>';
                statusText.innerText = 'TIME OUT • DEPARTED';
                statusSubtext.innerText = 'Campus departure verified and recorded';

                const timeLabel = document.getElementById('student-time-label');
                if (timeLabel) timeLabel.innerText = 'Time Out';
                document.getElementById('student-time-in').innerText = data.attendance.time_out;
                document.getElementById('student-status-text').innerText = 'Departed';
                document.getElementById('student-status-text').className = 'font-bold text-blue-600 mt-0.5';

                showFeedback('Time Out recorded successfully.', 'text-blue-700', 'bg-blue-50 border border-blue-200');
            }

            // Reveal Student Details and hide empty state
            const emptyState = document.getElementById('student-empty-state');
            const detailsCard = document.getElementById('student-details-card');
            if (emptyState) emptyState.classList.add('hidden');
            if (detailsCard) detailsCard.classList.remove('hidden');

            // Student Details (Clean institutional typography, no photo)
            document.getElementById('student-name').innerText = data.student.name;
            document.getElementById('student-no').innerText = data.student.student_no;
            document.getElementById('student-section').innerText = `Grade ${data.student.grade_level || '—'} - Section ${data.student.section || '—'}`;

            // Prepend to Recent Scans Table dynamically
            prependScanToTable(data);
        }

        // Display Already Completed Alert
        function showAlreadyCompleted(data) {
            const statusCard = document.getElementById('status-card');
            const statusCircle = document.getElementById('status-circle');
            const statusText = document.getElementById('status-text');
            const statusSubtext = document.getElementById('status-subtext');

            statusCard.className = 'rounded-xl border p-5 text-center transition-all duration-300 bg-amber-50 border-amber-200 text-amber-800';
            statusCircle.className = 'w-12 h-12 rounded-full border-2 border-amber-600 text-amber-600 flex items-center justify-center mx-auto mb-2.5 transition';
            statusCircle.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
            statusText.innerText = 'ALREADY COMPLETED';
            statusSubtext.innerText = 'Student has already completed entry and departure today';

            const emptyState = document.getElementById('student-empty-state');
            const detailsCard = document.getElementById('student-details-card');
            if (emptyState) emptyState.classList.add('hidden');
            if (detailsCard) detailsCard.classList.remove('hidden');

            if (data.student) {
                document.getElementById('student-name').innerText = data.student.name;
                document.getElementById('student-no').innerText = data.student.student_no;
                document.getElementById('student-section').innerText = `Grade ${data.student.grade_level || '—'} - Section ${data.student.section || '—'}`;
            }

            if (data.attendance) {
                document.getElementById('student-time-in').innerText = data.attendance.time_out || data.attendance.time_in;
                document.getElementById('student-status-text').innerText = 'Completed';
                document.getElementById('student-status-text').className = 'font-bold text-amber-700 mt-0.5';
            }

            showFeedback('Attendance cycle already completed today.', 'text-amber-800', 'bg-amber-50 border border-amber-200');
        }

        // Display Error Alert
        function showError(msg) {
            const statusCard = document.getElementById('status-card');
            const statusCircle = document.getElementById('status-circle');
            const statusText = document.getElementById('status-text');
            const statusSubtext = document.getElementById('status-subtext');

            statusCard.className = 'rounded-xl border p-5 text-center transition-all duration-300 bg-rose-50 border-rose-200 text-rose-800';
            statusCircle.className = 'w-12 h-12 rounded-full border-2 border-rose-600 text-rose-600 flex items-center justify-center mx-auto mb-2.5 transition';
            statusCircle.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>';
            statusText.innerText = 'INVALID QR BADGE';
            statusSubtext.innerText = msg;

            showFeedback(msg, 'text-rose-700', 'bg-rose-50 border border-rose-200');
        }

        function showFeedback(text, textClass, bgClass) {
            const fb = document.getElementById('scan-feedback');
            fb.className = `p-3 rounded-xl text-xs font-semibold text-center transition block ${textClass} ${bgClass}`;
            fb.innerText = text;
        }

        // Dynamically add new scan to the bottom table
        function prependScanToTable(data) {
            const tbody = document.getElementById('recent-scans-tbody');
            if (!tbody) return;

            const emptyRow = document.getElementById('empty-recent-row');
            if (emptyRow) emptyRow.remove();

            const isTimeIn = data.type === 'time_in';
            const initial = (data.student.name || 'S').charAt(0).toUpperCase();

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50/70 transition bg-emerald-50/20';
            tr.innerHTML = `
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-[#123b70] font-bold text-xs flex items-center justify-center flex-shrink-0">
                            ${initial}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-[#0e2c56]">${data.student.name}</p>
                            <p class="text-[11px] text-slate-400">Grade ${data.student.grade_level || '—'} - Section ${data.student.section || '—'}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-xs font-mono text-slate-600">
                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700">${data.student.student_no}</span>
                </td>
                <td class="px-5 py-3.5 text-xs font-medium text-slate-600">
                    <span class="inline-flex items-center gap-1 text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        ${data.attendance.time_in || '—'}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-xs font-medium text-slate-600">
                    ${data.attendance.time_out ? `<span class="inline-flex items-center gap-1 text-slate-700"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>${data.attendance.time_out}</span>` : `<span class="text-slate-300">—</span>`}
                </td>
                <td class="px-5 py-3.5 text-right">
                    ${isTimeIn ? `
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            On Campus
                        </span>
                    ` : `
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700">
                            Completed
                        </span>
                    `}
                </td>
            `;

            tbody.insertBefore(tr, tbody.firstChild);
        }

        // Reset to allow scanning another student
        function resetScanner(fullReset = false) {
            isProcessing = false;
            const fb = document.getElementById('scan-feedback');
            if (fb) fb.className = 'hidden';

            const barcodeInput = document.getElementById('barcode-input');
            if (barcodeInput) {
                barcodeInput.value = '';
                barcodeInput.focus();
            }

            if (fullReset) {
                // Restore status card back to Ready to Scan
                const statusCard = document.getElementById('status-card');
                const statusCircle = document.getElementById('status-circle');
                const statusText = document.getElementById('status-text');
                const statusSubtext = document.getElementById('status-subtext');

                if (statusCard) statusCard.className = 'rounded-xl border p-5 text-center transition-all duration-300 bg-slate-50 border-slate-200 text-slate-700';
                if (statusCircle) {
                    statusCircle.className = 'w-12 h-12 rounded-full border-2 border-slate-400 text-slate-600 flex items-center justify-center mx-auto mb-2.5 transition';
                    statusCircle.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>';
                }
                if (statusText) statusText.innerText = 'Ready to Scan';
                if (statusSubtext) statusSubtext.innerText = 'Awaiting student QR code at gate terminal';

                // Restore student card to idle awaiting state
                const emptyState = document.getElementById('student-empty-state');
                const detailsCard = document.getElementById('student-details-card');
                const timeLabel = document.getElementById('student-time-label');
                if (timeLabel) timeLabel.innerText = 'Time In';
                if (emptyState) emptyState.classList.remove('hidden');
                if (detailsCard) detailsCard.classList.add('hidden');
            }
        }

        // Support for Handheld USB/Bluetooth Barcode Scanners (Keyboard wedge)
        let barcodeBuffer = '';
        let lastKeyTime = Date.now();

        window.addEventListener('keydown', (e) => {
            const currentTime = Date.now();
            
            // If keys arrive in quick succession (< 150ms), it's a hardware scanner
            if (e.key === 'Enter') {
                if (barcodeBuffer.length > 2) {
                    onScanSuccess(barcodeBuffer);
                    barcodeBuffer = '';
                }
            } else if (e.key.length === 1) {
                if (currentTime - lastKeyTime > 150) {
                    barcodeBuffer = '';
                }
                barcodeBuffer += e.key;
                lastKeyTime = currentTime;
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            initScanner();
        });
    </script>

</x-guard-layout>