<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo APP_DESC ?>">
        <meta name="generator" content="Hugo 0.104.2">
        <title>Signup · <?php echo APP_NAME ?></title>

        <link href="<?php echo ROOT ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo ROOT ?>/assets/css/bootstrap-icons.min.css" rel="stylesheet">

        <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        </style>

        
        <!-- Custom styles for this template -->
        <link href="<?php echo ROOT ?>/assets/css/signin.css" rel="stylesheet">
    </head>
    <body class="text-center">
        
        <main class="form-signin w-100 m-auto">
        <form method="post">
            <i class="h1 mb-4 bi bi-person-circle"></i>
            <h1 class="h3 mb-3 fw-normal">Enter your details to sign-up</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger text-center">Please fix the error</div>
            <?php endif; ?>

            <div class="form-floating">
                <input value="<?php echo old_value_input('username') ?>" name="username" type="username" class="form-control" id="floatingInput" placeholder="username">
                <label for="floatingInput">Username</label>
            </div>
            <?php if (!empty($errors['username'])): ?>
                <div class="text-danger"><?php echo $errors['username'] ?></div>
            <?php endif; ?>

            <div class="form-floating">
                <input value="<?php echo old_value_input('email') ?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <?php if (!empty($errors['email'])): ?>
                <div class="text-danger"><?php echo $errors['email'] ?></div>
            <?php endif; ?>

            <div class="form-floating">
                <input value="<?php echo old_value_input('password') ?>" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <?php if (!empty($errors['password'])): ?>
                <div class="text-danger"><?php echo $errors['password'] ?></div>
            <?php endif; ?>

            <div class="checkbox mb-3">
                <label>
                    <input <?php echo old_checked_input('term', 1) ?> type="checkbox" name="terms" value="1"> Accept terms
                </label>
                <?php if (!empty($errors['terms'])): ?>
                    <div class="text-danger"><?php echo $errors['terms'] ?></div>
                <?php endif; ?>
            </div>

            <div class="form-floating mb-3">
                Already have an account?! <a href="<?php echo ROOT ?>/login">Login here</a>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Create account</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
        </form>
        </main>
    </body>
</html>
