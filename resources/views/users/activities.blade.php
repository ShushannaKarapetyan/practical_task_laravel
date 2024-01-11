@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h4 class="h4 mb-0 text-gray-800">Activities</h4>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                @if(count($allActivities) > 0)
                    <form method="GET" action="{{ route('user.activities') }}">
                        <div style="float: left">
                            <label for="start_date">Start Date:</label>
                            <input type="date"
                                   id="start_date"
                                   class="datepicker"
                                   placeholder="dd/mm/yyyy"
                                   name="start_date">
                        </div>
                        <div style="float: left; margin-right: 10px">
                            <label for="end_date">End Date:</label>
                            <input type="date"
                                   id="end_date"
                                   class="datepicker"
                                   placeholder="dd/mm/yyyy"
                                   name="end_date">
                        </div>

                        <button type="submit" class="btn btn-dark">Filter</button>

                        @error('start_date')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                        @error('end_date')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </form>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allActivities as $activity)
                            <tr>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>
                                    <img src="{{ asset('storage/images/' . $activity->image) }}"
                                         alt="Activity Image"
                                         width="110px">
                                </td>
                                <td>{{ $activity->date }}</td>
                            </tr>
                        @endforeach
                        <p>
                            {{-- {{ $allActivities->links() }}--}}
                        </p>
                        </tbody>
                    </table>
                @else
                    <div class="d-sm-flex align-items-center text-center mt-4 mb-4">
                        <h3 class="h3 mb-0 text-gray-800 w-100">No Activity</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Initialize Flatpickr -->
    <script>
        flatpickr('.datepicker', {
            dateFormat: 'd/m/Y',
            allowInput: true,
        });
    </script>
@endsection
