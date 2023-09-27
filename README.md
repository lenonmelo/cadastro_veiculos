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
* Baixar o projeto na pasta que pretende rodar o sistema;
* Acessar via terminal a pasta principal do sistema;
* Rodar o seguinte comenado para instalar os pacotes necessários;

      php composer install

* Fazer uma copia do arquivo ".env.example" encontrado na estrutura principal do sistema e alterar o nome somente para ".env";
* Incluir na configurações de banco de dados as informações do banco que irá rodar, conforme mostra abaixo;

      DB_CONNECTION=mysql <br>
      DB_HOST=127.0.0.1<br>
      DB_PORT=3306<br>
      DB_DATABASE=<b>xxxxxxxx</b><br>
      DB_USERNAME=<b>xxxx</b><br>
      DB_PASSWORD=<b>xxxx</b><br>

* Acessar via terminal e executar o seguinte comando na pasta principal do projeto;

      php artisan migrate

* Nesse momento o artisan irá perguntar se deseja criar a base no banco de dados, essa opção deve ser aceita;
* Agora o banco de dados será criado e as migrations executadas automaticamente;
* Também executar o seguinte comando para odar a seed, essa irá incluir os dados do usuário admin na base user;

      php artisan db:seed

* Agora novamente via terminal, na pasta principal do sistema, exeutar o seguinte comando para rodar o servidor de teste;

      php artisan serve 

* Acessar no navegador o endereço local do servidor mostrado no terminal.
      
      http://127.0.0.1:8000

# Acesso

* O usuário e senha padrão de teste são as seghuintes:

      Usuário: admin@teste.com.br
      Senha: admin


# Observação

* Ao rodar o sistema plea primeira vez no servidor, ele poderá solicitar a geração de uma chave de acesso, nesse momento é só apertar no botão que aparece na tela para a geração dessa chave, e entrar no endereço novamente.
