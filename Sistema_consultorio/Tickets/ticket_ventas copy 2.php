<?php
#       conexion SQL
$link = mysqli_connect("localhost", "root", "", "consultorio_db");
if(!$link)
    echo "error";

$folio = $_GET['folio'];
#Genera la actualizacion del status
        #$sold = mysqli_query($link, $vender);
        #if($sold)
        #{      
        #    $obtiene_med = "SELECT Cantidad_medicamento, ID_medicamento FROM medicamentos_abastecidos WHERE Folio_compra_proveedores = '$folio' AND stat = 'Abastecido';";
        #    $medicamentos = mysqli_query($link, $obtiene_med);
        #    if($medicamentos -> num_rows > 0)
        #    {
        #        while($medicinas = mysqli_fetch_array($medicamentos))
        ##        {
        #            $cant = $medicinas['Cantidad_medicamento'];
        #            $id = $medicinas['ID_medicamento'];

        #            $actualiza_cant = "UPDATE medicamentos SET Cantidad = (Cantidad+$cant) WHERE ID_medicamento = '$id';";
        #            $cantidad_actualizada = mysqli_query($link, $actualiza_cant);
        #        }
        #    }
        #    $abastecer = "UPDATE comprobante_abastecimiento SET stat = 'Abastecido', Fecha_compra = CURRENT_DATE, Hora = CURRENT_TIME WHERE Folio_compra_proveedores = '$folio';";
        #    $abastecido = mysqli_query($link, $abastecer);

	# Incluyendo librerias necesarias #
    require "./code128.php";

    #conexion con las base de datos sustanciales
    $Select_com_abas= "SELECT * FROM comprobante_abastecimiento WHERE Folio_compra_proveedores = '$folio' #AND stat = 'Abastecido'";
    $comprobante_abastecimiento = mysqli_query($link, $Select_com_abas);
    $comprobante = mysqli_fetch_array($comprobante_abastecimiento);
    $user = $comprobante['ID_usuario'];

    $Select_usuario= "SELECT * FROM usuarios WHERE ID_usuario = '$user'";
    $usuarios = mysqli_query($link, $Select_usuario);
    $usuario = mysqli_fetch_array($usuarios);

    $Select_med_abas= "SELECT * FROM medicamentos_abastecidos WHERE Folio_compra_proveedores = '$folio' #AND stat = 'Abastecido'";
    $medicamentos_abastecidos = mysqli_query($link, $Select_med_abas);
    $med_abastecido = mysqli_fetch_array($medicamentos_abastecidos);

    $pdf = new PDF_Code128('P','mm',array(80,258));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Consultorio Medico")),0,'C',false);
    $pdf->SetFont('Arial','',9);
    $pdf->MultiCell(0,5,utf8_decode("RUC: 0000000000"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Direccion: ###########, ##########"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 3344556677"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Email: correo@ejemplo.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->MultiCell(0,5,utf8_decode("Fecha: ".$comprobante['Fecha_compra']." Hora: ".$comprobante['Hora']),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Cajero: ".$usuario['Nombre_completo_usuario']),0,'C',false);
    $pdf->SetFont('Arial','B',10);
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Folio De Ticket: ".$folio)),0,'C',false);
    $pdf->SetFont('Arial','',9);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    $pdf->MultiCell(0,5,utf8_decode("Cliente: Carlos Alfaro"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Documento: DNI 00000000"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 00000000"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Dirección: San Salvador, El Salvador, Centro America"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(10,5,utf8_decode("Cant."),0,0,'C');
    $pdf->Cell(19,5,utf8_decode("Precio"),0,0,'C');
    $pdf->Cell(15,5,utf8_decode("Desc."),0,0,'C');
    $pdf->Cell(28,5,utf8_decode("Total"),0,0,'C');

    $pdf->Ln(3);
    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);



    /*----------  Detalles de la tabla  ----------*/
    $pdf->MultiCell(0,4,utf8_decode("Nombre de producto a vender"),0,'C',false);
    $pdf->Cell(10,4,utf8_decode("7"),0,0,'C');
    $pdf->Cell(19,4,utf8_decode("$10 USD"),0,0,'C');
    $pdf->Cell(19,4,utf8_decode("$0.00 USD"),0,0,'C');
    $pdf->Cell(28,4,utf8_decode("$70.00 USD"),0,0,'C');
    $pdf->Ln(4);
    $pdf->MultiCell(0,4,utf8_decode("Garantía de fábrica: 2 Meses"),0,'C',false);
    $pdf->Ln(7);
    /*----------  Fin Detalles de la tabla  ----------*/



    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);

    # Impuestos & totales #
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("SUBTOTAL"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("+ $70.00 USD"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("IVA (13%)"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("+ $0.00 USD"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL A PAGAR"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$70.00 USD"),0,0,'C');

    $pdf->Ln(5);
    
    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("TOTAL PAGADO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$100.00 USD"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("CAMBIO"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$30.00 USD"),0,0,'C');

    $pdf->Ln(5);

    $pdf->Cell(18,5,utf8_decode(""),0,0,'C');
    $pdf->Cell(22,5,utf8_decode("USTED AHORRA"),0,0,'C');
    $pdf->Cell(32,5,utf8_decode("$0.00 USD"),0,0,'C');

    $pdf->Ln(10);

    $pdf->MultiCell(0,5,utf8_decode("*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);

    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,7,utf8_decode("Gracias por su compra"),'',0,'C');

    $pdf->Ln(9);

    # Codigo de barras #
    $pdf->Code128(5,$pdf->GetY(),"COD000001V0001",70,20);
    $pdf->SetXY(0,$pdf->GetY()+21);
    $pdf->SetFont('Arial','',14);
    $pdf->MultiCell(0,5,utf8_decode("COD000001V0001"),0,'C',false);
    
    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket_Nro_1.pdf",true);