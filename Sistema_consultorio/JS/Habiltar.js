function valida_admin()
{
    select = document.getElementById("seleccion").value;

    if(select == "Medico")
    {
        document.getElementById("cedula").disabled = false;
    }
    else
    {
        document.getElementById("cedula").disabled = true;
    }

}
document.getElementById("seleccion").addEventListener("change", valida_admin);

