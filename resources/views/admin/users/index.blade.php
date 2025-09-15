<x-layouts.admin title="Users">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ __('Users') }}</h1>
            <div class="text-sm text-gray-500">
                {{ __('Showing') . ' ' . ($users->firstItem() ?? 0) . ' ' . __('to') . ' ' . ($users->lastItem() ?? 0) . ' ' . __('of') . ' ' . $users->total() . ' ' . __('results') }}
            </div>
        </div>
    </x-slot>
    <div class="bg-white shadow rounded-lg">
        <form method="GET" class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search') }}</label>
                    <x-admin.search-form 
                        placeholder="{{ __('Search by name or email...') }}" 
                        :value="request('filter.search')" />
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Role') }}</label>
                    <x-admin.filter-select 
                        name="role_id"
                        :options="$roles->pluck('name', 'id')"
                        :selected="request('filter.role_id')"
                        placeholder="{{ __('All roles') }}" />
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Status') }}</label>
                    <x-admin.filter-select 
                        name="status_id"
                        :options="$statuses->pluck('name', 'id')"
                        :selected="request('filter.status_id')"
                        placeholder="{{ __('All statuses') }}" />
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        {{ __('Filter') }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        {{ __('Clear') }}
                    </a>
                </div>
            </div>
        </form>
        @php
            $activeFilters = [];
            if(request('filter.search')) $activeFilters['search'] = request('filter.search');
            if(request('filter.role_id')) $activeFilters['role'] = $roles->find(request('filter.role_id'))->name ?? '';
            if(request('filter.status_id')) $activeFilters['status'] = $statuses->find(request('filter.status_id'))->name ?? '';
            if(request('sort')) $activeFilters['sort'] = str_replace(['-', '_'], [' (desc)', ' '], request('sort'));
        @endphp
        <x-admin.active-filters :filters="$activeFilters" />
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <x-admin.sortable-header field="name" :current-sort="request('sort')">
                                {{ __('User') }}
                            </x-admin.sortable-header>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <x-admin.sortable-header field="role_id" :current-sort="request('sort')">
                                {{ __('Role') }}
                            </x-admin.sortable-header>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <x-admin.sortable-header field="status_id" :current-sort="request('sort')">
                                {{ __('Status') }}
                            </x-admin.sortable-header>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Posts') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <x-admin.sortable-header field="last_login_at" :current-sort="request('sort')">
                                {{ __('Last login') }}
                            </x-admin.sortable-header>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <x-admin.sortable-header field="created_at" :current-sort="request('sort')">
                                {{ __('Joined') }}
                            </x-admin.sortable-header>
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">{{ __('Actions') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    @php
                    $createdAt = $user->created_at;
                    $createdAt->locale(config('app.locale'));
                    $createdAt->settings(['formatFunction' => 'translatedFormat']);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($user->avatar)
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ $user->initials() }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role->name === 'admin') bg-red-100 text-red-800 
                                @elseif($user->role->name === 'editor') bg-blue-100 text-blue-800 
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst(__($user->role->name)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->status->name === 'active') bg-green-100 text-green-800 
                                @elseif($user->status->name === 'inactive') bg-red-100 text-red-800 
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst(__($user->status->name)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->posts_count . ' ' . __('posts') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('Never') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $createdAt->format('F j, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="text-indigo-600 hover:text-indigo-900">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            {{ __('No users found matching your criteria.') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="bg-white px-6 py-3 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
