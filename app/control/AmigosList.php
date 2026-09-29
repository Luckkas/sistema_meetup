<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class AmigosList extends TPage
{

    private $form;

    public function __construct()
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Buscar Amigos');

        $id = new TEntry('id');
        $nome = new TEntry('nome');

        $this->form->addFields([new TLabel('Id')], [$id]);
        $this->form->addFields([new TLabel('Nome')], [$nome]);


        $this->form->addAction('Buscar', new TAction([$this, 'onEdit']), 'fa:save green');

        $vbox = new TVBox();
        $vbox->style = '100%';


        $vbox->add($this->form);
        
        parent::add($vbox);
    }


    public function onEdit($param){
        $dados = $this->form->getData();
        $this->form->setData($dados);

        var_dump($dados);
    }
}