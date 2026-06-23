@extends('layouts.admin')

@section('title', 'Exam Boards')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-12 text-white">
    <div class="max-w-6xl mx-auto px-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10">
            <div>
                <h1 class="text-4xl font-bold tracking-tighter">Exam Boards</h1>
                <p class="text-slate-400 mt-1">Manage examination boards</p>
            </div>
            
            <a href="{{ route('admin.setup.boards.create') }}" 
               class="flex items-center gap-3 bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 px-6 py-3 rounded-2xl font-medium transition">
                <i class="fas fa-plus"></i> Add New Board
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-500/10 border border-green-400/30 text-green-300 p-4 rounded-2xl flex items-center gap-3">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($boards as $board)
            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-7 hover:border-cyan-400 transition-all group">
                
                <i class="fas fa-graduation-cap text-4xl text-cyan-400 mb-5"></i>
                
                <h3 class="text-2xl font-semibold mb-6 line-clamp-2">{{ $board->name }}</h3>

                <div class="flex gap-3">
                    <a href="{{ route('admin.setup.boards.edit', $board) }}" 
                       class="flex-1 text-center py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-sm font-medium transition">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    
                    <form method="POST" action="{{ route('admin.setup.boards.delete', $board) }}" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure you want to delete this board?')" 
                                class="w-full py-3 bg-white/5 hover:bg-red-500/10 border border-white/10 hover:border-red-400 text-red-400 rounded-2xl text-sm font-medium transition">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>

                <a href="{{ route('admin.setup.boards.years.index', $board) }}" 
                   class="block mt-6 text-cyan-400 hover:text-cyan-300 text-center font-medium transition">
                    Manage Structure →
                </a>
            </div>
            @endforeach
        </div>

        @if($boards->isEmpty())
        <div class="text-center py-20">
            <i class="fas fa-folder-open text-6xl text-slate-500 mb-4"></i>
            <p class="text-slate-400">No exam boards yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection