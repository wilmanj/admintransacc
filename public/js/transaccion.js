function validarCamposHistorial(){
    if(document.getElementById('txtfechaDesde').value!=""){
        if(document.getElementById('txtfechaHasta').value!=""){
            document.getElementById('formBuscarHistorial').submit();
        }else{
            alert("Seleccione una fecha hasta");
        }
    }else{
        alert("Seleccione una fecha desde");
        document.getElementById('txtfechaDesde').focus;
    }
}