<?php

class Login {
    public static function generateLoginForm(string $action)
    {
        ?>        
            <form action="<?php $action ?>" method="post" id="log-form">
                <div class="input">
                    <input type="text" id="email" name="email" placeholder="email">
                </div>
                <div class="input">
                    <input type="password" id="password" name="password" placeholder="password">
                </div>
                <button type="submit" class="subBtn">Se connecter</button>
            </form>
        <?php
    }

    public static function log(string $username, string $password): array {
        $response = array();
    
        // Vérifier si le nom d'utilisateur et le mot de passe sont vides
        if (empty($username)) {
            $response['granted'] = false;
            $response['error'] = "username is empty";
            return $response;
        }
    
        if (empty($password)) {
            $response['granted'] = false;
            $response['error'] = "password is empty";
            return $response;
        }
    
        // Comparer avec les informations attendues
        $expectedUsername = "yacine";
        $expectedPassword = "yacine";
    
        if ($username === $expectedUsername && $password === $expectedPassword) {
            $response['granted'] = true;
            $response['error'] = null;
        } else {
            $response['granted'] = false;
            $response['error'] = "authentication failed";
        }
    
        return $response;
    }    
}

?>
