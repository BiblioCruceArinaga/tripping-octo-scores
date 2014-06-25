<?php

    namespace Smartscores\Bundle\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Serializer\Serializer;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Smartscores\Bundle\Entity\BuyScores;
    use Smartscores\Bundle\Entity\User;
    use Smartscores\Bundle\Entity\Scores;
    use Smartscores\Bundle\Entity\Spanish;
    use Smartscores\Bundle\Entity\English;
    use Smartscores\Bundle\Entity\BuyMoney;
    use Smartscores\Bundle\Entity\BonificacionesUsers;

    class StoreController extends Controller {


			/*

			====================================================
			Espacio reservado para el código de la tienda online
			====================================================
 
			*/




/*
			==============================================
			   Código tienda para dispositivos móviles
			==============================================
*/
	
	//Devuelve las partituras de piano
	public function getpianoinfoAction(Request $request){		
						
		$score = new Scores();
		$spanish = new Spanish();
    		$english = new English();
		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer(array($normalizer), array($encoder));
		

		$Language = utf8_encode($request->request->get('Lenguaje'));	
		
		//Si el dispositivo está en español devuelve partituras en ese idioma, sino, en inglés. 
		if(strcasecmp($Language, 'español') != 0){

			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT e.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, e.Description, e.Name_Song, e.instrument, e.URL, 					e.URL_Image 
				FROM SmartscoresBundle:English e JOIN SmartscoresBundle:Scores sc 
				WHERE e.Id_S = sc.Id_S AND e.instrument = 'Piano'" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;
		}else{

			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT s.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, s.Description, s.Name_Song, s.instrument, s.URL, 					s.URL_Image 
				FROM SmartscoresBundle:Spanish s JOIN SmartscoresBundle:Scores sc 
				WHERE s.Id_S = sc.Id_S AND s.instrument = 'Piano'" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;

							
		}
		return new Response();
	}

	//Devuelve las partituras de guitarra
	public function getguitarinfoAction(Request $request){						
		$score = new Scores();
		$spanish = new Spanish();
		$english = new English();
		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer(array($normalizer), array($encoder));
		
		$Language = utf8_encode($request->request->get('Lenguaje'));	

		//Si el dispositivo está en español devuelve partituras en ese idioma, sino, en inglés. 
		if(strcasecmp($Language, 'español') != 0){

			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT e.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, e.Description, e.Name_Song, e.instrument, e.URL, 					e.URL_Image 
				FROM SmartscoresBundle:English e JOIN SmartscoresBundle:Scores sc 
				WHERE e.Id_S = sc.Id_S AND e.instrument = 'Guitar'" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;
			
		}else{
			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT s.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, s.Description, s.Name_Song, s.instrument, s.URL, 					s.URL_Image 
				FROM SmartscoresBundle:Spanish s JOIN SmartscoresBundle:Scores sc 
				WHERE s.Id_S = sc.Id_S AND s.instrument = 'Guitarra'" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;
	
		}
		return new Response();
	}

	//Devuelve las partituras gratuitas
	public function getfreeinfoAction(Request $request){		
						
		$score = new Scores();
		$spanish = new Spanish();
		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer(array($normalizer), array($encoder));
		

		$Language = utf8_encode($request->request->get('Lenguaje'));	
		
		//Si el dispositivo está en español devuelve partituras en ese idioma, sino, en inglés. 
		if(strcasecmp($Language, 'español') != 0){

			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT e.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, e.Description, e.Name_Song, e.instrument, e.URL, 					e.URL_Image 
				FROM SmartscoresBundle:English e JOIN SmartscoresBundle:Scores sc 
				WHERE e.Id_S = sc.Id_S AND sc.Price = 0" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;
			
		}else{
			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT s.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, s.Description, s.Name_Song, s.instrument, s.URL, 					s.URL_Image 
				FROM SmartscoresBundle:Spanish s JOIN SmartscoresBundle:Scores sc 
				WHERE s.Id_S = sc.Id_S AND sc.Price = 0" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;	
		}
		return new Response();
	}

	//Devuelve los datos de las partituras que coincidan en nombre, autor o editorial con el fragmento que se le pasa (Buscador)
	public function searchAction(Request $request){
					
		$score = new Scores();
		$spanish = new Spanish();
		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer(array($normalizer), array($encoder));
		

		$Language = $request->request->get('Lenguaje');	
		$Word = $request->request->get('word');
		
		//Si el dispositivo está en español devuelve partituras en ese idioma, sino, en inglés. 
		if(strcasecmp($Language, 'español') != 0){

			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT e.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, e.Description, e.Name_Song, e.instrument, e.URL, 					e.URL_Image
				FROM SmartscoresBundle:English e JOIN SmartscoresBundle:Scores sc 
				WHERE e.Id_S = sc.Id_S AND (sc.Author LIKE '%$Word%' OR sc.Editor LIKE '%$Word%' OR e.Name_Song LIKE '%$Word%')" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;

		}else{
			
			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT s.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, s.Description, s.Name_Song, s.instrument, s.URL, 					s.URL_Image 
				FROM SmartscoresBundle:Spanish s JOIN SmartscoresBundle:Scores sc 
				WHERE s.Id_S = sc.Id_S AND (sc.Author LIKE '%$Word%' OR sc.Editor LIKE '%$Word%' OR s.Name_Song LIKE '%$Word%')" 
			);
			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;
				
		}
		return new Response();		
	}

	public function buyscoreAction(Request $request){
		$buy = new BuyScores();
            
            	//  El método request devuelve variables $_POST (el método query devuelve $_GET)
            	$Id_U = $request->request->get('id_u');
            	$Id_S = $request->request->get('id_s');

		$buy->setId_U($Id_U);
		$buy->setId_S($Id_S);		

//echo "GetId_U: ".$buy->getId_U().", GetId_S: ".$buy->getId_S();
	
		try {
                	$um = $this->getDoctrine()->getManager();
                    	$um->persist($buy);
                    	$um->flush();
		
			$resultado[] = array("buystatus" => "1");
                        echo json_encode($resultado);
                }catch (\Exception $e) {
                    
                    	//  Excepción SQL
                       	echo $e->getMessage();
                       // $resultado[] = array("buystatus" => "0");
                        echo json_encode($resultado);
          		
		}

                return new Response();
	}


	public function buyitAction(Request $request){
		$buy = new BuyScores();
            	
		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer(array($normalizer), array($encoder));
		
            	$Id_U = $request->request->get('id_u');

		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery("
			SELECT bs.Id_S
			FROM SmartscoresBundle:BuyScores bs 
			WHERE bs.Id_U = '$Id_U'" 
		);
		$Score2 = $query->getResult();
		$jsonContent = $serializer->serialize($Score2, 'json');
		echo $jsonContent;
                return new Response();
	}

	public function buymoneyAction(Request $request){

		$Id_U = $request->request->get('id_u',"");
            	$PayMethod = $request->request->get('paymethod',"");
           	$Money = $request->request->get('money',"");
		$Date = date('Ymd');
		
		$BuyM = new BuyMoney();

                $BuyM->setId_U($Id_U);
                $BuyM->setDate($Date);
                $BuyM->setPay_Method($PayMethod);
                $BuyM->setMoney($Money);

                try {
                	$um = $this->getDoctrine()->getManager();
                        $um->persist($BuyM);
                        $um->flush();
			
			if($Money > 5){			
				$this->bonificationMoney($Id_U, $Money);			
			}
                        
			$resultado[] = array("buyMstatus" => "1");
                   	echo json_encode($resultado);
             	
		}catch (\Exception $e) {
                        $resultado[] = array("buyMstatus" => "2");
                        echo json_encode($resultado);

                        //echo $e->getMessage();
                        return new Response();
                }
		
               	return new Response();	
	}

	public function bonificationMoney($id_u, $money){

		$Date = date('Ymd');
		$BonificationID = 0;
		
		switch($money){
			case 10: 
				$BonificationID = 7;	
				break;
			case 20: 
				$BonificationID = 8;
				break;
			case 50: 
				$BonificationID = 9;
				break;
			case 100:  
				$BonificationID = 10;
				break;
			default:
				$BonificationID = 0;
		}

		$BonUsers = new BonificacionesUsers();

                $BonUsers->setIdUser($id_u);
                $BonUsers->setIdBonificacion($BonificationID);
                $BonUsers->setFecha($Date);

                try {
                	$um = $this->getDoctrine()->getManager();
                        $um->persist($BonUsers);
                        $um->flush();

                        $resultado[] = array("bonUstatus" => "1");
                   	echo json_encode($resultado);
             	
		}catch (\Exception $e) {
                        $resultado[] = array("bonUstatus" => "2");
                        echo json_encode($resultado);

                        //echo $e->getMessage();
                        return new Response();
                }

               	return new Response();	
	}

	public function bonification_socialAction(Request $request){


		$Id_U = $request->request->get('id_u',"");
            	$Id_B = $request->request->get('id_b',"");
		$Date = date('Ymd');
		
		$BonUsers = new BonificacionesUsers();

                $BonUsers->setIdUser($Id_U);
                $BonUsers->setIdBonificacion($Id_B);
                $BonUsers->setFecha($Date);

                try {
                	$um = $this->getDoctrine()->getManager();
                        $um->persist($BonUsers);
                        $um->flush();

                        $resultado[] = array("bonificationstatus" => "1");
                   	echo json_encode($resultado);
             	
		}catch (\Exception $e) {
                        $resultado[] = array("bonificationstatus" => "2");
                        echo json_encode($resultado);

                        //echo $e->getMessage();
                        return new Response();
                }

               	return new Response();	
	}

	public function purchasesAction(Request $request){
					
		$score = new Scores();
		$spanish = new Spanish();
		$encoder = new JsonEncoder();
		$normalizer = new GetSetMethodNormalizer();
		$serializer = new Serializer(array($normalizer), array($encoder));
		
		$Language = $request->request->get('Lenguaje');	
		$Id_U = $request->request->get('Id_U');
		
		//Si el dispositivo está en español devuelve partituras en ese idioma, sino, en inglés. 
		if(strcasecmp($Language, 'español') != 0){

			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT e.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, e.Description, e.Name_Song, e.instrument, e.URL, 					e.URL_Image
				FROM SmartscoresBundle:English e JOIN SmartscoresBundle:Scores sc WITH e.Id_S = sc.Id_S JOIN 					SmartscoresBundle:BuyScores bs WITH sc.Id_S = bs.Id_S
				WHERE bs.Id_U = $Id_U"
			);

			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;

		}else{
			
			$em = $this->getDoctrine()->getManager();
			$query = $em -> createQuery("
				SELECT s.Id_S, sc.Author, sc.Price, sc.Year, sc.Editor, s.Description, s.Name_Song, s.instrument, s.URL, 					s.URL_Image 
				FROM SmartscoresBundle:Spanish s JOIN SmartscoresBundle:Scores sc WITH s.Id_S = sc.Id_S JOIN 					SmartscoresBundle:BuyScores bs WITH sc.Id_S = bs.Id_S
				WHERE bs.Id_U = $Id_U"
			);

			$Score2 = $query->getResult();
			$jsonContent = $serializer->serialize($Score2, 'json');
			echo $jsonContent;
				
		}
		return new Response();		
	}


    }

?>
