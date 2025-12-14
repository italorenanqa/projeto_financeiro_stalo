@extends('layouts.admin')

@section('page-title', 'Transações')

@section('header-actions')
    <a href="{{ route('transactions.create') }}" 
       class="inline-flex items-center px-5 py-2.5 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-full transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Criar Transação
    </a>
@endsection

@section('content')
<div class="max-w-6xl mx-auto" x-data="transactionList()">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Transações</h2>
        <p class="text-gray-500 mt-1">Gerencie suas transações financeiras</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between"
             x-data="{ show: true }" 
             x-show="show"
             x-transition>
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
            <button @click="show = false" class="text-green-700 hover:text-green-900">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Search Bar -->
        <div class="p-6 border-b border-gray-100">
            <div class="relative max-w-md">
                <input type="text" 
                       x-model="searchQuery"
                       @input="filterTransactions()"
                       placeholder="Buscar..." 
                       class="w-full pl-4 pr-12 py-3 border border-gray-200 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-transparent transition-all">
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-6 border-b border-gray-100 bg-gray-50">
            <div class="text-center">
                <p class="text-2xl font-bold text-gray-800">{{ $transactions->count() }}</p>
                <p class="text-sm text-gray-500">Total de Transações</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-green-600">{{ $transactions->where('status', 'aprovada')->count() }}</p>
                <p class="text-sm text-gray-500">Aprovadas</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $transactions->where('status', 'processando')->count() }}</p>
                <p class="text-sm text-gray-500">Em Processamento</p>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="divide-y divide-gray-100">
            @forelse ($transactions as $transaction)
                <div class="transaction-item px-6 py-4 hover:bg-gray-50 transition-colors cursor-pointer group"
                     data-valor="{{ $transaction->valor }}"
                     data-cpf="{{ $transaction->cpf }}"
                     data-status="{{ $transaction->status }}"
                     data-date="{{ $transaction->created_at->format('d/m/Y') }}"
                     @click="window.location='{{ route('transactions.show', $transaction) }}'">
                    <div class="flex items-center justify-between">
                        <!-- Transaction Info -->
                        <div class="flex items-center space-x-4 flex-1 min-w-0">
                            <!-- Amount Badge -->
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold
                                    @if($transaction->status === 'aprovada') bg-green-100 text-green-800
                                    @elseif($transaction->status === 'negada') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $transaction->valor_formatado }}
                                </span>
                            </div>
                            
                            <!-- Status & Date -->
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-700">
                                    <span class="font-medium">{{ $transaction->cpf_formatado }}</span>
                                    <span class="text-gray-400 mx-2">-</span>
                                    <span class="
                                        @if($transaction->status === 'aprovada') text-green-600
                                        @elseif($transaction->status === 'negada') text-red-600
                                        @else text-yellow-600
                                        @endif">
                                        @if($transaction->status === 'processando')
                                            Em processamento
                                        @elseif($transaction->status === 'aprovada')
                                            Aprovada
                                        @else
                                            Negada
                                        @endif
                                    </span>
                                    <span class="text-gray-400 mx-2">-</span>
                                    <span class="text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('transactions.show', $transaction) }}" 
                               @click.stop
                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                               title="Ver detalhes">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('transactions.edit', $transaction) }}" 
                               @click.stop
                               class="p-2 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors"
                               title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction) }}" 
                                  method="POST" 
                                  @click.stop
                                  onsubmit="return confirm('Deseja realmente excluir esta transação?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Excluir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhuma transação encontrada</h3>
                    <p class="text-gray-500 mb-6">Comece criando sua primeira transação</p>
                    <a href="{{ route('transactions.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-full transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Criar Transação
                    </a>
                </div>
            @endforelse
        </div>

        <!-- No Results Message (for search) -->
        <div class="px-6 py-12 text-center hidden" x-ref="noResults">
            <p class="text-gray-500">Nenhuma transação encontrada para "<span x-text="searchQuery"></span>"</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function transactionList() {
    return {
        searchQuery: '',
        filterTransactions() {
            const query = this.searchQuery.toLowerCase();
            const items = document.querySelectorAll('.transaction-item');
            let visibleCount = 0;

            items.forEach(item => {
                const valor = item.dataset.valor.toLowerCase();
                const cpf = item.dataset.cpf.toLowerCase();
                const status = item.dataset.status.toLowerCase();
                const date = item.dataset.date.toLowerCase();
                
                const matches = valor.includes(query) || 
                               cpf.includes(query) || 
                               status.includes(query) ||
                               date.includes(query);
                
                if (matches) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0 && this.searchQuery.length > 0) {
                this.$refs.noResults.classList.remove('hidden');
            } else {
                this.$refs.noResults.classList.add('hidden');
            }
        }
    }
}
</script>
@endpush
@endsection
