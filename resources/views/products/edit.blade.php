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
    <h1>Edit a Product</h1>
    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>


        @endif
    </div>
    <form action="{{route('product.update', ['product' => $product])}}" method="post">
       @csrf
       @method("put")
            <div class="form-group col-md-3">
                <label for="inputName" style="font-weight: bold">Name:  </label>
                <input type="text" class="form-control" id="inputName" placeholder="Product name" value="{{$product->name}}"  name="name">
              
            </div>
            <div class="form-group col-md-3">
                    <label for="price" style="font-weight: bold">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{$product->price}}" >
            </div>
            <div class="form-group col-md-3">
                <label for="quantity" style="font-weight: bold">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{$product->quantity}}">
            </div>
            <div class="form-group col-md-3">
                    <label for="description" style="font-weight: bold">Description:<label> </label> </label>
                    <input type="text" class="form-control" id="description" placeholder="Description"  name="description" value="{{$product->description}}">                  
            </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>