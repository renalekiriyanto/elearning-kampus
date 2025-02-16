@extends('layouts.adminlte.main')
@section('title', 'Create Submission')
@section('content')
    <!--begin::Quick Example-->
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <a href="{{ route('submissions') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
            <!--begin::Body-->
            @csrf
            <div class="card-body">
                <div class="col mb-3">
                    <label for="assignment_id" class="form-label">Assignment</label>
                    <select class="form-select" id="assignment_id" name="assignment_id" required>
                        <option selected disabled value="">Choose your assignment</option>
                        @foreach ($data as $item)
                            <option value="{{ $item->id }}">{{ $item->course->name }}- {{ $item->title }} - {{ $item->description }} ({{ Carbon\Carbon::parse($item->deadline)->format('Y-m-d') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="file_path" name="file_path" />
                    <label class="input-group-text" for="file_path">Upload</label>
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
