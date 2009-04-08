<?php
class Inflection{
	
	/**
	 * Именительный падеж
	 * @var int
	 * @desc Кто?
	 */
	const P_IMENITELTY = 1;
	
	/**
	 * Родительный падеж
	 * @var int
	 * @desc Кого?
	 */	
	const P_RODITELNY  = 2;
	
	/**
	 * Давательный падеж
	 * @var int
	 * @desc Кому?
	 */	
	const P_DAVATELNY  = 3;
	
	/**
	 * Винительный падеж
	 * @var int
	 * @desc Кого?
	 */	
	const P_VINITELNY  = 4;
	
	/**
	 * Творительный падеж
	 * @var int
	 * @desc Кем?
	 */		
	const P_TVORITELNY = 5;
	
	/**
	 * Именительный падеж
	 * @var int
	 * @desc О ком?
	 */		
	const P_PREDLOJNY  = 6;
	
	/**
	 * 
	 * @param $word Слово, которое нужно просклонять
	 * @param $resInflection Склонение, которое нужно получить (например P_PREDLOJNY)
	 * @return string
	 */
	public static function Inflect($word, $resInflection){
		$wRes = mysql_fetch_array(mysql_query('SELECT COUNT(id) as w_num FROM inflections WHERE case1 LIKE "'.$word.'"'));
		if($wRes['w_num']==0){
			//Чтиаем XML и пишет в базу ответ
			try{
				//$response = file_get_contents('http://export.yandex.ru/inflect.xml?name='.urlencode($word));
				$inflElement = simplexml_load_file('http://export.yandex.ru/inflect.xml?name='.urlencode($word));
				if(count($inflElement->inflection)==1) return $inflElement->original;
				self::addNewInflections($inflElement);
				return self::getResult($word, $resInflection);
			}
			catch(Exception $e){
				throw new Exception('Error occured while reading XML with message: '.$e->getMessage());
			}
			
		}
		elseif($wRes['w_num']==1){
			//Читаем из базы и отдаем ответ
			return self::getResult($word, $resInflection);
		}
		else{
			throw new Exception('Multiple word entries in database');
		}
	}
	
	/**
	 * 
	 * @param $xmlElement SimpleXMLElement
	 * @return none
	 */
	private static function addNewInflections(SimpleXMLElement $xmlElement){
		if(count($xmlElement->inflection) != 6) throw new Exception('Wrong inflections number in response');
		$q = 'INSERT INTO inflections VALUES(null,';
		$i=1;
		foreach($xmlElement->inflection as $inflection){
			$q .= '"'.$inflection.'"'.($i++!=count($xmlElement->inflection) ? ',' : '');
		}
		$q .= ')';
		if(!mysql_query($q)) throw new Exception('Error occured while inserting inflections in database');
	}
	
	/**
	 * Возвражает результат, уже записанный в базу данных
	 * @param $word Слово, которое нужно просклонять
	 * @param $resInflection Склонение, которое нужно получить (например P_PREDLOJNY)
	 * @return string
	 */
	private static function getResult($word, $inflection){
		$inflection = 'case'.$inflection;
		$wRes = mysql_fetch_array(mysql_query('SELECT '.$inflection.' as word FROM inflections WHERE case1 LIKE "'.$word.'"'));
		return $wRes['word'];
	}
	
}
?>