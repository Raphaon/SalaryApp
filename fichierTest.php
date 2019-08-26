
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
	<title>Generate Cenadi Salary File App	</title>
</head>
<body>
   <form method="post">
      <fieldset>
         <legend>Formulaire </legend>
         <label for="file">Import file : </label>
         <input type="file" name="Salaryfile" id="file">
         <input type="submit" name="Valider">
      </fieldset>

   </form>
</body>
</html>
<?php 
if(isset($_POST['Salaryfile']) and !empty($_POST['Salaryfile']))
{
   $linkFichier = realpath(htmlspecialchars($_POST['Salaryfile']));
   require_once './PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load($linkFichier);

/**
* récupération de la première feuille du fichier Excel
* @var PHPExcel_Worksheet $sheet
*/
$sheet = $objPHPExcel->getSheet(0);
echo '<table border="1">';
   $fileName = "Generate/Salaire".date("Y M").'.txt';
   $fichier  = fopen($fileName, 'w+');
 
// On boucle sur les lignes
foreach($sheet->getRowIterator() as $row) {
   $content  =  "297600";
   echo '<tr>';
   $i = 1;
   // On boucle sur les cellule de la ligne

 
   foreach ($row->getCellIterator() as $cell) {
        $val = $cell->getValue();
   if($i==4)
   {
         switch (strlen($cell->getValue())) {
         case 0:
            $val = "0000000";
            break;
         case 1:
            $val = "000000".$cell->getValue();
            break;
         case 2:
            $val = "00000".$cell->getValue();
            break;
         case 3:
            $val = "0000".$cell->getValue();
            break;
         case 4:
            $val = "000".$cell->getValue();
            break;
         case 5:
            $val = "00".$cell->getValue();
            break;
         case 6:
            $val = "0".$cell->getValue();
            break;
         case 7:
            $val = $cell->getValue();
            break;
         default:
            ;
            break;
      }
   }
   
      $content = $content.''.$val;
       echo '<td>';
      
      
      if($i==2)
      {
         if(strlen($content)>40)
         {
            $content = substr($content, 0,39);
            $content = $content.' ';
         }else
         {
            while (strlen($content)<40) {
               $content = $content.' ';
            }
         }
      }
      if($i==3)
      {
      if($cell->getValue()=="")
      {
         $content = $content."00000000 ";
      }else{$content = $content." ";}
      }
      if($i == 4)
      {
         fwrite($fichier, $content."\r\n");
      }
      print_r($cell->getValue());
   

      $i++;

      
      echo '</td>';
   }
 
   echo '</tr>';
}
echo '</table>';



}


 ?>
