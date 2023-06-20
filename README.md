<h4 align="center">
  🚀 Perfect Pay - Checkout de Pedidos - Desafio técnico
</h4>

<p align="center">
 <img src="https://img.shields.io/static/v1?label=PRs&message=welcome&color=7159c1&labelColor=000000" alt="PRs welcome!" />

  <img alt="License" src="https://img.shields.io/static/v1?label=license&message=MIT&color=7159c1&labelColor=000000">
</p>

<p align="center">
  <a href="#rocket-tecnologias">Tecnologias</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#-projeto">Projeto</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#-funcionalidades">Funcionalidades</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#-requisitos">Requisitos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#-instalação">Instalação</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
</p>

<br>

## :rocket: Tecnologias

Esse projeto foi desenvolvido com as seguintes tecnologias:

- [PHP 8.2](https://php.net)
- [Laravel 10](https://laravel.com)
- [MySQL](https://mysql.com)
- [Docker](https://docker.com)


## 💻 Projeto

Esse projeto é uma página de checkout para pagamento de pedidos feitos em Boleto, Cartão de Crédito ou PIX desenvolvida como teste técnico para o processo seletivo de Desenvolvedor PHP Sênior na Perfect Pay.


## 💻 Funcionalidades

O sistema possui página de checkout, processamento de pagamento e página de obrigado:

- Página de checkout para as informações de compra do cliente e dados de pagamento.
- Processamento do pagamento por Boleto, Cartão de Crédito e PIX usando integrações com a API do Asaas 
- Caso o processamento do pagamento ocorra com sucesso, página de Obrigado contendo o link para pagamento em boleto ou o QR Code para pagamento por PIX conforme tipo de pagamento selecionado.
- Caso ocorra falha no processamento do pagamento, página de erro amigável.
- O sistema também salva osd dados do cliente, pagamento processado e endereço(tanto do cliente como endereço informado para pagamento/pedido).

## 📄 Requisitos

* PHP 8.2+, Laravel 10+, MySQL 5.7 e Docker


## ⚙️ Instalação e execução

**Windows, OS X & Linux:**

Baixe o arquivo zip e o descompacte ou baixe o projeto para sua máquina através do git clone [https://github.com/randercarlos/perfect-pay.git](https://github.com/randercarlos/perfect-pay.git)


- Entre no prompt de comando e vá até a pasta do projeto:

```sh
cd ir-ate-a-pasta-do-projeto
```

- Crie o arquivo .env a partir do arquivo .env.example. As variáveis de ambiente relacionadas ao banco já estão configuradas.

```sh
copy .env.example .env
```

- Assumindo que tenha o docker instalado na máquina, para subir os containeres, execute o comando:

```sh
docker-compose up -d
```

- Após isso, execute o comando abaixo para instalar as dependências do laravel.

```sh
docker-compose exec perfect-pay-app composer install
``` 

- Depois de instalar as dependencias, crie as tabelas rodando o comando abaixo:

```sh
docker-compose exec perfect-pay-app php artisan migrate
``` 

- Após rodar o comando acima, basta acessar o endereço [http://localhost:8000/checkout](http://localhost:8000/checkout) para acessar a página de checkout.

## 📝 Documentação

- *Primeiramente*, para o sistema funcionar, é necessário ter uma API KEY para o ambiente de homologação(sandbox) do Asaas. 
- Caso tenha conta, Acesse o site do asaas em https://sandbox.asaas.com/. Caso não tenha, crie uma conta primeiro lá. Depois, vá em Configuração de Conta->Integrações e gere o *API Key*.
- Após isso, vá no arquivo *.env* e coloque-a na chave *ASAAS_API_KEY* entre aspas simples para não dar erro. Pronto, o sistema está configurado. 
- Ao acessar a página de checkout, preencher os dados conforme solicitados na tela.
- Para o CPF, o sistema verifica se o mesmo é válido. Usar o site *https://www.geradordecpf.org/* para gerar um CPF válido ou um outro site qualquer.
- Caso selecione a opção de pagamento em Cartão de Crédito, o sistema verifica se os dados do cartão são válidos. Usar o site *https://www.duplichecker.com/pt/credit-card-generator.php* para gerar dados válidos de cartão de crédito ou outro site qualquer.
- Ao processar pagamentos por boleto, é exibido o link para pagamento do mesmo. Se o pagamento for por PIX, é exibido o QR Code e o link copia e cola.
- O sistema salva os dados do cliente, do pagamento e endereço. Caso o pagamento tenha sido feito por cartão de crédito, os dados do cartão não são armazenados por motivos de segurança.
- As credenciais de acesso ao banco de dados para verificação dos dados salvos são:

```sh
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3307
DB_DATABASE=perfect-pay
DB_USERNAME=perfect
DB_PASSWORD=pay
```


Desenvolvido por Rander Carlos :wave: [Linkedin!](https://www.linkedin.com/in/rander-carlos-308a63a8//)
