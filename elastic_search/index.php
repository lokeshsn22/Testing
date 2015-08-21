<?php 
     require_once 'app/init.php';
 
     if(isset($_GET['q'])) {
          $q =$_GET['q'];

          $query = $es ->search([
            'body' => [
                  'query' => [
                        
                              /*  'match' => ['title' => $q] */
                              
    "fuzzy_like_this" => [
        "fields" => [_all],
        "like_text" =>  $q,
        
    
]
                   ] 
                ]
             ]);

        
          echo '<pre>', print_r($query), '</pre>'; 
          if($query['hits']['total']>=1){
              $results = $query['hits']['hits'];
          }
     }
?>
 
<html>
    <head>
          <meta charset="utf-8">     
          <title> Search | ES </title>
          <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
       <form action="index.php" method="get">
           <label>
                     Search for something
                     <input type="text" name="q" autocomplete=off>
           </label>
           <input type="submit" value="search">
       </form>

    <?php 
          if(isset($results)){
              foreach ($results as $r) { ?>
                 <div class="result">
                      <a href="#<?php echo $r['_id'];?>"><?php echo $r['_source']['title'];?></a>
                      <div class="result-keywords"><?php echo $r['_source']['name']['first'] .' '.$r['_source']['name']['last'];?></div>

                 </div>

              <?php }
          }
  ?>
     
    </body>

</html> 
 