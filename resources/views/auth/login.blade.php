<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Meet The People! </title>
    
    <!-- Bootstrap -->
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset("css/font-awesome.min.css") }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset("css/nprogress.css") }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">

    <link href="{{ asset("css/custom.css") }}" rel="stylesheet">
    
</head>

<body class="login">

<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="post" action="{{ url('/login') }}">
                    {!! csrf_field() !!}
                    <div class="loginimg" ><img src="{{ asset("images/PAP.png") }}"/></div>
                    <h1>MEET THE PEOPLE SESSION</h1>

                    <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="username">
                        <span class="glyphicon  form-control-feedback"><i class="fa fa-user" title="Align Left"></i></span>
                        @if ($errors->has('username'))
                            <span class="help-block">
                      <strong>{{ $errors->first('username') }}</strong>
                </span>
                        @endif
                    </div>
                    
                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                        @endif
                    
                    </div>
                   
                    <div class="form-group">
                        <input type="submit" class="btn btn-default submit" value="Login">
                       <!-- <a class="reset_pass" href="{{  url('/password/reset') }}">Lost your password?</a>-->
                    </div>
                    
                    <div class="clearfix"></div>
                    
                   
                </form>
            </section>
        </div>
    </div>
</div>

</body>
</html>