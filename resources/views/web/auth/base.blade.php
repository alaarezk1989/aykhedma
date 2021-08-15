@extends('web.layout')

@section('content')
    <section class="userditels">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="profil-info">
                        <br>
                        <ul class="box-other list-unstyled m-0 p-0">

                        </ul>
                    </div>
                </div>
                @yield('auth.content')
            </div>
        </div>
    </section>
@stop