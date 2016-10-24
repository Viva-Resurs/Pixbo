@extends('app')

@section('body')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-offset-2 col-md-8 main">
            <!--  Flash messages -->
            @include ('flash::message')

            <div class="jumbotron">
              <h1>Pixbo!</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
              <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
          </div>
      </div>
  </div>
</div>
@stop