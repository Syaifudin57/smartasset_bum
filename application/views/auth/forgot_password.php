<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password - SmartAsset BUM</title>
</head>

<body style="background-color: #f57c00; display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="background: white; padding: 30px; border-radius: 10px;">
        <h3>Reset Password</h3>
        <form method="post" action="<?= base_url('auth/forgot_password') ?>">
            <input type="text" name="username" placeholder="Masukkan Username" required><br><br>
            <button type="submit">Reset Password</button>
        </form>
        <p style="color: gray;">Password akan direset menjadi <strong>123456</strong></p>
        <a href="<?= base_url('auth') ?>">Kembali ke Login</a>
    </div>
</body>

</html>