@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Replay</h1>
<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contact.all') }}">Contact us messages</a></li>
        <li class="breadcrumb-item active" aria-current="page">replay</li>
    </ol>
</nav>


<div class="card shadow mb-4">    
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">The message - {{ $contact->title }} </h6>        
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-2">
                <span class="d-inline-block w-25"><strong>Name</strong></span>
                <span> {{ $contact->name }} </span>
            </div>
            <div class="col-md-6 mb-2">
                <span class="d-inline-block w-25"><strong>Title</strong></span>
                <span> {{ $contact->title }} </span>
            </div>
            <div class="col-md-6 mb-2">
                <span class="d-inline-block w-25"><strong>Email</strong></span>
                <span> {{ $contact->email }} </span>
            </div>
            <div class="col-md-6 mb-2">
                <span class="d-inline-block w-25"><strong>Mobile</strong></span>
                <span> {{ $contact->mobile }} </span>
            </div>

            <div class="col-md-6 mb-2">
                <span class="d-inline-block w-25"><strong>Ip</strong></span>
                <span> {{ $contact->ip_address }} </span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <span class="d-inline-block w-25 mb-2"><strong>Message</strong></span>
                <p class="lead">{{$contact->message}}</p>
            </div>
        </div>
    </div>
</div>

@if ($contact->status == 1)
<div class="card shadow mb-4">    
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">The replay </h6>        
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">                
                <p> {{ $contact->replay->replay }} </p>
            </div>
        </div>
        @if($contact->replay->status != 1 )
            <h5 class="text-warning"> Something was wrong so email <strong> was not</strong> sent</h5>
            <form action="{{ route('admin.contact.replay.resend', $contact->replay->id) }}" method="post" class="admin-form-password">
                @csrf
                <div class=" py-2">                    
                    <a href="javascript:void(0)" class="btn btn-warning btn-icon-split admin-btn-password">
                        <span class="icon text-white-50">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <span class="text">Resend replay</span>
                    </a>                    
                </div>
            </form>
        @endif
    </div>
</div>    
@else
<div class="card shadow mb-4">    
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Replay form</h6>        
    </div>
    <div class="card-body">
        <form action="{{ route('admin.contact.replay.send', $contact->id) }}" method="post" class="admin-form">
            @csrf
            <div class="form-group">
                <label for="replay"><strong>Reply</strong></label>
                <textarea name="replay" id="replay" class="form-control @error('replay') is-invalid @enderror" rows="7">{{ old('replay') }}</textarea>
                @error('replay')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            
            <div class="pt-3 pb-4 d-flex justify-content-center">                    
                <a href="#" class="btn btn-info btn-icon-split admin-btn">
                    <span class="icon text-white-50">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <span class="text">Send replay</span>
                </a>                    
            </div>
        </form>
    </div>
</div>    
@endif


@endsection
