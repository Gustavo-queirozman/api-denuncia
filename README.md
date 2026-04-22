# API Denúncia

API REST desenvolvida para gerenciamento de denúncias, com autenticação de usuários, cadastro e consulta de denúncias, upload de anexos e organização em arquitetura em camadas.

## Visão geral

O projeto foi construído com foco em uma aplicação monolítica bem estruturada, utilizando **Laravel 10** e **PHP 8.1**, com separação por responsabilidades e organização orientada ao domínio.

A aplicação permite:

- autenticação de usuários
- criação, listagem, edição e visualização de denúncias
- criação e listagem de respostas
- gerenciamento de usuários
- upload de anexos vinculados às denúncias
- documentação da API com Swagger

## Arquitetura

Este projeto segue uma estrutura com:

- **API REST**
- **Arquitetura em camadas**
- **Monólito modular**
- **Organização inspirada em DDD**

A ideia é manter o código mais coeso, legível e fácil de evoluir, separando responsabilidades entre controllers, requests, models e regras da aplicação.

## Tecnologias utilizadas

- **PHP 8.1**
- **Laravel 10**
- **MySQL**
- **Redis**
- **Laravel Passport**
- **Laravel Telescope**
- **L5 Swagger**
- **Predis**
- **Spatie Laravel Permission**
- **Laravel Actions**

## Funcionalidades principais

### Autenticação
- login de usuários com geração de token de acesso
- recuperação e redefinição de senha

### Módulo de denúncias
- criação de denúncias
- geração de protocolo
- upload de anexos
- listagem e visualização de denúncias
- edição de registros

### Módulo de respostas
- criação de respostas relacionadas às denúncias
- listagem de respostas

### Módulo de usuários
- cadastro de usuários
- edição
- exclusão
- listagem e visualização

## Estrutura do projeto

Uma visão geral da organização:

```bash
app/
 ├── Http/
 │   ├── Controllers/
 │   │   ├── AuthController.php
 │   │   ├── Denuncia/
 │   │   ├── Resposta/
 │   │   └── Usuario/
 │   └── Requests/
 ├── Models/
 │   ├── Denuncia.php
 │   └── User.php
routes/
 └── api.php
