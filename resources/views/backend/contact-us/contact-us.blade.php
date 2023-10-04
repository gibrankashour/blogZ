@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Contact us messages</h1>
<p class="mb-4 mt-4">Messages from website visitors</p>


<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">All messages</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    @include('backend.contact-us.filter')
                </div>
            </div>
        </div>  

    </div>

    <div class="card-body">
        <div class="table-responsive">            
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Title</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'title', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'title', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Title</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'title', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'title', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.contact.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.contact.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->title }}</td>
                        <td>
                            @if($contact->status === 0)
                                <span class="text-danger"><strong>Didn't repalyed</strong></span>
                            @elseif($contact->status === 1 && $contact->replay->status === 0)
                                <span class="text-warning"><strong>Resend replay</strong></span>
                            @elseif($contact->status === 1 && $contact->replay->status === 1)
                                <span class="text-success"><strong>Repalyed</strong></span>
                            @endif
                        </td>
                        <td>{{ $contact->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group-flex">
                                @if($contact->status === 0)
                                    <a href="{{ route('admin.contact.replay', $contact->id) }}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-envelope "></i>
                                        </span>      
                                        <span class="text">Replay</span>                              
                                    </a>
                                @elseif($contact->status === 1 && $contact->replay->status === 0)
                                    <a href="{{ route('admin.contact.replay', $contact->id) }}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas  fa-exclamation-triangle "></i>
                                        </span>      
                                        <span class="text">Resend</span>                              
                                    </a>
                                @elseif($contact->status === 1 && $contact->replay->status === 1)
                                    <a href="{{ route('admin.contact.replay', $contact->id) }}" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check "></i>
                                        </span>      
                                        <span class="text">Replayed</span>                              
                                    </a>
                                @endif

                                <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this message?') ) { document.getElementById('contact-delete-{{ $contact->id }}').submit(); } else { return false; }">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Delete</span>
                                </a>
                                
                                <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="post" id="contact-delete-{{ $contact->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center h2">No messages found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($contacts))
                    <div class="float-right">
                        {!! $contacts->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
