<?php
class DB_CONN{
    private $db_host = "";
    private $db_name = "";
    private $db_login = "";
    private $db_pass = "";

    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->db_host,$this->db_login,$this->db_pass,$this->db_name);
        $this->conn->set_charset('utf8');
        $this->conn->query('use $db_name;');
        if($this->conn){
        }else{
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        }
    }

    private function xssafe($data,$encoding='UTF-8')
    {
        return htmlspecialchars($data,ENT_QUOTES | ENT_HTML401,$encoding);
    }

    public function CountUserByLogin($data){
        $login = $this->xssafe($data);
        $stmt = $this->conn->query("SELECT * FROM Users WHERE Login='$login'");

        return $stmt->num_rows;
    }

    public function InsertUser($login,$password,$first_name,$last_name){
        $stmt = $this->conn->prepare("INSERT INTO Users(Login, Password, First_Name, Last_Name) VALUE (?,?,?,?)");
        $login=                     $this->xssafe($login);
        $first_name=                $this->xssafe($first_name);
        $last_name=                 $this->xssafe($last_name);
        $password=password_hash(    $password,PASSWORD_BCRYPT);
        $stmt->bind_param("ssss",$login,$password,$first_name,$last_name);

        if($stmt->execute()){
            return $stmt->insert_id;
        }else{
            return false;
        }
    }

    public function LoginUser($login,$password){
        $id = $this->GetIdByLogin($login);
        $hash = $this->GetHashById($id);
        if(password_verify($password,$hash)){
            return $id;
        }else{
            return false;
        }
    }

    public function GetFirstNameById($id){
        $stmt = $this->conn->prepare("SELECT First_Name FROM Users WHERE Id_User=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        return $res;
        }
    public function GetLastNameById($id){
        $stmt = $this->conn->prepare("SELECT Last_Name FROM Users WHERE Id_User=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        return $res;
        }
    public function GetLoginById($id){
        $stmt = $this->conn->prepare("SELECT Login FROM Users WHERE Id_User=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        return $res;
        }
    private function GetHashById($id){
        $stmt = $this->conn->prepare("SELECT Password FROM Users WHERE Id_User=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        return $res;
        }

    public function GetIdByLogin($login){
        $stmt = $this->conn->prepare("SELECT Id_User FROM Users WHERE Login = ?");
        $stmt->bind_param('s',$login);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        return $res;
    }
    public function GetToDosById($id){
        $stmt = $this->conn->prepare("SELECT * FROM Todos WHERE Author = ? ORDER BY Todos.Display_order ASC");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $res = array();
        $task_no = 0;
        do {
            $stmt->bind_result($res[$task_no]['ID'], $res[$task_no]['Author'], $res[$task_no]['Title'], $res[$task_no]['Add_date'],$res[$task_no]['Cat_id'],$res[$task_no]['Display_order']);
            $task_no++;
        }while ($stmt->fetch());
        array_pop($res);
        return $res;
    }
    public function CheckToDoOwnAuthor($id_a, $id_todo){
        $stmt = $this->conn->prepare("SELECT Title FROM Todos WHERE Author = ? AND Id_todo = ?");
        $stmt->bind_param("ii",$id_a,$id_todo);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function GetTasksById($id){
        $stmt = $this->conn->prepare("SELECT * FROM Tasks WHERE Id_todo=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $res = array();
        $task_no = 0;
        do {
            $stmt->bind_result($res[$task_no]['Id_task'], $res[$task_no]['Id_todo'], $res[$task_no]['Content'], $res[$task_no]['Done']);
            $task_no++;
        }while ($stmt->fetch());
        array_pop($res);
        return $res;

    }

    private function GetDisplayOrderById($id){
        $stmt = $this->conn->prepare("SELECT Display_order FROM Todos WHERE Id_todo = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->bind_result($do);
        $stmt->fetch();
        return $do;
    }

    public function SwapToDos($id1, $id2){
        $do1 = $this->GetDisplayOrderById($id1);
        $do2 = $this->GetDisplayOrderById($id2);

        if($do1 && $do2){
            $q1 = $this->conn->query("UPDATE Todos SET Display_order = $do2 WHERE Id_todo=$id1");
            $q2 = $this->conn->query("UPDATE Todos SET Display_order = $do1 WHERE Id_todo=$id2");

            if($q1 && $q2){
                return true;
            }else{
                return false;
            }
        }
    }
    private function GetTaskStatus($task_id){
        $stmt = $this->conn->prepare("SELECT Done FROM Tasks WHERE Id_task=?");
        $stmt->bind_param('i',$task_id);
        $stmt->execute();
        $stmt->bind_result($res);
        $stmt->fetch();
        return (int)$res;

    }

    public function CheckTaskOwnAuthor($id_task,$id_user){
        $res = $this->conn->query("SELECT Id_task from Tasks JOIN Todos ON Tasks.Id_todo = Todos.Id_todo WHERE Tasks.Id_task=$id_task  AND Author=$id_user");
        if($res->num_rows>0){
            return true;
        }else{
            return false;
        }
    }

    public function ChangeTaskStatus($task_id){

        $status = $this->GetTaskStatus($task_id);
        if($status == 0){
            $this->conn->query("UPDATE Tasks SET Done = 1 WHERE Id_task=$task_id");
            return true;
        }elseif ($status == 1){
            $this->conn->query("UPDATE Tasks SET Done = 0 WHERE Id_task=$task_id");
            return true;
        }else{
            return false;
        }
    }

    public function ChangeTaskContent($id_task,$content){
        $cont = $this->xssafe($content);
        if($this->conn->query("UPDATE Tasks SET Content = '$cont' WHERE Id_task = $id_task") === TRUE){
            return true;
        }else{
            return false;
        }
    }

    public function RemoveTask($id_task){
        if($this->conn->query("DELETE FROM Tasks WHERE Id_task = $id_task") === TRUE){
            return true;
        }else{
            return false;
        }
    }

    public function AddTask($todo_id,$content){
        $cont = $this->xssafe($content);
        $stmt = $this->conn->prepare("INSERT INTO Tasks (Id_todo, Content) VALUES (?,?)");
        $stmt->bind_param("is",$todo_id,$cont);
        $stmt->execute();
        return $this->conn->insert_id;
    }


    public function ChangeToDoTitle($todo_id, $title){
        $titl = $this->xssafe($title);
        $this->conn->query("UPDATE Todos SET Title = '$titl' WHERE Id_todo = $todo_id");
        if($this->conn->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }

    public function RemoveToDo($todo_id){
        $this->conn->query("DELETE FROM Todos WHERE Id_todo = $todo_id");
        if($this->conn->affected_rows>0){
            return true;
        }else{
            return false;
        }
    }

    public function GetLastToDoDisplayOrder($id_author){
        $stmt = $this->conn->query("SELECT Display_order FROM Todos WHERE Author=$id_author ORDER BY Display_order DESC LIMIT 1");
        $last_do = $stmt->fetch_assoc();
        return (int)$last_do['Display_order'];
    }

    public function AddToDo($title, $id_cat, $id_author){
        $titl=$this->xssafe($title);
        $curr_date = date('Y-m-d H:i:s');
        $displ_ord = $this->GetLastToDoDisplayOrder($id_author);
        $displ_ord++;
        $stmt = $this->conn->prepare("INSERT INTO Todos (Author, Title, Add_date, Cat_id,Display_order)  VALUES (?,?, ? ,?,?)");
        $stmt->bind_param('issii', $id_author, $titl, $curr_date, $id_cat,$displ_ord);
        $stmt->execute();
        $response=['date'=>$curr_date,'insert_id'=>$this->conn->insert_id];
        return $response;
    }
}
?>