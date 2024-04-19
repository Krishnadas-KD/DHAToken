<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Dubai Health Authority</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/home.css" rel="stylesheet">
  </head>
  <body class="d-flex flex-column h-100">
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top">
            <a class="navbar-brand" href="#" style="color:#000;">Dubai Health</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <!-- Add navbar items if necessary -->
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <a href="/login" class="btn btn-primary my-2 my-sm-0" type="submit" >Login</a>
            </form>
            </div>
        </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="flex-shrink-0 mt-5">
        <div class="container">
            <div class="jumbotron">
                <div class="row mb-5 d-flex justify-content-center">
                    <h3 class="h3 Blood">Token Displays</h3>
                </div>
                <div class="row mb-3">
                    <div class="col-6 themed-grid-col d-flex justify-content-center">Male Area</div>
                    <div class="col-6 themed-grid-col d-flex justify-content-center">Female Area</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-center">
                        <a href="/display-route/Registration/MALE" class="btn btn-lg btn-outline-primary btn-block" type="submit">Registration</a>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <a  href="/display-route/Registration/FEMALE" class="btn btn-lg btn-outline-primary btn-block" type="submit">Registration</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-center">
                        <a href="/display-route/Blood Collection/MALE" class="btn btn-lg btn-outline-primary btn-block" type="submit">Blood Collection</a>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <a href="/display-route/Blood Collection/FEMALE" class="btn btn-lg btn-outline-primary btn-block" type="submit">Blood Collection</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-center">
                        <a href="/display-route/X-Ray/MALE" class="btn btn-lg btn-outline-primary btn-block" type="submit">X - Ray</a>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <a href="/display-route/X-Ray/FEMALE" class="btn btn-lg btn-outline-primary btn-block" type="submit">X - Ray</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container d-flex justify-content-center">
            <span class="text-muted">DHA-NEW MUHAISNAH MEDICAL FITNESS CENTER</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <script src="{{ mix('js/app.js') }}"></script>
</html>
