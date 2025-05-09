<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/food/add_food">Page Add Food</a>
    @foreach ($foods as $food )
        <h1>{{ $food->name }}</h1>
        <h1>{{ $food->email }}</h1>
        <h1>{{ $food->password }}</h1>
    @endforeach
</body>
</html>