@extends('layouts.app')
@section('title', 'Users')
@include('layouts.datatable')
@section('content')
    <div class="row">
        @can('users.create')
            <div class="col-lg-4">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">{{ __('lang.roles') }}</h3>
                    </div>
                    <div class="tile-body">
                        <form action="{{ route('role.store') }}" method="post">
                            @csrf
                            <x-input name="role_name" :label="__('lang.name')" :required="1" />
                            <x-buttons.save />
                        </form>
                    </div>
                    <div class="tile-footer">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('lang.name') }}</th>
                                    <th>{{ __('lang.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="btn-group" dir="ltr">
                                                <x-buttons.edit :route="route('role.edit', $role->id)" />
                                                <button class="btn btn-info btn-sm give-permission"
                                                    role-id="{{ $role->id }}" title="Give permissions">
                                                    <i class="bi bi-unlock"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endcan
        @can('users.read')
            <div class="col-lg-8">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title"><i class="bi bi-list-ul"></i> {{ __('lang.users') }} </h3>
                        <x-buttons.modal modal="userModal" text="<i class='bi bi-plus'></i>" />
                    </div>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-striped data-table" id="printElement">
                                <thead class="table-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('lang.name') }}</th>
                                        <th>{{ __('lang.email') }}</th>
                                        <th>{{ __('jamiat.group_name') }}</th>
                                        <th>{{ __('lang.role') }}</th>
                                        <th>{{ __('lang.status') }}</th>
                                        <th>{{ __('lang.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->userGroup?->name }}</td>
                                            <td>
                                                @if (count($user->getRoleNames()))
                                                    {{ $user->getRoleNames()[0] }}
                                                @endif
                                                @can('users.edit')
                                                    <button class="btn btn-info btn-sm give-role" user-id="{{ $user->id }}"
                                                        title="{{ __('lang.give_role') }}">
                                                        <i class="bi bi-unlock"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('users.edit')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input user_status_toggle" type="checkbox"
                                                            role="switch" id="user_status" data-id="{{ $user->id }}"
                                                            @if ($user->isActive) checked @endif>
                                                        <label class="form-check-label" for="user_status">Active</label>
                                                    </div>
                                                @endcan
                                            </td>
                                            <td>
                                                <div class="btn-group" dir="ltr">
                                                    @can('users.edit')
                                                        <x-buttons.edit :route="route('user.edit', $user)" />
                                                        <a class="btn btn-sm btn-info" href="{{ route('user.show', $user) }}"
                                                            title="User logs">
                                                            <i class="bi bi-clock-history"></i>
                                                        </a>
                                                    @endcan

                                                    @can('user.delete')
                                                        <x-buttons.delete :route="route('user.destroy', $user)" />
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    @can('users.create')
        <!-- Modal -->
        <x-modal size="lg" id="myModal" title="<i class='bi bi-unlock'></i>{{ __('lang.permissions') }}">
            <form action="{{ route('role.give-permissions') }}" method="post">
                @csrf
                <input type="hidden" name="role_id" id="role_id">
                <div class="row" id="permissionsDiv"></div>
                <hr>
                <button type="submit" class="btn btn-primary">{{ __('lang.give_permissions') }}</button>
            </form>
        </x-modal>
        <x-modal id="giveRoleModal" title="<i class='bi bi-lock'></i>{{ __('lang.role') }}">
            <form action="{{ route('user.give-role') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" id="user_id">
                <x-select name="role_id" :options="$roles" />
                <hr>
                <button type="submit" class="btn btn-primary">{{ __('lang.give_role') }}</button>
            </form>
        </x-modal>
    @endcan
    <!-- user Modal -->
    <x-modal id="userModal" title="<i class='bi bi-plus'></i>{{ __('lang.user') }}">
        <form action="{{ route('user.store') }}" method="post">
            @csrf
            <x-input name="name" :label="__('lang.name')" :required="1" />
            <x-input type="email" name="email" :label="__('lang.email')" :required="1" />
            <x-js-select2 col="col-sm-12" :list="App\Models\UserGroup::all()" id='user_group_id' text="name" value='id'
                name="user_group_id" :label="__('jamiat.select_group')" modal_id='userModal' />
            <x-input type="password" name="password" :label="__('lang.password')" :required="1" />
            <x-input type="password" name="password_confirmation" :label="__('lang.password_confirmation')" :required="1" />

            <x-buttons.save />
        </form>
    </x-modal>
@endsection

@push('scripts')
    <!-- Page specific javascripts-->
    <script type="text/javascript">
        $("#userModal").on("shown.bs.modal", function() {
            $("#name").focus();
        });
        @if ($errors->any())
            const myModal = new bootstrap.Modal("#userModal", {
                keyboard: false
            });
            myModal.show();
        @endif
        $('.user_status_toggle').on('change', function() {
            var status = $(this).prop('checked') ? '1' : '0';
            var user_id = $(this).attr("data-id");

            $.ajax({
                url: "{{ route('user.update-user-status') }}",
                method: 'get',
                data: {
                    'user_id': user_id,
                    'status': status
                },
                success: function(response) {
                    toastr.success(response, 'Notice')
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle errors
                }
            });
        });

        $(document).on('click', '.give-permission', function() {
            var role_id = $(this).attr('role-id');
            $('#role_id').val(role_id);
            $.ajax({
                url: "{{ route('role.get-permissions') }}",
                method: 'GET',
                data: {
                    'role_id': role_id
                },
                success: function(response) {
                    $("#permissionsDiv").html(response);
                    const myModal = new bootstrap.Modal("#myModal", {
                        keyboard: false
                    });
                    myModal.show();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
        $(document).on('click', '.give-role', function() {
            var user_id = $(this).attr('user-id');
            $("#user_id").val(user_id);
            const roleModal = new bootstrap.Modal("#giveRoleModal", {
                keyboard: false
            });
            roleModal.show();
        });
    </script>
@endpush
