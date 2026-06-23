@extends('layouts.admin')

@section('title', 'Resources')

@section('content')
<div class="min-h-screen bg-slate-950 text-white p-4 md:p-8 space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl md:text-3xl font-bold"><i class="fa-solid fa-box-open"></i> Resources</h1>
            <p class="text-gray-400 text-sm">Manage uploaded past papers</p>
        </div>

        <a href="{{ route('admin.resources.create') }}"
           class="bg-green-600 hover:bg-green-500 transition px-5 py-2 rounded-xl font-medium shadow-lg">
            + Upload Resource
        </a>

    </div>

    <!-- CARD -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">

        <!-- TABLE WRAPPER -->
        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-slate-900 text-gray-300">
                    <tr class="text-left">
                        <th class="p-4">Resource</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th class="text-right pr-6">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-white/10">

                    @forelse($resources as $res)

                        <tr class="hover:bg-white/5 transition">

                            <!-- TITLE -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">

                                    <div class="text-xl text-indigo-400">
                                        <i class="fa-regular fa-file-pdf"></i>
                                    </div>

                                    <div>
                                        <p class="font-medium">
                                            {{ Str::limit($res->title, 40) }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $res->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <!-- COURSE -->
                            <td class="text-gray-300">
                                {{ optional($res->boardCourse)->name ?? '-' }}
                            </td>

                            <!-- TYPE -->
                            <td>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $res->type === 'past_paper' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }}">
                                    {{ ucfirst($res->type) }}
                                </span>
                            </td>

                            <!-- ACTIONS -->
                            <td class="text-right pr-6 space-x-2">

                                <!-- VIEW -->
                                <a href="{{ route('admin.resources.show', $res) }}"
                                   class="inline-block px-3 py-1 bg-indigo-600/20 text-indigo-400 rounded-lg hover:bg-indigo-600/30 transition text-xs">
                                    View
                                </a>

                                <!-- DELETE -->
                                <form method="POST"
                                      action="{{ route('admin.resources.destroy', $res) }}"
                                      class="inline"
                                      onsubmit="return confirm('Delete this resource?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition text-xs">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-16 text-gray-400">
                                <div class="text-5xl mb-3">📭</div>
                                No resources found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

    <!-- PAGINATION -->
    <div class="flex justify-center">
        <div class="bg-white/5 px-4 py-2 rounded-xl">
            {{ $resources->links() }}
        </div>
    </div>

</div>
@endsection

