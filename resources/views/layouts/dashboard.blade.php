<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="stylesheet" href="{{asset('css/styles.css')}}" />
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}" />
  <!----===== font awsome CSS ===== -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- javascript  -->
  <script src="{{asset('js/navbar.js')}}" defer></script>
  <script src="{{asset('js/sidebar.js')}}" defer></script>
  <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <title></title>
</head>

<body>
  <nav-bar></nav-bar>

  <section class="main-section">
    <side-bar></side-bar>

    @yield('content')
  </section>
</body>
<style>
  .box {
    padding: 20px;
    text-align: start;
    position: relative;
    background: #fff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
  }

  .box,
  .info-box,
  .small-box {
    box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
  }

  .box,
  .well-sm {
    border-radius: 3px;
  }

  .box-header {
    color: #444;
    display: block;
    margin: 30px 0px;
    position: relative;
  }

  .well-sm {
    padding: 9px;
  }

  .box,
  .well-sm {
    border-radius: 3px;
  }

  .box-body {
    display: flex;
  }

  .well {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 5%);
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 5%);
  }

  .input-group .form-control,
  .input-group-addon,
  .input-group-btn {
    display: table-cell;
  }

  span {
    line-height: 1.7;
  }
  .add-store-input-div {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 20px;
    }

    .add-store-input-div input,
    .add-store-input-div select {
      width: 100%;
      max-width: 600px;
      padding: 5px 10px;
      border-radius: 3px;
    }

    .add-store-submitBtn {
      width: 20%;
      border-radius: 5px;
      padding: 10px 10px;
      margin: 10px 10px;
      color: white;
      transition: 0.3s all ease;
      background-color: var(--sidebar-color);
    }

    .add-store-submitBtn:hover {
      scale: 1.1;
    }
</style>

</html>