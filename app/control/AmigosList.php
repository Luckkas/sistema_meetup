<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class AmigosList extends TPage
{

    private $form;
    private $grid;

    public function __construct()
    {
        parent::__construct();

        // Form para pesquisar os amigos
        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Buscar Amigos');

        $id = new TEntry('id');
        $nome = new TEntry('nome');


        $id->setSize('10%');
        $nome->setSize('50%');

        $this->form->addFields([new TLabel('Id')], [$id] );
        $this->form->addFields([new TLabel('Nome')], [$nome]);

        $this->form->addAction('Buscar', new TAction([$this, 'onReload']), 'fa:search');


        // Grid de amigos
        $this->grid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->grid->style = 'width: 100%';
        $this->grid->enablePopover('Details', '<b>Amigo: </b> {nome}');

        $id_grid   = new TDataGridColumn('id_usuario', 'Id', 'center', '10%');
        $nome_grid = new TDataGridColumn('nome', 'Nome', 'left', '30%');


        $this->grid->addColumn($id_grid);
        $this->grid->addColumn($nome_grid);

        $this->grid->createModel();

        $vbox = new TVBox();
        $vbox->style = 'width: 100%';

        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add($this->grid);
    
        parent::add($vbox);
    }


    public function onReload($param){
        try
        {

            $this->grid->clear();

            $dados = $this->form->getData();
            $this->form->setData($dados);

            TTransaction::open('banco');

            $usuario = new Usuario($dados->id);

            $this->grid->addItem($usuario);
            
            TTransaction::close();
        } catch (Exception $e){

            new TMessage('info', $e->getMessage());
        }
        
    }
} 