@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Customer ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Approved</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->user_id }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->approved ? 'Yes' : 'No' }}</td>
                        <td>
                            @if (!$appointment->approved)
                                <form action="{{ route('admin.appointment.approve', $appointment->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-sm btn-primary">Approve</button>
                                </form>
                            @endif

                            @if ($appointment->approved)
                                <form action="{{ route('admin.appointment.decline', $appointment->id) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
