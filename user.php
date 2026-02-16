<?php
class User {
    
    public $id;
    public $username;
    public $email;
    public $password; 

    public static function findByEmail($email) {
        global $pdo;
        require_once 'config.php';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new User();
            $user->id = $data['id'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = $data['password'];
            return $user;
        }
        return null;
    }

    public static function findById($id) {
        global $pdo;
        require_once 'config.php';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new User();
            $user->id = $data['id'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            return $user;
        }
        return null;
    }
}
?>