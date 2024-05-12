@extends('layouts.app')

@section('title', 'Edit Expense Category')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('umroh-expenses.index') }}">Expenses</a></li>
        <li class="breadcrumb-item"><a href="{{ route('travel-expense-categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active">Edit Expense Category</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7">
                @include('utils.alerts')
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('travel-expense-categories.update', $travel_expense_category) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="category_name">Category Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="category_name" required value="{{ $travel_expense_category->category_name }}">
                            </div>
                            <div class="form-group">
                                <label for="category_description">Description</label>
                                <textarea class="form-control" name="category_description" id="category_description" rows="5">{{ $travel_expense_category->category_description }}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update <i class="bi bi-check"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

