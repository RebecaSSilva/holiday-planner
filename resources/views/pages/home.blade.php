@extends('layouts.master')

@section('title', 'Holiday Planner')

@section('content')

<div class="container" id="holiday-list">
    
    <div class="header">
        <div class="title-section">
            <h2>Holiday Plan</h2>
        </div>
        <div class="register">
            <a href="#" id="add" class="add">New Holiday</a>
        </div>
    </div>  
    <!-- Datatable -->
    <div class="table-container">
        <table id="holidayPlansTable">
            <thead></thead>
            <tbody></tbody>
        </table>    
    </div>  

</div>  

@include('modals.edit')
@include('modals.add')

@endsection
