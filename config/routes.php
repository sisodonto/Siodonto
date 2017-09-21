<?php
/*
	routes.php
	Crie url personalizadas atraves da configuracao abaixo

	name: Nome da rota
	controller: Nome do controler a ser usado
	Action: Nome do metodo a ser chamado pelo controller
*/

$_ROUTERS = [
	
	// init
	['name'=>'agendas', 'controller'=>'Init', 'action'=>'agendas'],
	['name'=>'convenios', 'controller'=>'Init', 'action'=>'convenios'],
	['name'=>'fornecedores', 'controller'=>'Init', 'action'=>'fornecedor'],
	['name'=>'tratamentos', 'controller'=>'Init', 'action'=>'tratamentos'],
	['name'=>'produtos', 'controller'=>'Init', 'action'=>'produtos'],
	
	// painel
	['name'=>'novo-convenio', 'controller'=>'painel', 'action'=>'convenios', 'params'=>'new'],
	['name'=>'novo-fornecedor', 'controller'=>'painel', 'action'=>'fornecedores', 'params'=>'new'],
	['name'=>'novo-produto-medicamento', 'controller'=>'painel', 'action'=>'produto_medicamentos', 'params'=>'new'],
	['name'=>'novo-produto-protese', 'controller'=>'painel', 'action'=>'produto_proteses', 'params'=>'new'],
	['name'=>'novo-tratamento', 'controller'=>'painel', 'action'=>'tratamentos', 'params'=>'new'],
	['name'=>'novo-usuario', 'controller'=>'painel', 'action'=>'usuarios', 'params'=>'new'],
	['name'=>'nova-agenda', 'controller'=>'painel', 'action'=>'agendas', 'params'=>'new'],
	
	['name'=>'convenio', 'controller'=>'painel', 'action'=>'convenios', 'params'=>'index'],
	['name'=>'fornecedor', 'controller'=>'painel', 'action'=>'fornecedores', 'params'=>'index'],
	['name'=>'produto-medicamento', 'controller'=>'painel', 'action'=>'produto_medicamentos', 'params'=>'index'],
	['name'=>'produto-protese', 'controller'=>'painel', 'action'=>'produto_proteses', 'params'=>'index'],
	['name'=>'tratamento', 'controller'=>'painel', 'action'=>'tratamentos', 'params'=>'index'],
	['name'=>'usuarios', 'controller'=>'painel', 'action'=>'usuarios', 'params'=>'index'],
	['name'=>'dentista', 'controller'=>'painel', 'action'=>'dentistas', 'params'=>'index'],
	['name'=>'paciente', 'controller'=>'painel', 'action'=>'pacientes', 'params'=>'index'],
	['name'=>'secretaria', 'controller'=>'painel', 'action'=>'secretarias', 'params'=>'index'],
	['name'=>'agenda', 'controller'=>'painel', 'action'=>'agendas', 'params'=>'index'],

	['name'=>'alterar-senha', 'controller'=>'painel', 'action'=>'alterar_senha'],

	// login
	['name'=>'login', 'controller'=>'login', 'action'=>'index'],
	['name'=>'sair', 'controller'=>'login', 'action'=>'logout'],
	['name'=>'entrar', 'controller'=>'login', 'action'=>'entrar'],
	// service login
	['name'=>'s-login', 'controller'=>'login', 'action'=>'service'],

	// convenios
	['name'=>'atualizar-convenio', 'controller'=>'convenios', 'action'=>'update'],
	['name'=>'criar-convenio', 'controller'=>'convenios', 'action'=>'new'],
	['name'=>'excluir-convenio', 'controller'=>'convenios', 'action'=>'delete'],
	// service convenio
	['name'=>'s-convenio', 'controller'=>'convenios', 'action'=>'service'],
	// relatorio convenio
	['name'=>'r-convenio', 'controller'=>'convenios', 'action'=>'relatorio'],

	// tratamentos
	['name'=>'atualizar-tratamento', 'controller'=>'tratamentos', 'action'=>'update'],
	['name'=>'criar-tratamento', 'controller'=>'tratamentos', 'action'=>'new'],
	['name'=>'excluir-tratamento', 'controller'=>'tratamentos', 'action'=>'delete'],
	// service - tratamento
	['name'=>'s-tratamento', 'controller'=>'tratamentos', 'action'=>'service'],
	// relatorio - tratamentos
	['name'=>'r-tratamento', 'controller'=>'tratamentos', 'action'=>'relatorio'],

	// produtos medicamentos
	['name'=>'atualizar-produto-medicamento', 'controller'=>'produtosmedicamentos', 'action'=>'update'],
	['name'=>'criar-produto-medicamento', 'controller'=>'produtosmedicamentos', 'action'=>'new'],
	['name'=>'excluir-produto-medicamento', 'controller'=>'produtosmedicamentos', 'action'=>'delete'],
	// service - produto medicamento
	['name'=>'s-produto-medicamento', 'controller'=>'produtosmedicamentos', 'action'=>'service'],
	// relatorio - produto medicamento
	['name'=>'r-produto-medicamento', 'controller'=>'produtosmedicamentos', 'action'=>'relatorio'],

	// produtos proteses
	['name'=>'atualizar-produto-protese', 'controller'=>'produtosprotese', 'action'=>'update'],
	['name'=>'criar-produto-protese', 'controller'=>'produtosprotese', 'action'=>'new'],
	['name'=>'excluir-produto-protese', 'controller'=>'produtosprotese', 'action'=>'delete'],
	// service - produto protese
	['name'=>'s-produto-protese', 'controller'=>'produtosprotese', 'action'=>'service'],
	// relatorio - produto protese
	['name'=>'r-produto-protese', 'controller'=>'produtosprotese', 'action'=>'relatorio'],

	// fornecedores
	['name'=>'atualizar-fornecedor', 'controller'=>'fornecedores', 'action'=>'update'],
	['name'=>'criar-fornecedor', 'controller'=>'fornecedores', 'action'=>'new'],
	['name'=>'excluir-fornecedor', 'controller'=>'fornecedores', 'action'=>'delete'],
	// service - fornecedor
	['name'=>'s-fornecedor', 'controller'=>'fornecedores', 'action'=>'service'],
	// relatorio - fornecedor
	['name'=>'r-fornecedor', 'controller'=>'fornecedores', 'action'=>'relatorio'],
	
	// usuarios
	['name'=>'nova-conta', 'controller'=>'usuarios', 'action'=>'novo'],
	['name'=>'cadastrar', 'controller'=>'usuarios', 'action'=>'criar_conta'],
	['name'=>'add-usuario', 'controller'=>'usuarios', 'action'=>'new'],
	['name'=>'atualizar-usuario', 'controller'=>'usuarios', 'action'=>'update'],
	['name'=>'atualizar-senha', 'controller'=>'usuarios', 'action'=>'update_pass'],
	['name'=>'excluir-usuario', 'controller'=>'usuarios', 'action'=>'delete'],
	['name'=>'checar-horario', 'controller'=>'usuarios', 'action'=>'checar_horario'],
	// service - dentista
	['name'=>'s-dentista', 'controller'=>'dentistas', 'action'=>'service'],
	// service - paciente
	['name'=>'s-paciente', 'controller'=>'pacientes', 'action'=>'service'],
	// service - secretaria
	['name'=>'s-secretaria', 'controller'=>'secretarias', 'action'=>'service'],
	
	// paciente
	['name'=>'painel-paciente', 'controller'=>'pacientes', 'action'=>'index'],
	// dentista
	['name'=>'painel-dentista', 'controller'=>'dentistas', 'action'=>'index'],
	
	// agendas
	['name'=>'criar-agenda', 'controller'=>'agendas', 'action'=>'new'],
	['name'=>'atualizar-agenda', 'controller'=>'agendas', 'action'=>'update'],
	['name'=>'excluir-agenda', 'controller'=>'agendas', 'action'=>'delete'],
	['name'=>'checar-agenda', 'controller'=>'agendas', 'action'=>'checar_agenda'],
	['name'=>'listar-agenda-de-dentistas', 'controller'=>'agendas', 'action'=>'listar_agenda'],
	['name'=>'agenda-get-nome', 'controller'=>'agendas', 'action'=>'nome'],
	['name'=>'agenda-get-data', 'controller'=>'agendas', 'action'=>'data'],
	['name'=>'agenda-get-tratamento', 'controller'=>'agendas', 'action'=>'tratamento'],
	['name'=>'checar-dentista-horario', 'controller'=>'agendas', 'action'=>'chacar_dentista_horario'],
	['name'=>'checar-dentista', 'controller'=>'agendas', 'action'=>'chacar_dentista'],
	['name'=>'checar-paciente', 'controller'=>'agendas', 'action'=>'chacar_paciente'],
	// service - agenda
	['name'=>'s-agenda', 'controller'=>'agendas', 'action'=>'service'],
	// relatorio - agenda
	['name'=>'r-agenda', 'controller'=>'agendas', 'action'=>'relatorio'],

	// relatorios
	['name'=>'relatorios', 'controller'=>'relatorios', 'action'=>'index'],
	['name'=>'relatorio-agenda', 'controller'=>'relatorios', 'action'=>'agenda'],
	['name'=>'relatorio-convenio', 'controller'=>'relatorios', 'action'=>'convenio'],
	['name'=>'relatorio-dentista', 'controller'=>'relatorios', 'action'=>'dentista'],
	['name'=>'relatorio-fornecedor', 'controller'=>'relatorios', 'action'=>'fornecedor'],
	['name'=>'relatorio-paciente', 'controller'=>'relatorios', 'action'=>'paciente'],
	['name'=>'relatorio-produto-protese', 'controller'=>'relatorios', 'action'=>'produtosprotese'],
	['name'=>'relatorio-produto-medicamento', 'controller'=>'relatorios', 'action'=>'produtomedicamento'],
	['name'=>'relatorio-secretaria', 'controller'=>'relatorios', 'action'=>'secretaria'],
	['name'=>'relatorio-tratamento', 'controller'=>'relatorios', 'action'=>'tratamento']
	

];