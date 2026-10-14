@extends('layouts.member')

@section('content')
    <div class="max-w-lg mx-auto bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-gray-100">
        @yield('auth')
    </div>
@endsection
