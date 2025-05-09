<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/food/actionAddFood" method="post">
        @csrf
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
        @endif
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <label for="">Name</label><br>
        <input type="text" name="name" id="name"><br>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
        <label for="">Email</label><br>
        <input type="text" name="email" id="email"><br>
        @error('password')
            <span>{{ $message }}</span>
        @enderror
        <label for="">Password</label><br>
        <input type="text" name="password" id="password"><br>
        <button type="submit">Submit</button>
    </form>
    
</body>
</html>