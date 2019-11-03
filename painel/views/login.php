<html>
    <head><title>EAD - Login</title></head>
    <style type="text/css">
        form{
            width: 320px;
            height: 320px;
            background: #DDD;
            margin:auto;
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
        }
        input{
            width: 300px;
            padding: 15px;
            font-size: 14px;
            border: 1px solid #CCC;
        }
    </style>
    <body>
        <form method="POST">
            <h2>Login</h2>
            <input type="email" name="email" required placeholder="Email..."/><br/><br/>
            <input type="password" name="senha" required placeholder="Senha..."/><br><br/>
            <input type="submit"  value="Entrar" />
        </form>        
    </body>
</html>

