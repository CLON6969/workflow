@extends('layouts.Reviewer')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Create User</h2>
    @include('Reviewer.web.users.partials.form')
</div>
@endsection
