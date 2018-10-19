@extends('layouts.master')

@section('content')

@auth

{{-- New Tracking Period - display form for creating new tracking period if user doesn't have any active one --}}

@if(!Auth::user()->periods->where('status', '=', true)->count())
    <new-tracking-period></new-tracking-period>
@else
    
@endif

<tracking-stats></tracking-stats>




{{-- History - show history if user has at least one inactive tracking period --}}

@if(Auth::user()->periods->where('status', '=' , false)->count() > 0)
    @include('partials.history')
@endif

@endauth

@endsection