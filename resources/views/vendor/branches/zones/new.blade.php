@extends("admin.branches.zones.new")

@section("sidebar", View::make("vendor.sidebar"))

@section("open-form-tag")
    <form action="{{ route('vendor.branch.zones.store',['branch'=>$branch->id]) }}" method="post">
@endsection
