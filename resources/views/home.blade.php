<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Data</div>

                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><span style="color: #e74c3c;">Red</span></th>
                                <th><span style="color: #e74c3c;">Green</span></th>
                                <th><span style="color: #2ecc71;">Green</span></th>
                                <th><span style="color: #2ecc71;">Red</span></th>
                                <th><span style="color: #e74c3c;">אדום</span></th>
                                <th><span style="color: #e74c3c;">ירוק</span></th>
                                <th><span style="color: #2ecc71;">ירוק</span></th>
                                <th><span style="color: #2ecc71;">אדום</span></th>
                                <th>Created</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tests as $test)
                                <tr>
                                    <th scope="row">{{ $test->id }}</th>
                                    @for ($i = 0; $i < 8; $i++)
                                        <td><span style="color: <?= $test->data[$i]['status'] === 'Correct' ? '#2ecc71' : '#e74c3c'; ?>;">{{ $test->data[$i]['time'] }}</span></td>
                                    @endfor
                                    <td><span data-toggle="tooltip" data-placement="top" title="{{ $test->user_agent }}">{{ $test->created_at->timezone('Asia/Jerusalem')->toDateTimeString() }}</span></td>
                                    <td><span data-toggle="tooltip" data-placement="top" title="{{ $test->location['city'] }}, {{ $test->location['country'] }}">{{ $test->ip }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
