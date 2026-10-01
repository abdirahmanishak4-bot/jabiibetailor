<?php
if (file_get_contents('function.php') == '') {
	header('Location: '.'/install/');
}
require_once('function.php');
session_start();

if (is_user()) {
	redirect('home.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign In &middot; Jabiibe Tailor Management System</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

<style>
    :root{
        --brand:#0d9488;
        --brand-dark:#0f766e;
        --brand-light:#2dd4bf;
        --ink:#1e293b;
        --muted:#94a3b8;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{
        font-family:'Poppins',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:24px;
        color:var(--ink);
        background:linear-gradient(135deg,#0f766e 0%,#0d9488 50%,#0891b2 100%);
        position:relative;
        overflow:hidden;
    }
    /* Floating decorative blobs */
    body::before,body::after{
        content:'';
        position:absolute;
        border-radius:50%;
        filter:blur(8px);
        opacity:.35;
        z-index:0;
    }
    body::before{
        width:420px;height:420px;
        background:radial-gradient(circle,#fff,transparent 70%);
        top:-160px;right:-120px;
        animation:float 9s ease-in-out infinite;
    }
    body::after{
        width:360px;height:360px;
        background:radial-gradient(circle,#5eead4,transparent 70%);
        bottom:-140px;left:-100px;
        animation:float 11s ease-in-out infinite reverse;
    }
    @keyframes float{
        0%,100%{transform:translateY(0) translateX(0);}
        50%{transform:translateY(-30px) translateX(20px);}
    }

    .login-shell{
        position:relative;
        z-index:1;
        width:100%;
        max-width:940px;
        display:flex;
        align-items:stretch;
        background:rgba(255,255,255,.97);
        backdrop-filter:blur(14px);
        border:1px solid rgba(255,255,255,.6);
        border-radius:26px;
        box-shadow:0 30px 60px -12px rgba(30,27,75,.45);
        overflow:hidden;
        animation:rise .6s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes rise{
        from{opacity:0;transform:translateY(28px) scale(.97);}
        to{opacity:1;transform:none;}
    }

    /* ===== Left welcome / brand panel ===== */
    .login-brand{
        flex:0 0 44%;
        position:relative;
        padding:48px 40px;
        background:linear-gradient(160deg,var(--brand-dark) 0%,var(--brand) 65%,var(--brand-light) 140%);
        color:#fff;
        display:flex;
        flex-direction:column;
        justify-content:center;
        overflow:hidden;
    }
    .login-brand::before{
        content:'';
        position:absolute;
        width:280px;height:280px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.18),transparent 70%);
        top:-90px;left:-90px;
    }
    .login-brand::after{
        content:'\f0c9';
        font-family:'FontAwesome';
        position:absolute;
        font-size:220px;
        right:-40px;
        bottom:-50px;
        color:rgba(255,255,255,.06);
        transform:rotate(-15deg);
    }
    .brand-badge{
        position:relative;
        z-index:1;
        width:64px;height:64px;
        margin-bottom:22px;
        border-radius:18px;
        display:flex;align-items:center;justify-content:center;
        font-size:27px;color:#fff;
        background:rgba(255,255,255,.14);
        border:1px solid rgba(255,255,255,.3);
        box-shadow:0 10px 22px -8px rgba(0,0,0,.35);
    }
    .brand-eyebrow{
        position:relative;z-index:1;
        display:inline-flex;
        align-items:center;
        gap:8px;
        font-size:11.5px;
        font-weight:600;
        letter-spacing:1.6px;
        text-transform:uppercase;
        color:#99f6e4;
        margin-bottom:14px;
        opacity:.95;
    }
    .brand-eyebrow::before{
        content:'';
        width:22px;height:2px;
        background:#99f6e4;
        border-radius:2px;
    }
    .login-brand h1{
        position:relative;z-index:1;
        font-size:30px;
        font-weight:700;
        letter-spacing:-.4px;
        line-height:1.25;
        margin-bottom:14px;
    }
    .login-brand h1 span{
        display:block;
        font-weight:800;
        font-size:22px;
        color:#99f6e4;
        letter-spacing:.2px;
        margin-top:2px;
    }
    .login-brand p.welcome-copy{
        position:relative;z-index:1;
        font-size:14.5px;
        line-height:1.7;
        color:rgba(255,255,255,.85);
        max-width:340px;
        margin-bottom:30px;
    }
    .brand-features{
        position:relative;z-index:1;
        list-style:none;
        display:flex;
        flex-direction:column;
        gap:14px;
    }
    .brand-features li{
        display:flex;
        align-items:center;
        gap:12px;
        font-size:13.5px;
        font-weight:500;
        color:rgba(255,255,255,.92);
    }
    .brand-features li i{
        width:34px;height:34px;
        flex:0 0 34px;
        display:flex;align-items:center;justify-content:center;
        border-radius:10px;
        background:rgba(255,255,255,.14);
        font-size:14px;
    }

    /* ===== Right form panel ===== */
    .login-card{
        flex:1 1 auto;
        padding:48px 44px;
        display:flex;
        flex-direction:column;
        justify-content:center;
    }

    .login-card h2{
        font-size:23px;
        font-weight:600;
        letter-spacing:-.3px;
    }
    .login-card .subtitle{
        color:var(--muted);
        font-size:14px;
        margin-top:6px;
        margin-bottom:28px;
    }

    .alert-error{
        display:flex;align-items:center;gap:10px;
        background:#fef2f2;
        border:1px solid #fecaca;
        color:#b91c1c;
        font-size:13.5px;
        padding:12px 14px;
        border-radius:12px;
        margin-bottom:20px;
    }
    .alert-error i{font-size:15px;}

    .field{position:relative;margin-bottom:18px;}
    .field .field-icon{
        position:absolute;
        left:16px;top:50%;transform:translateY(-50%);
        color:var(--muted);
        font-size:15px;
        transition:color .2s;
    }
    .field input{
        width:100%;
        height:52px;
        border:1.5px solid #e2e8f0;
        border-radius:13px;
        padding:0 46px 0 44px;
        font-size:15px;
        font-family:inherit;
        color:var(--ink);
        background:#f8fafc;
        outline:none;
        transition:border-color .2s,background .2s,box-shadow .2s;
    }
    .field input::placeholder{color:#cbd5e1;}
    .field input:focus{
        border-color:var(--brand);
        background:#fff;
        box-shadow:0 0 0 4px rgba(13,148,136,.14);
    }
    .field input:focus + .field-icon,
    .field input:focus ~ .field-icon{color:var(--brand);}

    .toggle-pass{
        position:absolute;
        right:14px;top:50%;transform:translateY(-50%);
        border:none;background:none;cursor:pointer;
        color:var(--muted);font-size:15px;padding:6px;
        transition:color .2s;
    }
    .toggle-pass:hover{color:var(--brand);}

    .btn-login{
        width:100%;
        height:52px;
        border:none;
        border-radius:13px;
        font-size:15.5px;
        font-weight:600;
        letter-spacing:.3px;
        color:#fff;
        cursor:pointer;
        margin-top:6px;
        background:linear-gradient(135deg,var(--brand),var(--brand-dark));
        box-shadow:0 12px 24px -8px rgba(13,148,136,.7);
        transition:transform .15s,box-shadow .2s,filter .2s;
    }
    .btn-login:hover{transform:translateY(-2px);box-shadow:0 16px 30px -8px rgba(13,148,136,.8);filter:brightness(1.05);}
    .btn-login:active{transform:translateY(0);}

    .login-footer{
        text-align:center;
        margin-top:24px;
        font-size:12.5px;
        color:var(--muted);
    }

    @media (max-width:900px){
        .login-brand{display:none;}
        .login-shell{max-width:420px;}
        .login-card{padding:44px 38px 38px;}
    }
</style>
    </head>

    <body>

        <div class="login-shell">

            <div class="login-brand">
                <div class="brand-badge"><i class="fa fa-scissors"></i></div>
                <span class="brand-eyebrow">Jabiibe Tailor</span>
                <h1>Welcome to<span>Jabiibe Tailor Management System</span></h1>
            </div>

            <div class="login-card">
                <h2>Sign In</h2>
                <p class="subtitle">Welcome back! Sign in to your admin account</p>

                <?php if (!empty($_GET['error'])): ?>
                    <div class="alert-error">
                        <i class="fa fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                    </div>
                <?php endif ?>

                <form role="form" action="signin_post.php" method="post" class="registration-form">

                    <div class="field">
                        <input type="text" name="username" placeholder="Username" autocomplete="username" required autofocus>
                        <i class="fa fa-user field-icon"></i>
                    </div>

                    <div class="field">
                        <input type="password" name="password" id="password" placeholder="Password" autocomplete="current-password" required>
                        <i class="fa fa-lock field-icon"></i>
                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                            <i class="fa fa-eye"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-login">Sign In</button>
                </form>

                <p class="login-footer">&copy; <?php echo date('Y'); ?> Jabiibe Tailor. All rights reserved.</p>
            </div>

        </div>

        <script>
            (function(){
                var btn = document.getElementById('togglePass');
                var pass = document.getElementById('password');
                btn.addEventListener('click', function(){
                    var icon = btn.querySelector('i');
                    if(pass.type === 'password'){
                        pass.type = 'text';
                        icon.className = 'fa fa-eye-slash';
                    } else {
                        pass.type = 'password';
                        icon.className = 'fa fa-eye';
                    }
                });
            })();
        </script>

    </body>
</html>
