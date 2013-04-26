<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Virt Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 1200px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body>
   <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/virtOnline">Virt-Online</a>
          <ul class="nav pull-right">
<!--
            {% if request.user.is_authenticated or user.is_authenticated %}
            <li class="">
              <a href="/logout"><b>Sign out</b></a>
            </li>
            {% else %}
            <li class="">
              <a href="/login"><b>Sign in</b></a>
            </li>
            {% endif %}
-->
            <li class="">
              <a href="reconn.php"><b>Connect</b></a>
            </li>
          </ul>
        </div><!--/.container -->
      </div><!--/.navbar-inner -->
    </div><!--/.navbar -->


