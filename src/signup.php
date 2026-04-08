<?php
    //1. recibe metodo de envio por post
    include('../config/database.php');

    //2. Get data
    $f_name  = $_POST ['fname'];
    $l_name  = $_POST ['lname'];
    $e_mail  = $_POST ['email'];
    $m_phone = $_POST ['mphone'];
    $p_sswd  = $_POST ['psswd'];
    $enc_pass = md5($p_sswd);

    // FEATURE 1: Validar unicidad del email
    $email_check = pg_query($local_conn, "SELECT id FROM users WHERE email = '$e_mail'");

    if (pg_num_rows($email_check) > 0) {
        echo "Error: El correo '$e_mail' ya esta registrado. Use un correo diferente.";
        exit();
    }

    //Query to insert into SQL
    $sql = "INSERT INTO users (firstname, lastname, email, mobile_phone, psswd)
               
               values('$f_name', '$l_name', '$e_mail','$m_phone','$enc_pass')";  //values('Pablo', 'Tomson', 'tom@mail.com','300777000','123')";
               

    //Execute query
    $result = pg_query($local_conn, $sql);

    if (!$result) {
        echo "Error al registrar el usuario.";
    } else {
        echo "Registrado Exitosamente!";
    }

    //Para comprobar se usa postman

    /*
    ###Endpoint
    http://127.0.0.1:8080/app-beta/src/signup.php → se inserta en la barra (aparece a plena vista) 
    //                                                        de insert de postman y se despliega GET y
    //                                                        selecciona POST
    */
?>