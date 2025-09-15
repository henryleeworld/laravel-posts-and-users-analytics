<x-layouts.admin title="Post Details">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ Str::limit($post->title, 50) }}</h1>
            <a href="{{ route('admin.posts.index') }}" 
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                {{ __('Back to posts') }}
            </a>
        </div>
    </x-slot>
    @php
    $createdAt = $post->created_at;
    $createdAt->locale(config('app.locale'));
    $createdAt->settings(['formatFunction' => 'translatedFormat']);
    $publishedAt = $post->published_at;
    if ($publishedAt) {
        $publishedAt->locale(config('app.locale'));
        $publishedAt->settings(['formatFunction' => 'translatedFormat']);
    }
    $updatedAt = $post->updated_at;
    $updatedAt->locale(config('app.locale'));
    $updatedAt->settings(['formatFunction' => 'translatedFormat']);
    @endphp
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3">
            <div class="bg-white shadow rounded-lg">
                @if($post->featured_image)
                <div class="aspect-w-16 aspect-h-9">
                    <img class="w-full h-64 object-cover rounded-t-lg" src="{{ $post->featured_image }}" alt="{{ $post->title }}">
                </div>
                @endif
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                            @if($post->author->avatar)
                                <img class="h-8 w-8 rounded-full" src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-xs font-medium text-gray-700">{{ $post->author->initials() }}</span>
                                </div>
                            @endif
                            <span>{{ __('by ') }}<a href="{{ route('admin.users.show', $post->author) }}" class="text-indigo-600 hover:text-indigo-500">{{ $post->author->name }}</a></span>
                        </div>
                        <span>•</span>
                        <span>
                            {{ $createdAt->format('F j, Y') }}
                        </span>
                        @if($publishedAt)
                            <span>•</span>
                            <span>
                                {{ __('Published') . ' ' . $publishedAt->format('F j, Y') }}
                            </span>
                        @endif
                    </div>
                    @if($post->excerpt)
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Excerpt') }}</h3>
                        <p class="text-gray-700">{{ $post->excerpt }}</p>
                    </div>
                    @endif
                    <div class="prose max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Post details') }}</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Status') }}</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($post->status->name === 'published') bg-green-100 text-green-800 
                                    @elseif($post->status->name === 'draft') bg-yellow-100 text-yellow-800 
                                    @elseif($post->status->name === 'scheduled') bg-blue-100 text-blue-800 
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(__($post->status->name)) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Category') }}</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }}">
                                    {{ __($post->category->name) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Author') }}</dt>
                            <dd class="mt-1">
                                <a href="{{ route('admin.users.show', $post->author) }}" 
                                   class="text-sm text-indigo-600 hover:text-indigo-500">
                                    {{ $post->author->name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Slug') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono bg-gray-100 px-2 py-1 rounded">{{ $post->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Created') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($publishedAt)
                                {{ __('Published') . ' ' . $publishedAt->format('F j, Y') }}
                                @endif
                                {{ $createdAt->format('F j, Y g:i A') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Last updated') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $updatedAt->format('F j, Y g:i A') }}
                            </dd>
                        </div>
                        @if($publishedAt)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Published at') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $publishedAt->format('F j, Y g:i A') }}
                            </dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Featured image') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $post->featured_image ? __('Yes') : __('No') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Quick actions') }}</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.posts.index', ['filter[user_id]' => $post->author->id]) }}" 
                       class="block w-full px-4 py-2 text-sm text-center bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        {{ __('View all posts by :author_name', ['author_name' => $post->author->name]) }}
                    </a>
                    <a href="{{ route('admin.posts.index', ['filter[category_id]' => $post->category->id]) }}" 
                       class="block w-full px-4 py-2 text-sm text-center bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        {{ __('View all posts in :category_name', ['category_name' => __($post->category->name)]) }}
                    </a>
                    <a href="{{ route('admin.posts.index', ['filter[status_id]' => $post->status->id]) }}" 
                       class="block w-full px-4 py-2 text-sm text-center bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        {{ __('View all :status_name posts', ['status_name' => __($post->status->name)]) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
