<?php

//1)Iet cauri datubāzei/saņem sarakstu ar lietotājiem
//2) Atrod lietotāju sarakstā/meklē ievadīto lietotāju
//3.1)Salīdzina lietotāja paroli ar ievadīto paroli
//3.1.2)Ja sakrīt, aizsūta uz mapRoutes view
//3.1.3)Ja nesakrīt, atmet atpakaļ
//3.2)Ja neatrod lietotāju, atmet atpakaļ


//Varbūt izmantot kādu gatavu bibliotēku šim
//!!!Pārbaudīt, vai ievadīti ir vārdi, nevis kaut kas cits
$name=$_POST["name"];
$password=$_POST["password"];
echo $name;
$test="asd";
//Kā pārbaudīt, vai name un password ir normāli/nav sql injections?
if(str_contains($name,"asd")){///izdomāt pareizāk
    //atgriež uz login lapu ar kļūdu "Nepareizi ievadīts vārds"header("Location:login.php");
    //    exit;
    ?>
    <form id="login1" action="../views/login.php" method="post">
        <input type="hidden" name="errorCode" value="WUsername">
    </form>
    <script type="text/javascript">
        document.getElementById('login1').submit();
    </script>
<?php
}
else{
    //iegūst sarakstu ar lietotājiem no datubāzes
    $servername = "127.0.0.1";//??
    $username = "admin";
    $password = "password";
    $dbname = "carRoute";
    $port=3306;
    $conn = new mysqli($servername,$username,$password,$dbname,$port);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    //Atrod no datubāzes lietotāju ar tādu pašu vārdu
    $sql = $conn->prepare('SELECT * FROM Users WHERE name = ?');//atgriezt tikai lietotāju, kur sakrīt ar username
    $sql->bind_param('s', $name);
    $sql->execute();
    $result = $sql->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){///Kamēr ir rezultātu rindas(vai vajag, jo vārdam tikai vienam vajadzētu būt
            if($row["name"]==$name){
                $hash=password_hash($password,PASSWORD_DEFAULT);
                if(password_verify($row["password"],$hash)){
                    //atgriež uz home page ar karti
                    header("location:mapRoutes.php");
                    exit;
                }
                else{
                    //pārtrauc ciklu un atgriež uz login screen ar kļūdu "Nepareiza parole"
                    header("location:login.php");
                    exit;?>
                    <form action="views/login.php" method="post">
                        <input type="hidden" name="errorCode" value="WPassword">
                    </form>
                    <?php
                }
            }
        }
    }
    $conn->close();
}