@extends("admin.branches.zones.edit")

@section("sidebar", View::make("vendor.sidebar"))

@section("open-form-tag")
    <form action="{{ route('vendor.branch.zones.update', ['branch'=>$branchZone->branch_id,'branchZone' => $branchZone]) }}" method="post">
@endsection
