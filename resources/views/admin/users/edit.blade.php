<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            .nav-link {
                color: white
            }
            .nav-link:hover {
                background-color: #ccc;
                color: #17a2b8
            }
        </style>
</head>
<body>
    <h1>Edit a User</h1>
    
    <form action="{{route('user.update', ['user' => $user])}}" method="post">
       @csrf
       @method("put")
            <div class="form-group col-md-4">
                <label for="inputName" style="font-weight: bold">Name:  </label>
                <input type="text" class="form-control" id="inputName" placeholder="Product name"  name="name" value="{{$user -> name}}">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                    <label for="email" style="font-weight: bold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user -> email}}" >
                    @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="password" style="font-weight: bold">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{$user-> password}}" >
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
        </div>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>
    </x-app-layout>
