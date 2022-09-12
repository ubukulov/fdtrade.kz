<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Article</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Brand</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $product->article }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->convert('RUB', round($product->price2 + ($product->price2 * ($category->margin_ozon / 100)))) }}</td>
                <td>{{ $product->brand }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
