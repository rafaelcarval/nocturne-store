
# Nocturne Store

**Nocturne Store** é uma aplicação Laravel baseada em uma arquitetura modular com suporte a Docker para facilitar a implantação. Este projeto inclui serviços configurados com Nginx, PHP e Laravel.
Ambiente completo para a estrutura de uma loja e sua dependências e fluxos, desde a apresentação de produtos, cupons e finalização de uma compra

---

## 📑 Índice
1. [Arquitetura do Projeto](#arquitetura-do-projeto)
2. [Configuração do Ambiente](#configuração-do-ambiente)
   - [Pré-requisitos](#1-pré-requisitos)
   - [Clonar o Repositório](#2-clonar-o-repositório)
   - [Iniciar os Contêineres com Docker](#3-iniciar-os-contêineres-com-docker)
   - [Configurar o Laravel](#4-configurar-o-laravel)
   - [Configurar Permissões](#5-configurar-permissões)   
   - [Instalar Dependências do Front-End](#6-instalar-dependências-do-front-end)
   - [Acessar a Aplicação](#7-acessar-a-aplicação)
3. [Arquivo .env](#📁-arquivo-env)
4. [Detalhes do docker-compose.yml](#📦-detalhes-do-docker-composeyml)
5. [Contribuições](#🎉-contribuições)
6. [Licença](#📜-licença)

---

## 🌟 **Arquitetura do Projeto**

O projeto está dividido nos seguintes diretórios principais:

- **`laravel`**: Contém o código-fonte da aplicação Laravel.
- **`nginx`**: Configurações do servidor web Nginx.
- **`php`**: Configurações específicas do ambiente PHP.
- **`docker-compose.yml`**: Orquestra os serviços usando Docker Compose.

---

## 🚀 **Configuração do Ambiente**

### **1. Pré-requisitos**
Certifique-se de ter as ferramentas abaixo instaladas:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Node.js](https://nodejs.org/) (se desejar rodar o front-end localmente)

---

### **2. Clonar o Repositório**
```bash
git clone https://github.com/seuusuario/nocturne-store.git
cd nocturne-store
```
---

### **3. Iniciar os Contêineres com Docker**
Use o Docker Compose para construir e iniciar os serviços:

```bash
docker compose up -d --build
```

Este comando irá:
- Criar e iniciar os contêineres de Laravel, PHP e Nginx.
- Configurar as redes e volumes necessários.

> **Nota:** Caso precise parar os contêineres sem removê-los, use:
> ```bash
> docker stop $(docker ps -q)
> ```

---

### **4. Configurar o Laravel**
Após clonar o repositório, copie o arquivo `.env.example` para `.env`:

```bash
cd laravel
cp .env.example .env
```

Depois, acesse o contêiner do PHP para executar os comandos necessários:

Para acessar o contêiner
```bash
docker exec -it nocturne_php bash
```
Agora, dentro do contêiner, execute:
```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
exit
```

> **Nota:** Certifique-se de configurar as variáveis de ambiente no arquivo `.env`, como o banco de dados e credenciais.

---

### **5. Configurar Permissões**
Garanta que o Laravel tenha as permissões corretas para os diretórios `storage` e `bootstrap/cache`:

Para acessar o contêiner
```bash
docker exec -it nocturne_php bash
```
Agora, dentro do contêiner, execute:
```bash
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage
exit
```

---

### **6. Instalar Dependências do Front-End**
Entre na pasta Laravel para instalar as dependências do front-end e compilar os arquivos:

```bash
cd laravel
npm install
npm run dev
```

> **Nota:** Se estiver usando o ambiente de produção, substitua `npm run dev` por:
> ```bash
> npm run build
> ```

---

### **7. Acessar a Aplicação**
A aplicação estará disponível no navegador em:

```bash
http://localhost:8080
```

---

## **📁 Arquivo `.env`**
Certifique-se de configurar o arquivo `.env` na raiz do diretório `laravel`. Este arquivo contém variáveis de ambiente necessárias para a aplicação. Aqui está um exemplo das configurações essenciais:

```env
DB_CONNECTION=mysql
DB_HOST=nocturne_mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### Explicação:
- **`DB_CONNECTION`**: Define o tipo de banco de dados utilizado (MySQL neste caso).
- **`DB_HOST`**: Nome do serviço definido no `docker-compose.yml` (aqui, `nocturne_mysql`).
- **`DB_PORT`**: Porta interna do MySQL (3306).
- **`DB_DATABASE`**: Nome do banco de dados usado pela aplicação Laravel (predefinido como `laravel` no `docker-compose.yml`).
- **`DB_USERNAME`**: Nome de usuário do banco de dados configurado no `docker-compose.yml` (predefinido como `laravel`).
- **`DB_PASSWORD`**: Senha do usuário do banco de dados (predefinida como `secret`).

---

## **📦 Detalhes do `docker-compose.yml`**

O `docker-compose.yml` está estruturado para configurar três serviços principais: **PHP (Laravel App)**, **Nginx (Webserver)** e **MySQL**. Aqui está uma explicação detalhada:

### **1. Serviço: nocturne_app**
Este serviço contém o ambiente PHP necessário para rodar a aplicação Laravel.

```yaml
  nocturne_app:
    build:
      context: ./php
    container_name: nocturne_php
    volumes:
      - ./laravel:/var/www/html
    networks:
      - nocturne_network
    environment:
      - PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
```

### **2. Serviço: nocturne_webserver**
Este serviço configura o servidor Nginx para servir a aplicação Laravel.

```yaml
  nocturne_webserver:
    image: nginx:latest
    container_name: nocturne_webserver
    ports:
      - "8080:80"
    volumes:
      - ./nginx:/etc/nginx/conf.d
      - ./laravel:/var/www/html
    depends_on:
      - nocturne_app
    networks:
      - nocturne_network
```

### **3. Serviço: nocturne_mysql**
Este serviço configura o banco de dados MySQL para a aplicação Laravel.

```yaml
  nocturne_mysql:
    image: mysql:8.0
    container_name: nocturne_mysql
    ports:
      - "3608:3306"
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: laravel
      MYSQL_USER: laravel
      MYSQL_PASSWORD: secret
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - nocturne_network
```

# Comandos Básicos do Git

## 1. Configuração Inicial
Configure o Git no seu sistema:
```bash
git config --global user.name "Seu Nome"
git config --global user.email "seuemail@exemplo.com"
```

Verifique as configurações atuais:
```bash
git config --list
```

---

## 2. Criar ou Clonar um Repositório
### Criar um novo repositório:
```bash
git init
```

### Clonar um repositório existente:
```bash
git clone <URL_DO_REPOSITORIO>
```

Exemplo:
```bash
git clone https://github.com/rafaelcarval/nocturne-store.git
```

---

## 3. Verificar o Status e Histórico
### Verificar o status do repositório:
```bash
git status
```

### Exibir o histórico de commits:
```bash
git log
```

Para um histórico resumido:
```bash
git log --oneline
```

---

## 4. Trabalhar com Arquivos
### Adicionar arquivos ao staging (preparar para commit):
```bash
git add <arquivo>
```

Para adicionar todos os arquivos:
```bash
git add .
```

### Fazer um commit:
```bash
git commit -m "Mensagem do commit"
```

---

## 5. Trabalhar com Remotes (Repositórios Remotos)
### Adicionar um repositório remoto:
```bash
git remote add origin <URL_DO_REPOSITORIO>
```

### Verificar os repositórios remotos:
```bash
git remote -v
```

---

## 6. Enviar e Receber Alterações
### Enviar commits para o repositório remoto:
```bash
git push origin <nome_da_branch>
```

Para enviar a branch principal (geralmente `main`):
```bash
git push origin main
```

### Baixar alterações do repositório remoto:
```bash
git pull origin <nome_da_branch>
```

---

## 7. Branches
### Listar branches:
```bash
git branch
```

### Criar uma nova branch:
```bash
git branch <nome_da_branch>
```

### Trocar para outra branch:
```bash
git checkout <nome_da_branch>
```

### Criar e trocar para a nova branch:
```bash
git checkout -b <nome_da_branch>
```

### Mesclar uma branch à branch atual:
```bash
git merge <nome_da_branch>
```

---

## 8. Resolver Conflitos
Se houver conflitos ao mesclar ou ao fazer pull:
1. Edite os arquivos com conflitos.
2. Após resolver, adicione as alterações:
   ```bash
   git add <arquivo>
   ```
3. Finalize o commit:
   ```bash
   git commit
   ```

---

## 9. Desfazer Alterações
### Reverter alterações de um arquivo (antes de commitar):
```bash
git checkout -- <arquivo>
```

### Desfazer um commit local (mantendo as alterações):
```bash
git reset --soft HEAD~1
```

### Desfazer um commit local (removendo as alterações):
```bash
git reset --hard HEAD~1
```

---

## 10. Excluir e Limpar
### Remover um arquivo do repositório (mas mantê-lo localmente):
```bash
git rm --cached <arquivo>
```

### Limpar arquivos não rastreados:
```bash
git clean -f
```

---


---

## 🎉 **Contribuições**
Contribuições são bem-vindas! Sinta-se à vontade para enviar um pull request.

---

## 📜 **Licença**
Este projeto está licenciado sob a [MIT License](LICENSE).

---

**Divirta-se construindo com Nocturne Store!** 🚀
