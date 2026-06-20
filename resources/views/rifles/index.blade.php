@extends('_master')

@section('title')
<title>Rifles</title>
@stop

@section('Index')

<br>

<h3>My Rifles</h3>

<p>
    <a href="/rifles/create" class="btn btn-primary">
        Add Rifle
    </a>
</p>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Caliber</th>
            <th>Sight Type</th>
            <th>Click Value</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rifles as $rifle)
        <tr>
            <td>{{ $rifle->name }}</td>
            <td>{{ $rifle->caliber }}</td>
            <td>{{ $rifle->sight_type }}</td>
            <td>{{ $rifle->sight_click_moa }} MOA</td>
            <td>
                <a href="/rifles/{{ $rifle->id }}/edit"
                   class="btn btn-sm btn-primary">
                    Edit
                </a>

                <form method="POST"
                      action="/rifles/{{ $rifle->id }}/delete"
                      style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete rifle?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
