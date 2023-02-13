@extends('layouts.app')

@section('template_title')
    Account Info
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Account Info') }}
                            </span>

                             <div class="float-right">
{{--                                <a href="{{ route('account-infos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">--}}
{{--                                  {{ __('Create New') }}--}}
{{--                                </a>--}}
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">{{ __('Create New') }}</button>
                              </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @include('account-info.create')
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Send message</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

										<th>Username</th>
										<th>Name</th>
										<th>Sex</th>
										<th>Birthday</th>
										<th>Email</th>
										<th>Remark</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accountInfos as $accountInfo)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $accountInfo->username }}</td>
											<td>{{ $accountInfo->name }}</td>
											<td>{{ $accountInfo->sex }}</td>
											<td>{{ $accountInfo->birthday }}</td>
											<td>{{ $accountInfo->email }}</td>
											<td>{{ $accountInfo->remark }}</td>

                                            <td>
                                                <form action="{{ route('account-infos.destroy',$accountInfo->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('account-infos.show',$accountInfo->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('account-infos.edit',$accountInfo->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $accountInfos->links() !!}
            </div>
        </div>
    </div>
@endsection
