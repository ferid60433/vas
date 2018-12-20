<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Andegna Systems PLC">
    <link rel="icon" href="favicon.ico">
    <title>{{ $title or 'Home' }} | Andegna Systems</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        th, td {
            /*border: black solid 1px;*/
        }
    </style>
</head>
<body onload="printMe()">
<div class="container">
    @include('layout._report')
</div>
<script>
    function printMe() {
        window.print();
    }
</script>
</body>
</html>
