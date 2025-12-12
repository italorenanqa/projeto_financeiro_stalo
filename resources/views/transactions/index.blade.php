@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Minhas Transações</h1>
    <a href="{{ route('transactions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Nova Transação</a>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">ID</th>
                <th class="py-2">Valor</th>
                <th class="py-2">CPF</th>
                <th class="py-2">Status</th>
                <th class="py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td class="py-2">{{ $transaction->id }}</td>
                <td class="py-2">R$ {{ number_format($transaction->valor, 2, ',', '.') }}</td>
                <td class="py-2">{{ $transaction->cpf }}</td>
                <td class="py-2">{{ $transaction->status }}</td>
                <td class="py-2">
                    <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-600">Ver</a> |
                    <a href="{{ route('transactions.edit', $transaction) }}" class="text-yellow-600">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
