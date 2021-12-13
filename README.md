<h3 align="center">Payments API</h3>

<p align="center">
   API Rest baseada em uma simulação de carteira digital para realização de transações financeiras entre usuários.
</p>

## :pushpin: Sobre

Esse projeto compreende um sistema de pagamentos entre usuários que podem ser do tipo pessoa física (0) ou pessoa jurídica (1). Cada usuário possui uma carteira que é criada no momento em que o usuário é registrado no banco, via seeder. Além disso, é possível realizar transações desde que sejam atendidas as seguintes condições:

- Apenas usuários do tipo pessoa física (0) podem realizar transferências;
- É necessário checar o saldo da carteira para habilitar a transação;
- Uma vez validado o saldo, é necessário obter a confirmação de um serviço externo para aprovação da transação;
- As transações podem ser revertidas em caso de inconsistência.

## :pushpin: Tecnologias
- PHP 7.4
- Laravel 8
- Docker

## :pushpin: Documentação
A documentação da API foi construída através da ferramenta Swagger e o deploy do ambiente de testes foi feito no Heroku.
Acesse a documentação <b><a href="http://payments-api-challenge.herokuapp.com/api/docs">aqui</a></b>.<br>
Obs: é necessário acessar via http devido a uma <a href="https://github.com/DarkaOnLine/L5-Swagger/issues/320">issue</a> do L5-swagger.

## :pushpin: Modelagem do problema
### Gráfico de fluxo

Para o design da solução da transação, foi feito um gráfico de fluxo:

<p align="center"><img width="100%" src="https://raw.githubusercontent.com/4ngelica/payments-api/master/public/docs/Flow.png?token=ALNOMQLSOFLIZUVYUGPFYWDBYDBUM"></p>

### Modelagem de Dados

As três entidades relacionais definidas são Carteira (Wallet), Usuário (User) e Transação (Transaction). Usuário e carteira apresentam uma relação de 1:1 e usuário/transação apresentam uma relação de 1:N. Quando um novo registro de usuário é gerado via seeder, uma carteira é associada a esse usuário, carregando como chave estrangeira a user_id.

<p align="center"><img width="80%" src="https://raw.githubusercontent.com/4ngelica/payments-api/master/public/docs/db.PNG?token=ALNOMQLOMJE4OPCQ44VSFW3BYDBXQ"></p>

## :pushpin: Instalação

## :pushpin: Escolha da stack

Foi utilizado o framework Laravel por ter uma vasta gama de funcionalidades built-in para APIS. Ele também deixa o projeto organizado em relação ao MVC e trás recursos para tratamento de excessões.

Também seria interessante utilizar o Lumen (um micro framework do Laravel), visto que deixaria o projeto mais enxuto, trazendo apenas as dependências necessárias para a criação da API.

Como desafio, foi utilizado o Docker. Foram criados os serviços php, db e nginx para rodar a aplicação isoladamente.

## :pushpin: Possíveis melhorias


## :pushpin: Referências
- [Laravel 8](https://laravel.com/docs/8.x)
- [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger/wiki)
- [Swagger](https://swagger.io/docs/)
- [EspecializaTI](https://github.com/especializati/setup-docker-laravel)
- [Docker](https://docs.docker.com/)
