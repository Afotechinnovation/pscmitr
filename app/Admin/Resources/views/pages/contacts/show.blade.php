@extends('admin::layouts.app')

@section('title', 'Test Questions')

@section('header')
    <h1 class="page-title">Contacts</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route( 'admin.contacts.index', $contact->id )}}">Contacts</a></li>
        </ol>
    </nav>

@endsection

@section('content')

    <div class="card">
        <div class="card-body p-0">
            <div class="card-header bg-white border-bottom p-20">
                <h4 class="card-title m-0">View Contact </h4>
            </div>
            <dl class="">
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Name</dd>
                    <dt class="col-md-9">{{ $contact->name }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Email</dd>
                    <dt class="col-md-9">{{ $contact->email }}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Message</dd>
                    <dt class="col-md-9">{{ $contact->message }}</dt>
                </div>
            </dl>
        </div>
    </div>



@endsection

