<script>

        function Solo_letras(x)
        {
            key = x.keyCode || x.which;
            tecla = String.fromCharCode(key).toString();
            letras = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚabcdefghijklmnñopqrstuvwxyzáéíóú";

            especiales = [8, 13, 32];
            tecla_especial = false;
            for(var i in especiales)
            {
                if(key == especiales[i])
                {
                    tecla_especial = true;
                    break;
                }   
            }
            if(letras.indexOf(tecla) == -1 && !tecla_especial)
            {
                alert("Solamente puedes ingresar letras.");
                return false;
            }
        }

        function Solo_numeros(num)
        {
            if(window.event){
                tecla_numero = num.keyCode;
            }else{
                tecla_numero = num.which;
            }
            if((tecla_numero > 47 && tecla_numero < 58) || tecla_numero == 8 || tecla_numero == 13 )
            return true;
            else{
                alert("Solo puedes ingresar numeros en ese campo.");
                return false;
            }
        }

        function solo_precio(num)
        {
            if(window.event){
                tecla_numero = num.keyCode;
            }else{
                tecla_numero = num.which;
            }
            if((tecla_numero > 47 && tecla_numero < 58) || tecla_numero == 8 || tecla_numero == 13 ||  tecla_numero == 46)
            return true;
            else{
                alert("Solo numeros o formato de precio.");
                return false;
            }
        }

        function solo_num(num)
        {
            if(window.event){
                tecla_numero = num.keyCode;
            }else{
                tecla_numero = num.which;
            }
            if((tecla_numero > 47 && tecla_numero < 58) || tecla_numero == 8 || tecla_numero == 13 ||  tecla_numero == 46)
            return true;
            else{
                alert("Ingresa numeros en los formatos que se requiere.");
                return false;
            }
        }

        function confirma_modificacion()
        {
            var respuesta = confirm("¿Esta seguro que desea modificar este registro?");
            if(respuesta)
                return true;
            else
                return false;
        }

        function confirma_registro()
        {
            var respuesta = confirm("Seleccione aceptar para realizar registro del medicamento.");
            if(respuesta)
                return true;
            else
                return false;
        }

        function eliminacion(e)
        {
            var respuesta = confirm("¿Esta seguro que desea eliminar este registro?")
            if(respuesta)
                return true;
            else
                return false;
        }

        function confirma_cierre_sesion()
        {
            var respuesta = confirm("¿Desea realizar el cierre de sesión?");
            if(respuesta){
                return true;
            }
            else{
                return false;
            }
        }

        function confirma_abastecimiento()
        {
            var respuesta = confirm("¿Desea realizar el abastecimiento?");
            if(respuesta){
                return true;
            }
            else{
                return false;
            }
        }

        function confirma_cancelacion()
        {
            var respuesta = confirm("¿Desea cancelar el registro?");
            if(respuesta){
                return true;
            }
            else{
                return false;
            }
        }

        function advertir()
        {
            var respuesta = confirm("Usted no es un usuario ´Medico´ y por lo tanto no puede acceder a este apartado");
            if(respuesta){
                return true;
            }
            else{
                return false;
            }
        }

        function concluida()
        {
            var respuesta = confirm("Ya se ha concluido, Cancelado o emitido la receta medica, no puede emitir la receta para esta cita");
            if(respuesta){
                return true;
            }
            else{
                return false;
            }
        }

        function recetar()
        {
            var respuesta = confirm("¿Desea terminar con el registro de la receta medica?");
            if(respuesta){
                return true;
            }
            else{
                return false;
            }
        }

</script>