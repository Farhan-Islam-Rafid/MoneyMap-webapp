<?php
require_once __DIR__ . '/includes/auth.php'; require_login();
if($_SERVER['REQUEST_METHOD']!=='GET'||!hash_equals($_SESSION['_csrf']??'',$_GET['token']??'')){http_response_code(419);exit('Invalid delete request.');}$id=(int)($_GET['id']??0);$statement=$pdo->prepare('DELETE FROM transactions WHERE id=:id AND user_id=:user_id');$statement->execute(['id'=>$id,'user_id'=>(int)$_SESSION['user_id']]);flash('success',$statement->rowCount()?'Transaction deleted.':'Transaction not found.');redirect('transactions.php');
