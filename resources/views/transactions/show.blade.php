@extends('layouts.admin')

@section('page-title', 'Detalhes da Transação')

@section('header-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('transactions.edit', $transaction) }}" 
           class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 text-sm font-medium transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Editar
        </a>
        <a href="{{ route('transactions.index') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-black hover:bg-gray-800 text-white text-sm font-medium rounded-full transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <h2 class="text-3xl font-bold text-gray-800">Transação #{{ $transaction->id }}</h2>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                @if($transaction->status === 'aprovada') bg-green-100 text-green-800
                @elseif($transaction->status === 'negada') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800
                @endif">
                @if($transaction->status === 'processando')
                    Em processamento
                @elseif($transaction->status === 'aprovada')
                    Aprovada
                @else
                    Negada
                @endif
            </span>
        </div>
        <p class="text-gray-500">Criada em {{ $transaction->created_at->format('d/m/Y \à\s H:i:s') }}</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Amount Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-8 text-center">
            <p class="text-gray-400 text-sm mb-1">Valor da Transação</p>
            <p class="text-4xl font-bold text-white">{{ $transaction->valor_formatado }}</p>
        </div>

        <!-- Transaction Details -->
        <div class="p-6 space-y-6">
            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- ID -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">ID da Transação</p>
                    <p class="text-lg font-semibold text-gray-800">#{{ $transaction->id }}</p>
                </div>

                <!-- CPF -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">CPF</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $transaction->cpf_formatado }}</p>
                </div>

                <!-- Data de Criação -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">Data de Criação</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                </div>

                <!-- Última Atualização -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500 mb-1">Última Atualização</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $transaction->updated_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>

            <!-- Documento -->
            <div class="border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500 mb-3">Documento Anexado</p>
                @if($transaction->documento)
                    @php
                        $isPdf = Str::endsWith($transaction->documento, '.pdf');
                        $documentUrl = asset('storage/' . $transaction->documento);
                    @endphp
                    <button type="button"
                            @click="$dispatch('open-document-modal', { url: '{{ $documentUrl }}', isPdf: {{ $isPdf ? 'true' : 'false' }}, filename: '{{ basename($transaction->documento) }}' })"
                            class="inline-flex items-center px-4 py-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition-colors group w-full text-left">
                        <div class="flex-shrink-0 w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center mr-3">
                            @if($isPdf)
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 group-hover:text-black truncate">
                                {{ basename($transaction->documento) }}
                            </p>
                            <p class="text-sm text-gray-500">Clique para visualizar</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                @else
                    <div class="flex items-center px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">Nenhum documento anexado</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <form action="{{ route('transactions.destroy', $transaction) }}" 
                  method="POST" 
                  onsubmit="return confirm('Deseja realmente excluir esta transação?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 text-red-600 hover:text-red-800 hover:bg-red-50 font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Excluir Transação
                </button>
            </form>
            
            <a href="{{ route('transactions.edit', $transaction) }}" 
               class="inline-flex items-center px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-medium rounded-full transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
        </div>
    </div>
</div>

<!-- Modal de Visualização de Documento -->
<div x-data="documentModal()" 
     x-show="isOpen" 
     x-cloak
     @open-document-modal.window="openModal($event.detail)"
     @keydown.escape.window="closeModal()"
     class="fixed inset-0 z-50 overflow-hidden"
     style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeModal()"
         class="absolute inset-0 bg-black bg-opacity-75 backdrop-blur-sm">
    </div>

    <!-- Modal Content -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative flex items-center justify-center min-h-screen p-4">
        
        <!-- Close Button -->
        <button @click="closeModal()" 
                class="absolute top-4 right-4 z-10 p-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Header with filename -->
        <div class="absolute top-4 left-4 z-10">
            <p class="text-white text-sm font-medium bg-black bg-opacity-50 px-3 py-1 rounded-full" x-text="filename"></p>
        </div>

        <!-- Download Button -->
        <a :href="url" 
           download
           class="absolute top-4 right-16 z-10 p-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-white transition-colors"
           title="Baixar arquivo">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
        </a>

        <!-- Open in new tab Button -->
        <a :href="url" 
           target="_blank"
           class="absolute top-4 right-28 z-10 p-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-white transition-colors"
           title="Abrir em nova aba">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>

        <!-- Document Viewer -->
        <div class="relative max-w-5xl max-h-[85vh] w-full" @click.stop>
            <!-- PDF Viewer -->
            <template x-if="isPdf">
                <iframe :src="url" 
                        class="w-full h-[85vh] rounded-lg shadow-2xl bg-white">
                </iframe>
            </template>
            
            <!-- Image Viewer -->
            <template x-if="!isPdf">
                <div class="flex items-center justify-center">
                    <img :src="url" 
                         :alt="filename"
                         class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl"
                         @click.stop>
                </div>
            </template>
        </div>
    </div>
</div>

@push('scripts')
<script>
function documentModal() {
    return {
        isOpen: false,
        url: '',
        isPdf: false,
        filename: '',
        
        openModal(detail) {
            this.url = detail.url;
            this.isPdf = detail.isPdf;
            this.filename = detail.filename;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeModal() {
            this.isOpen = false;
            document.body.style.overflow = '';
        }
    }
}
</script>
@endpush
@endsection
