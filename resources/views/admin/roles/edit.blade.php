<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Create Permission</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
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
    <h1>Create a Role</h1>
    <div>
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>

        @endif
    </div>
    <form action="{{route('role.update', ['role' => $role])}}" method="post">
        @csrf
        @method("put")
        <div class="form-group col-md-6">
            <label for="inputName" style="font-weight: bold">Name: </label>
            <input type="text" class="form-control" id="inputName" placeholder="Role Name" name="name"
                   value="{{$role->name}}">

        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <h1>{{ __('Permissions') }}</h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Permission') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td class="styled-checkbox">
                                <input type="checkbox" value="{{ $permission->name }}" name="permission[]"
                                       id="permission_{{ $permission->id }}"
                                       @if ($role->permissions->contains('id', $permission->id)) checked @endif />
                                <label class="checkmark" for="permission_{{ $permission->id }}"></label>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="form-group col-md-6">
                <h1>{{ __('Users') }}</h1>

                <label for="users">{{ __('Users') }}</label>
                <select class="form-control" name="users[]" id="users" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if ($role->users->contains('id', $user->id)) selected @endif>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Add</button>
    </form>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </html>
</x-app-layout>

