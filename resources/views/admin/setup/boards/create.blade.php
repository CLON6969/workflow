@extends('layouts.admin')

@section('title', 'Create Board')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 flex items-center justify-center p-6 text-white">
    <div class="w-full max-w-md">
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8">
            
            <div class="flex flex-col items-center text-center mb-8">
                <i class="fas fa-graduation-cap text-5xl text-cyan-400 mb-4"></i>
                <h1 class="text-3xl font-bold tracking-tighter">Create New Board</h1>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-400/30 rounded-2xl p-4 text-sm text-red-300">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><i class="fas fa-circle-exclamation"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.setup.boards.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Board Name</label>
                    <input type="text" name="name" 
                           class="w-full bg-white/5 border border-white/10 focus:border-cyan-400 rounded-2xl px-5 py-4 text-white outline-none transition"
                           placeholder="e.g. Cambridge International" required>
                </div>

                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 rounded-2xl font-semibold text-lg transition-all active:scale-[0.97]">
                    <i class="fas fa-save mr-2"></i> Save Board
                </button>
            </form>

            <a href="{{ route('admin.setup.boards.index') }}" 
               class="block text-center mt-6 text-slate-400 hover:text-white transition">
                ← Back to All Boards
            </a>
        </div>
    </div>
</div>
@endsection