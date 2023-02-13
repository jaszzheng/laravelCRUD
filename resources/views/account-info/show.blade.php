@extends('layouts.app')

@section('template_title')
    {{ $accountInfo->name ?? 'Show Account Info' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Account Info</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('account-infos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Username:</strong>
                            {{ $accountInfo->username }}
                        </div>
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $accountInfo->name }}
                        </div>
                        <div class="form-group">
                            <strong>Sex:</strong>
                            {{ $accountInfo->sex }}
                        </div>
                        <div class="form-group">
                            <strong>Birthday:</strong>
                            {{ $accountInfo->birthday }}
                        </div>
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $accountInfo->email }}
                        </div>
                        <div class="form-group">
                            <strong>Remark:</strong>
                            {{ $accountInfo->remark }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
