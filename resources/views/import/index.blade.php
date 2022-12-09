<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Inquries</title>


</head>
<body class="container-fluid">
<h1 class="text-center">Inquries</h1>
<table class="table ">
    <thead>
        <tr>
            <td colspan="10">{{ count($data) }}</td>
        </tr>
        <tr>
            <th>created_at </th>
            <th>email</th>
            <th>prename</th>
            <th>surname</th>
            <th>gender</th>
            <th>domain_id </th>
            <th>offer_price </th>
            <th>offer_time </th>

            <th>ip</th>
            <th>website_language</th>
            <th>browser_language</th>
        </tr>

    </thead>
    <tbody>

    @foreach($data as $row)

        <tr>
           {{-- @dd($row)--}}
            <td>{{ $row['created_at'] }}</td>
            <td>{{ $row['email'] }}</td>
            <td>{{ $row['prename'] }}</td>
            <td>{{ $row['surname'] }}</td>
            <td>{{ $row['gender'] }}</td>
            <td>{{ $row['domain_id'] }}</td>
            <td>{{ $row['offer_price'] }}</td>
            <td>{{ $row['offer_time'] }}</td>
            <td>{{ $row['ip'] }}</td>
            <td>{{ $row['website_language'] }}</td>
            <td>{{ $row['browser_language'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="col-12 safe-score justify-content-center" id="safe-score">

</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
-->
</body>
</html>
