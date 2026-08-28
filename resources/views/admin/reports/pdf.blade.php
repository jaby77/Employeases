<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Employease Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.6; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0F172A; padding-bottom: 20px; }
        .header h1 { margin: 0; color: #0F172A; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #666; }
        .summary { margin-bottom: 30px; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { padding: 8px 12px; border: 1px solid #ddd; }
        .summary td:first-child { font-weight: bold; background: #f8f9fa; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #0F172A; color: #fff; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>EMPLOYEASE</h1>
        <p>Municipal Public Employment Service Office<br>Tagudin, Ilocos Sur</p>
        <p>Employment Report - {{ now()->format('F d, Y') }}</p>
    </div>

    <div class="summary">
        <h2>Summary</h2>
        <table>
            <tr><td>Total Job Vacancies</td><td>{{ $totalVacancies }}</td></tr>
            <tr><td>Total Applicants</td><td>{{ $totalApplicants }}</td></tr>
        </table>
    </div>

    <h2>Job Vacancies</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Applicants</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vacancies as $vacancy)
                <tr>
                    <td>{{ $vacancy->title }}</td>
                    <td>{{ $vacancy->category?->name ?? 'N/A' }}</td>
                    <td>{{ $vacancy->applications_count }}</td>
                    <td>{{ $vacancy->is_open ? 'Open' : 'Closed' }}</td>
                    <td>{{ $vacancy->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated on {{ now()->format('F d, Y h:i A') }} by {{ auth()->user()->name }}</p>
        <p>&copy; {{ date('Y') }} EMPLOYEASE - PESO Tagudin, Ilocos Sur</p>
    </div>
</body>
</html>
