<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" type="text/css"/>

    <title>Add original Theme</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <form role="form">
                <div class="form-group">
                    <label for="exampleInputEmail1">Theme demo Url</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="http://toggle.me">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Theme Name</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Avada">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Theme Description</label>
                    <textarea type="text" class="form-control" id="exampleInputEmail1"
                              placeholder="This is a bootstrap 4 premium theme."></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Theme Alias</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="avada">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Screenshot Url</label>
                    <input type="email" class="form-control" id="exampleInputEmail1"
                           placeholder="http://toggle.me/wp-content/themes/avada/screenshot.png">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Screenshot Hash</label>
                    <input type="email" class="form-control" id="exampleInputEmail1"
                           placeholder="123abef67676aeb3abcds">
                </div>


                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>


</body>
</html>