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
        <div class="row">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Users</h1>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                @if(count($users) > 0)
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div>
                                        <a href="{{ route('users.show', ['id' => $user->id]) }}"
                                           class="btn btn-primary">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <p>
                            {{ $users->links() }}
                        </p>
                        </tbody>
                    </table>
                @else
                    <div class="d-sm-flex align-items-center text-center mb-4">
                        <h3 class="h3 mb-0 text-gray-800 w-100">No User</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
