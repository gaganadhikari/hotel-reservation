@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Hotels</h2>
            </div>
            <div class="pull-right">
                @can('hotel-create')
                <a class="btn btn-success" href="{{ route('hotels.create') }}"> Create New Hotel</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($hotels as $hotel)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $hotel->name }}</td>
	        <td>{{ $hotel->detail }}</td>
	        <td>
                <form action="{{ route('hotels.destroy',$hotel->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('hotels.show',$hotel->id) }}">Show</a>
                    @can('hotel-edit')
                    <a class="btn btn-primary" href="{{ route('hotels.edit',$hotel->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('hotel-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $hotels->links() !!}


<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection