# Integrantes:
* Charles Muller
* Tainá Schaeffer
* Kevilin Rodrigues
* Gonzalo Munoz
* Rafael Trapp
* Rodrigo Paris



# Api Bcb
Projeto para fim acadêmico, utiliza a API do banco central (https://dadosabertos.bcb.gov.br/dataset) para consulta de Indices e calculo de ajuste de preços

<img src="diagramaDeClasses-1.png">


## Mapear no hosts:
127.0.0.1 api.apibcb.local mysql.apibcb.local

## .env
versionado dado que este projeto é destinado a estudos

## Iniciando aplicação
docker-compose up -d

## Acessando
api.apibcb.local/api

## Endpoints

* Consulta por meses:
http://api.apibcb.local/api/getIndiceMeses/igpm?meses=6

* Calculo de preço de ajuste:
http://api.apibcb.local/api/ajusteDePrecoPeriodo/igpm/230/?de=28/01/2023&ate=28/03/2023


#
# Endpoints

# EndPoint 1: 
Consulta de histórico do indice de IGPM ou IPCA dos últimmos X meses

### Descrição:
Como usuário, quero poder consultar o histórico dos índices de IGPM e IPCA dos últimos meses, através de um Endpoint de API, para obter informações econômicas relevantes.

### Pré-condições:
- A funcionalidade depende do consumo de dados da API do Banco Central, que está disponível em [dadosabertos.bcb.gov.br](https://dadosabertos.bcb.gov.br/dataset).

### Ações do Usuário:
O usuário deve realizar uma solicitação GET para o endpoint `getIndiceMeses`, fornecendo os seguintes parâmetros:
- `Indice` (IGPM ou IPCA)
- `Meses` (quantidade de meses a serem retornados)

### Resultado Esperado:
Espera-se que a resposta seja fornecida no formato JSON, com a seguinte estrutura:

```json
{
    "data": [
        {
            "data": "01/01/2023",
            "valor": "0.21"
        },
        {
            "data": "01/02/2023",
            "valor": "0.18"
        },
        {
            "data": "01/03/2023",
            "valor": "0.23"
        },
        ...
    ]
}
```

# EndPoint 2: 
Calculo de ajuste de preço em um determinado período, possíveis através de dois indices IGPM ou IPCA

### Descrição:
Como usuário, quero poder consultar o valor de ajuste utilizando IGPM ou IPCA em um determinado período de tempo, através de um Endpoint de API.

### Pré-condições:
- A funcionalidade depende do consumo de dados da API do Banco Central, que está disponível em [dadosabertos.bcb.gov.br](https://dadosabertos.bcb.gov.br/dataset).

### Ações do Usuário:
O usuário deve realizar uma solicitação GET para o endpoint `ajusteDePrecoPeriodo`, fornecendo os seguintes parâmetros:
- `Indice` (IGPM ou IPCA)
- `Preco` (Valor base onde o ajuste será feito de forma percentual)
- `De` (Data Inicial do intervalo a ser aplicado o ajuste) ex: 30/01/2022
- `Ate`(Data Final do intervalo a ser aplicado o ajuste) ex: 30/01/2023

### Resultado Esperado:
Espera-se que a resposta seja fornecida no formato JSON, com a seguinte estrutura:

```json
{
    "data": "245,33"
}
```

# Testes de Aceitação Para Endpoint 1:

# Cenário 1: Consulta Válida de IGPM

**Dado:** É possível consultar o histórico do índice de IGPM dos últimos 6 meses
**Quando:** Uma solicitação GET é feita para o endpoint `getIndiceMeses` com `Indice` definido como "IGPM" e `Meses` definido como 6
**Então:** A resposta deve conter um array de objetos com 6 entradas, cada uma representando um mês com as chaves "data" e "valor"

# Cenário 2: Consulta Válida de IPCA

**Dado:** É possível consultar o histórico do índice de IPCA dos últimos 3 meses
**Quando:** Uma solicitação GET é feita para o endpoint `getIndiceMeses` com `Indice` definido como "IPCA" e `Meses` definido como 3
**Então:** A resposta deve conter um array de objetos com 3 entradas, cada uma representando um mês com as chaves "data" e "valor"

# Cenário 3: Consulta Inválida - Índice Incorreto

**Dado:** É possível retornar um erro ao tentar consultar um índice inválido
**Quando:** Uma solicitação GET é feita para o endpoint `getIndiceMeses` com `Indice` definido como "XYZ" e `Meses` definido como 6
**Então:** A resposta deve conter uma mensagem de erro apropriada indicando que o índice é inválido

# Cenário 4: Consulta Inválida - Meses Negativos

**Dado:** É possível retornar um erro ao tentar consultar um número negativo de meses
**Quando:** Uma solicitação GET é feita para o endpoint `getIndiceMeses` com `Indice` definido como "IGPM" e `Meses` definido como -1
**Então:** A resposta deve conter uma mensagem de erro apropriada indicando que o número de meses é inválido

# Testes de aceitação para Endpoint 2: 

# Cenário 5: Cálculo de Ajuste de Preço - IGPM

**Dado:** É possível calcular o valor de ajuste utilizando o índice IGPM em um determinado período de tempo
**Quando:** Uma solicitação GET é feita para o endpoint `ajusteDePrecoPeriodo` com `Indice` definido como "IGPM", `Preco` definido como 200.0, `De` definido como "30/01/2022", e `Ate` definido como "30/01/2023"
**Então:** A resposta deve ser fornecida no formato JSON, com a chave "data" contendo o valor do ajuste, que deve ser "200,86"

# Cenário 6: Cálculo de Ajuste de Preço - IPCA

**Dado:** É possível calcular o valor de ajuste utilizando o índice IPCA em um determinado período de tempo
**Quando:** Uma solicitação GET é feita para o endpoint `ajusteDePrecoPeriodo` com `Indice` definido como "IPCA", `Preco` definido como 150.0, `De` definido como "15/02/2022", e `Ate` definido como "15/02/2023"
**Então:** A resposta deve ser fornecida no formato JSON, com a chave "data" contendo o valor do ajuste, que deve ser "150,75"

# Cenário 7: Cálculo de Ajuste de Preço - Período Inválido

**Dado:** É possível calcular o valor de ajuste em um período inválido
**Quando:** Uma solicitação GET é feita para o endpoint `ajusteDePrecoPeriodo` com `Indice` definido como "IGPM", `Preco` definido como 250.0, `De` definido como "30/01/2023", e `Ate` definido como "30/01/2022"
**Então:** A resposta deve ser fornecida no formato JSON, com uma mensagem de erro indicando que o período é inválido

# Como executar os testes ?

Entre dentro do container da aplicação:
```
docker exec -it apibcb bash
```

Execute o phpunit:

```
vendor/bin/phpunit tests/Feature/ --testdox
```

O resultado esperado é:

```
Runtime:       PHP 8.2.1
Configuration: /app/phpunit.xml

.......                                                             7 / 7 (100%)

Time: 00:02.627, Memory: 26.00 MB

Calculo Ajuste De Preco Igpm (Tests\Feature\CalculoAjusteDePrecoIgpm)
 ✔ Calculo de ajuste de preco igpm
 ✔ Calculo de ajuste de preco igpm com data inicial maior que data final

Calculo Ajuste De Preco Ipca (Tests\Feature\CalculoAjusteDePrecoIpca)
 ✔ Calculo de ajuste de preco ipca

Consulta Igpm (Tests\Feature\ConsultaIgpm)
 ✔ Consulta valida de igpm
 ✔ Consulta de igpm com meses negativo

Consulta Indice (Tests\Feature\ConsultaIndice)
 ✔ Consulta invalida de indice

Consulta Ipca (Tests\Feature\ConsultaIpca)
 ✔ Consulta valida de ipca

OK (7 tests, 39 assertions)

```
