<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
            <Link href="{{ route('posts.create') }}" class="px-4 py-2 text-white bg-indigo-400 hover:bg-indigo-600 rounded-md">New Post</Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$posts">
                        @cell('action', $post)
                            <Link href="{{ route('posts.edit', $post->id) }}" class="inline-flex items"
                                class="text-green-600 hover:text-green-400 font-semibold">Edit</Link>
                            <Link confirm="Delete Post..." confirm-text="Are you sure to delete this post?" confirm-button="Yes, Delete it!" cancel-button="No, Cancel!"  href="{{ route('posts.destroy', $post->id) }}" class="text-red-600 hover:text-red-400 font-semibold" method="DELETE" preserve-scroll> Delete</Link>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
