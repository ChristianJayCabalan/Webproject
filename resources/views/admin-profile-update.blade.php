<x-layouts.admin>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Card -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 fw-bold">Update Admin Profile</h3>

                        @if(session('success'))
                            <div class="alert alert-success text-center">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Picture -->
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ $admin->profile_picture ? asset('storage/' . $admin->profile_picture) : 'https://via.placeholder.com/120' }}" 
                                         alt="Admin Profile Picture" 
                                         class="rounded-circle border shadow-sm" 
                                         width="120" height="120"
                                         id="preview-image">

                                    <!-- Camera Icon (Bottom Right) -->
                                    <label for="profile_picture" 
                                           class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow"
                                           style="cursor: pointer;">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>

                                <input type="file" name="profile_picture" id="profile_picture" class="d-none"
                                       onchange="previewImage(event)">
                                @error('profile_picture') 
                                    <small class="text-danger d-block mt-1">{{ $message }}</small> 
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Admin Name</label>
                                <input type="text" name="name" class="form-control rounded-3" 
                                       value="{{ old('name', $admin->name) }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary rounded-3 shadow-sm">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            let reader = new FileReader();
            reader.onload = function(){
                document.getElementById('preview-image').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-layouts.admin>
