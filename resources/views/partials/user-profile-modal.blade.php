<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    {{-- Avatar preview --}}
                    <div class="text-center mb-4">
                        <label for="upload_profile" class="d-block">
                            <img id="preview-image" src="{{ Auth::user()->profile_url }}" class="rounded-circle"
                                width="141" height="141" style="object-fit: cover; cursor: pointer;" />
                        </label>
                        <input type="file" id="upload_profile" name="profile" class="d-none"
                            onchange="previewImage(this)">
                        <p class="mt-2">Click image to change</p>
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ Auth::user()->name ?? '' }}">
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ Auth::user()->email ?? '' }}">
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
