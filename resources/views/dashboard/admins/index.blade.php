@php
    use App\Models\Admins;
@endphp

@extends('layouts.admin')
@section('title', 'Admins Page')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@section('content')

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />


    @can('admins.create')
        <a href="{{ route('dashboard.admins.create') }}" class="btn btn-outline-primary mb-5" style="margin-left: 250px">
            + New Admin
        </a>
    @endcan

    @if ($admins->count())

        <div style="margin-left: 250px;">
            <form action="{{ URL::current() }}" method="get" class="d-felx justify-content-between mb-4">
                <x-form.input name="name" class="form-control" placeholder="Name" style="width: 40%; display: inline;" />
                <button type="submit" class="btn btn-sm btn-primary mx-2">Search</button>
            </form>
        </div>
        <table class="table" style="margin-left: 250px; width:auto">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>ROLES</th>
                    <th>CREATED AT</th>
                    <th colspan="2">CONTROL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td><a href="{{ route('dashboard.admins.show', $admin->id) }}">{{ $admin->name }}</a> </td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            @php
                                $roles = json_decode($admin->roles);
                            @endphp
                            @for ($i = 0; $i < count($roles); $i++)
                                {{ $roles[$i]->name . ($i != count($roles) - 1 ? ' | ' : '') }}
                            @endfor
                        </td>
                        <td>{{ $admin->created_at }}</td>
                        <td>
                            @can('admins.update')
                                <a href="{{ route('dashboard.admins.edit', $admin->id) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            @endcan
                        </td>
                        <td>
                            @can('admins.delete')
                                <form action="{{ route('dashboard.admins.destroy', $admin->id) }}" method="post">
                                    @csrf
                                    {{-- Form method spoofing --}}
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <div class="alert alert-info" style="margin-left:250px">
                    <h3 class="text-center">No Admins Found</h3>
                </div>
    @endif
    </tbody>
    </table>

    <div style="margin-left: 250px; margin-right:50px">
        {{ $admins->withQueryString()->links() }}
    </div>
@endsection

</div>
