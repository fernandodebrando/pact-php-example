# Pact PHP Exemplos
Aqui está uma demonstração do uso do [Pact-PHP](https://github.com/pact-foundation/pact-php/) para testes de contato de API. Os exemplos são baseados na [Meetup.com API](https://www.meetup.com/meetup_api/).  Temos dois cenários com dois consumers/clients e um provider/api.  

Estes exemplos são baseados no Pact-PHP 3.X ou maior.

## Exemplo Client Um
1. Use a API Meetup.com para extrair `categories` versão 2
2. Crie uma simulação e publique um PACT usando Pact PHP 3.0 para uma pasta local
3. Execute usando test/run_test.bat


## Exemplo Client Dois
1. Use a API Meetup.com para extrair `cities` versão 2 
2. Use a API Meetup.com para extrair `dashboards` versão 2
2. Crie uma simulação e publique um PACT usando Pact PHP 3.0 para uma pasta local
3. Execute usando test/run_test.bat


## Exemplo API
1. Na pasta src, vamos simular a API Meetup.com e testar com os clients.  
2. Pull the Pacts 
3. Configure o end point da API para o exemplo Two Client dashboards.  No diretório src/state.
4. Execute usando test/run_test.bat
5. Os testes de unidade encerram o servidor após três minutos
