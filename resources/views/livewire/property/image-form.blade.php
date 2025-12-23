<div>
    @if (session()->has('message'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Upload Images</h3>
        
        <!-- Regular Form (Not Livewire) -->
        <form 
            action="{{ route('properties.images.upload', $property) }}" 
            method="POST" 
            enctype="multipart/form-data"
            x-data="{
                isDragging: false,
                files: [],
                previewUrls: [],
                isUploading: false,
                
                handleFiles(fileList) {
                    const validFiles = Array.from(fileList).filter(file => 
                        file.type.startsWith('image/') && file.size <= 10485760
                    );
                    
                    if (validFiles.length === 0) {
                        alert('Please select valid image files (max 10MB each)');
                        return;
                    }
                    
                    // Add to existing files
                    this.files = [...this.files, ...validFiles];
                    
                    // Generate preview URLs
                    validFiles.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewUrls.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                    
                    // Update file input
                    this.updateFileInput();
                },
                
                updateFileInput() {
                    const dt = new DataTransfer();
                    this.files.forEach(file => dt.items.add(file));
                    $refs.fileInput.files = dt.files;
                },
                
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.previewUrls.splice(index, 1);
                    this.updateFileInput();
                },
                
                clearAll() {
                    this.files = [];
                    this.previewUrls = [];
                    $refs.fileInput.value = '';
                }
            }"
            @submit="isUploading = true"
        >
            @csrf
            
            <div 
                @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @dragenter.prevent="isDragging = true"
            >
                <input 
                    type="file" 
                    x-ref="fileInput"
                    name="images[]"
                    multiple 
                    accept="image/*"
                    class="hidden"
                    @change="handleFiles($event.target.files)"
                >

                <div 
                    @click="$refs.fileInput.click()"
                    :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-gray-50'"
                    class="border-2 border-dashed rounded-lg p-8 text-center cursor-pointer transition-all duration-200 hover:border-blue-400 hover:bg-blue-50"
                >
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="font-semibold">Click to select images</span> or drag and drop
                    </p>
                    <p class="mt-1 text-xs text-gray-500">
                        Select multiple images to upload (Max 10MB per image)
                    </p>
                </div>

                <!-- Preview Selected Files -->
                <div x-show="files.length > 0" class="mt-6" x-cloak>
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-medium text-gray-700" x-text="`${files.length} image(s) selected`"></p>
                        <button 
                            type="button" 
                            @click="clearAll()"
                            class="text-sm text-red-600 hover:text-red-800 font-medium"
                        >
                            Clear All
                        </button>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        <template x-for="(url, index) in previewUrls" :key="index">
                            <div class="relative group">
                                <img 
                                    :src="url" 
                                    alt="Preview"
                                    class="w-full h-32 object-cover rounded-lg border border-gray-200"
                                >
                                <button 
                                    type="button"
                                    @click.stop="removeFile(index)"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <!-- Upload Button -->
                    <div class="mt-4">
                        <button 
                            type="submit"
                            :disabled="isUploading"
                            class="w-full bg-blue-600 text-white py-2.5 px-4 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed font-medium"
                        >
                            <span x-show="!isUploading">Upload Images</span>
                            <span x-show="isUploading" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Uploading...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Uploaded Images Section -->
    @if ($propertyImages->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Uploaded Images</h3>
            <p class="text-sm text-gray-600 mb-4">{{ $propertyImages->count() }} image(s) uploaded</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($propertyImages as $index => $image)
                    <div class="relative group" wire:key="img-{{ $image->id }}">
                            <img 
                                src="{{ Storage::url($image->image_path) }}" 
                                alt="Property Image"
                                class="w-full h-32 object-cover rounded-lg border-2  {{ $image->is_primary ? 'border-blue-500' : 'border-gray-200' }}"
                            >
                        
                        @if ($image->is_primary)
                            <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-md font-medium shadow-lg">
                                Primary
                            </span>
                        @endif

                        <div class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-40 transition-all rounded-lg !z-10">
                            <div class="absolute bottom-2 left-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if (!$image->is_primary)
                                    <button 
                                        type="button"
                                        wire:click="setPrimary('{{ $image->id }}')"
                                        class="flex-1 bg-blue-600 text-white text-xs py-1.5 px-2 rounded hover:bg-blue-700 font-medium"
                                    >
                                        Set Primary
                                    </button>
                                @endif
                                <button 
                                    type="button"
                                    wire:click="deleteImage('{{ $image->id }}')"
                                    onclick="return confirm('Are you sure you want to delete this image?')"
                                    class="flex-1 bg-red-600 text-white text-xs py-1.5 px-2 rounded hover:bg-red-700 font-medium"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No images uploaded yet</h3>
            <p class="mt-1 text-sm text-gray-500">Upload your first image to get started</p>
        </div>
    @endif

<style>
    [x-cloak] { display: none !important; }
</style>
</div>
