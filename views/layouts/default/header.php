<!DOCTYPE html>
<html>
<head>
    <title>Forum<?php if(isset($this->title)) echo ' - ' . htmlspecialchars($this->title) ?></title>
    <link rel="stylesheet" type="text/css" href="/content/style.css"/>
    <link rel="stylesheet" type="text/css" href="/library/bootstrap/bootstrap.min.css"/>
    <meta charset="utf-8"/>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="navbar navbar-default ">
            <div class="container">
                <div class="navbar-header">

                    <a href="/"><img src="/content/images/logo.png" alt="Logo"/></a>
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul id="menu" class="nav navbar-nav navbar-right">
                        <li><a href="/">Home</a></li>
                        <li><a href="/questions">Questions</a></li>
                        <li><a href="/category">Category</a></li>
                        <?php if(isset($_SESSION['username'])) : ?>
                            <li><span id="username" class="btn btn-primary disabled"><?= htmlspecialchars($_SESSION['username']) ?></span></li>
                            <li><a href="/accounts/logout">Logout</a></li>
                        <?php else : ?>
                            <li><a class="btn-danger" href="/accounts/login">Login</a></li>
                            <li><a class="btn-primary" href="/accounts/register">Register</a></li>
                        <?php endif ?>
                    </ul>

                </div>
            </div>
        </div>
    </header>

    <?php include('messages.php'); ?>

    <main>



