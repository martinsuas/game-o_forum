<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <ul id="navigation">
        {% for item in navigation %}
            <li><a href="{{ item.href }}"</li>
        {% endfor %}
    </ul>
</body>
</html>