@extends("admin.branches.new")

@section("sidebar", View::make("vendor.sidebar"))

@section("vendors","")

@section("open-form-tag")
    <form action="{{ route('vendor.branches.store') }}" method="post">
@endsection
