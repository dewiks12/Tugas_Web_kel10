<x-admin-layout>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Branches</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all branches in the system including their name, address, and status.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.branches.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto">
                Add Branch
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.branches.index') }}" method="GET" class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                <div class="sm:w-1/3">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Branch name or code">
                </div>
                <div class="sm:w-1/3">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="sm:w-1/3 sm:flex sm:items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Branches Table -->
        <div class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Address</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($branches as $branch)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $branch->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-300">{{ $branch->code }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $branch->address }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $branch->phone }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $branch->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                {{ $branch->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.branches.edit', $branch) }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">Edit</a>
                                <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this branch?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $branches->withQueryString()->links() }}
        </div>
    </div>
</x-admin-layout> 