<!DOCTYPE html>
<html>
<body>

    <center><h1>Total Realizado para cada Espaço num Edifício</h1></center>


   <h3> <?=$_REQUEST['morada']?>  <?=$_REQUEST['codigo']?> </h3>
 <form action="table.php" method="post">
 <p><input type="hidden" name="morada"
value="<?=$_REQUEST['morada']?>"/></p>
 <p>Morada: <input type="text" name="morada"/></p>     
 <p><input type="submit" value="Submit"/></p>
 </form>
   
    
    
<?php
    
    $morada=$_REQUEST['morada'];
try
 {
     $host = "db.ist.utl.pt";
     $user ="ist178742";
     $password = "hnum2031";
     $dbname = $user;

     $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql="SELECT morada, codigo, SUM(montante)
                FROM (
   
                SELECT E.morada, E.codigo,
          
          SUM(O.tarifa * DATEDIFF(LEAST(O.data_fim, '2016/12/12'),
                                  GREATEST(O.data_inicio, '2016/01/01'))) AS montante
   FROM espaco E, oferta O, aluga A
   WHERE E.morada = O.morada AND O.morada = A.morada
     AND E.codigo = O.codigo AND O.codigo = A.codigo
   GROUP BY E.morada, E.codigo

   UNION
   
    SELECT E.morada, E.codigo,
          SUM(O.tarifa * DATEDIFF(LEAST(O.data_fim, '2016/12/12'),
          GREATEST(O.data_inicio, '2016/01/01'))) AS montante
   FROM espaco E, posto P, oferta O, aluga A
   WHERE E.morada = P.morada AND P.morada = O.morada AND O.morada = A.morada
     AND E.codigo = P.codigo_espaco AND P.codigo = O.codigo AND O.codigo = A.codigo
   GROUP BY E.morada, E.codigo) AS montantes
GROUP BY morada, codigo;
   
   ";
    
    $result = $db->query($sql);


    
     $db = null;
     }
     catch (PDOException $e)
     {
     echo("<p>ERROR: {$e->getMessage()}</p>");
     }


?>
    
    
    <?php
        $link_address1 = 'bd.php';
    echo "<a href='$link_address1'>Voltar</a>";
?>
   
    

</body>
</html>
    