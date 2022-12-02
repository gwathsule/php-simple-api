
# API simples com PHP

Esse é uma a API simples feita em PHP 8.1 sem a utilização de frameworks, apenas algumas bibliotecas afim de facilitar o desenvolvimento.

O sistema foi construído seguindo ~ou tentando~ a filosofia da Clean Architecture, procurando manter limites arquiteturais entre a regra de negócio e o resto do software.

A API tem por objetivo o cadastro de feiras em regiões metropolitanas;

## Stack utilizada

**Back-end:** PHP

**Servidor Web:** Nginx

**Banco de dados:** Sqlite

**Observabilidade:** Arquivos de texto .log gerados na pasta `storage/logs/`

## Rodando localmente

1. Clone o projeto para o seu diretório
```bash
  git clone git@github.com:gwathsule/php-simple-api.git
```
2. Entre no diretório do projeto
```bash
  cd php-simple-api
```
3. Faça uma cópia do arquivo `.env.example` chamado `.env`
```bash
  cp .env.example .env
```
4. Faça o build do container docker da aplicação 
```bash
  docker-compose up -d
```
5. Instale as dependências
```bash
  docker-compose exec -it app composer install
```
6. Associe a pasta storage ao usuário www-data 
```bash
  docker-compose exec -it app chown www-data:www-data -R /var/www/storage
```

Após essas etapas o sistema deverá estar rodando no endereço [http://localhost:8888](http://localhost:8888)

## Rodando os testes unitários
A aplicação foi construida seguindo ~ou tentando~ os conceitos de TDD, e para os testes unitários e de integração foi utilizado a bilbioteca `phpunit`.
Para rodar os testes localmente em sua máquina rode o comando abaixo:
```
  docker-compose exec -it app vendor/bin/phpunit  --testdox --coverage-html _reports/coverage/
```
Esse comando, além de rodar os testes presentes no software, cria um relatório sobre a cobertura dos testes presentes no sofwtare.
O relatórios fica disponível na pasta `_reports/coverage/index.html` ou neste [endereço](http://localhost:63342/php-simple-api/_reports/coverage/index.html).
## Documentação da API
A seguir abaixo está todas as rotas disponibilizada pela API, você também pode encontrar na pasta `docs` um arquivo JSON que é possivel exportar para o [cliente http Postman](https://www.postman.com/downloads/) uma _collection_ contendo todas as requests aqui explicadas.

### Criar nova feira
Esse endpoint cria uma nova feira
```JSONC
  //rota: POST /fair

  body:
  {
    "id": 1, // int | required
    "long": "-46550164", // string | required
    "lat": "-23558733", // string | required
    "setcens": "355030885000091", // string | required
    "areap": "3550308005040 ", // string | required
    "coddist": 87, // int | required
    "distrito": "VILA FORMOSA", // string | required
    "codsubpref": 26, // int | required
    "subprefe": "ARICANDUVA-FORMOSA-CARRAO", // string | required
    "regiao5": "Leste", // string | required
    "regiao8": "Leste 1", // string | required
    "nome_feira": "VILA FORMOSA", // string | required
    "registro": "4041-0 ", // string | required
    "logradouro": "RUA MARAGOJIPE", // string | required
    "numero": null, // string | nullable
    "bairro": "VL FORMOSA", // string | required
    "referencia": null // string | nullable
  }
```
Retornos
``` http
200 (OK): {... JSON com as informações do registro criado ...}
409 (Conflict): {"message": "The register id 211 is duplicated"}
400 (BAD request): {... JSON informando erros de validação na request ...}
500 (Internal Server Error): {"message":"Internal server error."}
```
------
### Buscar feiras
Endpoint que filtra as feiras, os parâmetros devem ser passados via _query params_, isto é, na url da requisição. Os filtros que estão disponíveis são: `distrito`; `regiao5`; `nome_feira`; `bairro`. É possível combinar 1 ou mais parametros na busca. 
```JSONC
  //rota: GET /fair?distrito=123&regiao5=25&nome_feira=test&bairro=testing
```
Retornos
``` JSONC
200 (Sucesso)[... JSON com os registros que se encaixa no filtro ...]
500 (Internal Server Error): {"message":"Internal server error."}
```
------
### Deletar feira
Recebe um id para ser deletado da base de dados
```JSONC
  //rota: DELETE /fair/{fairId} 
```
Retornos
``` JSONC
200 (Sucesso)[... JSON com os registros que se encaixa no filtro ...]
404 (Not found) {"message":"Item not found"}
500 (Internal Server Error): {"message":"Internal server error."}
```
------
### Atualizar feira
Recebe o ID de uma feira e novos dados para atualizar uma feira existente no BD
```JSONC
  //rota: PUT /fair/{fairId}

  body:
    {
    "long": "-46550164", // string 
    "lat": "-23558733", // string 
    "setcens": "355030885000091", // string 
    "areap": "3550308005040 ", // string 
    "coddist": 87, // int 
    "distrito": "VILA FORMOSA", // string 
    "codsubpref": 26, // int 
    "subprefe": "ARICANDUVA-FORMOSA-CARRAO", // string 
    "regiao5": "Leste", // string 
    "regiao8": "Leste 1", // string 
    "nome_feira": "VILA FORMOSA", // string 
    "registro": "4041-0 ", // string 
    "logradouro": "RUA MARAGOJIPE", // string 
    "numero": null, // string | nullable
    "bairro": "VL FORMOSA", // string 
    "referencia": null // string | nullable
   }
```
Retornos
``` JSONC
200 (OK): {... JSON com as informações do registro criado ...}
404 (Not found) {"message":"Item not found"}
400 (BAD request): {... JSON informando erros de validação na request ...}
500 (Internal Server Error): {"message":"Internal server error."}
```
-----
### Importar feiras em lote
Faz a importação de um arquivo CSV contendo a informações de 1 ou mais feiras para base de dados. O padrão do arquivo segue o exemplo do arquivo existente no caminho `storage/stubs/example.csv`. O arquivo deve ser passado via _form-data_ para o endpoint, num campo chamado `csv_file`.
```JSONC
  //rota: POST /fair/import

  --form-data:
  csv_file

```
Retornos
``` JSONC
200(OK):
{
    "created": 4, # quantidade de novos registro criados
    "duplicatedIds": [245, 246], # lista de IDs duplicados encontrados
    "linesWithErrors": [5, 7, 10, 11] # Lista de linhas do arquivo em que houve erro ao tentar salvar
}
400 (BAD request): {... JSON informando erros de validação na request ...}
500 (Internal Server Error): {"message":"Internal server error."}
```
