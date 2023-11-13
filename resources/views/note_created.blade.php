<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }

        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        li {
            margin-bottom: 5px;
        }

        strong {
            font-weight: bold;
        }
    </style>
    <title>Note Created</title>
</head>
<body>
<h1>New Note Created</h1>

<p>Dear Administrator,</p>

<p>A new note has been created:</p>

<ul>
    <li><strong>Id:</strong> {{ $note->id }}</li>
    <li><strong>User Id:</strong> {{ $note->user_id }}</li>
    <li><strong>Title:</strong> {{ $note->title }}</li>
    <li><strong>Content:</strong> {{ $note->text }}</li>
</ul>

<p>Thank you.</p>
</body>
</html>
