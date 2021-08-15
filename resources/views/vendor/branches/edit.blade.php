@extends("admin.branches.edit")

@section("sidebar", View::make("vendor.sidebar"))

@section("vendors","")

@section("open-form-tag")
    <form action="{{ route('vendor.branches.update', ['branch' => $branch]) }}" method="post">
@endsection
