<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Batch Student ID Badges - VIP Campus Presence</title>

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
        }

        .toolbar {
            background: #0e2c56;
            color: white;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 12px rgba(14, 44, 86, 0.15);
        }

        .toolbar-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 16px;
        }

        .toolbar-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-select {
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        .filter-select option {
            background: #0e2c56;
            color: white;
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

        /* Sheet grid layout */
        .batch-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 24px;
            justify-items: center;
        }

        .badge-item {
            width: 310px;
            height: 480px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
            border: 1.5px solid #cbd5e1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            page-break-inside: avoid;
            break-inside: avoid;
            position: relative;
        }

        .cut-guide {
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            border: 1px dashed #94a3b8;
            pointer-events: none;
            border-radius: 16px;
        }

        .card-header {
            background: linear-gradient(135deg, #0e2c56 0%, #123b70 100%);
            color: white;
            padding: 14px 12px 10px;
            text-align: center;
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #38bdf8 0%, #3b82f6 50%, #f59e0b 100%);
        }

        .school-name {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .badge-type {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 1.5px;
            color: #93c5fd;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .card-body {
            padding: 12px 14px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .photo-container {
            width: 96px;
            height: 96px;
            border-radius: 14px;
            overflow: hidden;
            border: 2.5px solid #0e2c56;
            box-shadow: 0 4px 8px rgba(14, 44, 86, 0.12);
            background: #f8fafc;
            margin-bottom: 8px;
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
            font-size: 14px;
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
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 9999px;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .info-grid {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 5px 8px;
            margin-bottom: 8px;
            font-size: 10.5px;
        }

        .info-item {
            text-align: left;
        }

        .info-label {
            font-size: 8.5px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            display: block;
        }

        .info-value {
            font-size: 10px;
            color: #0f172a;
            font-weight: 700;
        }

        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: auto;
            padding-bottom: 4px;
        }

        .qr-box {
            background: white;
            padding: 4px;
            border-radius: 8px;
            border: 1.5px solid #0e2c56;
            display: inline-flex;
        }

        .qr-box img {
            width: 90px;
            height: 90px;
            display: block;
        }

        .qr-caption {
            font-size: 8.5px;
            color: #64748b;
            font-weight: 600;
            margin-top: 3px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            width: 100%;
        }

        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .batch-container {
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 8mm !important;
            }

            .badge-item {
                box-shadow: none !important;
                border: 1px solid #94a3b8 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            @page {
                size: A4 portrait;
                margin: 8mm;
            }
        }
    </style>
</head>
<body>

    <!-- TOP TOOLBAR -->
    <div class="toolbar no-print">
        <div class="toolbar-title">
            <i class="fa-solid fa-layer-group"></i>
            <span>Batch Student ID Badge Generator ({{ $students->count() }} Badges)</span>
        </div>

        <form method="GET" action="{{ route('students.badges.batch') }}" class="toolbar-filter">
            <select name="grade_level" class="filter-select" onchange="this.form.submit()">
                <option value="">All Grade Levels</option>
                @foreach($gradeLevels as $gl)
                    <option value="{{ $gl }}" {{ request('grade_level') == $gl ? 'selected' : '' }}>Grade {{ $gl }}</option>
                @endforeach
            </select>

            <select name="section" class="filter-select" onchange="this.form.submit()">
                <option value="">All Sections</option>
                @foreach($sections as $sec)
                    <option value="{{ $sec }}" {{ request('section') == $sec ? 'selected' : '' }}>Section {{ $sec }}</option>
                @endforeach
            </select>

            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Students</span>
            </a>

            <button type="button" onclick="window.print()" class="btn btn-primary">
                <i class="fa-solid fa-print"></i>
                <span>Print All ({{ $students->count() }})</span>
            </button>
        </form>
    </div>

    <!-- BATCH BADGES GRID -->
    <div class="batch-container">
        @forelse($students as $student)
            <div class="badge-item">
                <div class="cut-guide"></div>

                <div class="card-header">
                    <div class="school-name">VIP Learning Center Inc.</div>
                    <div class="badge-type">Campus Presence Pass</div>
                </div>

                <div class="card-body">
                    <div class="photo-container">
                        <img src="{{ $student->photo_url }}" alt="{{ $student->first_name }} {{ $student->last_name }}">
                    </div>

                    <div class="student-name">
                        {{ $student->first_name }}
                        @if($student->middle_name)
                            {{ substr($student->middle_name, 0, 1) }}.
                        @endif
                        {{ $student->last_name }}
                    </div>

                    <div class="student-id-pill">
                        {{ $student->student_no }}
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Grade</span>
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
                            <span class="info-label">S.Y.</span>
                            <span class="info-value">2026 - 2027</span>
                        </div>
                    </div>

                    <div class="qr-section">
                        <div class="qr-box">
                            <img 
                                src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($student->qr_code ?: $student->student_no) }}&margin=4" 
                                alt="QR Code"
                            >
                        </div>
                        <div class="qr-caption">
                            Scan at Gate Kiosk
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fa-solid fa-id-card-clip" style="font-size: 40px; color: #94a3b8; margin-bottom: 12px;"></i>
                <h3 style="font-size: 16px; font-weight: 700; color: #334155;">No students found</h3>
                <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Try selecting a different grade level or section.</p>
                <a href="{{ route('students.badges.batch') }}" class="btn btn-primary" style="margin-top: 14px;">Clear Filters</a>
            </div>
        @endforelse
    </div>

</body>
</html>
