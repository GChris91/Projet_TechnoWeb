<?php

   require_once 'model.php';
   $result=prepare_test('azerty','azerty',"Arts et Litterature");

   $question=affiche_Qs($result);

   $reponse=recup_rep($result);

   $i=0;

   foreach ($question['id_q'] as $id_q1)
   {
   		printf($question['description'][$i].":");
   		$i++;
   		$j=0;
   		foreach ($reponse['id_q'] as $id_q2)
   		{
   			if($id_q1 == $id_q2)
   			{
   				printf($reponse['description'][$j].",");
   			}
   			$j++;
   		}
   }

?>
