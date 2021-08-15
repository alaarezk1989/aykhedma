@if(session()->has('success'))
    <div class="alert alert-success alert-has-icon alert-dismissible show fade">
        <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <div class="alert-title">Success</div>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
        <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <div class="alert-title">Error</div>
            {{ session('error') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
