@extends("admin.branches.products.edit")

@section("sidebar", View::make("vendor.sidebar"))

@section("open-form-tag")
    <form action="{{ route('vendor.branch.products.update', ['branch'=>$branchProduct->branch_id,'branchProduct' => $branchProduct]) }}" method="post">
@endsection
