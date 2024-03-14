<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday Planner PDF</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            text-transform: uppercase;
        }
        .holiday-info {
            margin-bottom: 30px;
        }
        .holiday-info p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }
        strong {
            color: #000;
        }
    </style>
</head>
<body>
    <h1>Holiday Planner</h1>
    <div class="holiday-info">
        <p><strong>Title:</strong> {{ $holidayPlan->title }}</p>
        <p><strong>Description:</strong> {{ $holidayPlan->description }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($holidayPlan->date)->format('d/m/Y') }}</p>
        <p><strong>Location:</strong> {{ $holidayPlan->location }}</p>
        <p><strong>Participants:</strong> {{ $holidayPlan->participants }}</p>
    </div>
</body>
</html>
