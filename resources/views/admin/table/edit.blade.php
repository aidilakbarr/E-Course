@extends('layouts.app')
@section('title', 'Table')

@section('content')
    <main class="w-full flex-grow p-6">
        <h1 class="w-full text-3xl text-black pb-6">Forms</h1>

        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
                <p class="text-xl pb-6 flex items-center">
                    <i class="fas fa-list mr-3"></i> Add User
                </p>
                <div class="leading-loose">
                    <form method="POST" action="{{ route('table.update', $table) }}">
                        @csrf
                        @method('PUT')
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="name">Name</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="name" name="name"
                                value="{{ old('name', $table->name) }}" type="text" required=""
                                placeholder="Your Name" aria-label="Name">
                            @error('name')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="email">Email</label>
                            <input class="w-full px-5  py-4 text-gray-700 bg-gray-200 rounded" id="email" name="email"
                                value="{{ old('email', $table->email) }}" type="text" required=""
                                placeholder="Your Email" aria-label="Email">
                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="password">Password</label>
                            <input class="w-full px-5  py-4 text-gray-700 bg-gray-200 rounded" id="password"
                                name="password" type="password" required="" placeholder="Your Password"
                                aria-label="Password" value="{{ old('password', $table->password) }}">
                            @error('password')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="role">Role</label>
                            <select name="role" id="role" required
                                class="w-full px-5 py-4 text-gray-700 bg-gray-200 rounded border border-gray-300
               focus:outline-none focus:ring-2 focus:ring-black "
                                aria-label="Role">
                                @foreach (\App\Enums\RoleEnum::cases() as $role)
                                    <option value="{{ $role->value }}"
                                        {{ old('role', $table->role->value) === $role->value ? 'selected' : '' }}>
                                        {{ $role->value }}
                                    </option>
                                @endforeach

                            </select>

                            @error('role')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <div class="mt-6">
                            <button
                                class="px-4 py-1 text-white font-light tracking-wider bg-[#3d68ff] rounded cursor-pointer"
                                type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
