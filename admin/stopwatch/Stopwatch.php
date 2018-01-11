<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stopwatch</title>

    <link rel="shortcut icon" href="../../icon.png">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="Clock.js"></script>
    <style>
        body {
            background-color: #000000;
        }
    </style>
</head>
<body onload="show();">
<br>
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">Hours Streamed</span>
            <span class="info-box-number" id="time"></span>
        </div>
    </div>
</div>

<br>
<input type="button" value="start" onclick="start();">
<input type="button" value="stop" onclick="stop();">
<input type="button" value="reset" onclick="reset()">
<br>
<input type="button" value="Add Second" onclick="add_sec()">
<input type="button" value="Add Minute" onclick="add_min()">
<input type="button" value="Add Hour" onclick="add_hour()">
<br>
<input type="button" value="Remove Second" onclick="remove_sec()">
<input type="button" value="Remove Minute" onclick="remove_min()">
<input type="button" value="Remove Hour" onclick="remove_hour()">
</body>
</html>
