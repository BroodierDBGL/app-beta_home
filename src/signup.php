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

    // FEATURE 3: Registro atomico en Local y Supabase
    pg_query($local_conn, "BEGIN");
    pg_query($supa_conn,  "BEGIN");

    //Query to insert into SQL
    $sql = "INSERT INTO users (firstname, lastname, email, mobile_phone, psswd)
               
               values('$f_name', '$l_name', '$e_mail','$m_phone','$enc_pass')";  //values('Pablo', 'Tomson', 'tom@mail.com','300777000','123')";
               

    //Execute query
    $local_result = pg_query($local_conn, $sql);
    $supa_result  = pg_query($supa_conn,  $sql);

    if ($local_result && $supa_result) {
        pg_query($local_conn, "COMMIT");
        pg_query($supa_conn,  "COMMIT");
        echo "Registrado Exitosamente en ambas bases de datos!";
    } else {
        pg_query($local_conn, "ROLLBACK");
        pg_query($supa_conn,  "ROLLBACK");
        echo "Error: El registro fallo. Se deshicieron los cambios en ambas bases de datos.";
    }


    //Para comprobar se usa postman

    /*
    ###Endpoint
    http://127.0.0.1:8080/app-beta/src/signup.php → se inserta en la barra (aparece a plena vista) 
    //                                                        de insert de postman y se despliega GET y
    //                                                        selecciona POST
    */
?>