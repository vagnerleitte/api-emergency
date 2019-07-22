
# ApiEmergency

Api Rest desenvolvida em laravel

# Ambiente

- Mysql 5.7
- PHP 7.1>
- Composer

# Como implantar

- Ao clonar o projeto acesse a pasta e execute o comando composer install
- Ao finalizar a instalação execute cp .env.example .env
- Abra o .env coloque as informações do banco de dados
- Execute o comando php artisan key:generate
- Execute o comando php artisan migrate --seed
- Execute o comando php artisan passport:install, esse comando irá gerar os dados do cliente rest, salve essas informaçoes para conectar.

# Executar o server

- Execute na raiz do projeto o comando php artisan serve, caso queira liberar pelo ip na rede execute o comando php artisan serve --host=ipdamaquina

# EndPoints

- 1 :  POST localhost:8000/oauth/token
    ```
     {
      	"client_id":2,
      	"client_secret":"NRCx71HwSJ0VCNCgRkw8wVI73vSmCwyWEIsb0qLG",
      	"grant_type":"password",
      	"username":"leivitoncs@gmail.com",
      	"password":"123456"
     }
    ```
  
- 2 : POST localhost:8000/api/v1/admin/user
    ```
    {
    	"name":"Leiviton Carlos",
    	"email":"leivitonpj@gmail.com",
    	"password":"123456",
    	"cpf":"11122233344",
    	"role":"solicitante"
    }
    ```
- 3 : GET localhost:8000/api/v1/admin/user?status=ativo
    ```
    {
      "data": [
        {
          "id": 1,
          "name": "Leiviton Carlos",
          "email": "leivitoncs@gmail.com",
          "role": "admin",
          "cpf": "08967095660",
          "status": "ativo",
          "created_at": "2019-07-22T16:01:09.000000Z",
          "updated_at": "2019-07-22T16:01:09.000000Z"
        },
        {
          "id": 3,
          "name": "Leiviton Carlos",
          "email": "leivitonpj@gmail.com",
          "role": "solicitante",
          "cpf": "11122233344",
          "status": "ativo",
          "created_at": "2019-07-22T16:18:32.000000Z",
          "updated_at": "2019-07-22T16:18:32.000000Z"
        },
        {
          "id": 2,
          "name": "Vagner Silva",
          "email": "vagnerleitte@outlook.com",
          "role": "admin",
          "cpf": "08967095661",
          "status": "ativo",
          "created_at": "2019-07-22T16:01:09.000000Z",
          "updated_at": "2019-07-22T16:01:09.000000Z"
        }
      ],
      "meta": {
        "pagination": {
          "total": 3,
          "count": 3,
          "per_page": 15,
          "current_page": 1,
          "total_pages": 1,
          "links": []
        }
      }
    }
    ```