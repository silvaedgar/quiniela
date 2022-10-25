<div class="row">
    <div class="col-sm-8">
        <div class="mb-2">
            <label for="email" class="form-label"> Nombre de usuario</label>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" required name="name"
                    value="{{ isset($user) ? $user->name : old('name') }}">
            </div>
            @error('name')
                <span style="font-size: small; text-color: red "> {{ $message }} </span>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email" class="form-label"> Correo Electronico</label>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" required name="email"
                    value="{{ isset($user) ? $user->email : old('email') }}">
            </div>
            @error('email')
                <span style="font-size: small; "> {{ $message }} </span>
            @enderror
        </div>
        <div class="mb-2">
            <label for="password" class="form-label"> Password</label>
            <input type="password" class="form-control" name="password"
                value="{{ isset($user) ? $user->password : '' }} " required>
            @error('password')
                <span style="font-size: small; "> {{ $message }} </span>
            @enderror
        </div>
    </div>
    {{-- @if (!Auth::user()->hasRole('Client'))
        <div class="col-sm-6">
            <div class="row">
                <label for="name" class="col-sm-3 col-md-2 col-form-label mr-2 text-center">Roles</label> <br />
                <div class="col-sm-7">
                    <div class="form-group">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table mt-4">
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="roles[]" value="{{ $role->id }}"
                                                                {{ isset($user) ? ($user->roles->contains($role->id) ? 'checked' : '') : '' }}>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $role->name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif --}}
</div>
