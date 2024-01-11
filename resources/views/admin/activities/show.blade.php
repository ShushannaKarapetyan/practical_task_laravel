@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Activity</h1>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                <div class="d-sm-flex mb-4">
                    <p class="mb-0 text-gray-800 w-100">Title - {{ $activity->title }}</p>
                </div>
                <div class="d-sm-flex mb-4">
                    <p class="mb-0 text-gray-800 w-100">Description - {{ $activity->description }}</p>
                </div>
                <div class="d-sm-flex mb-4">
                    <p class="mb-0 text-gray-800 w-100">Image
                        <img src="{{ asset('storage/images/' . $activity->image) }}" alt="Activity Image" width="110px">
                    </p>
                </div>
                <div class="d-sm-flex mb-4">
                    <p class="mb-0 text-gray-800 w-100">Date - {{ $activity->date }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
