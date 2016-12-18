<?php
session_start();
if(isset($_SESSION['Id'],$_POST['action']) && !empty($_POST['action'])){
    $action = $_POST['action'];
    require_once '../includes/user.php';
    $usr = new User();
    $usr->SetVariablesBySession();

    switch ($action){
        case "getToDo":
            $toDos = $usr->GetUserToDos();
            echo json_encode(array("status"=>"success","response"=>"Ok","data"=>$toDos));
            break;
        case "getTasks":
            $idToDo = $_POST['id'];
            $tasks = $usr->GetTaskByToDo($idToDo);
            echo json_encode(array("status"=>$tasks['status'],"response"=>"Ok","data"=>$tasks['data']));
            break;
        case "swapTasks":
            $id1 = $_POST['id1'];
            $id2 = $_POST['id2'];
            $swap = $usr->SwapToDos($id1,$id2);
            echo json_encode($swap);
            break;
        case "changeTaskStatus":
            $id = $_POST['id'];
            $change = $usr->ChangeTaskStatus($id);
            echo json_encode($change);
            break;
        case "changeTaskContent":
            $id = $_POST['id'];
            $content = $_POST['content'];
            $change = $usr->ChangeTaskContent($id,$content);
            echo json_encode($change);
            break;
        case "removeTask":
            $id = $_POST['id'];
            $remove = $usr->RemoveTask($id);
            echo json_encode($remove);
            break;
        case "addTask":
            $todo_id = $_POST['idToDo'];
            $content = $_POST['content'];
            $task = $usr->AddTask($todo_id,$content);
            echo json_encode($task);
            break;
        case "changeToDoTitle":
            $todo_id =  $_POST['idToDo'];
            $title   =  $_POST['title'];
            echo json_encode($usr->ChangeToDoTitle($todo_id,$title));
            break;
        case "removeToDo":
            $todo_id =  $_POST['idToDo'];
            echo json_encode($usr->RemoveToDo($todo_id));
            break;
        case 'addToDo':
            $title  = $_POST['title'];
            $cat_id = $_POST['cat_id'];
            echo json_encode($usr->AddToDo($cat_id,$title));
            break;
        default:
            echo json_encode(array("status"=>"fail","response"=>"Niepoprawne zapytanie"));
            break;
    }

}else{
    echo json_encode(array("status"=>"fail","response"=>"Niepoprawne zapytanie"));
}