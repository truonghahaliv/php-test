<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Products</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
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

    <div class="container">

        <div>

            <div class="container">

                <a href="{{route('product.create')}}" class="btn  p-2"
                   style="background: #58abff; color: white; margin-bottom: 45px;margin-top: 30px ">Add New Product</a>
            </div>
            <div class="container">
                <a href="{{ route('product.file') }}" class="btn p-2"
                   style="background: #58abff; color: white; margin-bottom: 45px; margin-top: 30px;">Import File List
                    User</a>
            </div>


        </div>
        <div class="container" style="margin-top: -30px">
            <h2 style="color: #17a2b8">List Product</h2>
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Name</th>

                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>

                @foreach ($products as $p)
                    <tr>
                        <td>{{$p -> id}}</td>
                        <td>{{$p -> name}}</td>
                        <td>{{$p -> price}}</td>
                        <td>{{$p -> quantity}}</td>
                        <td>{{$p -> description}}</td>

                        <td>
                            <img src="{{$p->image}}" alt="Product Image" width="64" height="64">
                        </td>
                        <td><a class="btn btn-primary"
                               href="{{route('product.edit',['product' => $p])}}">Edit</a>

                        </td>
                        <td>
                            <form method="post" action="{{route('product.destroy', ['product' => $p])}}">
                                @csrf
                                @method('delete')
                                <input class="btn btn-danger" type="submit" value="Delete"/>
                            </form>
                        </td>

                    </tr>
                @endforeach


            </table>
            <div>
                @if (session() -> has ('success') )
                    <div style="color: green">
                        {{session('success')}}
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-end"> {{$products->links()}}</div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
    </body>
    </html>

</x-app-layout>
