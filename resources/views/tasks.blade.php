<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Slevoking task</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-2"></div>
    <a href="{{ route('one') }}" class="btn btn-success col-md-2">Úloha 1</a>
    <a href="{{ route('two') }}" class="btn btn-info col-md-2">Úloha 2</a>
    <a href="{{ route('three') }}" class="btn btn-warning col-md-2">Úloha 3</a>
    <a href="{{ route('four') }}" class="btn btn-danger col-md-2">Úloha 4</a>
</div>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2">
        <h4>IP užívateľa: {{$userInfo['ip']}}</h4>
    </div>
    <div class="col-md-2">
        <h4>Locale užívateľa: {{$userInfo['locale']}}</h4>
    </div>
    <div class="col-md-4">
        <h4>UserAgent užívateľa: {{$userInfo['userAgent']}}</h4>
    </div>
</div>
@isset($validObjects)
    @php $progressPercentage = (100/($validObjectsCount + $invalidObjectsCount)) @endphp
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <h2>Počet správnych objektov: {{$validObjectsCount}}</h2>
        </div>
        <div class="col-md-5">
            <h2>Počet nesprávnych objektov: {{$invalidObjectsCount}}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar"
                     style="width:{{$validObjectsCount*$progressPercentage}}%">
                    {{$validObjectsCount}}
                </div>
                <div class="progress-bar bg-danger" role="progressbar"
                     style="width:{{$invalidObjectsCount*$progressPercentage}}%">
                    {{$invalidObjectsCount}}
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>first</th>
                    <th>second</th>
                    <th>third</th>
                    <th>math</th>
                    <th>created</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($validObjects as $object)
                    <tr>
                        <td>{{$object->id}}</td>
                        <td>{{$object->name}}</td>
                        <td>{{$object->first}}</td>
                        <td>{{$object->second}}</td>
                        <td>{{$object->third}}</td>
                        <td>{{$object->math}}</td>
                        <td>{{$object->created}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endisset
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</html>
