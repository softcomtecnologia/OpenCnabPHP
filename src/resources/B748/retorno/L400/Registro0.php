<?php
/*
* CnabPHP - GeraÃ§Ã£o de arquivos de remessa e retorno em PHP
*
* LICENSE: The MIT License (MIT)
*
* Copyright (C) 2013 Ciatec.net
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of this
* software and associated documentation files (the "Software"), to deal in the Software
* without restriction, including without limitation the rights to use, copy, modify,
* merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
* permit persons to whom the Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be included in all copies
* or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
* INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
* PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
* OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
* SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
namespace CnabPHP\resources\B748\retorno\L400;

use CnabPHP\RegistroRetSicredAbstract;
use CnabPHP\RetornoAbstract;

class Registro0 extends RegistroRetSicredAbstract
{
    public $trailler;
    protected $meta = array(
        'tipo_registro'=>array(
            'tamanho'=>1,
            'default'=>'0',
            'tipo'=>'int',
            'required'=>true),
        'operacao'=>array(
            'tamanho'=>1,
            'default'=>'2',
            'tipo'=>'int',
            'required'=>true),
        'literal_remessa'=>array(
            'tamanho'=>7,
            'default'=>'RETORNO',
            'tipo'=>'alfa',
            'required'=>true),
        'tipo_servico'=>array(
            'tamanho'=>2,
            'default'=>'01',
            'tipo'=>'int',
            'required'=>true),
        'literal_servico'=>array(
            'tamanho'=>15,
            'default'=>'COBRANCA',
            'tipo'=>'alfa',
            'required'=>true),
        'codigo_beneficiario'=>array(
            'tamanho'=>5,
            'default'=>'',
            'tipo'=>'int',
            'required'=>true),
        'numero_inscricao'=>array(
            'tamanho'=>14,
            'default'=>'',
            'tipo'=>'int',
            'required'=>true),
        'filler0'=>array(
            'tamanho'=>31,
            'default'=>' ',
            'tipo'=>'alfa',
            'required'=>true),
        'codigo_banco'=>array(
            'tamanho'=>3,
            'default'=>'748',
            'tipo'=>'int',
            'required'=>true),
        'nome_banco'=>array(
            'tamanho'=>15,
            'default'=>'BANSICREDI',
            'tipo'=>'alfa',
            'required'=>true),
        'data_gravacao'=>array(
            'tamanho'=>8,
            'default'=>'',// nao informar a data na instanciaÃ§Ã£o - gerada dinamicamente
            'tipo'=>'date',
            'required'=>true),
        'filler01'=>array(
            'tamanho'=>8,
            'default'=>' ',
            'tipo'=>'int',
            'required'=>true),
        'numero_retorno'=>array(
            'tamanho'=>7,
            'default'=>' ',
            'tipo'=>'int',
            'required'=>true),
        'filler1'=>array(
            'tamanho'=>272,
            'default'=>' ',
            'tipo'=>'alfa',
            'required'=>true),
        'versao_sistema'=>array(
            'tamanho'=>5,
            'default'=>'99.99',
            'tipo'=>'alfa',
            'required'=>true),
        'numero_sequencial_registro'=>array(
            'tamanho'=>6,
            'default'=>'',
            'tipo'=>'int',
            'required'=>true),
    );
    public function __construct($linhaTxt)
    {
        parent::__construct($linhaTxt);
        RetornoAbstract::$linesCounter++;
        $this->inserirDetalhe();
    }
    public function inserirDetalhe()
    {
        while(RetornoAbstract::$linesCounter < (count(RetornoAbstract::$lines)-2))
        {
            $class = 'CnabPHP\resources\\B'.RetornoAbstract::$banco.'\retorno\\'.RetornoAbstract::$layout.'\Registro1';
            $this->children[] = new $class(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]);
        }
        //RetornoAbstract::$linesCounter--;
    }

    public function getRegistros($lote = 1)
	{
		//$lote = $this->children[$lote-1];
		return $this->getChilds();
	}
}
