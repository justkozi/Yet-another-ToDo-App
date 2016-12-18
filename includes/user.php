<?php
session_start();
class User
{
    private $IdUser,
            $Login,
            $Password,
            $First_Name,
            $Last_Name;

    public function setIdUser($IdUser){$this->IdUser = $IdUser;}
    public function setLogin($Login){$this->Login = $Login;}
    public function setPassword($Password){$this->Password = $Password;}
    public function setFirstName($First_Name){$this->First_Name = $First_Name;}
    public function setLastName($Last_Name){$this->Last_Name = $Last_Name;}

    public function getIdUser(){return $this->IdUser;}
    public function getLogin(){return $this->Login;}
    public function getPassword(){return $this->Password;}
    public function getFirstName(){return $this->First_Name;}
    public function getLastName(){return $this->Last_Name;}

    private function SetVariables(){
        $id = $this->IdUser;
        $this->setLogin($this->GetLoginById($id));
        $this->setFirstName($this->GetFirstNameById($id));
        $this->setLastName($this->GetLastNameById($id));
    }

    public function SetVariablesBySession(){
        $this->setIdUser($_SESSION['Id']);
        $this->SetVariables();
    }

    private function GetLoginById($id)
    {
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        return $dbh->GetLoginById($id);
    }

    private function GetFirstNameById($id)
    {
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        return $dbh->GetFirstNameById($id);
    }

    private function GetLastNameById($id)
    {
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        return $dbh->GetLastNameById($id);
    }

    public function InsertUser()
    {
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $login = $this->getLogin();
        if ($dbh->CountUserByLogin($login) > 0) {
            $response['status'] = 'fail';
            $response['messege'] = "Istnieje już użytkownik o loginie $login";
            return $response;
        } else {
            $login = $this->getLogin();
            $password = $this->getPassword();
            $first_name = $this->getFirstName();
            $last_name = $this->getLastName();

            if ($id = $dbh->InsertUser($login, $password, $first_name, $last_name)) {
                $response['status'] = 'success';
                $response['messege'] = 'Pomyślnie dodano użytkownika ' . $this->getFirstName() . " " . $this->getLastName();
                $this->setIdUser($id);
                return $response;
            } else {
                $response['status'] = 'fail';
                $response['messege'] = "Błąd przy dodawaniu do bazy danych.";
                return $response;
            }
        }

    }

    public function SetSessionVariables()
    {
        $_SESSION['Id'] = $this->getIdUser();
    }

    public function AuthenticateUser($login,$password){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $id = $dbh->LoginUser($login, $password);
        if ($id > 0) {
            $this->setIdUser($id);
            $this->SetSessionVariables();
            $this->SetVariables();
            return true;
        } else {
            return false;
        }
    }

    public function GetUserToDos(){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $id = $this->getIdUser();
        $todos = $dbh->GetToDosById($id);
        return $todos;
    }

    public function GetTaskByToDo($id){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $valid_id = $dbh->CheckToDoOwnAuthor($this->getIdUser(),$id);

        if($valid_id == true){
            $tasks = $dbh->GetTasksById($id);
            $response['data'] = $tasks;
            $response['status'] = "success";
            $id_usr = $this->getIdUser();
            $response['messege'] = "Zadania dla Todo: $id, utworzonego przez $id_usr";
            return $response;
        }else{
            $response['messege'] = "Niepoprawne zapytanie";
            return $response;
        }
    }

    public function SwapToDos ($id1,$id2){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $valid_id1 = $dbh->CheckToDoOwnAuthor($this->getIdUser(),$id1);
        $valid_id2 = $dbh->CheckToDoOwnAuthor($this->getIdUser(),$id2);
        if($valid_id1 == true && $valid_id2==true){
            if($dbh->SwapToDos($id1,$id2)){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje ToDo";
        }
        return $response;
    }

    public function ChangeTaskStatus($task_id){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        if($dbh->CheckTaskOwnAuthor($task_id,$this->getIdUser())){
            if($dbh->ChangeTaskStatus($task_id)){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje zadanie...";
        }
        return $response;

    }

    public function ChangeTaskContent($task_id,$content){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        if($dbh->CheckTaskOwnAuthor($task_id,$this->getIdUser())){
            if($dbh->ChangeTaskContent($task_id,$content)){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje zadanie...";
        }
        return $response;
    }

    public function RemoveTask($task_id){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        if($dbh->CheckTaskOwnAuthor($task_id,$this->getIdUser())){
            if($dbh->RemoveTask($task_id)){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje zadanie...";
        }
        return $response;
    }

    public function AddTask($todo_id, $content){
        require_once 'functions.php';
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $valid_id = $dbh->CheckToDoOwnAuthor($this->getIdUser(),$todo_id);
        if($valid_id == true){
            $id = $dbh->AddTask($todo_id,$content);
            if($id){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
                $task = [
                    'Id_task'=>$id,
                    'Done'=>0,
                    'Content'=>xssafe($content),
                    'Id_todo'=>$todo_id
                ];
                $response['data'] = $task;
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje ToDo";
        }
        return $response;
    }

    public function ChangeToDoTitle($todo_id,$title){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $valid_id = $dbh->CheckToDoOwnAuthor($this->getIdUser(),$todo_id);
        if($valid_id == true){
            if($dbh->ChangeToDoTitle($todo_id,$title)){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje ToDo";
        }
        return $response;
    }

    public function RemoveToDo($todo_id){
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $valid_id = $dbh->CheckToDoOwnAuthor($this->getIdUser(),$todo_id);
        if($valid_id == true){
            if($dbh->RemoveToDo($todo_id)){
                $response['status'] = 'success';
                $response['messege'] = 'Ok';
            }else{
                $response['messege'] = 'Złe zapytanie';
            }
        }else{
            $response['messege'] = "To nie Twoje ToDo";
        }
        return $response;
    }

    public function AddToDo($cat_id,$title){
        require_once 'functions.php';
        require_once 'dbh.php';
        $dbh = new DB_CONN();
        $response = Array(
            'status' => 'fail',
            'messege' => ''
        );
        $add_data = $dbh->AddToDo($title,$cat_id,$this->getIdUser());
        if($add_data['insert_id'] > 0){
            $response['status'] = 'success';
            $response['messege'] = 'Ok';
            $todo = [
                'Cat_id'=>$cat_id,
                'Add_date'=>$add_data['date'],
                'ID'=>$add_data['insert_id'],
                'Title'=>xssafe($title)
            ];
            $response['data'] = $todo;

        }else{
            $response['messege'] = 'Złe zapytanie';
        }
        return $response;
    }


}