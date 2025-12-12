@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Nova Transação</h1>
    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block">Valor</label>
            <input type="number" step="0.01" name="valor" value="{{ old('valor') }}" class="border rounded w-full p-2">
        </div>
        <div>
            <label class="block">CPF</label>
            <input type="text" name="cpf" value="{{ old('cpf') }}" class="border rounded w-full p-2">
        </div>
        <div>
            <label class="block">Status</label>
            <select name="status" class="border rounded w-full p-2">
                <option value="processando">Processando</option>
                <option value="aprovada">Aprovada</option>
                <option value="negada">Negada</option>
            </select>
        </div>
        <div>
            <label class="block">Documento (opcional)</label>
            <input type="file" name="documento" class="border rounded w-full p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Criar</button>
        <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
    </form>
</div>
@endsection
