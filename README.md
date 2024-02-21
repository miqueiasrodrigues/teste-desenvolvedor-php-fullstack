# Projeto de Cadastro de Fornecedores

Este é um projeto desenvolvido utilizando Laravel 9 no backend e Vue.js 2 no frontend, com o objetivo de criar um sistema de cadastro de fornecedores. O projeto está estruturado em duas pastas principais: `backend` e `frontend`.

## Funcionalidades

- **Cadastro de Fornecedores:** Permite inserir novos fornecedores no sistema, fornecendo informações como nome, CNPJ, endereço, entre outros.
  
- **Consulta na API da Receita Federal:** Integração com a API da Receita Federal para consulta de informações a partir do CNPJ do fornecedor, facilitando o preenchimento automático de dados.
  
- **Consulta na Base de Dados:** Possibilidade de realizar consultas na base de dados do sistema para recuperar informações sobre fornecedores já cadastrados.

- **Atualização de Fornecedores:** Permite atualizar as informações de fornecedores já cadastrados, garantindo a atualização correta dos dados.

- **Exclusão de Fornecedores:** Funcionalidade para remover fornecedores do sistema quando necessário.

## Configuração do Ambiente de Desenvolvimento

### Backend

1. Navegue até a pasta `backend`.
2. Execute `composer install` para instalar as dependências do Laravel.
3. Configure o arquivo `.env` com as informações do banco de dados e outras configurações necessárias.
4. Execute `php artisan migrate` para criar as tabelas no banco de dados.
5. Execute `php artisan serve` para iniciar o servidor backend.

### Frontend

1. Navegue até a pasta `frontend`.
2. Execute `npm install` para instalar as dependências do Vue.js.
3. Configure o arquivo `.env` com as URLs necessárias para comunicação com o backend.
4. Execute `npm run serve` para iniciar o servidor frontend.

Certifique-se de ter as versões corretas do PHP, Node.js e npm instaladas em sua máquina.

## Contribuição

Contribuições são bem-vindas! Se você identificar algum problema ou quiser adicionar novas funcionalidades, fique à vontade para abrir uma issue ou enviar um pull request.

## Licença

Este projeto está licenciado sob a [MIT License](https://opensource.org/licenses/MIT).
