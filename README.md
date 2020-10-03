![picture](https://shippmedia.s3.sa-east-1.amazonaws.com/popups/desafioshipp.png)

# Desafio Shipp Backend

### Vitrine de Lojas

O objetivo do desafio é construir uma API para consulta e recuperação de uma lista de lojas, ordenada e filtrada por distância. Você deve utilizar
a base de dados de lojas fake disponibilizada no final da descrição do desafio

1) Crie uma modelagem de banco de dados para o dataset fornecido. Utilize um banco de dados sqlite para o desafio. 
Defina a modelagem que seja a mais adequada para a solução, na sua opinião.

2) Implemente um *Comando*, que importa os dados do .csv para o banco .sqlite, esse comando pode ser feito via terminal. E necessário criar um README.md explicando como rodar esse comando.

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

O desafio pode ser implementado em qualquer linguagem de backend, dê preferencia as linguagens (PHP,Nodejs,Python,Java).

Faça um Fork deste repositório e abra um Pull Request, com seu nome na descrição, para participar.

---
### Diferenciais
- Criar um middleware para verificar a existência ou não dos parâmetros obrigatórios da API.
- Escrever um teste (ou conjunto de testes) que garanta o funcionamento esperado da API.
- Criar um middleware que realize um log de cada request, registrando o horário, o valor de latitude, 
o valor de longitude, o status code e o número de lojas retornadas. Decida se o log será registrado em banco de dados
ou em arquivo simples de texto.

---

[dataset.csv](https://s3-sa-east-1.amazonaws.com/shippmedia/general/stores.csv)

# Parte do Desenvolvedor

Nome: Matheus Mauricio de Souza Araujo
E-mail: matheus_mauricio@hotmail.com
Vaga: Desenvolvedor Backend
Linkedin: https://www.linkedin.com/in/matheus-mauricio-de-souza-araujo-1b3a52185/

### Instruções para rodar o projeto
- Faça o download/clone do projeto
- Executar o comando `composer install`
- Rodar o servidor PHP. Para esse projeto eu rodei o servidor na porta 8001 com o comando `php -S 0.0.0.0:8001 -t public`
- Para criar as tabelas é necessário criar a base `desafio-shipp.sqlite` (conforme consta no **.env**) e rodar o comando `php artisan migrate` no terminal
- Antes de rodar o comando **php artisan command:importar-base-dados** (que importará os dados do arquivo .csv para o base do sqlite) certifique-se de mudar o caminho absoluto da variável **DB_DATABASE** que está no arquivo **.env**
- Executar o comando no terminal **php artisan command:importar-base-dados** na pasta raíz do projeto (essa importação levará alguns minutos)

### Observações
- Durante o desenvolvimento todos os commits foram realizados na branch develop, e após a conclusão foi feito um merge com a branch master.
- Para facilitar o entendimento e execução desse projeto, o arquivo **.env** ficará disponível aqui nesse repositório com as informações necessárias para fazer o projeto funcionar.
- É necessário se certificar que o computador que está rodando o projeto possui a versão 7.3 ou superior do PHP
- O arquivo .csv fornecido está na pasta storage/app para melhor organização.
