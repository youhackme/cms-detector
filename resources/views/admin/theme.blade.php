<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

    <title>Add original Theme</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <h3 class="text-info">Add a Theme</h3>
            <hr>
            <form role="form" method="POST" class="js-submit-form">

                <div class="form-group has-feedback">
                    <label for="previewlink">Theme Preview Url</label>
                    <input type="text" class="form-control js-find-application" id="previewlink"
                           placeholder="http://toggle.me">
                    <span class="js-find-application-spinner glyphicon glyphicon-repeat fast-right-spinner form-control-feedback"
                          style="display: none;">
                    </span>
                </div>
                <div class="form-group">
                    <label for="uniqueidentifier">Unique Identifier</label>
                    <input type="text" class="form-control" id="uniqueidentifier" placeholder="987878787">
                </div>
                <div class="form-group">
                    <label for="name">Theme Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Avada">
                </div>

                <div class="form-group">
                    <label for="description">Theme Description</label>
                    <textarea type="text"
                              class="form-control"
                              id="description"
                              placeholder="This is a bootstrap 4 premium theme."
                              style="height:200px;"
                    ></textarea>
                </div>
                <div class="form-group">
                    <label for="slug">Theme Slug</label>
                    <input type="text" class="form-control" id="slug" placeholder="avada">
                </div>
                <div class="form-group">
                    <label for="screenshoturl">Screenshot Url</label>
                    <input type="text" class="form-control" id="screenshoturl"
                           placeholder="http://toggle.me/wp-content/themes/avada/screenshot.png">
                </div>
                <div class="form-group">
                    <label for="screenshotHash">Screenshot Hash</label>
                    <input type="text" class="form-control" id="screenshotHash" placeholder="123abef67676aeb3abcds">
                </div>

                <div class="form-group">
                    <label for="downloadlink">Download Link</label>
                    <input type="text" class="form-control" id="downloadlink"
                           placeholder="http://themeforest.net/theme">
                </div>

                <div class="form-group">
                    <label for="provider">Providers</label>
                    <select class="form-control" name="provider" id="provider">
                        <option value="themeforest.net">Themeforest.net</option>
                        <option value="wordpress.org">WordPress.org</option>
                        <option value="teslathemes.com">Teslathemes.com</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="provider">Type</label>
                    <select class="form-control" name="type" id="type">
                        <option value="premium">Premium</option>
                        <option value="free">Free</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>
<style>
    .glyphicon.fast-right-spinner {
        -webkit-animation: glyphicon-spin-r 1s infinite linear;
        animation: glyphicon-spin-r 1s infinite linear;
    }

    @-webkit-keyframes glyphicon-spin-r {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }

    @keyframes glyphicon-spin-r {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }


</style>
<script>
  (function ($) {
    var o = $({});
    $.each({
      on: 'subscribe',
      trigger: 'publish',
      off: 'unsubscribe'
    }, function (key, api) {
      $[api] = function () {
        o[key].apply(o, arguments);
      };
    });
  })(jQuery);

  (function ($) {

    var themeForm = {
      init: function () {
        this.bindEvents();
        this.subscriptions();

      },
      bindEvents: function () {
        $('.js-find-application').focusout(this.findTheme);
        $('.js-submit-form').submit(function (event) {
          event.preventDefault();
          console.log('triggered');
          themeForm.save.call(this);

        });

      },
      subscriptions: function () {
        $.subscribe('wordpress/results', this.renderResults);
      },
      findTheme: function () {
        themeForm.toggleSpinner.call(this);
        var themeDemoUrl = $('#previewlink').val();
        if (themeDemoUrl != '') {

          axios.get('/site/' + themeDemoUrl)
            .then(function (response) {
              themeForm.toggleSpinner.call(this);
              themeForm.response = response;

              $.publish('wordpress/results');

            });
        }
      },
      toggleSpinner: function () {
        $('.js-find-application-spinner').toggle();
      },
      renderResults: function () {
        var themeAliases = [];
        var self = themeForm;
        $.each(self.response.data.theme, function (themeAlias, detail) {
          themeAliases.push(themeAlias);
          $('#description').val(detail.description);
        });

        $('#slug').val(themeAliases.join());

        $.each(self.response.data.screenshot, function (themeAlias, screenshot) {
          $('#screenshotHash').val(screenshot.hash);
          $('#screenshoturl').val(screenshot.url);
          return false;
        });
      },
      save: function () {
        console.log('test');
        axios.post('/admin/theme/add', {
          uniqueidentifier: $('#uniqueidentifier').val(),
          name: $('#name').val(),
          slug: $('#slug').val(),
          screenshoturl: $('#screenshoturl').val(),
          downloadlink: $('#downloadlink').val(),
          description: $('#description').val(),
          previewlink: $('#previewlink').val(),
          provider: $('#provider').val(),
          type: $('#type').val(),
          screenshotHash: $('#screenshotHash').val(),
          type: $('#type').val()
        })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });

      }
    };

    themeForm.init();

  })(jQuery);


</script>
</body>
</html>