@extends('_master')

@section('title')
<title>Zero Book</title>
@stop

@section('Index')

<h3>{{ $rifle->name }} - Zero Book</h3>

<p>
    <a href="/rifles/{{ $rifle->id }}/zeros/create" class="btn btn-primary">Add Zero</a>
    <a href="/rifles" class="btn btn-default">Back to Rifles</a>
</p>

@if ($zeros->isEmpty())
    <div class="alert alert-info">
        No zero data has been entered for this rifle.
    </div>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Distance</th>
                <th>Elevation</th>
                <th>Windage</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($zeros as $zero)
                <tr>
                    <td>{{ $zero->distance }}</td>
                    <td>{{ $zero->elevation }}</td>
                    <td>{{ $zero->windage }}</td>
                    <td>{{ $zero->notes }}</td>
                    <td>
                        <a href="/rifle-zeros/{{ $zero->id }}/edit" class="btn btn-default">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@stop
