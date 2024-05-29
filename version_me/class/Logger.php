<?php
class Logger
{
    public function generateLoginForm(string $action = '/', string $username = null, $message = null): void
    {
        ?>
        <?php if ($message): ?>
            <div class="magic-card">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="login-container">
            <div id="form-container">
                <img src="../images/movies.png" alt="image">
                <div class="login-form">
                    <legend>
                        <div id="logo"><span id="first-letter">C</span>ine<span id="first-letter">C</span>ollection</div>
                    </legend>
                    <div class="formulaire">
                        <h2>Bienvenue</h2>
                        <p>Entrer vos identifiants.</p>
                        <form action="<?php echo htmlspecialchars($action); ?>" method="post" id="log-form">
                            <div class="input">
                                <input type="text" id="email" name="email" placeholder="email" value="<?php echo htmlspecialchars($username); ?>">
                                <div class="error"></div>
                            </div>
                            <div class="input">
                                <input type="password" id="password" name="password" placeholder="password">
                                <div class="error"></div>
                            </div>
                            <button type="submit" class="subBtn">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function log(string $username, string $password): array
    {
        $user = "y@b.com";
        $pwd = "youcef";

        $error = null;
        $nick = null;
        $granted = false;

        if (empty($username)) {
            $error = "username is empty";
        } elseif (empty($password)) {
            $error = "password is empty";
        } elseif ($user == $username && $pwd == $password) {
            $granted = true;
            $nick = htmlspecialchars("Gandalf");
        } else {
            $error = "Authentication Failed";
        }

        return [
            'granted' => $granted,
            'nick' => $nick,
            'error' => $error,
        ];
    }
}
