<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // Exibir lista de transações (web)
    public function indexWeb()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();
        return view('transactions.index', compact('transactions'));
    }

    // Exibir formulário de criação
    public function create()
    {
        return view('transactions.create');
    }

    // Exibir detalhes de uma transação
    public function showWeb(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    // Exibir formulário de edição
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    // Listar transações do usuário autenticado (API)
    public function index()
    {
        return Transaction::where('user_id', auth()->id())->get();
    }

    // Criar nova transação (API)
    public function store(Request $request)
    {
        $data = $request->validate([
            'valor' => 'required|numeric',
            'cpf' => 'required|digits:11',
            'status' => 'required',
            'documento' => 'file|mimes:pdf,jpg,png,jpeg'
        ]);

        if ($request->hasFile('documento')) {
            $data['documento'] = $request->file('documento')->store('docs');
        }

        $data['user_id'] = auth()->id();

        return Transaction::create($data);
    }

    // Ver uma transação (API)
    public function show(Transaction $transaction)
    {
        return $transaction;
    }

    // Atualizar transação (API)
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update($request->all());
        return $transaction;
    }

    // Soft delete (API)
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['mensagem' => 'Excluída com sucesso']);
    }
}
