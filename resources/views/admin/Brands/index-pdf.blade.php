<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>

    <style>
        p{
            margin-left: 40%;
            color: blue;
            font-size: 50px;
        }
        table th {
   text-align: center;
}

table {

   margin: auto;
   width: 50% ;
}
table, th, td  {
  border: 2px solid red;
  border-collapse: collapse;

}


    </style>
</head>
<body>

    <p>ALL Brands Here.</p>
    <table  >
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Brand Name</th>
            <th scope="col">Brand SLug</th>
            <th>brand logo</th>

          </tr>
        </thead>
        <tbody>
     @foreach ($data as $key=>$row)
     <tr>
        <th scope="row">{{$key++}}</th>
        <td>{{$row->brand_name}}</td>
        <td>{{$row->brand_slug}}</td>
        <td><img src="{{$row->brand_logo}}" width="20px" height="20px" alt=""></td>

      </tr>
     @endforeach
        </tbody>
      </table>

</body>
</html>
