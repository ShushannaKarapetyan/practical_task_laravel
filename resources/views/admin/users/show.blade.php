@extends('admin.layouts.app')

@section('content')
    <style>
        nav .hidden {
            display: none;
        }

        .col-12 nav {
            position: absolute;
            bottom: -50px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h1 class="h3 mb-0 text-gray-800">User</h1>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                <div class="d-sm-flex mb-4">
                    <p class="mb-0 text-gray-800 w-100">Name - {{ $user->name }}</p>
                </div>
                <div class="d-sm-flex mb-4">
                    <p class="mb-0 text-gray-800 w-100">Email - {{ $user->email }}</p>
                </div>
            </div>
        </div>
        <div class="user-activities">
            <div class="row bottom-100">
                <div class="col-12">
                    <a href="{{ route('users.activities.create', ['id' => $user->id]) }}"
                       class="btn btn-success float-right">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>
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
                        <form method="GET" action="{{ route('users.show', ['id' => $user->id]) }}">
                            <label for="start_date">Start Date:</label>
                            <input type="date"
                                   id="start_date"
                                   class="datepicker"
                                   placeholder="dd/mm/yyyy"
                                   name="start_date">

                            <label for="end_date">End Date:</label>
                            <input type="date"
                                   id="end_date"
                                   class="datepicker"
                                   placeholder="dd/mm/yyyy"
                                   name="end_date">

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
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col">Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allActivities as $activity)
                                <tr>
                                    <th scope="row">{{ $activity->id }}</th>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>
                                        <img src="{{ asset('storage/images/' . $activity->image) }}"
                                             alt="Activity Image"
                                             width="110px">
                                    </td>
                                    <td>{{ $activity->date }}</td>
                                    <td>
                                        <div style="max-width: max-content">
                                            <a href="{{ route('users.activities.show', ['userId' => $user->id, 'id' => $activity->id]) }}"
                                               class="btn btn-primary" style="float: left">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.activities.edit', ['userId' => $user->id,'id' => $activity->activity_id ?? $activity->id]) }}"
                                               class="btn btn-warning" style="margin-left: 10px; margin-right: 10px">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form
                                                action="{{ route('users.activities.destroy', ['userId' => $user->id,'id' => $activity->id]) }}"
                                                method="POST" style="float: right">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this activity?')"
                                                        class="btn btn-danger">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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
