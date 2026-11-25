# Vortex Recrutamento

Sistema web de recrutamento desenvolvido para o desafio técnico de Desenvolvedor Back-end da Vortex Educação.

A aplicação permite gerenciar vagas de emprego, cadastrar candidatos e controlar inscrições em oportunidades disponíveis.

## Tecnologias utilizadas

- PHP
- Laravel 12
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap 5
- Blade
- PHPUnit
- Docker e Docker Compose
- Git

## Funcionalidades

### Gerenciamento de vagas

- Cadastro, edição, listagem e exclusão de vagas.
- Tipos de contratação: CLT, Pessoa Jurídica e Freelancer.
- Pausa e reativação de vagas.
- Filtragem por todos os campos.
- Paginação de 20 registros por página.
- Validação dos dados informados.

### Gerenciamento de candidatos

- Cadastro, edição, listagem e exclusão de candidatos.
- Validação dos campos obrigatórios.
- Controle de duplicidade de CPF e e-mail.
- Filtragem por todos os campos.
- Paginação de 20 registros por página.

### Inscrições

- Inscrição de candidatos em múltiplas vagas.
- Bloqueio de inscrições em vagas pausadas.
- Prevenção de inscrições duplicadas.
- Listagem e cancelamento de inscrições.
- Remoção automática de inscrições relacionadas quando uma vaga ou candidato é excluído.

## Executando o projeto com Docker

### Pré-requisitos

- Git
- Docker
- Docker Compose

Clone o repositório:

```bash
git clone https://github.com/ZpexLaKip/vortex-recrutamento.git
cd vortex-recrutamento
```

Construa as imagens e inicie os containers:

```bash
docker compose up -d --build
```

As migrations são executadas automaticamente durante a inicialização da aplicação.

Para popular o banco de dados com registros fictícios:

```bash
docker compose exec app php artisan db:seed
```

Acesse a aplicação no navegador:

http://localhost:8001

Para interromper os containers:

```bash
docker compose down
```

Os dados do MySQL são preservados em um volume Docker.

## Executando localmente sem Docker

### Pré-requisitos

- PHP 8.3 ou compatível com as dependências do projeto.
- Composer
- MySQL
- Git

Clone o repositório:

```bash
git clone https://github.com/ZpexLaKip/vortex-recrutamento.git
cd vortex-recrutamento
```

Instale as dependências:

```bash
composer install
```

Crie o arquivo de configuração do ambiente:

```bash
cp .env.example .env
```

No Windows PowerShell, utilize:

```powershell
Copy-Item .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Crie um banco de dados MySQL:

```sql
CREATE DATABASE vortex_recrutamento;
```

Configure as credenciais do banco no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vortex_recrutamento
DB_USERNAME=root
DB_PASSWORD=
```

Ajuste o usuário e a senha conforme seu ambiente MySQL.

Execute as migrations e os seeders:

```bash
php artisan migrate --seed
```

Inicie o servidor:

```bash
php artisan serve
```

Acesse:

http://127.0.0.1:8000

## Banco de dados

O banco de dados é estruturado por meio das migrations do Laravel e possui três tabelas principais:

| Tabela | Responsabilidade |
|---|---|
| vagas | Armazenar oportunidades de emprego |
| candidatos | Armazenar os dados dos candidatos |
| inscricoes | Relacionar candidatos e vagas |

O relacionamento entre candidatos e vagas é do tipo muitos-para-muitos (N:N).

Foram utilizadas chaves estrangeiras, restrições de unicidade e exclusão em cascata para garantir a integridade dos dados.

## Factories e Seeders

O projeto utiliza factories para gerar registros fictícios e seeders para popular o banco de dados.

Cada execução do seeder gera:

- 25 vagas ativas.
- 5 vagas pausadas.
- 25 candidatos.
- 50 inscrições em vagas ativas.

O seeder acrescenta registros ao banco de dados existente.

## Testes automatizados

Foram implementados testes unitários e funcionais utilizando PHPUnit.

Os testes verificam:

- Cadastro, edição, listagem e exclusão de vagas.
- Cadastro, edição, listagem e exclusão de candidatos.
- Validação de campos obrigatórios.
- Prevenção de cadastros duplicados.
- Filtragem e paginação.
- Pausa e reativação de vagas.
- Inscrições em múltiplas vagas.
- Bloqueio de inscrições duplicadas.
- Bloqueio de inscrições em vagas pausadas.
- Cancelamento de inscrições.
- Integridade dos relacionamentos.

Para executar os testes localmente:

```bash
php artisan test
```

Para executar os testes com Docker:

```bash
docker compose exec app php artisan test
```

Os testes utilizam SQLite em memória para não interferir nos dados do MySQL.

### Resultado da execução

- 26 testes aprovados.
- 78 asserções verificadas.

## Arquitetura do projeto

A aplicação utiliza o padrão MVC (Model-View-Controller), seguindo a estrutura do Laravel.

```text
app/
    Http/
        Controllers/
        Requests/
    Models/
database/
    factories/
    migrations/
    seeders/
resources/
    views/
routes/
tests/
    Feature/
    Unit/
```

Os Models são responsáveis pela representação dos dados e seus relacionamentos. Os Controllers gerenciam as requisições e operações da aplicação. Os Form Requests centralizam as validações, enquanto as Views são responsáveis pela apresentação da interface.

## Considerações

O projeto foi desenvolvido com foco na organização do código, separação de responsabilidades, integridade dos dados e facilidade de execução.

A configuração Docker é destinada ao ambiente de desenvolvimento e avaliação local. A aplicação não depende de compilação de assets com Node.js, utilizando Bootstrap via CDN para estilização da interface.

---

Projeto desenvolvido para o desafio técnico da Vortex Educação.