@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detalhes da Transação</h1>
    <ul class="mb-4">
        <li><strong>ID:</strong> {{ $transaction->id }}</li>
        <li><strong>Valor:</strong> R$ {{ number_format($transaction->valor, 2, ',', '.') }}</li>
        <li><strong>CPF:</strong> {{ $transaction->cpf }}</li>
        <li><strong>Status:</strong> {{ $transaction->status }}</li>
        <li><strong>Documento:</strong> @if($transaction->documento)
            <a href="{{ asset('storage/' . $transaction->documento) }}" target="_blank">Ver arquivo</a>
            @else
            Nenhum
            @endif
        </li>
    </ul>
    <a href="{{ route('transactions.edit', $transaction) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</a>
    <a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Voltar</a>
</div>
@endsection
