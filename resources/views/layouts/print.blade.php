<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Print')</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color:#111827; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f3f4f6; }
        @media print { button { display:none; } }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>