<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Web Programming 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="body_login">
    <main class="auth-page">
        <section class="login-card">
            <h1>Login</h1>
            <p>Masuk untuk membuka project Web Programming 1.</p>
            
            <?php if (isset($_GET["error"])): ?>
                <p class="message error" style="color: red; margin-bottom: 10px;">Username atau password salah.</p>
            <?php endif; ?>
            
            <?php if (isset($_GET["logout"])): ?>
                <p class="message" style="color: green; margin-bottom: 10px;">Anda sudah logout.</p>
            <?php endif; ?>
            
            <form action="proses_login.php" method="POST">

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="username" style="display: block; margin-bottom: 5px;">Username</label>
                    <input type="text" id="username" name="username" required autocomplete="username" placeholder="admin = admin, operator = operator" style="width: 100%; padding: 8px ; ">
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="password" style="display: block; margin-bottom: 5px;">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="admin123/operator123" style="width: 100%; padding: 8px;">
                </div class="button-wraper">
                
                <button type="submit" style="padding: 10px 15px; cursor: pointer;">Login</button>
            </form>
        </section>
    </main>
</body>
</html>