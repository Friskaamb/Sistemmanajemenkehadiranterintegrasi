@extends('layouts.app')

@section('content')

<div class="card">
    <div style="
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: auto;
    margin-top: 40px;
">
    <h1 style="margin-bottom: 10px;">Dashboard</h1>

    <p style="color: gray; font-size: 14px;">
        Data kehadiran karyawan
    </p>
    
    <p style="font-size: 18px;">
        Total Kehadiran: 
        <strong style="color: #2c7be5; font-size: 22px;">
    {{ $total }}
</strong>
    </p>
</div>
</div>

@endsection