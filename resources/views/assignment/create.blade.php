@extends('layouts.adminlte.main')
@section('title', 'Create Material')
@section('content')
    <!--begin::Quick Example-->
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <a href="{{ route('assignments') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{ route('assignment.store') }}" method="POST" enctype="multipart/form-data">
            <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="col mb-3">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select" id="course_id" name="course_id" required>
                        <option selected disabled value="">Choose your course</option>
                        @foreach ($courses as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->description }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text"
                        class="form-control @error('title')
                        is-invalid
                    @enderror"
                        id="title" name="title" required />
                    @error('title')
                        <div class="form-text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text"
                        class="form-control @error('description')
                        is-invalid
                    @enderror"
                        id="description" name="description" />
                    @error('description')
                        <div class="form-text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date"
                        class="form-control @error('deadline')
                        is-invalid
                    @enderror"
                        id="deadline" name="deadline" required />
                    @error('deadline')
                        <div class="form-text text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Quick Example-->
@endsection
