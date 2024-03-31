# Controle de Estacionamento

Este é um sistema simples de controle de estacionamento desenvolvido em PHP e HTML, com estilos CSS para a interface do usuário. Ele oferece as seguintes funcionalidades:

- Cadastro de categorias de veículos, com inclusão do valor da taxa de estacionamento.
- Cadastro de veículos, associando-os a uma categoria previamente cadastrada.
- Registro de saída de veículos, incluindo a data e hora da saída, bem como o cálculo do valor cobrado com base na categoria do veículo e no tempo de permanência.
- Exibição dos veículos estacionados, mostrando sua placa, data e hora de entrada, data e hora de saída (se disponível), tempo de permanência e valor cobrado.

## Estrutura de Pastas

- **css**: Contém os arquivos CSS para estilização da interface.
- **img**: Armazena imagens utilizadas no sistema.
- **pages**: Contém os arquivos PHP responsáveis pelas diferentes páginas do sistema.
- **config**: Pasta com arquivos de configuração, como conexão com o banco de dados.
- **README.md**: Documentação do sistema.

## Como Utilizar

1. Clone ou faça o download do repositório para sua máquina local.
2. Certifique-se de ter um servidor web configurado (como Apache) e PHP instalado em sua máquina.
3. Importe o arquivo `database.sql` para criar o banco de dados e tabelas necessárias.
4. Configure as informações de conexão com o banco de dados no arquivo `connectionDb.php` dentro da pasta `config`.
5. Acesse o sistema através do navegador, navegando para `http://localhost/seu_diretorio/index.php`.
6. A partir daí, você pode usar as diferentes funcionalidades do sistema através dos links fornecidos na página inicial.

## Melhorias Futuras

- Implementar autenticação de usuário para garantir acesso seguro ao sistema.
- Adicionar funcionalidade de edição e exclusão de registros de veículos e categorias.
- Aprimorar a interface do usuário com elementos mais modernos e responsivos.
- Incluir gráficos ou relatórios para análise dos dados de estacionamento.

Esse é um sistema básico que pode ser expandido e aprimorado para atender às necessidades específicas de controle de estacionamento de diferentes estabelecimentos.
