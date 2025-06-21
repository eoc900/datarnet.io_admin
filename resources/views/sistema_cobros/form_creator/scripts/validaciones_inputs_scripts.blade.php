<script>
    $(document).ready(function(){

        creadorFormularioValidate();
        activarEventoChangeConfigAvanzada();
        
        function creadorFormularioValidate(){
            //1. Nombre de formulario
            const input = document.getElementById('nombre_formulario');
            const alerta = document.getElementById('alerta_longitud');
            const limite = 50;

            if(input){
                 input.addEventListener('input', function () {
                if (input.value.length > limite) {
                    alerta.classList.remove('d-none');
                } else {
                    alerta.classList.add('d-none');
                }
                });
            }
           

        }
        function activarEventoChangeConfigAvanzada(){
           
                const toggle = document.getElementById('conf_avanzada');
                const camposAvanzados = document.getElementById('campos-avanzados');
                if(toggle && camposAvanzados)
                {
                    toggle.addEventListener('change', function () {
                        if (toggle.checked) {
                            camposAvanzados.classList.remove('d-none');
                        } else {
                            camposAvanzados.classList.add('d-none');
                        }
                    });
                }
          

        }
       
    });
</script>