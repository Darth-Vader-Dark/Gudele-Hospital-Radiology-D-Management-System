<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background: #f5f7fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 15px;
        }
        .logo-section {
            width: 100px;
            margin-right: 20px;
            text-align: center;
        }
        .logo {
            width: 130px;
            height: 130px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .logo img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }
        .header-title {
            flex: 1;
        }
        .header-title h1 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header-title p {
            color: #7f8c8d;
            font-size: 13px;
        }
        .title {
            text-align: center;
            font-size: 20px;
            color: #2c3e50;
            margin: 30px 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .info-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ecf0f1 100%);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #3498db;
        }
        .info-card h2 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 15px;
            text-transform: uppercase;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            background: white;
            padding: 10px;
            border-radius: 5px;
        }
        .info-label {
            font-size: 11px;
            color: #7f8c8d;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 13px;
            color: #2c3e50;
            font-weight: bold;
        }
        .medical-history {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #f39c12;
        }
        .medical-history h3 {
            color: #f39c12;
            font-size: 12px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .medical-history p {
            font-size: 12px;
            color: #333;
        }
        .appointment-card {
            background: #d4edda;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #27ae60;
            margin-bottom: 20px;
        }
        .appointment-card h3 {
            color: #27ae60;
            font-size: 12px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .appointment-details {
            font-size: 12px;
            color: #333;
        }
        .results-list {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #ecf0f1;
            margin-bottom: 20px;
        }
        .results-list h3 {
            color: #2c3e50;
            font-size: 13px;
            margin-bottom: 15px;
            text-transform: uppercase;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .result-item {
            background: #f0f3f4;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 5px;
            border-left: 3px solid #27ae60;
            font-size: 12px;
        }
        .result-type {
            font-weight: bold;
            color: #27ae60;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
            font-size: 10px;
        }
        .footer-text {
            color: #7f8c8d;
        }
        .print-date {
            color: #2c3e50;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-primary {
            background: #cfe9f3;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ public_path('images/logo.png') }}" alt="Hospital Logo">
                </div>
            </div>
            <div class="header-title">
                <h1>GUDELE HOSPITAL</h1>
                <p>Radiology Department - Patient Summary Report</p>
            </div>
        </div>

        <div class="title">Patient Record Summary</div>

        <!-- Patient Information -->
        <div class="info-card">
            <h2>Patient Details</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Patient ID</div>
                    <div class="info-value">{{ $patient->patient_id }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">{{ $patient->date_of_birth->format('d/m/Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Age</div>
                    <div class="info-value">{{ $patient->age }} years</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ ucfirst($patient->sex) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Contact</div>
                    <div class="info-value">{{ $patient->phone }}</div>
                </div>
            </div>
        </div>

        <!-- Medical History -->
        @if($patient->medical_history)
            <div class="medical-history">
                <h3>Medical History</h3>
                <p>{{ $patient->medical_history }}</p>
            </div>
        @endif

        <!-- Recent Radiology Results -->
        @if($results->count() > 0)
            <div class="results-list">
                <h3>Radiology Examination Results</h3>
                @foreach($results as $result)
                    <div class="result-item">
                        <div class="result-type">{{ $result->examination_type }}</div>
                        <div style="margin-top: 5px;">{{ Str::limit($result->findings, 100) }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Next Appointment -->
        @if($nextAppointment)
            <div class="appointment-card">
                <h3>Next Appointment</h3>
                <div class="appointment-details">
                    <strong>Date:</strong> {{ $nextAppointment->scheduled_date->format('d F Y') }}<br>
                    <strong>Time:</strong> {{ $nextAppointment->scheduled_date->format('H:i') }}<br>
                    <strong>Doctor:</strong> {{ $nextAppointment->doctor->name }}
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                <strong>Gudele Hospital Radiology Department</strong><br>
                Report Generated: {{ now()->format('d F Y \a\t H:i:s') }}
            </div>
            <div class="print-date">
                <span class="badge badge-primary">OFFICIAL RECORD</span>
            </div>
        </div>
    </div>
</body>
</html>
