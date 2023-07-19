@extends('layouts.customer')

@section('content')
    <div class="container mt-4">
        <form method="POST" action="{{ route('customer.appointment.create') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">ID</label>
                <input type="string" name="user_id" value="{{ $user }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection
