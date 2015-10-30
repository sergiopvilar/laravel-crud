@extends('layouts.default')

@section('content')

    <h2>{{  $name }}</h2>

    {{
    \SmartForm::open('/admin/'.$route, $method, $fields)
    }}

    {{\SmartForm::close('Save')}}

@stop
