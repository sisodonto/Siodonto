Aplicativo Multiplataforma para consultórios odontológicos - Sis-odonto
=========

sistema de gerenciamento de consultório odontológico multiplataforma. Endereço: http://sisodontoonline.com/


Sistema desenvolvido para monografia apresentada ao Instituto Federal Fluminense, Ciência e Tecnologia Fluminense - campus Campos Centro como parte das exigências para a conclusão do curso de Bacharelado em Sistemas de Informação.

# Web Service
Os dados de retorno foram validados em: https://jsonlint.com/

### Agendas
Filtros para um dentista em particular

Filtro de agenda por id_dentista/data inicial/data final/horario.
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/id_dentista-intervalo-data-hora_fixa/12/24-07-2017/30-10-2017/10:00:00

Filtro de agenta por id_dentista/data inicial/ data final
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/id_dentista-intervalo-data/12/24-07-2017/31-10-2017

Filtro de agenda por id_dentista/data e hora fixa
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/id_dentista-data-hora-fixa/3/12-10-2017%2010:30:00

Filtro de agenda por id_dentista e uma data fixa no formato 99-99-9999
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/id_dentista-data-fixa/3/12-10-2017

Filtro de pacientes agendados com um dentista específico
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/pacientes_do_dentista/13

Filtro de paciente relacionado com um dentista pelo nome. Passa o id do dentista e o nome do paciente.
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/nome-paciente_do_dentista/12/Beta%20gomes

Filtro de paciente relacionado com dentista pelo cpf. Informa o id do dentista e o cpf do paciente.
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/cpf-paciente_do_dentista/12/154.879.656-26

Consultar data e hora
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/intervalo-data-hora/03-07-2015%2000:00:00/02-07-2018%2000:00:00

Esta consulta retorna as datas que estiverem entre o intervalo das duas datas fornecidas.

O nome intervalo-data-hora indica que são dois parâmetros a serem passados conforme na URL acima. Passamos uma data no formato dd-mm-aaaa e seu horário no formato hh:mm:ss. Juntos ficarão da seguinte maneira: dd-mm-aaaa hh:mm:ss.

Exemplo de chamada: <br>
http://sisodontoonline.com/s-agenda/service/intervalo-data-hora/12-01-2017%2018:00:00/12-01-2017%2021:30:00

Esta consulta retorna dados entre os dias 12-01-2017 18:00:00 e 12-01-2017 21:30:00

*Consultar datas*<br>
Para consultar datas o mesmo processo é feito mas com duas diferenças. O horário deve ser omitido e na URL de requisição deve-se trocar intervalo-data-hora por intervalo-data.
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/intervalo-data/31-07-2015/12-12-2015

Retorna os dados entre as datas 31-07-2015 e 12-12-2015

*Consultar data e hora fixa*<br>
Neste tipo de consulta será retornado a data e o horário que bater exatamente com os dados informados.
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/data-hora-fixa/12-10-2017%2010:30:00

Esta consulta pede para retornar alguma agenda que esteja marcada no dia 12-10-2017 as 10:30:00 horas. Diferente das outras requisições, esta exige apenas um único parâmetro.


*Consultar data fixa*<br>
Funciona da mesma maneira que a anterior com a exceção de que os dados referentes ao horário devem ser ignorados. Somente os dados da data devem ser passados via URL.
*Exemplo:*<br>
http://sisodontoonline.com/s-agenda/service/data-fixa/12-10-2017 

*Id*<br>
A consulta retornará uma agenda com o seu id associado. <br>
*Exemplo:*<br> http://sisodontoonline.com/s-agenda/service/id/12 

*Nome de dentista*<br>
Você pode fazer uma consulta na agenda pelo nome do dentista associado a ela. <br>
*Exemplo:*<br> 
http://sisodontoonline.com/s-agenda/service/nome-dentista/Carlos <br>
Deve retornar registros da agenda que tenha o dentista marcos relacionado.

*Nome paciente* <br>
Similar ao processo anterior, podemos filtrar a agenda pelo nome do paciente.
*Exemplo:*<br>  
http://sisodontoonline.com/s-agenda/service/nome-paciente/Beta gomes

*Nome do tratamento* <br>
Além de dentista e paciente podemos filtrar também pelo nome do tratamento relacionado a agenda. <br>
*Exemplo:*<br> 
http://sisodontoonline.com/s-agenda/service/nome-tratamento/Rx oclusal
<br>
A chamada a http://sisodontoonline.com/s-agenda/service/ retorna todos os dados da agenda.

### Login
Para checar se um usuário existe, basta informar o email e senha do usuário da seguinte maneira:<br>
http://sisodontoonline.com/s-login/service/email-senha/maickon4developers@gmail.com/maickon123

Na URL o próprio nome email-senha indica que a requisição deve ser composta de um email primeiro e depois uma senha.

A requisição retorna 1 em caso de sucesso, 0 (zero) em caso de falha.

### Convênio
Retorna um convênio pelo seu ID a partir da seguinte requisição:<br>
http://sisodontoonline.com/s-convenio/services/id/2

Para retornar todos os convênios basta fazer a seguinte requisição:

### Dentistas
Retorna o dentista pelo seu id ou retorna todos os dentistas.
Exemplo:
*Retornando tudo:*<br>
http://sisodontoonline.com/s-dentista/services/tudo
*Retornando por ID:* <br>
http://sisodontoonline.com/s-dentista/services/id/3
Se o id não for encontrado retorna uma mensagem avisando que o dentista não pode ser encontrado.

### Fornecedor
Retorna id se passado ou todos os registros conforme os exemplos abaixo.
*Por id:* <br>
http://sisodontoonline.com/s-fornecedor/services/id/2
*Todos:* <br>
http://sisodontoonline.com/s-fornecedor/services/tudo

### Pacientes
Faz requisição por id, nome e cpf.  
*Exemplo:*<br>
Consulta por cpf:<br> http://sisodontoonline.com/s-paciente/services/cpf/123.654.887-96
Consulta por nome:<br> http://sisodontoonline.com/s-paciente/services/nome/julios
Consulta por id:<br> http://sisodontoonline.com/s-paciente/services/id/1

Também retorna todos os dados se for feita a requisição:<br>
Consulta por cpf: http://sisodontoonline.com/s-paciente/services/tudo

### Produto medicamento e Produto Prótese
Faz requisição por id
*Exemplo:*<br> 
Produto medicamento http://sisodontoonline.com/s-produto-medicamento/service/id/7
*Exemplo:*<br> 
Produto Protese http://sisodontoonline.com/s-produto-protese/services/id/2
<br>
Faz requisição para retornar todos.
*Exemplo:*<br>
Produto medicamento http://sisodontoonline.com/s-produto-medicamento/services/tudo
*Exemplo:*<br> 
Produto Protese http://sisodontoonline.com/s-produto-protese/services/tudo

### Secretárias
Similar ao paciente, faz requisição por id, nome e cpf. 
*Exemplo:*<br> 
Consulta por id http://sisodontoonline.com/s-secretaria/service/id/7
*Exemplo:*<br> 
Consulta por nome http://sisodontoonline.com/s-secretaria/service/id/marcia
*Exemplo:*<br> 
Consulta por cpf http://sisodontoonline.com/s-secretaria/service/id/123.695.789-77

Retornando todas as secretárias: http://sisodontoonline.com/s-secretaria/service/tudo

### Tratamentos
Faz requisição por id, *Exemplo:*<br> 
http://sisodontoonline.com/s-tratamento/service/id/7  
Pode retornar todos os dados. *Exemplo:*<br> 
http://sisodontoonline.com/s-tratamento/service/tudo


# Estrutura do sistema
O sistema foi desenvolvido seguindo os padrões MVC, toda a sua arquitetura se baseia nesses princípios. A seguir será descrito a estrutura dos arquivos.

## Pasta app/
Dentro desta pasta se encontram subpastas que suportam a lógica do sistema com os modelos, seu controlador e sua view. Nesta pasta temos as seguintes subpastas:

## assets/
Armazena todos os arquivos relacionados a css e javacript. Bibliotecas como bootstrap e jquery foram utilizadas para dar suporte às necessidades do sistema. Além disso, é aqui que se encontram os arquivos de imagem do sistema em /img e arquivos de font.

## controllers/
A pasta controllers é como um intermediador entre as classes de modelo e os arquivos de visualização (view). É através dele que o sistema determina qual view exibir e quais requisições serão feitas do modelo com base na URL requisitada pelo sistema.

## models/
A pasta models armazena os arquivos de classe que representam o modelo. Estes modelos são capazes de se comunicar com a base de dados do sistema, extrair informações e executar determinados algoritmos que satisfazem a necessidade do sistema. Os models apenas retornam um resultado com base na necessidade esperada. O controle é quem faz uso deste retorno final e exibe o resultado na tela através da view.

## Pasta config/
Esta pasta armazena arquivos de extrema importância para a configuração do sistema. Dado para a inicialização, conexão com banco de dados, linguagem a ser usada pelo sistema e carregamento automático dos arquivos de classe a serem usadas pelo sistema podem ser encontrados aqui.

Entre as suas subpastas e arquivos temos:

## db/
Dentro desta pasta podemos encontrar a definição dos arquivos globais de configuração de banco de dados. Este arquivo não pode ser modificado

## locale/
A pasta locale armazena arquivos com extensão .trl que significa arquivos (translate - Arquivos de tradução). São úteis para caso o sistema necessite apresentar os seus dados e mais de uma língua. Dentro desta pasta deve existir uma subpasta com o nome da linguagem a ser usada. Por padrão já temos a pasta pt-br/ e dentro dela podemos armazenar todas as referências de saída de texto do sistema nela. Ao inicializar o sistema ele determinar pt-br como linguagem padrão. Caso houvesse possibilidade de mudança de língua, bastasse criar uma nova pasta como en-en/ por exemplo e configurar todas as saídas de texto para inglês dentro desta pasta. 

## config/
Este é um arquivo que deve ser configurado para o ambiente adequado na qual o sistema será hospedado. Dentro do array $_CONFIG você deverá preencher as informações corretas conforme o ambiente de desenvolvimento usado. O array oferece a opção de ambiente local e de em produção. Na chave local você deve informar os dados do seu sistema dentro do ambiente local, na chave de produção deve-se informar os dados referentes ao ambiente de produção.

O mesmo deve ser feito na chave db que é responsável pela configuração do banco de dados do sistema. 
Além disso na chave language você pode determinar qual linguagem será usada por parão na inicialização do sistema. Por padrão o sistema inicializa com português brasileiro.

## arquivo init.php
Este arquivo é responsável por utilizar os dados de configuração de config. Ele pega a definição de URL interna usada dentro do sistema operacional (Ex: C:\xampp\htdocs\projeto) e a definição web (http://localhost/) para usar nas requisições que o sistema faz durante o seu ciclo de vida.

Através de um método de autoload, sempre que uma classe é instanciada o sistema identifica a classe e faz um require do seu arquivo para que sua instância funcione. Isso permite que arquivos de classe de modelo e controllers possam ser instanciados sem a necessidade direta de se fazer um require antes. Por conta disso todo o sistema funciona corretamente, sem este arquivo o sistema não é capaz de gerenciar corretamente as instâncias que ocorrem sob demanda pelo sistema.

Dentro deste arquivos também são carregados os arquivos de banco de dados e o arquivos de rotas que será explicado no próximo item.

## rotas.php
Este arquivo é responsável por estabelecer URLs amigáveis para o sistema. Através de um array global $_ROUTERS, podemos definir cada url que desejamos usar. Para que isso funcione, devemos preencher corretamente as informações dentro deste array. Exemplo:

['Nome' => 'agendas', 'controlador' => 'Init', 'ação' => 'agendas'],

Ao acessar o nome agendas no sistema ele nos guia para o controller Init e solicita a action agendas. Esta action agendas é responsável por exibir a view agendas que por sua vez irá exibir na tela os dados referentes a agenda.

## Arquivo .htaccess
Este arquivo é responsável por fazer uma reescrita na URL usada pelo sistema. As informações presentes neste arquivo configura o servidor para que o sistema consiga usar URLs amigáveis. Uma requisição que antes era site/produto?id=100 passa a ser assim site/produto/100.

## Arquivo console.php
Este aqui faz uso de uma classe interna chamada core (núcleo). Dentro desta pasta existem arquivos úteis e indispensáveis para a agilidade no desenvolvimento do sistema. Entre eles temos a ferramenta console que permite a geração de códigos de forma automática. Durante a criação de classes model, controles ou arquivos de view, ao invés de escrevermos do zero o código fonte, podemos gerar um código base pronto através de alguns comandos no terminal. Para usar o console basta abrir o terminal, ir na pasta raiz do projeto e digitar php console.php

## core/
Esta pasta apresenta um conjunto de subpasta que são indispensáveis para a agilidade do sistema e o funcionamento do mesmo. Nesta pasta estão presentes classes que fazem a conexão com o banco de dados, que persistem editam e excluem os mesmos. Além disso podemos encontrar também classes que gerenciam as requisições de URL, classes que determinam funcionalidade padrão para os controllers e entre outras coisas de utilidade indispensável ao sistema.