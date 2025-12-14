<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Rules\ValidCpf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    // Exibir lista de transações (web)
    public function indexWeb()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
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
        Gate::authorize('view', $transaction);
        
        return view('transactions.show', compact('transaction'));
    }

    // Exibir formulário de edição
    public function edit(Transaction $transaction)
    {
        Gate::authorize('update', $transaction);
        
        return view('transactions.edit', compact('transaction'));
    }

    // Listar transações do usuário autenticado (API)
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($transactions);
    }

    // Criar nova transação (API e Web)
    public function store(Request $request)
    {
        $data = $request->validate([
            'valor' => 'required|numeric|min:0.01',
            'cpf' => ['required', 'digits:11', new ValidCpf],
            'status' => 'required|in:processando,aprovada,negada',
            'documento' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048'
        ], [
            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.digits' => 'O CPF deve conter 11 dígitos.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
            'documento.mimes' => 'O documento deve ser PDF, JPG ou PNG.',
            'documento.max' => 'O documento não pode ser maior que 2MB.'
        ]);

        if ($request->hasFile('documento')) {
            $data['documento'] = $request->file('documento')->store('docs', 'public');
        }

        $data['user_id'] = auth()->id();

        $transaction = Transaction::create($data);

        // Se for requisição web, redirecionar com mensagem
        if ($request->expectsJson()) {
            return response()->json($transaction, 201);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transação criada com sucesso!');
    }

    // Ver uma transação (API)
    public function show(Transaction $transaction)
    {
        Gate::authorize('view', $transaction);

        return response()->json($transaction);
    }

    // Atualizar transação (API e Web)
    public function update(Request $request, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        $data = $request->validate([
            'valor' => 'sometimes|required|numeric|min:0.01',
            'cpf' => ['sometimes', 'required', 'digits:11', new ValidCpf],
            'status' => 'sometimes|required|in:processando,aprovada,negada',
            'documento' => 'sometimes|nullable|file|mimes:pdf,jpg,png,jpeg|max:2048'
        ], [
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'cpf.digits' => 'O CPF deve conter 11 dígitos.',
            'status.in' => 'Status inválido.',
            'documento.mimes' => 'O documento deve ser PDF, JPG ou PNG.',
            'documento.max' => 'O documento não pode ser maior que 2MB.'
        ]);

        if ($request->hasFile('documento')) {
            // Deletar documento antigo se existir
            if ($transaction->documento) {
                Storage::disk('public')->delete($transaction->documento);
            }
            $data['documento'] = $request->file('documento')->store('docs', 'public');
        }

        $transaction->update($data);

        // Se for requisição web, redirecionar com mensagem
        if ($request->expectsJson()) {
            return response()->json($transaction);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    // Soft delete (API e Web)
    public function destroy(Request $request, Transaction $transaction)
    {
        Gate::authorize('delete', $transaction);

        $transaction->delete();

        // Se for requisição web, redirecionar com mensagem
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Transação excluída com sucesso']);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transação excluída com sucesso!');
    }
}
