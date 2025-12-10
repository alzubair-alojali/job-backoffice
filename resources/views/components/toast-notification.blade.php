<div>
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(()=> show = false, 3000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                    class="max-w-full mx-auto mb-4">
                    <div class="flex items-start gap-3 bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm">
                        <div class="flex-shrink-0 mt-0.5">
                            <!-- success icon -->
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1 text-sm text-green-800">
                            <strong class="block font-medium">Success</strong>
                            <span class="block">{{ session('success') }}</span>
                        </div>

                        <button type="button" @click="show = false"
                            class="text-green-600 hover:text-green-800 ml-4 rounded focus:outline-none">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>