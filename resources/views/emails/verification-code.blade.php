<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رمز التحقق</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 25px;
        }
        .code {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            letter-spacing: 2px;
        }
        .footer {
            font-size: 14px;
            color: #999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>رمز التحقق</h1>
        
        <p>مرحباً، يرجى استخدام الرمز التالي لتأكيد حسابك:</p>
        
        <div class="code">{{ $code }}</div>
        
        <p>هذا الرمز صالح لمدة 10 دقائق.</p>
        
    </div>
</body>
</html>