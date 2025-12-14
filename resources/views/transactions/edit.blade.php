@extends('layouts.admin')

@section('page-title', 'Editar Transação')

@section('header-actions')
    <a href="{{ route('transactions.index') }}" 
       class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-800 text-sm font-medium transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Editar Transação</h2>
        <p class="text-gray-500 mt-1">Transação #{{ $transaction->id }} - Criada em {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">Por favor, corrija os erros abaixo:</span>
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('transactions.update', $transaction) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Valor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="valor">
                        Valor <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">R$</span>
                        <input type="number" 
                               step="0.01" 
                               name="valor" 
                               id="valor"
                               value="{{ old('valor', $transaction->valor) }}" 
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-transparent transition-all @error('valor') border-red-300 @enderror"
                               placeholder="0,00"
                               required>
                    </div>
                    @error('valor')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CPF -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="cpf">
                        CPF <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="cpf" 
                           id="cpf"
                           value="{{ old('cpf', $transaction->cpf) }}" 
                           maxlength="11"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-transparent transition-all @error('cpf') border-red-300 @enderror"
                           placeholder="Apenas números (11 dígitos)"
                           required>
                    @error('cpf')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="status">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="status" 
                                id="status"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-transparent transition-all appearance-none @error('status') border-red-300 @enderror"
                                required>
                            <option value="processando" {{ old('status', $transaction->status) === 'processando' ? 'selected' : '' }}>Em Processamento</option>
                            <option value="aprovada" {{ old('status', $transaction->status) === 'aprovada' ? 'selected' : '' }}>Aprovada</option>
                            <option value="negada" {{ old('status', $transaction->status) === 'negada' ? 'selected' : '' }}>Negada</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Documento Atual -->
                @if($transaction->documento)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Documento Atual
                    </label>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-700 truncate">{{ basename($transaction->documento) }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $transaction->documento) }}" 
                           target="_blank"
                           class="flex-shrink-0 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 hover:text-gray-800 hover:border-gray-300 transition-colors">
                            Ver arquivo
                        </a>
                    </div>
                </div>
                @endif

                <!-- Novo Documento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="documento">
                        {{ $transaction->documento ? 'Substituir Documento' : 'Documento' }} <span class="text-gray-400 font-normal">(opcional)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-gray-300 transition-colors"
                         x-data="{ fileName: '' }"
                         @dragover.prevent
                         @drop.prevent="
                             const file = $event.dataTransfer.files[0];
                             if (file) {
                                 document.getElementById('documento').files = $event.dataTransfer.files;
                                 fileName = file.name;
                             }
                         ">
                        <input type="file" 
                               name="documento" 
                               id="documento"
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="hidden"
                               @change="fileName = $event.target.files[0]?.name || ''">
                        <label for="documento" class="cursor-pointer">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-gray-600" x-show="!fileName">
                                <span class="text-black font-medium">Clique para selecionar</span> ou arraste o arquivo
                            </p>
                            <p class="text-gray-600 font-medium" x-show="fileName" x-text="fileName"></p>
                            <p class="text-gray-400 text-sm mt-1">PDF, JPG ou PNG (máx. 2MB)</p>
                        </label>
                    </div>
                    @error('documento')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-xl flex items-center justify-between">
                <button type="button" 
                        onclick="if(confirm('Deseja realmente excluir esta transação?')) { document.getElementById('delete-form').submit(); }"
                        class="px-4 py-2 text-red-600 hover:text-red-800 hover:bg-red-50 font-medium rounded-lg transition-colors">
                    Excluir Transação
                </button>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('transactions.index') }}" 
                       class="px-5 py-2.5 text-gray-600 hover:text-gray-800 font-medium transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-black hover:bg-gray-800 text-white font-medium rounded-full transition-colors">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Formulário separado para exclusão -->
        <form id="delete-form" action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
