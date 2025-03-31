<?php

namespace CnabPHP;

abstract class RegistroRetSicredAbstract extends RegistroRetAbstract
{
 
    /**
     * método __set()
     * executado sempre que uma propriedade for atribuÃ­da.
     */
    public function __set($prop, $value)
    {
        // verifica se existe método set_<propriedade>
        if (method_exists($this, 'set_' . $prop)) {
            // executa o Método set_<propriedade>
            call_user_func(array($this, 'set_' . $prop), $value);
        } else {
            $metaData = (isset($this->meta[$prop])) ? $this->meta[$prop] : null;
            switch ($metaData['tipo']) {
                case 'decimal':
                    $inteiro = (int)(substr($value, 0, $metaData['tamanho']));
                    $decimal = (int)(substr($value, $metaData['tamanho'], $metaData['precision'])) / 100;
                    $retorno = ($inteiro + $decimal);
                    $this->data[$prop] = $retorno;
                    break;
                case 'int':
                    $retorno = (int)$value;
                    $this->data[$prop] = $retorno;
                    break;
                case 'alfa':
                    $retorno = trim($value);
                    $this->data[$prop] = $retorno;
                    break;
                case 'date':
                    if(empty(trim($value))){
                        $this->data[$prop] = '';
                        break;
                    }

                    if ($metaData['required']) {
                        if ($metaData['tamanho'] == 6) {
                            $data = \DateTime::createFromFormat('dmy', sprintf('%06d', $value));
                        } elseif ($metaData['tamanho'] == 8) {
                            $data = \DateTime::createFromFormat('Ymd', sprintf('%08d', $value));
                        } else {
                            throw new \InvalidArgumentException("Tamanho do campo {$prop} inválido");
                        }

                        $this->data[$prop] = $data->format('Y-m-d');
                    } else {
                        $this->data[$prop] = '';
                    }
                    break;
                default:
                    $this->data[$prop] = $value;
                    break;
            }
        }
    }

}
