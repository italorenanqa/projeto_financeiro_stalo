# 💰 Sistema de Gerenciamento de Transações Financeiras

Sistema completo para gerenciamento de transações financeiras desenvolvido com **Laravel 12** e interface administrativa moderna. Permite cadastrar, visualizar, editar e excluir transações com validação de CPF, upload de documentos e controle de status.

---

## 📋 Índice

-   [Visão Geral](#-visão-geral)
-   [Tecnologias Utilizadas](#-tecnologias-utilizadas)
-   [Requisitos do Sistema](#-requisitos-do-sistema)
-   [Instalação](#-instalação)
-   [Estrutura do Projeto](#-estrutura-do-projeto)
-   [Banco de Dados](#-banco-de-dados)
-   [Backend (API)](#-backend-api)
-   [Frontend (Web)](#-frontend-web)
-   [Autenticação e Segurança](#-autenticação-e-segurança)
-   [Rotas da Aplicação](#-rotas-da-aplicação)
-   [Funcionalidades](#-funcionalidades)
-   [Testes](#-testes)

---

## 🎯 Visão Geral

Este sistema é uma aplicação **CRUD completa** para gerenciamento de transações financeiras, oferecendo:

-   **Interface Web** com design moderno e responsivo
-   **API RESTful** para integração com outros sistemas
-   **Autenticação segura** via sessão (web) e tokens (API)
-   **Upload de documentos** (PDF, JPG, PNG)
-   **Validação de CPF** com algoritmo oficial
-   **Soft Delete** para preservação de dados
-   **Políticas de autorização** para isolamento de dados entre usuários

---

## 🚀 Tecnologias Utilizadas

### Backend

| Tecnologia          | Versão | Descrição                   |
| ------------------- | ------ | --------------------------- |
| **PHP**             | ^8.2   | Linguagem de programação    |
| **Laravel**         | ^12.0  | Framework PHP               |
| **Laravel Sanctum** | ^4.2   | Autenticação API via tokens |
| **Laravel Breeze**  | \*     | Scaffolding de autenticação |
| **MySQL/MariaDB**   | 8.0+   | Banco de dados relacional   |

### Frontend

| Tecnologia       | Versão | Descrição                    |
| ---------------- | ------ | ---------------------------- |
| **Tailwind CSS** | ^3.1.0 | Framework CSS utilitário     |
| **Alpine.js**    | ^3.4.2 | Framework JavaScript reativo |
| **Vite**         | ^7.0.7 | Build tool e dev server      |
| **Blade**        | -      | Template engine do Laravel   |

### Ferramentas de Desenvolvimento

| Tecnologia       | Descrição                            |
| ---------------- | ------------------------------------ |
| **Laravel Pint** | Formatador de código PHP             |
| **PHPUnit**      | Framework de testes                  |
| **Laravel Pail** | Visualização de logs em tempo real   |
| **Laravel Sail** | Ambiente Docker para desenvolvimento |

---

## 💻 Requisitos do Sistema

-   **PHP** >= 8.2
-   **Composer** >= 2.0
-   **Node.js** >= 18.x
-   **NPM** >= 9.x
-   **MySQL** >= 8.0 ou **MariaDB** >= 10.6
-   **Extensões PHP**: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML

---

## 📦 Instalação

### 1. Clonar o repositório

```bash
git clone <url-do-repositorio>
cd projeto_otimizado
```

### 2. Instalar dependências

```bash
# Dependências PHP
composer install

# Dependências JavaScript
npm install
```

### 3. Configurar ambiente

```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4. Configurar banco de dados

Edite o arquivo `.env` com suas credenciais:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projeto_financeiro
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

> ⚠️ **IMPORTANTE**: Nunca compartilhe suas credenciais de banco de dados em repositórios públicos!

### 5. Executar migrações

```bash
php artisan migrate
```

### 6. Criar link simbólico para storage

```bash
php artisan storage:link
```

### 7. Compilar assets

```bash
# Desenvolvimento
npm run dev

# Produção
npm run build
```

### 8. Iniciar servidor

```bash
php artisan serve
```

Acesse: **http://127.0.0.1:8000**

### Instalação Rápida (Script)

```bash
composer setup
```

---

## 📁 Estrutura do Projeto

```
projeto_otimizado/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Controllers de autenticação
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── ProfileController.php    # Gerenciamento de perfil
│   │   │   └── TransactionController.php # CRUD de transações
│   │   └── Requests/
│   │       └── ProfileUpdateRequest.php # Validação de perfil
│   ├── Models/
│   │   ├── Transaction.php              # Modelo de transação
│   │   └── User.php                     # Modelo de usuário
│   ├── Policies/
│   │   └── TransactionPolicy.php        # Políticas de autorização
│   ├── Providers/
│   │   └── AppServiceProvider.php       # Registro de serviços
│   └── Rules/
│       └── ValidCpf.php                 # Regra de validação de CPF
├── config/                              # Arquivos de configuração
├── database/
│   ├── factories/                       # Factories para testes
│   ├── migrations/                      # Migrações do banco
│   └── seeders/                         # Seeders de dados
├── public/                              # Arquivos públicos
│   ├── storage -> ../storage/app/public # Link simbólico
│   └── build/                           # Assets compilados
├── resources/
│   ├── css/
│   │   └── app.css                      # Estilos globais
│   ├── js/
│   │   ├── app.js                       # JavaScript principal
│   │   └── bootstrap.js                 # Configuração Axios
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php          # Layout administrativo
│       │   ├── app.blade.php            # Layout padrão
│       │   └── guest.blade.php          # Layout para visitantes
│       ├── transactions/
│       │   ├── index.blade.php          # Listagem
│       │   ├── create.blade.php         # Criação
│       │   ├── edit.blade.php           # Edição
│       │   └── show.blade.php           # Visualização
│       ├── profile/                     # Views de perfil
│       ├── auth/                        # Views de autenticação
│       └── components/                  # Componentes Blade
├── routes/
│   ├── api.php                          # Rotas da API
│   ├── web.php                          # Rotas web
│   └── auth.php                         # Rotas de autenticação
├── storage/
│   └── app/public/docs/                 # Documentos enviados
└── tests/                               # Testes automatizados
```

---

## 🗄️ Banco de Dados

### Diagrama ER

```
┌─────────────────────┐       ┌─────────────────────────┐
│       users         │       │      transactions       │
├─────────────────────┤       ├─────────────────────────┤
│ id (PK)             │───┐   │ id (PK)                 │
│ name                │   │   │ user_id (FK)            │───┘
│ email (UNIQUE)      │   │   │ valor (DECIMAL 10,2)    │
│ email_verified_at   │   │   │ cpf (VARCHAR 11)        │
│ password            │   │   │ documento (VARCHAR)     │
│ remember_token      │   │   │ status (ENUM)           │
│ created_at          │   │   │ deleted_at (SOFT DEL)   │
│ updated_at          │   │   │ created_at              │
└─────────────────────┘   │   │ updated_at              │
                          │   └─────────────────────────┘
                          │
                          └──────────── 1:N ────────────────
```

### Tabela: `users`

| Coluna              | Tipo            | Descrição                      |
| ------------------- | --------------- | ------------------------------ |
| `id`                | BIGINT UNSIGNED | Chave primária auto-incremento |
| `name`              | VARCHAR(255)    | Nome completo do usuário       |
| `email`             | VARCHAR(255)    | E-mail único do usuário        |
| `email_verified_at` | TIMESTAMP       | Data de verificação do e-mail  |
| `password`          | VARCHAR(255)    | Senha criptografada (bcrypt)   |
| `remember_token`    | VARCHAR(100)    | Token "lembrar-me"             |
| `created_at`        | TIMESTAMP       | Data de criação                |
| `updated_at`        | TIMESTAMP       | Data de atualização            |

### Tabela: `transactions`

| Coluna       | Tipo            | Descrição                           |
| ------------ | --------------- | ----------------------------------- |
| `id`         | BIGINT UNSIGNED | Chave primária auto-incremento      |
| `user_id`    | BIGINT UNSIGNED | FK para users.id                    |
| `valor`      | DECIMAL(10,2)   | Valor monetário da transação        |
| `cpf`        | VARCHAR(11)     | CPF do titular (apenas números)     |
| `documento`  | VARCHAR(255)    | Caminho do arquivo anexado          |
| `status`     | ENUM            | 'processando', 'aprovada', 'negada' |
| `deleted_at` | TIMESTAMP       | Soft delete (null = ativo)          |
| `created_at` | TIMESTAMP       | Data de criação                     |
| `updated_at` | TIMESTAMP       | Data de atualização                 |

### Tabelas Auxiliares

| Tabela                   | Descrição                   |
| ------------------------ | --------------------------- |
| `password_reset_tokens`  | Tokens para reset de senha  |
| `sessions`               | Sessões ativas dos usuários |
| `cache`                  | Cache da aplicação          |
| `jobs`                   | Filas de processamento      |
| `personal_access_tokens` | Tokens de API (Sanctum)     |

---

## 🔧 Backend (API)

### Arquitetura

O backend segue o padrão **MVC (Model-View-Controller)** do Laravel com camadas adicionais:

```
Request → Route → Middleware → Controller → Policy → Model → Database
                                    ↓
                              Validation Rules
```

### Models

#### Transaction Model

```php
class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'valor', 'cpf', 'documento', 'status'];

    protected $casts = [
        'valor' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relacionamentos
    public function user() // belongsTo User

    // Accessors
    public function getValorFormatadoAttribute() // R$ 1.234,56
    public function getCpfFormatadoAttribute()   // 123.456.789-00
}
```

#### User Model

```php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    // Relacionamentos
    public function transactions() // hasMany Transaction
}
```

### Controller: TransactionController

| Método       | Descrição               | Tipo  |
| ------------ | ----------------------- | ----- |
| `indexWeb()` | Lista transações (view) | Web   |
| `create()`   | Formulário de criação   | Web   |
| `showWeb()`  | Detalhes da transação   | Web   |
| `edit()`     | Formulário de edição    | Web   |
| `index()`    | Lista transações (JSON) | API   |
| `store()`    | Criar transação         | Ambos |
| `show()`     | Detalhes (JSON)         | API   |
| `update()`   | Atualizar transação     | Ambos |
| `destroy()`  | Excluir transação       | Ambos |

### Validações

#### Transação

```php
[
    'valor' => 'required|numeric|min:0.01',
    'cpf' => ['required', 'digits:11', new ValidCpf],
    'status' => 'required|in:processando,aprovada,negada',
    'documento' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048'
]
```

#### Validação de CPF (ValidCpf Rule)

A regra `ValidCpf` implementa o algoritmo oficial da Receita Federal:

1. Remove caracteres não numéricos
2. Verifica se tem 11 dígitos
3. Rejeita CPFs com todos os dígitos iguais (111.111.111-11)
4. Calcula e valida o primeiro dígito verificador
5. Calcula e valida o segundo dígito verificador

### Políticas de Autorização (TransactionPolicy)

| Método      | Regra                               |
| ----------- | ----------------------------------- |
| `viewAny()` | Sempre permitido (lista própria)    |
| `view()`    | Apenas se `user_id == auth()->id()` |
| `create()`  | Sempre permitido                    |
| `update()`  | Apenas se `user_id == auth()->id()` |
| `delete()`  | Apenas se `user_id == auth()->id()` |
| `restore()` | Apenas se `user_id == auth()->id()` |

---

## 🎨 Frontend (Web)

### Design System

O frontend utiliza um design moderno e minimalista com:

-   **Cores Principais**:

    -   Sidebar: `#000000` (preto)
    -   Fundo: `#F3F4F6` (cinza claro)
    -   Cards: `#FFFFFF` (branco)
    -   Accent: `#F59E0B` (âmbar/dourado)
    -   Sucesso: `#10B981` (verde)
    -   Alerta: `#EF4444` (vermelho)
    -   Processando: `#F59E0B` (amarelo)

-   **Tipografia**: Inter (Google Fonts)
-   **Ícones**: Heroicons (SVG inline)
-   **Bordas**: Arredondadas (`rounded-xl`, `rounded-full`)
-   **Sombras**: Suaves (`shadow-sm`)

### Layout Administrativo

```
layouts/admin.blade.php
├── Sidebar (Fixo, Colapsável)
│   ├── Logo com gradiente
│   ├── Menu de navegação
│   │   ├── Transações (ícone moeda)
│   │   └── Perfil (ícone usuário)
│   └── Info do usuário + Logout
├── Header Mobile (Hamburger menu)
└── Main Content (@yield('content'))
```

### Views de Transações

#### Index (Listagem)

-   Estatísticas resumidas (Total, Aprovadas, Processando, Negadas)
-   Barra de busca com ícone integrado
-   Botão "Nova Transação"
-   Tabela responsiva com:
    -   ID, Valor, CPF formatado, Status (badge colorido), Data
    -   Ações: Visualizar, Editar, Excluir (aparecem no hover)
-   Estado vazio com ilustração

#### Create (Nova Transação)

-   Formulário em card branco
-   Campos: Valor, CPF (máscara), Status (select), Documento (drag & drop)
-   Preview de arquivo selecionado
-   Botões: Cancelar, Salvar

#### Edit (Editar Transação)

-   Similar ao Create
-   Exibe documento atual se existir
-   Opção de substituir documento
-   Botão de exclusão (modal de confirmação)

#### Show (Detalhes)

-   Visualização completa dos dados
-   Status com badge colorido
-   Preview de documento em modal
-   Botão de edição

### Componentes Alpine.js

```javascript
// Busca em tempo real na listagem
x-data="{ search: '' }"
x-show="item.includes(search)"

// Modal de documento
x-data="documentModal()"
@open-document-modal.window="openModal($event.detail)"

// Upload drag & drop
x-data="{ dragOver: false }"
@dragover.prevent="dragOver = true"
@drop.prevent="handleDrop($event)"
```

---

## 🔐 Autenticação e Segurança

### Autenticação Web (Sessão)

Utiliza **Laravel Breeze** com sessões baseadas em cookies:

| Rota                      | Método   | Descrição             |
| ------------------------- | -------- | --------------------- |
| `/register`               | GET/POST | Registro de usuário   |
| `/login`                  | GET/POST | Login                 |
| `/logout`                 | POST     | Logout                |
| `/forgot-password`        | GET/POST | Recuperação de senha  |
| `/reset-password/{token}` | GET/POST | Redefinir senha       |
| `/verify-email`           | GET      | Verificação de e-mail |

### Autenticação API (Sanctum)

Utiliza **Laravel Sanctum** com tokens:

```bash
# Login - Obter token
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}

# Resposta
{
    "token": "1|abc123...",
    "user": { ... }
}

# Usar token nas requisições
Authorization: Bearer 1|abc123...
```

### Proteções de Segurança

| Proteção          | Implementação                        |
| ----------------- | ------------------------------------ |
| **CSRF**          | Token em todos os formulários        |
| **XSS**           | Blade escapa output por padrão       |
| **SQL Injection** | Eloquent ORM com prepared statements |
| **Senhas**        | Hash bcrypt automático               |
| **Autorização**   | Policies verificam ownership         |
| **Upload**        | Validação de MIME type e tamanho     |
| **Rate Limiting** | Throttle em rotas sensíveis          |

---

## 🛤️ Rotas da Aplicação

### Rotas Web

| Método | URI                       | Controller | Nome                 |
| ------ | ------------------------- | ---------- | -------------------- |
| GET    | `/`                       | Closure    | -                    |
| GET    | `/dashboard`              | Redirect   | dashboard            |
| GET    | `/transactions`           | `indexWeb` | transactions.index   |
| GET    | `/transactions/create`    | `create`   | transactions.create  |
| POST   | `/transactions`           | `store`    | transactions.store   |
| GET    | `/transactions/{id}`      | `showWeb`  | transactions.show    |
| GET    | `/transactions/{id}/edit` | `edit`     | transactions.edit    |
| PUT    | `/transactions/{id}`      | `update`   | transactions.update  |
| DELETE | `/transactions/{id}`      | `destroy`  | transactions.destroy |
| GET    | `/profile`                | `edit`     | profile.edit         |
| PATCH  | `/profile`                | `update`   | profile.update       |
| DELETE | `/profile`                | `destroy`  | profile.destroy      |

### Rotas API

| Método | URI                      | Controller | Nome                     |
| ------ | ------------------------ | ---------- | ------------------------ |
| POST   | `/api/login`             | Closure    | -                        |
| GET    | `/api/user`              | Closure    | -                        |
| GET    | `/api/transactions`      | `index`    | api.transactions.index   |
| POST   | `/api/transactions`      | `store`    | api.transactions.store   |
| GET    | `/api/transactions/{id}` | `show`     | api.transactions.show    |
| PUT    | `/api/transactions/{id}` | `update`   | api.transactions.update  |
| DELETE | `/api/transactions/{id}` | `destroy`  | api.transactions.destroy |
| POST   | `/api/logout`            | Closure    | -                        |

---

## ✨ Funcionalidades

### Transações

-   ✅ **Listagem** com busca em tempo real
-   ✅ **Criação** com validação completa
-   ✅ **Visualização** detalhada
-   ✅ **Edição** com upload de documento
-   ✅ **Exclusão** com soft delete
-   ✅ **Upload de documentos** (PDF, JPG, PNG até 2MB)
-   ✅ **Validação de CPF** algoritmo oficial
-   ✅ **Status** (Processando, Aprovada, Negada)
-   ✅ **Formatação** automática de valores e CPF

### Perfil de Usuário

-   ✅ **Atualizar nome e e-mail**
-   ✅ **Alterar senha** (com validação da atual)
-   ✅ **Excluir conta** (com confirmação de senha)
-   ✅ **Verificação de e-mail**

### Interface

-   ✅ **Design responsivo** (mobile/tablet/desktop)
-   ✅ **Sidebar colapsável**
-   ✅ **Tema escuro** na sidebar
-   ✅ **Modais** para confirmações e visualizações
-   ✅ **Drag & Drop** para upload
-   ✅ **Mensagens de feedback** (sucesso/erro)
-   ✅ **Estados vazios** com ilustrações

---

## 🧪 Testes

### Executar Testes

```bash
# Todos os testes
php artisan test

# Com cobertura
php artisan test --coverage

# Testes específicos
php artisan test --filter=TransactionTest
```

### Estrutura de Testes

```
tests/
├── Feature/
│   ├── Auth/           # Testes de autenticação
│   ├── ExampleTest.php
│   └── ProfileTest.php # Testes de perfil
└── Unit/
    └── ExampleTest.php
```

---

## 📝 Comandos Úteis

```bash
# Desenvolvimento
composer dev                    # Inicia servidor + vite + logs + queue

# Cache
php artisan cache:clear         # Limpar cache
php artisan config:clear        # Limpar config cache
php artisan route:clear         # Limpar route cache
php artisan view:clear          # Limpar view cache

# Database
php artisan migrate             # Executar migrações
php artisan migrate:fresh       # Recriar banco
php artisan migrate:rollback    # Reverter última migração
php artisan db:seed             # Popular banco

# Manutenção
php artisan storage:link        # Criar link para storage
php artisan optimize            # Otimizar para produção

# Logs
php artisan pail                # Visualizar logs em tempo real
```

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 👤 Autor

Desenvolvido como projeto de gerenciamento de transações financeiras.

---

## 🤝 Contribuição

1. Fork o projeto
2. Crie sua branch (`git checkout -b feature/NovaFeature`)
3. Commit suas mudanças (`git commit -m 'Add: nova feature'`)
4. Push para a branch (`git push origin feature/NovaFeature`)
5. Abra um Pull Request
