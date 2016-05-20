<?php
class Helpers {
    /**
    * Função para imprimir um Array PRE formatado
    * @access  static
    * @param   string
    */

    public static function pre($data) 
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        return;
    }

    /**
     * Função para imprimir a ultima Query executada pelo Laravel
     * @access  static
     * @param   string
     */ 

    public static function lastQuery($last = false)
    {
    	$queries = DB::getQueryLog();
    	if ($last) {
    		Helpers::pre(end($queries));
    		return;
    	}
    	Helpers::pre($queries);

    }

    // ------------------------------------------------------------------------

    /**
     * Word Limiter
     * Função para Limitar uma string para um número X de palavras
     *
     * @access  static
     * @param   string
     * @param   integer
     * @param   string  O caráter final. Normalmente três Elipses, exemplo "..."
     * @return  string
     */

    public static function word_limiter($str, $limit = 100, $end_char = '&#8230;')
    {
        if (trim($str) == ''){
            return $str;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

        if (strlen($str) == strlen($matches[0])){
            $end_char = '';
        }

        return rtrim($matches[0]).$end_char;
    }


    // ------------------------------------------------------------------------

    /**
     * Character Limiter
     *
     * Limita a cadeia com base na contagem de caracteres. 
     * Preserva palavras completas assim que a contagem de caracteres pode não ser exatamente como especificado.
     *
     * @access  public
     * @param   string
     * @param   integer
     * @param   string  O caráter final. Normalmente três Elipses, exemplo "..."
     * @return  string
     */

    public static function character_limiter($str, $n = 500, $end_char = '&#8230;')
    {
        if (strlen($str) < $n){
            return $str;
        }

        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

        if (strlen($str) <= $n){
            return $str;
        }

        $out = "";
        foreach (explode(' ', trim($str)) as $val){
            $out .= $val.' ';

            if (strlen($out) >= $n){
                $out = trim($out);
                return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
            }
        }
    }

    /**
     * Retorna a diferença entre duas datas
     * @access  public
     * @param   string Data Inicial, exemplo: "10/05/2016"
     * @param   string Data Final, exemplo: "15/05/2016"
     * return   integer, exemplo: "5"
    */

    public static function diferenca_dias($data_inicial, $data_final) 
    {
        $dStart = new DateTime($data_inicial);
        $dEnd  = new DateTime($data_final);
        $dDiff = $dStart->diff($dEnd);
        return $dDiff->days;
    }

    /**
     * Função para retorna a data em um Formato Predefinido
     * @access  public
     * @param   string Data no formato de entrada, exemplo: "2016-05-13"
     * @param   string Formato de saida, exemplo: "d/m/Y"
     * return   string Data de retorno, exemplo: "13/05/2016"
     */ 

    public static function retorna_data($data, $formato_saida) 
    {
        $timestamp = strtotime($data);
        return date($formato_saida, $timestamp);
    }

}