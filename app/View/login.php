<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <form action="/login" method="post">
            <h2>Login Page</h2>
            <div class="input-box">
                <?php echo $errors['email'] ?? ''; ?>
                <input type="email"  name="email" placeholder="Email" >
            </div>
            <div class="input-box">
                <?php echo $errors['password'] ?? ''; ?>
            <input type="password" name="password"  placeholder="Password">
            </div>
            <div class="input-box button">
                <input type="Submit" value="Login">
            </div>
            <div class="text">
            </div>
            <div class="text">
            <h3>Create account?<a href="/registrate"> Create</a></h3>
            </div>
        </form>
    </div>
</div>
</body>