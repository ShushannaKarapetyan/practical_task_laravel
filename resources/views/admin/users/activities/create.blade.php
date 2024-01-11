@extends('admin.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row bottom-100">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Create Activity</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form method="POST" action="{{ route('users.activities.store', ['id' => $user->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" class="form-control" placeholder="Title" name="title">
                        @error('title')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        @error('description')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" placeholder="Image" name="image">
                        @error('image')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="text" class="form-control" id="date" placeholder="Select date" name="date">
                        @error('date')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#date", {
                enableTime: false,
                dateFormat: "Y-m-d",
            });

            const form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                const dateInput = document.getElementById('activityDate');
                const selectedDate = dateInput.value;

                // Append the chosen date to the form data
                const formData = new FormData(form);
                formData.append('activityDate', selectedDate);

                // Optional: You can log formData to see what data will be sent
                console.log(Object.fromEntries(formData));

                // If you want to stop the form from submitting directly and handle it using AJAX, use event.preventDefault();
                // event.preventDefault();

                // If you don't prevent the default behavior, the form will submit normally
            });
        });
    </script>
@endsection
