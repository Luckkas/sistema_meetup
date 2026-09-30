<?php

use Adianti\Database\TRecord;

class Usuario extends TRecord 
{
    const TABLENAME  = 'usuarios';
    const PRIMARYKEY = 'id_usuario';
    const IDPOLICY   = 'max';

    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('email');
        parent::addAttribute('senha');
        parent::addAttribute('criado_em');
        parent::addAttribute('deletado_em');
    }
}