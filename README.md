# Aplicação de teste Autoconf
Teste de nível técnico do Lenon Platenetti de Melo

# Objetivo
Aplicação de teste desenvolvida para a finalidade de medir o nível de conhecimento técnico do candidato Lenon Platenetti de Melo.

# Desenvolvimento
Para o desenvolvimento da aplicação foram utilizadas as seguintes tecnologias web.
* PHP versão 8.0.28;
* Framework Laravel versão 9.19;
* Framework de estilo CSS Bootstrap versão 4.4.1;
* Estrutura visual com o plugin AdminLTE versão 3.9;
* Interação de tela utilizando Javascript com a biblioteca jQuery versão 3.6.0;
* Composer versão 2.5.4;
* Banco Mysql versão 15.1

# Rodar a aplicação
Para rodar a aplicação o ambiente/máquina deverá ter instalado as seguintes aplicações:
* PHP 8.0.x instalado e configurado nas variáveis de ambiente do sistema.
<br><b>OBS:</b> Pode ser instalado através de aplicações com ambientes prontos como Xampp ou Wampp.
* Composer: Para instalações dos pacotes necessários
* Artisan: Para rodar o servidor de teste
* MySQL 15.X ou Maria DB.
Deverá seguir os seguintes passos:
* Baixar o projeto na pasta que pretende rodar o sistema
* Acessar via terminal a pasta principal do sistema
* Rodar o seguinte comenado para instalar os pacotes necessários

    <code>php composer install/code>

* Fazer uma copia do arquivo ".env.example" encontrado na estrutura principal do sistema e alterar o nome somente para ".env"
* Incluir na configurações de banco de dados as informações do banco que irá rodar, conforme mostra abaixo.

<code> DB_CONNECTION=mysql 
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=**xxxxxxxx**
DB_USERNAME=**xxxx**
DB_PASSWORD=**xxxx**
</code>

* Acessar via terminal e executar o seguinte comando na pasta principal do projeto.

    <code> php artisan migrate </code>

* Nesse momento o artisan irá perguntar se deseja criar a base no banco de dados, essa opção deve ser aceita.
* Agora o banco de dados será criado e as migrations executadas automaticamente.
* Também executar o seguinte comando para odar a seed, essa irá incluir os dados do usuário admin na base user.

    <code> php artisan db:seed</code> 

* Agora novamente via terminal, na pasta principal do sistema, exeutar o seguinte comando para rodar o servidor de teste.
 
    <code> php artisan serve </code>


* Acessar no navegador o endereço local do servidor mostrado no terminal.

  <code> http://127.0.0.1:8000/ </code>

     <code> DB_CONNECTION=mysql </code>
     
     
     
     
     
     
     
     
