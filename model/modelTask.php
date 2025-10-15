<?php

// connexion pdo

require_once  '../config.php';


//securisé le code 
function secureCode2($input){
        return htmlspecialchars(trim(strip_tags($input)));
}


//---------------------crud---------------------//


//Creation de db pour ajax qui ne passe pas par index
try{ 
    $db = new PDO(DSN, DB_USER, DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

}catch(Exception $e){
    die($e->getMessage());
}


//pour créer un tache
function taskAdd(PDO $db, $title, $comment)
{
    $demande = $db->prepare("insert into `task` (title, comment) values (?,?)");
    try{
        $demande->execute([$title, $comment]);
        $demande->closeCursor();
    }catch(Exception $e){
        die($e->getMessage());
    }   
}

//pour afficher toutes les taches
function taskRead(PDO $db)
{

    try{
        $demande = $db->query("select * from `task`");
        $reponse = $demande->fetchAll();
        $demande->closeCursor();
        header('Content-Type: application/json');
        echo json_encode($reponse);
    }catch(Exception $e){
        die($e->getMessage());
    }
}

//pour modifier une tache
function taskUpdate(PDO $db, $id, $title, $comment)
{
    $demande = $db->prepare("update `task` set title = ?, comment = ? where id = ?");
    try{
        $demande->execute([$title, $comment, $id]);
        $demande->closeCursor();
    }catch(Exception $e){
        die($e->getMessage());
    }   
}


//pour supprimer une tache
function taskDelete(PDO $db, $id)
{
    $demande = $db->prepare("delete from `task` where id = ?");
    try{
        $demande->execute([$id]);
        $demande->closeCursor();
    }catch(Exception $e){
        die($e->getMessage());
    }   
}

if (isset($_GET['task'])){
    if ($_GET['task'] == 'add'){
        $title = secureCode2($_GET['title']);
        $comment = secureCode2($GET['comment']);
        taskAdd($db, $title, $comment);
    }elseif ($_GET['task'] == 'read'){
        taskRead($db);
    }elseif ($_GET['task'] == 'update'){
        $id = secureCode2($GET['id']);
        $title = secureCode2($_GET['title']);
        $comment = secureCode2($GET['comment']);
        taskUpdate($db, $id, $title, $comment);
    }elseif ($_GET['task'] == 'delete'){
        $id = secureCode2($_GET['id']);
        taskDelete($db, $id);
    }
}