![picture](https://s3-sa-east-1.amazonaws.com/shippmedia/general/backend.png)

# Desafio Shipp Backend

O objetivo do desafio é construir uma API para consulta e recuperação de uma lista de lojas, ordenada e filtrada por distância. Você deve utilizar
a base de dados de lojas fake disponibilizada no final da descrição do desafio

1) Crie uma modelagem de banco de dados para o dataset fornecido. Utilize um banco de dados sqlite para o desafio. 
Defina a modelagem que seja a mais adequada para a solução, na sua opinião.

2) Implemente um *Command*, que importa os dados do .csv para o banco .sqlite, e que possua a seguinte assinatura: **"php artisan import:db"**.

3) defina uma rota **GET /V1/stores** onde será possível obter todas as lojas hospedadas no banco de dados. A rota deve receber como 
parâmetro um valor de latitude e um valor de longitude. Caso alguém tente acessar este endpoint sem um desses parâmetros, o
sistema deve retornar uma resposta 4XX (Bad Request).

O endpoint deve retornar, no formato JSON, uma lista de lojas ordernadas pela distância em relação ao
ponto fornecido como parâmetro. Assim, em um cenário hipotético, um cliente que acessa o endpoint passando como argumento as 
coordenadas de sua localização atual, receberia como resposta uma lista de lojas, onde as mais próximas ao seu local estariam 
ordernadas no topo da lista. Além disso, a lista deve ser filtrada de acordo com uma distância máxima de 6.5km, de forma que o 
cliente da API não receba na resposta nenhuma loja cujo a distância seja maior do que isso! A localização de cada loja pode ser
encontrada no .csv fornecido na coluna 15 (location). O corpo da resposta deve conter um campo distance em cada loja. Observe que este 
atributo não deve pertencer à modelagem de banco de dados, uma vez que trata-se de um atributo calculado em tempo real, de acordo com a
localização de cada cliente.

O desafio deve ser implementado na framework Laravel.

Faça um Fork deste repositório e abra um Pull Request, com seu nome na descrição, para participar. 
Assim que terminar, envie um e-mail para contato@shipp.delivery com o seu usuário do Bitbucket nos avisando.

---
#####Diferenciais:
1) Criar um middleware para verificar a existência ou não dos parâmetros obrigatórios da API.
2) Escrever um teste (ou conjunto de testes) que garanta o funcionamento esperado da API.
3) Criar um middleware que realize um log de cada request, registrando o horário, o valor de latitude, 
o valor de longitude, o status code e o número de lojas retornadas. Decida se o log será registrado em banco de dados
ou em arquivo simples de texto.

---

[dataset.csv](https://s3-sa-east-1.amazonaws.com/shippmedia/general/stores.csv)