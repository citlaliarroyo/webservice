<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\App;
// Obtener todos los estudiantes
$app->get('/api/estudiantes', function(Request $request, Response $response){
	//echo "Estudiantes";
	$sql = "select * from estudiante";
	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiantes = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiantes);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Obtener un estudiante por no de control
$app->get('/api/estudiantes/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');
    $sql = "SELECT * FROM estudiante WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $estudiante = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($estudiante);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar un estudiante
$app->post('/api/estudiantes/add', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_paterno_estudiante');
    $apellidom = $request->getParam('apellido_materno_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave_carrera');
    $sql = "INSERT INTO estudiante (No_control, nombre_estudiante, apellido_paterno_estudiante, apellido_materno_estudiante, semestre, carrera_clave_carrera) VALUES (:No_control, :nombre_estudiante, :apellido_paterno_estudiante, :apellido_materno_estudiante, :semestre, :carrera_clave_carrera)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':No_control',      $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_paterno_estudiante',      $apellidop);
        $stmt->bindParam(':apellido_materno_estudiante',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave_carrera',  $carrera_clave);
        $stmt->execute();
        echo '{"notice": {"text": "Estudiante agregado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar estudiante
$app->put('/api/estudiantes/update/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getParam('No_control');
    $nombre = $request->getParam('nombre_estudiante');
    $apellidop = $request->getParam('apellido_paterno_estudiante');
    $apellidom = $request->getParam('apellido_materno_estudiante');
    $semestre = $request->getParam('semestre');
    $carrera_clave = $request->getParam('carrera_clave_carrera');
    $sql = "UPDATE estudiante SET
                No_control               = :No_control,
                nombre_estudiante       = :nombre_estudiante,
                apellido_paterno_estudiante   = :apellido_paterno_estudiante,
                apellido_materno_estudiante   = :apellido_materno_estudiante,
                semestre                = :semestre,
                carrera_clave_carrera           = :carrera_clave_carrera
            WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':No_control',      $nocontrol);
        $stmt->bindParam(':nombre_estudiante',         $nombre);
        $stmt->bindParam(':apellido_paterno_estudiante',      $apellidop);
        $stmt->bindParam(':apellido_materno_estudiante',      $apellidom);
        $stmt->bindParam(':semestre',       $semestre);
        $stmt->bindParam(':carrera_clave_carrera',  $carrera_clave);
        $stmt->execute();
        echo '{"notice": {"text": "Estudiante actualizado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar estudiante
$app->delete('/api/estudiantes/delete/{No_control}', function(Request $request, Response $response){
    $nocontrol = $request->getAttribute('No_control');
    $sql = "DELETE FROM estudiante WHERE No_control = $nocontrol";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Estudiante eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//Carreras

// Obtener todos las carreras
$app->get('/api/carreras', function(Request $request, Response $response){
	//echo "Carreras";
	$sql = "select * from carrera";
	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $carreras = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($carreras);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Obtener una carrera por clave de carrera
$app->get('/api/carreras/{clave_carrera}', function(Request $request, Response $response){
    $clavecarrera = $request->getAttribute('clave_carrera');
    $sql = "SELECT * FROM carrera WHERE clave_carrera = '".$clavecarrera."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $carrera = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($carrera);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar un carrera
$app->post('/api/carreras/add', function(Request $request, Response $response){
    $clavecarrera = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre_carrera');
    $sql = "INSERT INTO carrera (clave_carrera, nombre_carrera) VALUES (:clave_carrera, :nombre_carrera)";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_carrera',      $clavecarrera);
        $stmt->bindParam(':nombre_carrera',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "Carrera agregada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Actualizar carrera
$app->put('/api/carreras/update/{clave_carrera}', function(Request $request, Response $response){
    $clavecarrera = $request->getParam('clave_carrera');
    $nombre = $request->getParam('nombre_carrera');
    $sql = "UPDATE carrera SET
                clave_carrera        = :clave_carrera,
                nombre_carrera       = :nombre_carrera
            WHERE clave_carrera = '".$clavecarrera."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':clave_carrera',      $clavecarrera);
        $stmt->bindParam(':nombre_carrera',         $nombre);
        $stmt->execute();
        echo '{"notice": {"text": "Carrera actualizada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Borrar carrera
$app->delete('/api/carreras/delete/{clave_carrera}', function(Request $request, Response $response){
    $clavecarrera = $request->getAttribute('clave_carrera');
    $sql = "DELETE FROM carrera WHERE clave_carrera = '".$clavecarrera."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Carrera eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//departamento
// Obtener todos los departamentos

$app->get('/api/departamentos', function(Request $request, Response $response){
	//echo "departamento";
	$sql = "select * from departamento";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $departamentos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($departamento);
      print_r($departamentos);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->get('/api/departamentos/{ClaveDepa}', function(Request $request, Response $response){
    $ClaveDepa = $request->getAttribute('ClaveDepa');
    $sql = "SELECT * FROM departamento WHERE ClaveDepa = '".$ClaveDepa."'";
    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();
        $stmt = $db->query($sql);
        $departamento = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($departamento);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar un departamento
$app->post('/api/departamentos/add', function(Request $request, Response $response){
    $ClaveDepa = $request->getParam('ClaveDepa');
    $nombre_depa = $request->getParam('nombre_depa');
		$trabajador_rfc = $request->getParam('trabajador_rfc');


    $sql = "INSERT INTO departamento (ClaveDepa, nombre_depa, trabajador_rfc) VALUES (:ClaveDepa, :nombre_depa, :trabajador_rfc)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ClaveDepa', $ClaveDepa);
        $stmt->bindParam(':nombre_depa',$nombre_depa);
				$stmt->bindParam(':trabajador_rfc',$trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar departamento
$app->put('/api/departamentos/update/{ClaveDepa}', function(Request $request, Response $response){
    $ClaveDepa = $request->getParam('ClaveDepa');
    $nombre_depa = $request->getParam('nombre_depa');
		$trabajador_rfc=$request->getParam('trabajador_rfc');


    $sql = "UPDATE departamento SET
                ClaveDepa        = :ClaveDepa,
                nombre_depa       = :nombre_depa,
								trabajador_rfc = :trabajador_rfc

            WHERE ClaveDepa = '".$ClaveDepa."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ClaveDepa',   $ClaveDepa);
        $stmt->bindParam(':nombre_depa',  $nombre_depa);
				$stmt->bindParam(':trabajador_rfc',  $trabajador_rfc);


        $stmt->execute();

        echo '{"notice": {"text": "departamento actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar departamento
$app->delete('/api/departamentos/delete/{ClaveDepa}', function(Request $request, Response $response){
    $ClaveDepa = $request->getAttribute('ClaveDepa');

    $sql = "DELETE FROM departamento WHERE ClaveDepa = '".$ClaveDepa."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "departamento eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//trabajor
//todos los trabajadores
$app->get('/api/trabajadores', function(Request $request, Response $response){
    //echo "trabajador";
    $sql = "select * from trabajador";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajadores = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($trabajador);
        print_r($trabajadores);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Obtener un trabajador por rfc
$app->get('/api/trabajadores/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "SELECT * FROM trabajador WHERE rfc_trabajador = '".$rfc_trabajador."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $trabajadores = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($trabajadores);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un trabajador
$app->post('/api/trabajadores/add', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_paterno_trabajador = $request->getParam('apellido_paterno_trabajador');
    $apellido_materno_trabajador = $request->getParam('apellido_materno_trabajador');

    $sql = 	"INSERT INTO trabajador (rfc_trabajador, nombre_trabajador,apellido_paterno_trabajador,apellido_materno_trabajador) VALUES (:rfc_trabajador,:nombre_trabajador,:apellido_paterno_trabajador,:apellido_materno_trabajador)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',          $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',       $nombre_trabajador);
        $stmt->bindParam(':apellido_paterno_trabajador',              $apellido_paterno_trabajador);
        $stmt->bindParam(':apellido_materno_trabajador',              $apellido_materno_trabajador);


        $stmt->execute();

        echo '{"notice": {"text": "trabajador agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar trabajador
$app->put('/api/trabajadores/update/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getParam('rfc_trabajador');
    $nombre_trabajador = $request->getParam('nombre_trabajador');
    $apellido_paterno_trabajador = $request->getParam('apellido_paterno_trabajador');
    $apellido_materno_trabajador = $request->getParam('apellido_materno_trabajador');



    $sql = "UPDATE trabajador SET
           rfc_trabajador            = :rfc_trabajador,
           nombre_trabajador         = :nombre_trabajador,
           apellido_paterno_trabajador                = :apellido_paterno_trabajador,
           apellido_materno_trabajador                = :apellido_materno_trabajador


            WHERE rfc_trabajador = '".$rfc_trabajador."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':rfc_trabajador',   $rfc_trabajador);
        $stmt->bindParam(':nombre_trabajador',  $nombre_trabajador);
        $stmt->bindParam(':apellido_paterno_trabajador',   $apellido_paterno_trabajador);
        $stmt->bindParam(':apellido_materno_trabajador',   $apellido_materno_trabajador);


        $stmt->execute();

        echo '{"notice": {"text": "trabajor actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar trabajador
$app->delete('/api/trabajadores/delete/{rfc_trabajador}', function(Request $request, Response $response){
    $rfc_trabajador = $request->getAttribute('rfc_trabajador');

    $sql = "DELETE FROM trabajador WHERE rfc_trabajador = '".$rfc_trabajador."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "trabajador eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// instituto
$app->get('/api/institutos', function(Request $request, Response $response){
    //echo "institutos";
    $sql = "select * from instituto";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $institutos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //  echo json_encode($institu);
        print_r($institutos);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Obtener un instituto por no de clave
$app->get('/api/institutos/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "SELECT * FROM instituto WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $institutos = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($institutos);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Agregar un instituto
$app->post('/api/institutos/add', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');


    $sql = 	"INSERT INTO instituto (clave_instituto, nombre_instituto) VALUES (:clave_instituto, :nombre_instituto)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',      $clave_instituto);
        $stmt->bindParam(':nombre_instituto',         $nombre_instituto);


        $stmt->execute();

        echo '{"notice": {"text": "instituto agregado"}';

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Actualizar instituto
$app->put('/api/institutos/update/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getParam('clave_instituto');
    $nombre_instituto = $request->getParam('nombre_instituto');

    $sql = "UPDATE instituto SET
                clave_instituto        = :clave_instituto,
                nombre_instituto       = :nombre_instituto


            WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_instituto',   $clave_instituto);
        $stmt->bindParam(':nombre_instituto',  $nombre_instituto);



        $stmt->execute();

        echo '{"notice": {"text": "instituto actualizado"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar instituto
$app->delete('/api/institutos/delete/{clave_instituto}', function(Request $request, Response $response){
    $clave_instituto = $request->getAttribute('clave_instituto');

    $sql = "DELETE FROM instituto WHERE clave_instituto = '".$clave_instituto."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "instituto eliminado"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//actividadescomplementarias

$app->get('/api/actividades', function(Request $request, Response $response){
	//echo "materias";
	$sql = "select * from act_complementaria";

	try{
		// Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $actividades = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
      //  echo json_encode($carrera);
      print_r($actividades);
	} catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
$app->get('/api/actividades/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "SELECT * FROM act_complementaria WHERE clave_act = '".$clave_act."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->query($sql);
        $actividades = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($actividades);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// Agregar una actividad
$app->post('/api/actividades/add', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_act = $request->getParam('nombre_act');


    $sql = "INSERT INTO act_complementaria (clave_act, nombre_act) VALUES (:clave_act, :nombre_act)";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act', $clave_act);
        $stmt->bindParam(':nombre_act',$nombre_act);


        $stmt->execute();

        echo '{"notice": {"text": "carrera agregada"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Actualizar carrera
$app->put('/api/actividades/update/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getParam('clave_act');
    $nombre_act = $request->getParam('nombre_act');


    $sql = "UPDATE act_complementaria SET
                clave_act        = :clave_act,
                nombre_act       = :nombre_act

            WHERE clave_act = '".$clave_act."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':clave_act',   $clave_act);
        $stmt->bindParam(':nombre_act',  $nombre_act);


        $stmt->execute();

        echo '{"notice": {"text": "actividades actualizadas"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Borrar actividades
$app->delete('/api/actividades/delete/{clave_act}', function(Request $request, Response $response){
    $clave_act = $request->getAttribute('clave_act');

    $sql = "DELETE FROM act_complementaria WHERE clave_act = '".$clave_act."'";

    try{
        // Obtener el objeto DB
        $db = new db();
        // Conectar
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "actividad eliminada"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
