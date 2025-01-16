<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
$pago = $_GET['monto'];

	# Incluyendo librerias necesarias #
    require "./code128.php";

    #conexion con las base de datos sustanciales
    $Select_com_abas= "SELECT * FROM ventas WHERE Folio_ventas = '$folio' AND stat = 'Vendido'";
    $comprobante_abastecimiento = mysqli_query($link, $Select_com_abas);
    $comprobante = mysqli_fetch_array($comprobante_abastecimiento);
    $user = $comprobante['ID_usuario'];

    $Select_usuario= "SELECT * FROM usuarios WHERE ID_usuario = '$user'";
    $usuarios = mysqli_query($link, $Select_usuario);
    $usuario = mysqli_fetch_array($usuarios);

    $pdf = new PDF_Code128('P','mm',array(100,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("TICKET DE COMPRA")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,5,utf8_decode("CONSULTORIO MEDICO"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Direccion: ###########, ##########"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 3344556677"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Email: correo@ejemplo.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->MultiCell(0,5,utf8_decode("Fecha: ".$comprobante['Fecha']." Hora: ".$comprobante['Hora']),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Cajero: ".$usuario['Nombre_completo_usuario']),0,'C',false);
    if($usuario['Tipo'] == "Encargado")
            $type = "Encargado en caja";
    if($usuario['Tipo'] == "Medico")
            $type = "Medico";
    if($usuario['Tipo'] == "Admin")
            $type = "Administrativo";        
    $pdf->MultiCell(0,5,utf8_decode("Tipo de Usuario: ".$type),0,'C',false);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Folio De Ticket: ".$folio)),0,'C',false);
    $pdf->SetFont('Arial','',9);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("----------------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(25,5,utf8_decode("Nombre."),0,0,'C');
    $pdf->Cell(31,5,utf8_decode("Precio"),0,0,'C');
    $pdf->Cell(10,5,utf8_decode("Cant."),0,0,'C');
    $pdf->Cell(20,5,utf8_decode("Total"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(0,5,utf8_decode("----------------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    $pdf->Ln(3);
    $pdf->MultiCell(0,4,utf8_decode("Informacion de productos"),0,'C',false);
    $pdf->Ln(3);

    $Select_med_abas= "SELECT * FROM medicamento_ventas WHERE Folio_venta = '$folio' AND stat = 'Vendido'";
    $medicamentos_abastecidos = mysqli_query($link, $Select_med_abas);
    if($medicamentos_abastecidos -> num_rows > 0)
    {
        $total = 0;
        $total_final = 0;
        $total_venta = 0;
        while($med_abastecido = mysqli_fetch_array($medicamentos_abastecidos))
        {
            $id_med = $med_abastecido['ID_Medicamento'];
            $consulta = "SELECT * FROM medicamentos WHERE ID_medicamento = '$id_med'";
            $consultando = mysqli_query($link, $consulta);
            $med = mysqli_fetch_array($consultando);
            
            /*----------  Detalles de la tabla  ----------*/
            $pdf->Cell(35,4,utf8_decode($med['Nombre_medicamento']),0,0,'C');
            $pdf->Cell(13,4,utf8_decode("$ ".$med_abastecido['Precio_Medicamento_Actual']." MXN"),0,0,'C');
            $pdf->Cell(21,4,utf8_decode($med_abastecido['Cantidad_Medicamento']),0,0,'C');
            $total = $med_abastecido['Precio_Medicamento_Actual']*$med_abastecido['Cantidad_Medicamento'];
            $total_final += $total;
            $pdf->Cell(14,4,utf8_decode("$ ".($total)." MXN"),0,0,'C');
            $pdf->Ln(2);
            $pdf->Ln(5);
            /*----------  Fin Detalles de la tabla  ----------*/
        }
    }



    $pdf->Cell(0,5,utf8_decode("----------------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);

    $Subtotal = ($total_final/100)*84;
    $iva = ($total_final/100)*16;
    # Impuestos & totales #
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(26,5,utf8_decode("SUBTOTAL"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("+ $ ".$Subtotal." MXN"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(26,5,utf8_decode("IVA (16%)"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("+ $ ".$iva." MXN"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(0,5,utf8_decode("----------------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(10);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(26,5,utf8_decode("TOTAL:"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$ ".$total_final." MXN"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(26,5,utf8_decode("MONTO PAGADO:"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$ ".$pago." MXN"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(26,5,utf8_decode("CAMBIO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$ ".$pago-$total_final." MXN"),0,0,'C');

    $pdf->Ln(10);
    
    $pdf->MultiCell(0,5,utf8_decode("*** Losrpecios de productos provistos ya incluyen impuestos. Para poder realizar un reclamo o devolución a los proveedores debe de presentar este ticket ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,utf8_decode("Gracias por su preferencia"),'',0,'C');

    $pdf->Ln(9);

    $new_id = $folio;
    $vector = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    #Verifica y crea un nuevo id que sea diferente del nuevo maximo para agregar 8 digitos
    for($var = 11; $var >= 0; $var--)
    {
        $vector[$var] = $new_id % 10;
        $new_id /= 10;
    }
    $new_id = $vector[0].$vector[1].$vector[2].$vector[3].$vector[4].$vector[5].$vector[6].$vector[7].$vector[8].$vector[9].$vector[10].$vector[11];

    # Codigo de barras #
    $pdf->Code128(15,$pdf->GetY(),$new_id,70,20);
    $pdf->SetXY(0,$pdf->GetY()+21);
    $pdf->SetFont('Arial','',14);
    $pdf->MultiCell(0,5,utf8_decode($new_id),0,'C',false);
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket_Nro_1.pdf",true);