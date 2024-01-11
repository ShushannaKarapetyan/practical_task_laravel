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
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row bottom-100">
            <div class="col-12">
                <a href="{{ route('activities.create') }}" class="btn btn-success float-right">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Activities</h1>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                @if(count($activities) > 0)
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
                        @foreach($activities as $activity)
                            <tr>
                                <th scope="row">{{ $activity->id }}</th>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>
                                    <img src="{{ asset('storage/images/' . $activity->image) }}" alt="Activity Image"
                                         width="110px">
                                </td>
                                <td>{{ $activity->date }}</td>
                                <td>
                                    <div>
                                        <a href="{{ route('activities.show', ['id' => $activity->id]) }}"
                                           class="btn btn-primary" style="float: left">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('activities.edit', ['id' => $activity->id]) }}"
                                           class="btn btn-warning"
                                           style="float: left; margin-left: 10px; margin-right: 10px">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('activities.destroy', ['id' => $activity->id]) }}"
                                              method="POST">
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
                        <p style="width: 100px !important">
                            {{ $activities->links() }}
                        </p>
                        </tbody>
                    </table>
                @else
                    <div class="d-sm-flex align-items-center text-center mb-4">
                        <h3 class="h3 mb-0 text-gray-800 w-100">No Activity</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
