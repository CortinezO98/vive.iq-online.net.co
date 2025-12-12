<script>
    /** 
     * Filtra en el input text de la barra de búsqueda y reemplaza los caracteres validados
     */
    jQuery(document).ready(function(){
        jQuery("#filtro_busqueda").on('input', function (evt) {
        jQuery(this).val(jQuery(this).val().replace(/[.,*/]/g, ''));
        });
    });

    /** 
     * Valida campo input file y pone en color verde el label del archivo seleccionado
     */
    function validar_documento(id){
        var valor_opcion = document.getElementById(id).files[0].name;

        if (valor_opcion!="") {
            $('#'+id).addClass("color-verde");
        }
    }

    
</script>