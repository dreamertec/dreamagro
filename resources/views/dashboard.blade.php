<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DreamAgro — Smart Agricultural Controller</title>
    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0b0914;
            --card-bg: rgba(255, 255, 255, 0.04);
            --card-border: rgba(255, 255, 255, 0.08);
            --card-hover-border: rgba(255, 255, 255, 0.15);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --color-primary: #10b981; /* Emerald */
            --color-primary-rgb: 16, 185, 129;
            --color-accent: #3b82f6; /* Blue */
            --color-accent-rgb: 59, 130, 246;
            --color-warning: #f59e0b; /* Amber */
            --color-danger: #ef4444;
            --shadow-glow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(15, 12, 29, 1) 0%, rgba(11, 9, 20, 1) 100%);
            background-attachment: fixed;
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.5;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* HEADER */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 1.5rem;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }

        .logo-icon svg {
            width: 26px;
            height: 26px;
            fill: white;
        }

        .logo-text h1 {
            font-size: 1.75rem;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #ffffff, #d1d5db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-text span {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-family: 'Outfit', sans-serif;
            display: block;
            margin-top: -2px;
        }

        .system-time {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 0.5rem 1rem;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            color: var(--text-secondary);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .system-time span {
            color: var(--color-primary);
            font-weight: 600;
        }

        /* GRID LAYOUTS */
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        @media (min-width: 1024px) {
            .main-grid {
                grid-template-columns: 4fr 5fr;
            }
        }

        /* GLASSMOPHISM CARD */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: var(--shadow-glow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            border-color: var(--card-hover-border);
            transform: translateY(-2px);
        }

        /* WIDGET CARDS */
        .widget {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .widget-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .widget-info {
            display: flex;
            flex-direction: column;
        }

        .widget-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .widget-value {
            font-size: 1.85rem;
            font-weight: 700;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
        }

        /* SPECIFIC WIDGETS */
        .widget-temp .widget-icon {
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: var(--color-warning);
        }
        .widget-hum .widget-icon {
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: var(--color-accent);
        }
        .widget-device .widget-icon {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--color-primary);
        }

        /* BUTTONS & CONTROLS */
        .card-title-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 0.75rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-title svg {
            width: 20px;
            height: 20px;
            color: var(--color-primary);
        }

        /* MODE SWITCHER */
        .mode-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0.35rem;
            border-radius: 14px;
            margin-bottom: 2rem;
        }

        .mode-btn {
            background: transparent;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .mode-btn:hover {
            color: #ffffff;
        }

        .mode-btn.active {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Active styling based on selected system mode */
        body.mode-auto .mode-btn.btn-auto {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.05));
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--color-primary);
        }
        body.mode-manual .mode-btn.btn-manual {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.05));
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: var(--color-accent);
        }
        body.mode-disabled .mode-btn.btn-disabled {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.05));
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--color-danger);
        }

        /* MANUAL SWITCH LIST */
        .control-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            margin-bottom: 1rem;
            transition: all 0.2s ease;
        }

        .control-row:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .control-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .control-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
        }

        .control-row.active .control-icon-wrapper {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--color-primary);
        }

        .control-details h4 {
            font-size: 1rem;
            margin-bottom: 0.15rem;
        }

        .control-details p {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* SWITCH TOGGLE */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 56px;
            height: 30px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background-color: #ffffff;
            transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        input:checked + .slider {
            background-color: var(--color-primary);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* FORMS */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-select, .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: #ffffff;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-select:focus, .form-input:focus {
            border-color: var(--color-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .form-select option {
            background-color: #121021;
            color: #ffffff;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--color-primary), #059669);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        /* TABLES */
        .table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        th {
            background: rgba(255, 255, 255, 0.02);
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: var(--text-secondary);
            font-family: 'Outfit', sans-serif;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            color: var(--text-primary);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.01);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-dripper {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .badge-fogger {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .btn-delete {
            background: transparent;
            border: none;
            color: var(--color-danger);
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        /* NOTIFICATION BANNER */
        .alert-banner {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #34d399;
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 2.5rem 0;
            color: var(--text-secondary);
            font-size: 0.8rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 3rem;
        }

        .pulse-indicator {
            width: 8px;
            height: 8px;
            background-color: var(--color-primary);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse 1.6s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
    </style>
</head>
<body class="mode-{{ $settings->mode }}">
    <div class="container">
        <!-- HEADER -->
        <header>
            <div class="logo-group">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <h1>DreamAgro</h1>
                    <span>Precision Agriculture Dashboard</span>
                </div>
            </div>
            <div class="system-time">
                <span class="pulse-indicator"></span> Controller Online • Subdomain: <span>dreamagro.dreamertec.com</span>
            </div>
        </header>

        @if(session('success'))
        <div class="alert-banner">
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <!-- TELEMETRY STATUS ROW -->
        <div class="widget-grid">
            <!-- Mode Status Widget -->
            <div class="card widget widget-device">
                <div class="widget-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div class="widget-info">
                    <span class="widget-label">System Mode</span>
                    <span class="widget-value" id="status-mode-label" style="text-transform: capitalize;">{{ $settings->mode }}</span>
                </div>
            </div>

            <!-- Temperature Widget -->
            <div class="card widget widget-temp">
                <div class="widget-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"></path>
                    </svg>
                </div>
                <div class="widget-info">
                    <span class="widget-label">Air Temperature</span>
                    <span class="widget-value">{{ number_format($latestSensor->temperature, 1) }} °C</span>
                </div>
            </div>

            <!-- Humidity Widget -->
            <div class="card widget widget-hum">
                <div class="widget-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="widget-info">
                    <span class="widget-label">Relative Humidity</span>
                    <span class="widget-value">{{ number_format($latestSensor->humidity, 1) }} %</span>
                </div>
            </div>
        </div>

        <!-- MAIN LAYOUT GRID -->
        <div class="main-grid">
            <!-- LEFT PANEL: CONTROLS -->
            <div class="card">
                <div class="card-title-group">
                    <h3 class="card-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.47,5.34 14.86,5.08L14.47,2.42C14.43,2.18 14.22,2 13.97,2H9.97C9.72,2 9.5,2.18 9.47,2.42L9.08,5.08C8.47,5.34 7.9,5.66 7.38,6.05L4.89,5.05C4.67,4.96 4.4,5.05 4.27,5.27L2.27,8.73C2.15,8.95 2.2,9.22 2.39,9.37L4.5,11C4.47,11.34 4.45,11.67 4.45,12C4.45,12.33 4.47,12.65 4.5,12.97L2.39,14.63C2.2,14.78 2.15,15.05 2.27,15.27L4.27,18.73C4.4,18.95 4.67,19.04 4.89,18.95L7.38,17.95C7.9,18.34 8.47,18.66 9.08,18.92L9.47,21.58C9.5,21.82 9.72,22 9.97,22H13.97C14.22,22 14.43,21.82 14.47,21.58L14.86,18.92C15.47,18.66 16.04,18.34 16.56,17.95L19.05,18.95C19.27,19.04 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z"/>
                        </svg>
                        System Controls
                    </h3>
                </div>

                <!-- Operating Mode Buttons -->
                <div class="form-group">
                    <label class="form-label">System Mode</label>
                    <div class="mode-selector">
                        <button class="mode-btn btn-auto {{ $settings->mode == 'auto' ? 'active' : '' }}" onclick="updateSystemMode('auto')">Auto</button>
                        <button class="mode-btn btn-manual {{ $settings->mode == 'manual' ? 'active' : '' }}" onclick="updateSystemMode('manual')">Manual</button>
                        <button class="mode-btn btn-disabled {{ $settings->mode == 'disabled' ? 'active' : '' }}" onclick="updateSystemMode('disabled')">Disabled</button>
                    </div>
                </div>

                <!-- Manual Valves & Motor Overrides -->
                <div class="form-group">
                    <label class="form-label" style="margin-bottom: 0.75rem;">Manual Valve & Pump Overrides</label>

                    <!-- PUMP/MOTOR TOGGLE -->
                    <div class="control-row {{ $settings->motor_override == 'ON' ? 'active' : '' }}" id="row-motor">
                        <div class="control-info">
                            <div class="control-icon-wrapper">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <div class="control-details">
                                <h4>Water Pump Motor</h4>
                                <p>Manual Pump Override Control</p>
                            </div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="toggle-motor" {{ $settings->motor_override == 'ON' ? 'checked' : '' }} onchange="toggleOverride('motor')">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <!-- DRIPPER TOGGLE -->
                    <div class="control-row {{ $settings->dripper_override == 'ON' ? 'active' : '' }}" id="row-dripper">
                        <div class="control-info">
                            <div class="control-icon-wrapper">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22a7 7 0 0 0 7-7c0-4.3-7-11-7-11S5 10.7 5 15a7 7 0 0 0 7 7z"></path>
                                </svg>
                            </div>
                            <div class="control-details">
                                <h4>Dripper Valve</h4>
                                <p>Manual Drip Irrigation Override</p>
                            </div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="toggle-dripper" {{ $settings->dripper_override == 'ON' ? 'checked' : '' }} onchange="toggleOverride('dripper')">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <!-- FOGGER TOGGLE -->
                    <div class="control-row {{ $settings->fogger_override == 'ON' ? 'active' : '' }}" id="row-fogger">
                        <div class="control-info">
                            <div class="control-icon-wrapper">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M12 8l0 4"></path>
                                    <path d="M12 16l.01 0"></path>
                                </svg>
                            </div>
                            <div class="control-details">
                                <h4>Fogger Valve</h4>
                                <p>Manual Mist / Fogger Override</p>
                            </div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="toggle-fogger" {{ $settings->fogger_override == 'ON' ? 'checked' : '' }} onchange="toggleOverride('fogger')">
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL: SCHEDULES -->
            <div class="card">
                <div class="card-title-group">
                    <h3 class="card-title">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                            <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"/>
                        </svg>
                        Irrigation Schedule Manager
                    </h3>
                </div>

                <!-- Add Schedule Form -->
                <form action="{{ route('dashboard.schedules.store') }}" method="POST" style="margin-bottom: 2rem;">
                    @csrf
                    <div style="display: grid; grid-template-columns: 2fr 2fr 1fr; gap: 1rem; align-items: end;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Valve Type</label>
                            <select name="type" class="form-select" required>
                                <option value="dripper">Dripper Valve</option>
                                <option value="fogger">Fogger Valve</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Start Time</label>
                            <input type="time" name="time" class="form-input" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Duration (Mins)</label>
                            <input type="number" name="duration" class="form-input" min="1" max="120" value="10" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit" style="margin-top: 1rem;">Add Schedule Timer</button>
                </form>

                <!-- Active Schedules List -->
                <h4 style="margin-bottom: 0.75rem; font-size: 0.95rem; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 0.05em;">Current Timers</h4>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Valve</th>
                                <th>Start Time</th>
                                <th>Duration</th>
                                <th>Recurrence</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $s)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $s->type }}">
                                        {{ ucfirst($s->type) }}
                                    </span>
                                </td>
                                <td style="font-family: 'Outfit', sans-serif; font-weight: 500;">
                                    {{ date('h:i A', strtotime($s->time)) }}
                                </td>
                                <td>{{ $s->duration }} minutes</td>
                                <td style="color: var(--text-secondary);">Daily</td>
                                <td style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                                     <button type="button" class="btn-delete" style="color: var(--color-accent); padding: 0.25rem; border-radius: 6px; display: inline-flex;" title="Edit schedule" onclick="openEditModal('{{ $s->id }}', '{{ $s->type }}', '{{ date('H:i', strtotime($s->time)) }}', '{{ $s->duration }}')">
                                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                             <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                             <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                         </svg>
                                     </button>
                                     <form action="{{ route('dashboard.schedules.destroy', $s->id) }}" method="POST" style="display: inline-flex;">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn-delete" title="Delete schedule">
                                             <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                 <polyline points="3 6 5 6 21 6"></polyline>
                                                 <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                 <line x1="10" y1="11" x2="10" y2="17"></line>
                                                 <line x1="14" y1="11" x2="14" y2="17"></line>
                                             </svg>
                                         </button>
                                     </form>
                                 </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 2rem;">No schedules configured. Add one above!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- BOTTOM AREA: SYSTEM ACTIVITY LOGS -->
        <div class="card">
            <div class="card-title-group">
                <h3 class="card-title">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                        <path d="M13,19C13,19.7 13.13,20.37 13.35,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5V13.35C20.37,13.13 19.7,13 19,13V5H5V19H13M11,7H7V9H11V7M17,7H13V9H17V7M11,11H7V13H11V11M13,11H12.35C12.13,11.63 11.79,12.21 11.35,12.7V13H13V11M17,12.35L19,10.35L21.65,13L17,17.65L14,14.65L15.35,13.3L17,15L17,12.35Z"/>
                    </svg>
                    System Operations Log (Valve Opens & Closes)
                </h3>
                <span style="font-size: 0.85rem; color: var(--text-secondary);">Real-Time Event Tracking</span>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Event Action</th>
                            <th>Trigger Source</th>
                        </tr>
                    </thead>
                    <tbody id="activity-log-body">
                        @forelse($activityLogs as $log)
                        <tr>
                            <td style="color: var(--text-secondary); font-family: monospace;">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td style="font-weight: 500;">
                                @if(str_contains(strtolower($log->event), 'open') || str_contains(strtolower($log->event), 'start') || str_contains(strtolower($log->event), 'on'))
                                    <span style="color: var(--color-primary); font-weight: 600;">●</span>
                                @else
                                    <span style="color: var(--color-danger); font-weight: 600;">○</span>
                                @endif
                                {{ $log->event }}
                            </td>
                            <td>
                                <span style="background: rgba(255,255,255,0.04); padding: 0.2rem 0.5rem; border-radius: 6px; font-size: 0.8rem;">
                                    {{ $log->triggered_by }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-secondary); padding: 2rem;">No system events logged yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <footer>
            <p>&copy; {{ date('Y') }} DreamAgro Irrigation Controller. Powered by Laravel 12 & ESP32 Precision Control.</p>
        </footer>
    </div>

    <!-- Dynamic Dashboard Interactive Scripts -->
    <script>
        // Set up global AJAX headers for CSRF protection
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Function to update system mode (auto, manual, disabled)
        function updateSystemMode(mode) {
            fetch("{{ route('dashboard.mode') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ mode: mode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update body class to toggle theme indicators
                    document.body.className = '';
                    document.body.classList.add('mode-' + mode);

                    // Update UI labels
                    document.getElementById('status-mode-label').innerText = mode;

                    // Toggle active button state
                    document.querySelectorAll('.mode-btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelector('.btn-' + mode).classList.add('active');

                    // If system is disabled, turn off all check toggles visually
                    if (mode === 'disabled') {
                        document.querySelectorAll('.toggle-switch input').forEach(input => {
                            input.checked = false;
                        });
                        document.querySelectorAll('.control-row').forEach(row => {
                            row.classList.remove('active');
                        });
                    }
                }
            })
            .catch(error => console.error("Error updating mode:", error));
        }

        // Function to toggle manual override settings
        function toggleOverride(target) {
            const checkbox = document.getElementById('toggle-' + target);
            const state = checkbox.checked ? 'ON' : 'OFF';

            fetch("{{ route('dashboard.override') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ target: target, state: state })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const row = document.getElementById('row-' + target);
                    if (state === 'ON') {
                        row.classList.add('active');
                    } else {
                        row.classList.remove('active');
                    }
                } else {
                    // Revert UI toggle on failure
                    checkbox.checked = !checkbox.checked;
                }
            })
            .catch(error => {
                console.error("Error toggling override:", error);
                checkbox.checked = !checkbox.checked;
            });
        }

        // Live reload dashboard data & log listings periodically (every 5 seconds)
        setInterval(() => {
            fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // 1. Update temperature & humidity values
                    const widgets = document.querySelectorAll('.widget-value');
                    const newWidgets = doc.querySelectorAll('.widget-value');
                    widgets.forEach((w, index) => {
                        if (newWidgets[index] && w.id !== 'status-mode-label') {
                            w.innerHTML = newWidgets[index].innerHTML;
                        }
                    });

                    // 2. Update toggle checkbox positions (only if user is not actively clicking)
                    const toggles = ['motor', 'dripper', 'fogger'];
                    toggles.forEach(t => {
                        const newToggle = doc.getElementById('toggle-' + t);
                        const currentToggle = document.getElementById('toggle-' + t);
                        const row = document.getElementById('row-' + t);
                        
                        if (newToggle && currentToggle) {
                            currentToggle.checked = newToggle.checked;
                            if (newToggle.checked) {
                                row.classList.add('active');
                            } else {
                                row.classList.remove('active');
                            }
                        }
                    });

                    // 3. Update activity logs table
                    const currentLog = document.getElementById('activity-log-body');
                    const newLog = doc.getElementById('activity-log-body');
                    if (currentLog && newLog) {
                        currentLog.innerHTML = newLog.innerHTML;
                    }
                })
                .catch(error => console.warn("Background sync failed:", error));
        }, 5000);

        // Edit Schedule Modal Handlers
        function openEditModal(id, type, time, duration) {
            document.getElementById('edit-type').value = type;
            document.getElementById('edit-time').value = time;
            document.getElementById('edit-duration').value = duration;
            
            const form = document.getElementById('edit-schedule-form');
            form.action = `/schedules/${id}`;
            
            document.getElementById('edit-modal').style.display = 'flex';
        }
        
        function closeEditModal() {
            document.getElementById('edit-modal').style.display = 'none';
        }
    </script>

    <!-- Edit Schedule Modal Overlay (Frosted Glass Glassmorphism) -->
    <div id="edit-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(11, 9, 20, 0.7); backdrop-filter: blur(8px); justify-content: center; align-items: center; z-index: 1000;">
        <div class="card" style="width: 420px; border: 1px solid var(--card-hover-border); box-shadow: 0 10px 40px rgba(0,0,0,0.5); padding: 2rem;">
            <div class="card-title-group" style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 0.75rem;">
                <h3 class="card-title" style="font-size: 1.2rem; display: flex; align-items: center; gap: 0.5rem; margin: 0;">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="color: var(--color-accent);">
                        <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"/>
                    </svg>
                    Edit Timer Schedule
                </h3>
                <button type="button" onclick="closeEditModal()" style="background: transparent; border: none; color: var(--text-secondary); cursor: pointer; font-size: 1.75rem; padding: 0; line-height: 1;">&times;</button>
            </div>
            
            <form id="edit-schedule-form" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.4rem;">Valve Type</label>
                    <select name="type" id="edit-type" class="form-select" required style="padding: 0.6rem 0.8rem;">
                        <option value="dripper">Dripper Valve</option>
                        <option value="fogger">Fogger Valve</option>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.4rem;">Start Time</label>
                    <input type="time" name="time" id="edit-time" class="form-input" required style="padding: 0.6rem 0.8rem;">
                </div>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label class="form-label" style="font-size: 0.8rem; margin-bottom: 0.4rem;">Duration (Mins)</label>
                    <input type="number" name="duration" id="edit-duration" class="form-input" min="1" max="120" required style="padding: 0.6rem 0.8rem;">
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="button" onclick="closeEditModal()" class="form-input" style="text-align: center; cursor: pointer; border-color: rgba(255,255,255,0.05); background: transparent; padding: 0.6rem 1rem;">Cancel</button>
                    <button type="submit" class="btn-submit" style="margin-top: 0; padding: 0.6rem 1rem; background: linear-gradient(135deg, var(--color-accent), #2563eb); box-shadow: 0 4px 15px rgba(59,130,246,0.2);">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
