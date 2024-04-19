<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>JSP Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
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
    <h1>Users</h1>
    <div class="container">
        <div>
            <div class="container">
                <a href="{{ route('user.create') }}" class="btn p-2" style="background: #58abff; color: white; margin-bottom: 45px; margin-top: 30px;">Add New User</a>
            </div>
        </div>
        <div class="container" style="margin-top: -30px">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Name</th>    
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>    
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->role == 0)
    <td>Admin</td>
@elseif ($user->role == 1)
    <td>Customer</td>
@endif

                    <td>
                        <a class="btn btn-primary" href="{{ route('user.edit', ['user' => $user]) }}">Edit</a>
                    </td>
                    <td>
                        @if ($user->id !== auth()->user()->id)
                        <form id="deleteForm{{ $user->id }}" method="post" action="{{ route('user.destroy', ['user' => $user]) }}">
                            @csrf 
                            @method('delete')
                            <button class="btn btn-danger" type="button" onclick="confirmDelete({{ $user->id }})">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
            <div>
                @if (session()->has('success'))
                <div style="color: green">
                    {{ session('success') }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById('deleteForm' + userId).submit();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQ