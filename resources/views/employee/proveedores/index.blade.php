{{-- resources/views/admin/proveedores/index.blade.php --}}
<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800;900&display=swap');
        .font-hatil { font-family: 'Inter', sans-serif; }
        .reveal { animation: fadeInUp 0.5s ease-out forwards; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        .supplier-card { background: white; border: 1px solid #f1f5f9; border-radius: 2.5rem; transition: all 0.4s; }
        .supplier-card:hover { border-color: #0f172a; box-shadow: 0 30px 60px -12px rgba(15, 23, 42, 0.08); transform: translateY(-3px); }
        
        .contact-badge { background: #f8fafc; border-radius: 1rem; padding: 0.75rem 1rem; }
        .btn-action { font-[900] text-[9px] uppercase tracking-[0.2em] italic transition: all 0.3s; }
    </style>

    <x-slot name="header">
        <div class="w-full rounded-b-[4rem] shadow-2xl bg-slate-900 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-12 reveal">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <nav class="flex mb-3 text-white/30 text-[10px] font-black uppercase tracking-[0.5em]">
                            <span>ADMINISTRACIÓN</span> <span class="mx-2">/</span> <span>PARTNERS</span>
                        </nav>
                        <h2 class="font-hatil font-black text-4xl text-white tracking-tighter italic uppercase leading-none">
                            Gestión de <span class="text-white/40">Proveedores</span>
                        </h2>
                    </div>
                    
                    <a href="{{ route('admin.proveedores.create') }}" class="inline-flex items-center bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-500/20 italic">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Proveedor
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen font-hatil">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            {{-- ALERTAS --}}
            @if (session('success'))
                <div class="mb-8 p-5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl reveal shadow-sm flex items-center">
                    <div class="bg-emerald-500 rounded-full p-1 mr-3">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs font-black text-emerald-800 uppercase tracking-tight">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($proveedores as $proveedor)
                    <div class="supplier-card p-8 flex flex-col justify-between reveal">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">ID: #{{ str_pad($proveedor->Proveedor_id, 3, '0', STR_PAD_LEFT) }}</span>
                                <div class="h-10 w-10 bg-slate-900 rounded-xl flex items-center justify-center text-white font-black italic">
                                    {{ substr($proveedor->Nombre, 0, 1) }}
                                </div>
                            </div>

                            <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter mb-2 leading-tight">
                                {{ $proveedor->Nombre }}
                            </h3>
                            
                            <div class="flex items-center text-slate-400 mb-6">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest">{{ $proveedor->Pais }} — {{ $proveedor->Ciudad }}</span>
                            </div>

                            <div class="space-y-3 mb-8">
                                <div class="contact-badge flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    <span class="text-xs font-black text-slate-700 tracking-tight italic">{{ $proveedor->Telefono }}</span>
                                </div>
                                <div class="contact-badge flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center mr-3 text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500 lowercase truncate">{{ $proveedor->Email }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                            <a href="{{ route('admin.proveedores.edit', ['Proveedor_id' => $proveedor->Proveedor_id]) }}" 
                               class="btn-action text-indigo-500 hover:text-indigo-800">
                                Editar Perfil
                            </a>
                            
                            <form action="{{ route('admin.proveedores.destroy', ['Proveedor_id' => $proveedor->Proveedor_id]) }}" method="POST" 
                                  onsubmit="return confirm('¿Eliminar socio estratégico?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action text-red-400 hover:text-red-600">
                                    Dar de Baja
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-block p-10 bg-white rounded-[4rem] shadow-sm border border-slate-100">
                            <p class="text-sm font-black text-slate-300 uppercase tracking-[0.5em] italic">Sin proveedores en sistema</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- PAGINACIÓN --}}
            @if ($proveedores instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-16">
                    {{ $proveedores->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>