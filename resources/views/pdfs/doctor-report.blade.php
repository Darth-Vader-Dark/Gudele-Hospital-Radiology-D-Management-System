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
            line-height: 1.3;
        }
        .container {
            display: block;
            min-height: 100vh;
        }
        .sidebar {
            display: none;
        }
        .main-content {
            padding: 12px 25px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 8px;
        }

        .header .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header .brand img {
            width: 80px;
            height: auto;
            object-fit: contain;
            border-radius: 6px;
            background: #fff;
            padding: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        .header .title {
            text-align: left;
        }

        .header h1 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .header p {
            color: #7f8c8d;
            font-size: 11px;
        }
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .section {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        .section.fullwidth {
            grid-column: 1 / -1;
        }
        .section h2 {
            font-size: 13px;
            color: #2c3e50;
            margin-bottom: 8px;
            text-transform: uppercase;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #2c3e50;
            width: 40%;
        }
        .info-value {
            color: #555;
            width: 60%;
            text-align: right;
        }
        .results-section {
            background: white;
            padding: 12px;
            border-radius: 8px;
            border: 2px solid #ecf0f1;
            margin-bottom: 12px;
        }
        .results-section h3 {
            font-size: 12px;
            color: #2c3e50;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e74c3c;
        }
        .result-item {
            background: #f0f3f4;
            padding: 8px;
            margin-bottom: 6px;
            border-radius: 5px;
            border-left: 3px solid #27ae60;
        }
        .result-item-title {
            font-weight: bold;
            color: #27ae60;
            font-size: 11px;
            margin-bottom: 5px;
        }
        .result-item-value {
            color: #333;
            font-size: 11px;
        }
        .prescription {
            background: #fff3cd;
            padding: 8px;
            margin-bottom: 6px;
            border-radius: 5px;
            border-left: 3px solid #f39c12;
            font-size: 10px;
        }
        .prescription-title {
            font-weight: bold;
            color: #f39c12;
            margin-bottom: 5px;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #ecf0f1;
            font-size: 9px;
        }
        .signature-box {
            text-align: center;
            width: 150px;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            margin-right: 5px;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="brand">
                    <img src="{{ public_path('images/logo.png') }}" alt="Hospital Logo">
                    <div class="title">
                        <h1>RADIOLOGY REPORT</h1>
                        <p>{{ now()->format('d F Y - H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Patient & Doctor Information -->
            <div class="content-grid">
                <div class="section">
                    <h2>Patient Information</h2>
                    <div class="info-row">
                        <span class="info-label">Name:</span>
                        <span class="info-value"><strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Patient ID:</span>
                        <span class="info-value">{{ $patient->patient_id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">DOB:</span>
                        <span class="info-value">{{ $patient->date_of_birth->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Age:</span>
                        <span class="info-value">{{ $patient->age }} years</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Gender:</span>
                        <span class="info-value">{{ ucfirst($patient->sex) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Contact:</span>
                        <span class="info-value">{{ $patient->phone }}</span>
                    </div>
                </div>

                <div class="section">
                    <h2>Doctor Information</h2>
                    <div class="info-row">
                        <span class="info-label">Doctor:</span>
                        <span class="info-value"><strong>{{ $doctor->name }}</strong></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Department:</span>
                        <span class="info-value">Radiology</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Report Date:</span>
                        <span class="info-value">{{ now()->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Report Time:</span>
                        <span class="info-value">{{ now()->format('H:i:s') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="info-value"><span class="badge badge-success">COMPLETED</span></span>
                    </div>
                </div>
            </div>

            <!-- Radiology Results -->
            @if($results->count() > 0)
                <div class="results-section fullwidth">
                    <h3>Radiology Examination Results</h3>
                    @foreach($results as $result)
                        <div class="result-item">
                            <div class="result-item-title">{{ $result->examination_type }}</div>
                            <div class="result-item-value">
                                <strong>Findings:</strong> {{ $result->findings }}
                            </div>
                            @if($result->diagnosis)
                                <div class="result-item-value">
                                    <strong>Conclusions:</strong> {{ $result->diagnosis }}
                                </div>
                            @endif
                            @if($result->recommendation)
                                <div class="result-item-value">
                                    <strong>Recommendations:</strong> {{ $result->recommendation }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Prescriptions -->
            @if($prescriptions->count() > 0)
                <div class="results-section fullwidth">
                    <h3>Prescriptions</h3>
                    @foreach($prescriptions as $prescription)
                        <div class="prescription">
                            <div class="prescription-title">{{ $prescription->medication_name }} - {{ $prescription->dosage }}</div>
                            <div>{{ $prescription->instructions }}</div>
                            <div style="color: #666; margin-top: 5px;">Duration: {{ $prescription->duration ?? 'As needed' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Footer with Signature -->
            <div class="footer">
                <div class="signature-box">
                    <p style="margin-bottom: 20px;"><strong>Doctor's Signature</strong></p>
                    <div class="signature-line"></div>
                    <p>{{ $doctor->name }}</p>
                </div>
                <div class="signature-box">
                    <p style="margin-bottom: 20px;"><strong>Hospital Seal</strong></p>
                    <div style="border: 1px dashed #999; height: 40px; display: flex; align-items: center; justify-content: center; color: #999;">
                        [STAMP]
                    </div>
                </div>
                <div class="signature-box">
                    <p style="margin-bottom: 20px;"><strong>Date & Time</strong></p>
                    <div class="signature-line"></div>
                    <p>{{ now()->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
