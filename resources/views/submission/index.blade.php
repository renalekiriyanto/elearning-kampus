@extends('layouts.adminlte.main')
@section('title', 'Submissions')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('error')}}
        </div>
    @endif
    @if (Session::has('warning'))
        <div class="alert alert-warning" role="alert">
            {{Session::get('warning')}}
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            @can('upload-submission')
                <a href="{{ route('submission.create') }}" class="btn btn-sm btn-primary">Create</a>
            @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Deadline</th>
                        <th>Course</th>
                        <th style="width: 40px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr class="align-middle">
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                            <td>{{ $item->title ?? '-' }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td>{{ Carbon\Carbon::parse($item->deadline)->format('Y-m-d') ?? '-' }}</td>
                            <td>{{ $item->course->name ?? '-' }}</td>
                            <td class="d-flex align-content-around">
                                {{-- @can('download-materials')
                                    <a href="{{route('materials.download', $item->id)}}" class="badge bg-primary btn" type="submit">Download</a>
                                @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                @if ($data->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $data->previousPageUrl() }}">&laquo;</a>
                    </li>
                @endif

                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    @if ($page == $data->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($data->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $data->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </div>
    </div>
@endsection
