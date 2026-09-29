<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student ID Badge - {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_no }})</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            min-height: 100vh;
        }

        /* Top control bar */
        .toolbar {
            background: #0e2c56;
            color: white;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(14, 44, 86, 0.15);
        }

        .toolbar-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 16px;
        }

        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            border: none;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Container */
        .badges-wrapper {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 32px;
        }

        /* Badge Card Standard PVC Dimensions: 54mm x 85.6mm (204px x 324px at 96dpi, styled as 320px x 490px for high-density display) */
        .id-card {
            width: 330px;
            height: 510px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* Card Header */
        .card-header {
            background: linear-gradient(135deg, #0e2c56 0%, #123b70 60%, #1e40af 100%);
            color: white;
            padding: 16px 14px 12px;
            text-align: center;
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 50%, #f59e0b 100%);
        }

        .school-name {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .badge-type {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            color: #93c5fd;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Lanyard hole indicator */
        .lanyard-hole {
            width: 36px;
            height: 8px;
            background: #cbd5e1;
            border-radius: 4px;
            margin: 6px auto 0;
            border: 1px solid #94a3b8;
        }

        /* Front Body */
        .card-body-front {
            padding: 14px 16px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .photo-container {
            width: 108px;
            height: 108px;
            border-radius: 16px;
            overflow: hidden;
            border: 3px solid #0e2c56;
            box-shadow: 0 4px 10px rgba(14, 44, 86, 0.15);
            background: #f8fafc;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-name {
            font-size: 16px;
            font-weight: 800;
            color: #0e2c56;
            line-height: 1.25;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .student-id-pill {
            display: inline-block;
            background: #0e2c56;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 9999px;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-grid {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px 10px;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .info-item {
            text-align: left;
        }

        .info-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            display: block;
        }

        .info-value {
            font-size: 11px;
            color: #0f172a;
            font-weight: 700;
        }

        /* QR Code Container */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: auto;
            padding-bottom: 4px;
        }

        .qr-box {
            background: white;
            padding: 6px;
            border-radius: 10px;
            border: 1.5px solid #0e2c56;
            display: inline-flex;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .qr-box img {
            width: 100px;
            height: 100px;
            display: block;
        }

        .qr-caption {
            font-size: 9px;
            color: #64748b;
            font-weight: 600;
            margin-top: 4px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Card Back */
        .card-body-back {
            padding: 18px 18px 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .back-section-title {
            font-size: 10px;
            font-weight: 800;
            color: #0e2c56;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1.5px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }

        .terms-text {
            font-size: 9.5px;
            color: #475569;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .contact-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 12px;
            font-size: 10px;
        }

        .contact-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .contact-row:last-child {
            margin-bottom: 0;
        }

        .contact-title {
            color: #64748b;
            font-weight: 600;
        }

        .contact-val {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }

        .signature-block {
            text-align: center;
            margin-top: auto;
            padding-top: 8px;
        }

        .signature-line {
            width: 140px;
            height: 1px;
            background: #0f172a;
            margin: 22px auto 4px;
        }

        .signature-label {
            font-size: 9px;
            font-weight: 700;
            color: #0e2c56;
            text-transform: uppercase;
        }

        .signature-sub {
            font-size: 8px;
            color: #64748b;
        }

        .card-footer-strip {
            background: #0e2c56;
            color: white;
            text-align: center;
            font-size: 8.5px;
            font-weight: 600;
            padding: 6px;
            margin: 12px -18px -14px;
            letter-spacing: 0.5px;
        }

        /* PRINT STYLES */
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .badges-wrapper {
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
                gap: 15mm !important;
            }

            .id-card {
                box-shadow: none !important;
                border: 1px solid #94a3b8 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>

    <!-- TOP TOOLBAR (HIDDEN ON PRINT) -->
    <div class="toolbar no-print">
        <div class="toolbar-title">
            <i class="fa-solid fa-id-card"></i>
            <span>Student Official ID Badge Layout</span>
        </div>

        <div class="toolbar-actions">
            <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Student Profile</span>
            </a>

            <a href="{{ route('students.badges.batch') }}" class="btn btn-secondary">
                <i class="fa-solid fa-layer-group"></i>
                <span>Batch Badge Printing</span>
            </a>

            <button onclick="window.print()" class="btn btn-primary">
                <i class="fa-solid fa-print"></i>
                <span>Print Badge (Front & Back)</span>
            </button>
        </div>
    </div>

    <!-- BADGES CONTAINER -->
    <div class="badges-wrapper">

        <!-- ============================================== -->
        <!-- BADGE FRONT -->
        <!-- ============================================== -->
        <div class="id-card">
            <!-- HEADER -->
            <div class="card-header">
                <div class="school-name">VIP Learning Center Inc.</div>
                <div class="badge-type">Campus Presence Pass</div>
                <div class="lanyard-hole"></div>
            </div>

            <!-- BODY FRONT -->
            <div class="card-body-front">
                <!-- PHOTO -->
                <div class="photo-container">
                    <img src="{{ $student->photo_url }}" alt="{{ $student->first_name }} {{ $student->last_name }}">
                </div>

                <!-- NAME -->
                <div class="student-name">
                    {{ $student->first_name }}
                    @if($student->middle_name)
                        {{ substr($student->middle_name, 0, 1) }}.
                    @endif
                    {{ $student->last_name }}
                </div>

                <!-- STUDENT ID -->
                <div class="student-id-pill">
                    {{ $student->student_no }}
                </div>

                <!-- INFO GRID -->
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Grade Level</span>
                        <span class="info-value">Grade {{ $student->grade_level }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Section</span>
                        <span class="info-value">{{ $student->section ?: 'General' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Gender</span>
                        <span class="info-value">{{ $student->gender ?: 'N/A' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">School Year</span>
                        <span class="info-value">2026 - 2027</span>
                    </div>
                </div>

                <!-- QR CODE SECTION -->
                <div class="qr-section">
                    <div class="qr-box">
                        <img 
                            src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($student->qr_code ?: $student->student_no) }}&margin=4" 
                            alt="QR Code for {{ $student->student_no }}"
                        >
                    </div>
                    <div class="qr-caption">
                        Scan at Campus Gate Kiosk
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- BADGE BACK -->
        <!-- ============================================== -->
        <div class="id-card">
            <!-- HEADER -->
            <div class="card-header">
                <div class="school-name">VIP Learning Center Inc.</div>
                <div class="badge-type">Student Information & Terms</div>
                <div class="lanyard-hole"></div>
            </div>

            <!-- BODY BACK -->
            <div class="card-body-back">
                <div>
                    <div class="back-section-title">Terms of Use & Security Policy</div>
                    <p class="terms-text">
                        1. This identification pass is property of VIP Learning Center Inc. and is non-transferable.<br>
                        2. The student must present this badge at the automated gate reader upon arrival (Time In) and departure (Time Out).<br>
                        3. Loss of this badge must be reported immediately to the School Registrar.
                    </p>

                    <div class="back-section-title">Emergency Contact Information</div>
                    <div class="contact-box">
                        @php
                            $parent = $student->parents->first();
                        @endphp

                        @if($parent)
                            <div class="contact-row">
                                <span class="contact-title">Guardian / Parent:</span>
                                <span class="contact-val">{{ $parent->first_name }} {{ $parent->last_name }}</span>
                            </div>

                            <div class="contact-row">
                                <span class="contact-title">Contact No:</span>
                                <span class="contact-val">{{ $parent->phone ?: '0917-000-0000' }}</span>
                            </div>

                            <div class="contact-row">
                                <span class="contact-title">Address:</span>
                                <span class="contact-val">{{ \Illuminate\Support\Str::limit($parent->address ?: 'Sorsogon City', 32) }}</span>
                            </div>
                        @else
                            <div class="contact-row">
                                <span class="contact-title">Campus Hotline:</span>
                                <span class="contact-val">(056) 123-4567</span>
                            </div>
                            <div class="contact-row">
                                <span class="contact-title">Emergency Cell:</span>
                                <span class="contact-val">0917-888-9999</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SIGNATURE -->
                <div class="signature-block">
                    <div class="signature-line"></div>
                    <div class="signature-label">Dr. Alfonso Estacio, Ed.D.</div>
                    <div class="signature-sub">School Principal / Campus Administrator</div>
                </div>

                <!-- FOOTER STRIP -->
                <div class="card-footer-strip">
                    If found, please return to VIP Learning Center Administration Office.
                </div>
            </div>
        </div>

    </div>

</body>
</html>
