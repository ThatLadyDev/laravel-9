<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Company's Email</title>
    <style>
        .email-container {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .email-header {
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
        }
        .email-header h1 {
            margin: 0;
        }
        .email-content {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-footer {
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
<table class="email-container" role="presentation" width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td class="email-header">
            <h1>VanillaSoft</h1>
        </td>
    </tr>
    <tr>
        <td class="email-content" style="padding: 20px;">
            @yield('content')
        </td>
    </tr>
    <tr>
        <td class="email-footer">
            &copy; {{ date('Y') }} VanillaSoft. All rights reserved.
        </td>
    </tr>
</table>
</body>
</html>
