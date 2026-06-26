@extends('_master')

@section('title')
<title>Ammo Library</title>
@stop

@section('Index')

<a href="/" class="btn btn-link">Back to Matches</a>

<h3>Ammo Library</h3>

<p>
    <a href="/ballistics/create" class="btn btn-primary">
        New Ammo Profile
    </a>
</p>

@if ($profiles->isEmpty())

    <p class="text-muted">No Ammo profiles found.</p>

@else

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Cartridge</th>
            <th>Bullet</th>
            <th>Velocity</th>
            <th>BC</th>
            <th>Source</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($profiles as $profile)
            <tr>
                <td>{{ $profile->name }}</td>
                <td>{{ $profile->type }}</td>
                <td>{{ $profile->cartridge }}</td>
                <td>
                    @if ($profile->bullet_weight)
                        {{ $profile->bullet_weight }}gr
                    @endif

                    {{ $profile->bullet_manufacturer }}
                    {{ $profile->bullet_name }}
                </td>
                <td>
                    @if ($profile->muzzle_velocity)
                        {{ $profile->muzzle_velocity }} fps
                    @endif
                </td>
                <td>
                    @if ($profile->g1_bc)
                        G1 {{ $profile->g1_bc }}
                    @elseif ($profile->g7_bc)
                        G7 {{ $profile->g7_bc }}
                    @endif
                </td>
                <td>
                    @if ($profile->is_system)
                        System
                    @else
                        Mine
                    @endif
                </td>
                <td>
                    @if (! $profile->is_system)
                        <a href="/ballistics/{{ $profile->id }}/edit"
                           class="btn btn-xs btn-default">
                            Edit
                        </a>

                        <form method="POST"
                              action="/ballistics/{{ $profile->id }}/delete"
                              style="display:inline;">
                            @csrf
                            <button class="btn btn-xs btn-warning"
                                    onclick="return confirm('Archive this Ammo profile?')">
                                Archive
                            </button>
                        </form>
                    @else
                        <span class="text-muted">Read only</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endif

@stop
