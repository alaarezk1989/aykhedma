@extends("admin.branches.products.new")

@section("sidebar", View::make("vendor.sidebar"))

@section("open-form-tag")
    <form action="{{ route('vendor.branch.products.store',['branch'=>$branch->id]) }}" method="post">
@endsection
