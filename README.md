# Desafio onfly
Você precisa desenvolver um microsserviço em Laravel para gerenciar pedidos de viagem corporativa. O microsserviço deve expor uma API REST para as seguintes operações:
Criar um pedido de viagem: Um pedido deve incluir o ID do pedido, o nome do solicitante, o destino, a data de ida, a data de volta e o status (solicitado, aprovado, cancelado).
Atualizar o status de um pedido de viagem: Possibilitar a atualização do status para "aprovado" ou "cancelado". (nota: o usuário que fez o pedido não pode alterar o status do mesmo)
Consultar um pedido de viagem: Retornar as informações detalhadas de um pedido de viagem com base no ID fornecido.
Listar todos os pedidos de viagem: Retornar todos os pedidos de viagem cadastrados, com a opção de filtrar por status.
Cancelar pedido de viagem após aprovação: Implementar uma lógica de negócios que verifique se é possível cancelar um pedido já aprovado 
Filtragem por período e destino: Adicionar filtros para listar pedidos de viagem por período de tempo (ex: pedidos feitos ou com datas de viagem dentro de uma faixa de datas) e/ou por destino.
Notificação de aprovação ou cancelamento: Sempre que um pedido for aprovado ou cancelado, uma notificação deve ser enviada para o usuário que solicitou o pedido.

### Requisitos Técnicos
Utilize o framework Laravel (versão mais recente possível).
A API deve seguir as boas práticas de arquitetura de microsserviços.
Utilize um banco de dados relacional (MySQL) e forneça uma migração para a estrutura das tabelas necessárias.
Implemente validação de dados no backend e tratamento de erros apropriado.
Escreva testes automatizados (preferencialmente com PHPUnit) para as principais funcionalidades.
Utilize Docker para facilitar a execução do serviço. A aplicação deve poder ser executada via Docker.
Implemente autenticação simples usando tokens (como JWT) para proteger a API.
Crie um relacionamento entre as ordens de viagem e o usuário autenticado e faça com que cada usuário possa ver, editar e cadastrar apenas as suas próprias ordens.

### Como entregar
Suba o projeto em um repositório público no GitHub e compartilhe o link com nosso time (envie para este e-mail mesmo).
No repositório, inclua um README.md com as instruções para:
Instalar as dependências.
Executar o serviço localmente (usando Docker).
Configurar o ambiente (variáveis de ambiente, banco de dados, etc.).
Executar os testes.
Qualquer informação adicional que você considere relevante.

###  Critérios de Avaliação
Organização e Qualidade do Código: Como você estrutura e organiza seu código, aplicando boas práticas de desenvolvimento.
Uso de Boas Práticas do Laravel: Queremos ver como você utiliza os recursos do framework, como Eloquent, Middlewares, Requests e Resources.
Eficiência da Solução: Avaliação da performance geral e da eficiência da sua solução.
Testes e Confiabilidade: Como você garante a confiabilidade da aplicação com testes automatizados.
Documentação: A clareza das instruções fornecidas no README.md para configurar e executar o projeto.

Estamos ansiosos para conhecer sua solução! Caso tenha qualquer dúvida ou precise de algum suporte durante a execução do desafio, sinta-se à vontade para entrar em contato.







# Setup Docker Laravel 11 com PHP 8.3
[Assine a Academy, e Seja VIP!](https://academy.especializati.com.br)

### Passo a passo
Clone Repositório
```sh
git clone -b laravel-11-with-php-8.3 https://github.com/especializati/setup-docker-laravel.git app-laravel
```
```sh
cd app-laravel
```

Suba os containers do projeto
```sh
docker-compose up -d
```


Crie o Arquivo .env
```sh
cp .env.example .env
```

Acesse o container app
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

OPCIONAL: Gere o banco SQLite (caso não use o banco MySQL)
```sh
touch database/database.sqlite
```

Rodar as migrations
```sh
php artisan migrate
```

Acesse o projeto
[http://localhost:8000](http://localhost:8000)
