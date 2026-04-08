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

    // FEATURE 2: Validar unicidad del celular
    $phone_check = pg_query($local_conn, "SELECT id FROM users WHERE mobile_phone = '$m_phone'");

    if (pg_num_rows($phone_check) > 0) {
        echo "Error: El celular '$m_phone' ya esta registrado. Use un numero diferente.";
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