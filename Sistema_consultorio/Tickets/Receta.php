<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];

	# Incluyendo librerias necesarias #
    require "./code128.php";

    #conexion con las base de datos sustanciales
    $Select_com_abas= "SELECT * FROM recetas WHERE Folio_cita = '$folio'";
    $comprobante_abastecimiento = mysqli_query($link, $Select_com_abas);
    $comprobante = mysqli_fetch_array($comprobante_abastecimiento);
    $user = $comprobante['ID_usuario'];
    $patient = $comprobante['CURP_Paciente'];

    $Select_usuario= "SELECT * FROM usuarios WHERE ID_usuario = '$user'";
    $usuarios = mysqli_query($link, $Select_usuario);
    $usuario = mysqli_fetch_array($usuarios);

    $Select_paciente= "SELECT * FROM paciente WHERE Curp_paciente = '$patient'";
    $pacientes = mysqli_query($link, $Select_paciente);
    $paciente = mysqli_fetch_array($pacientes);

    $pdf = new PDF_Code128('P','mm',array(257,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',13);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(80,5,utf8_decode(strtoupper("informacion del medico: ")),0,0,'C');
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(90,0,utf8_decode("RECETA MEDICA CONSULTORIO MEDICO"),0,0,'C');
    $pdf->MultiCell(0,5,utf8_decode("SUCURSAL:"),7,'C',false);
    $pdf->Cell(80,10,utf8_decode("Medico: ".$usuario['Nombre_completo_usuario']),0,0,'C');
    $pdf->MultiCell(255,8,utf8_decode("Direccion: ###########, ##########"),0,'C',false);
    $pdf->Cell(80,7,utf8_decode("Cedula Profesional No. ".$usuario['ID_usuario']),0,0,'C');
    $pdf->MultiCell(255,6,utf8_decode("Teléfono: 3344556677"),0,'C',false);
    $pdf->Cell(80,10,utf8_decode("Fecha de prescripcion: ".$comprobante['Fecha_prescripcion']),0,0,'C');
    $pdf->MultiCell(255,6,utf8_decode("Email: correo@ejemplo.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,3,utf8_decode("______________________________________________________________________________________________________"),0,0,'C');
    $pdf->Ln(5);

    $pdf->SetFont('Times','B',15);
    $pdf->Cell(140,13,utf8_decode("Paciente: ".$paciente['Nombre_completo_paciente']),0,0,'C');
    
    $edad = "SELECT SUBSTRING((CURDATE())-(Fecha_nacimiento),1,2) AS Edad_actual FROM paciente WHERE Curp_paciente = '$patient';"; 
    $edad_actual = mysqli_query($link, $edad);
    $age = mysqli_fetch_array($edad_actual);        

    $pdf->MultiCell(100,12,utf8_decode("EDAD: ".$age['Edad_actual']),0,'C',false);
    
    $pdf->Ln(3);
    $pdf->SetFont('Times','',14);

    $pdf->Ln(1);
    $pdf->Cell(0,-10,utf8_decode("__________________________________________________________________________________________"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(70,5,utf8_decode("Peso:  ".$comprobante['Peso'].' Kg.'),0,0,'C');
    $pdf->Cell(35,5,utf8_decode("Altura:  ".$comprobante['Altura'].' Mts.'),0,0,'C');
    $pdf->Cell(70,5,utf8_decode("Temperatura:  ".$comprobante['Temperatura'].' °C.'),0,0,'C');
    $pdf->Cell(45,5,utf8_decode("Pulso cardiaco:  ".$comprobante['Pulso'].'  P/S.'),0,0,'C');


    $pdf->Ln(13);
    $pdf->MultiCell(0,4,utf8_decode("Alergias:  ".$comprobante['Alergias'].'.'),0,'C',false);
    $pdf->Ln(3);

    $pdf->SetFont('Times', 'B', 15);
    $pdf->Cell(70, 8,utf8_decode("Medicamentos recetados:"),0,0,'C');
    $pdf->SetFont('Times','',13);
    $pdf->Ln(13);

    $Select_med_abas= "SELECT * FROM medicamentos_receta WHERE Folio_Receta = '$folio' AND stat = 'Terminada'";
    $medicamentos_abastecidos = mysqli_query($link, $Select_med_abas);
    if($medicamentos_abastecidos -> num_rows > 0)
    {
        while($med_receta = mysqli_fetch_array($medicamentos_abastecidos))
        {

            $id_med = $med_receta['ID_Medicamento'];
            $consulta = "SELECT * FROM medicamentos WHERE ID_medicamento = '$id_med'";
            $consultando = mysqli_query($link, $consulta);
            $med = mysqli_fetch_array($consultando);
            
            /*----------  Detalles de la tabla  ----------*/
            $pdf->MultiCell(200,4,utf8_decode('        - -  '.$med['Nombre_medicamento']),0,'B',false); 
            $pdf->MultiCell(250,10,utf8_decode('        '.$med_receta['Dosis']),0,'B',false);
            $pdf->Ln(1);
            /*----------  Fin Detalles de la tabla  ----------*/
        }
    }

    $pdf->Cell(0,-7,utf8_decode("________________________________________________________________________________________________"),0,0,'C');

        $pdf->Ln(5);

    # Impuestos & totales #
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->SetFont('Times', 'B', 15);
    $pdf->Cell(26,5,utf8_decode("Comentarios: "),0,0,'C');
    $pdf->Ln(9);
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->SetFont('Times','',13);
    $pdf->MultiCell(200,5,utf8_decode($comprobante['Comentarios']),0,'B', false);

    $pdf->Ln(9);
    $pdf->SetFont('Times', 'B', 17);
    $pdf->MultiCell(0,5,utf8_decode("Firma: _______________________"),0,'C', false);
    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket_Nro_1.pdf",true);