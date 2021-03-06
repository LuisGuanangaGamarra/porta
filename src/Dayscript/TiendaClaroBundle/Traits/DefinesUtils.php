<?php
/**
 * Created by PhpStorm.
 * User: Link Digital
 * Date: 15/03/2019
 * Time: 12:55
 */

namespace Dayscript\TiendaClaroBundle\Traits;


trait DefinesUtils
{
    /**
     * @param $array
     * @return string
     */
    protected function util__iterate_array($array)
    {
        $str = '';
        foreach ($array as $key => $value) {
            $str .= '['.$key.']: '.(is_array($value) ? 'array: <'.sizeof($value).'>' : (is_string($value) ? 'string' : (is_int($value) ? 'int' : (is_bool($value) ? :get_class($value).($value ? ' -> ++ ID: '.$value->getId().' ++' : ''))))).' ---- ';
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $str .= '<br>('.$key2.'): '.(is_array($value2) ? 'array: <'.sizeof($value2).'>' : (is_string($value2) ? 'string: "'.$value2.'"' : (is_int($value2) ? 'int: '.$value2 : (is_bool($value2) ? 'boolean: '.($value2 ? 'true' : 'false') : (is_double($value2) ? 'double: '.$value2 : get_class($value2).($value2 ? ' -> + ID: '.$value2->getId().' +' : '')))))).' - ';
                }
            } $str .= '--------------------<br>';
        }
        return $str;
    }

    public function validator__validate($values)
    {
        $messages = [];
        $validator = $this->get('validator');
        foreach ($values as $value) {
            $errors = $validator->validate($value);
            if (count($errors) >0) {
                foreach ($errors as $violation) {
                    $messages[$violation->getPropertyPath()][] = $violation->getMessage();
                }
            }
        }
        return $messages;
    }

    public static function getDateTimeFromString($fecha_str)
    {
        if($fecha_str instanceof \DateTime) {
            return $fecha_str;
        }
        $fecha = null;
        try {
            $fecha = \DateTime::createFromFormat('Y-m-d H:i', $fecha_str);
            if($fecha)    return $fecha;
        } catch(\Exception $e) { }
        try {
            $fecha = \DateTime::createFromFormat('Y-m-d H:i:s', $fecha_str);
            if($fecha)    return $fecha;
        } catch(\Exception $e) { }
        try {
            $fecha = \DateTime::createFromFormat('Y-m-d H:i:s.u', $fecha_str);
            if($fecha)    return $fecha;
        } catch(\Exception $e) { }
        try {
            $fecha = \DateTime::createFromFormat('Y-m-d', $fecha_str);
            if($fecha)    return $fecha;
        } catch(\Exception $e) { }
        try {
            $fecha = new \DateTime($fecha_str, new \DateTimeZone('ECT'));
            if($fecha)    return $fecha;
        } catch(\Exception $e) { }
        return false;
    }

    public static function addZerosBefore($number, $n_zeros)
    {
        $init = 10**($n_zeros-1);
        while($number < $init)
        {
            $number = '0'.$number;
            $init /= 10;
        } return $number;
    }

    public function limpiarString($string)
    {
        $replace = [
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'Ae',
            '&Auml;' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'Ae',
            '??' => 'C', '??' => 'C', '??' => 'C', '??' => 'C', '??' => 'C', '??' => 'D', '??' => 'D',
            '??' => 'D', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E',
            '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'G', '??' => 'G',
            '??' => 'G', '??' => 'G', '??' => 'H', '??' => 'H', '??' => 'I', '??' => 'I',
            '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I',
            '??' => 'I', '??' => 'IJ', '??' => 'J', '??' => 'K', '??' => 'K', '??' => 'K',
            '??' => 'K', '??' => 'K', '??' => 'K', '??' => 'N', '??' => 'N', '??' => 'N',
            '??' => 'N', '??' => 'N', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O',
            '??' => 'Oe', '&Ouml;' => 'Oe', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O',
            '??' => 'OE', '??' => 'R', '??' => 'R', '??' => 'R', '??' => 'S', '??' => 'S',
            '??' => 'S', '??' => 'S', '??' => 'S', '??' => 'T', '??' => 'T', '??' => 'T',
            '??' => 'T', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'Ue', '??' => 'U',
            '&Uuml;' => 'Ue', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U',
            '??' => 'W', '??' => 'Y', '??' => 'Y', '??' => 'Y', '??' => 'Z', '??' => 'Z',
            '??' => 'Z', '??' => 'T', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a',
            '??' => 'ae', '&auml;' => 'ae', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a',
            '??' => 'ae', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c',
            '??' => 'd', '??' => 'd', '??' => 'd', '??' => 'e', '??' => 'e', '??' => 'e',
            '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e',
            '??' => 'f', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'h',
            '??' => 'h', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i',
            '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'ij', '??' => 'j',
            '??' => 'k', '??' => 'k', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l',
            '??' => 'l', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n',
            '??' => 'n', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'oe',
            '&ouml;' => 'oe', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'oe',
            '??' => 'r', '??' => 'r', '??' => 'r', '??' => 's', '??' => 'u', '??' => 'u',
            '??' => 'u', '??' => 'ue', '??' => 'u', '&uuml;' => 'ue', '??' => 'u', '??' => 'u',
            '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'w', '??' => 'y', '??' => 'y',
            '??' => 'y', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 't', '??' => 'ss',
            '??' => 'ss', '????' => 'iy', '??' => 'A', '??' => 'B', '??' => 'V', '??' => 'G',
            '??' => 'D', '??' => 'E', '??' => 'YO', '??' => 'ZH', '??' => 'Z', '??' => 'I',
            '??' => 'Y', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => 'O',
            '??' => 'P', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U', '??' => 'F',
            '??' => 'H', '??' => 'C', '??' => 'CH', '??' => 'SH', '??' => 'SCH', '??' => '',
            '??' => 'Y', '??' => '', '??' => 'E', '??' => 'YU', '??' => 'YA', '??' => 'a',
            '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'yo',
            '??' => 'zh', '??' => 'z', '??' => 'i', '??' => 'y', '??' => 'k', '??' => 'l',
            '??' => 'm', '??' => 'n', '??' => 'o', '??' => 'p', '??' => 'r', '??' => 's',
            '??' => 't', '??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c', '??' => 'ch',
            '??' => 'sh', '??' => 'sch', '??' => '', '??' => 'y', '??' => '', '??' => 'e',
            '??' => 'yu', '??' => 'ya'
        ];

        return str_replace(array_keys($replace), $replace, $string);
    }

}