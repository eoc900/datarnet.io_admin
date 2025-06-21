<script>
    $(document).ready(function(){
        const checkboxPublico = document.getElementById("publico");
        const seccionBanner = document.getElementById("seccion-banner");
        const dropZone = document.getElementById("drop-zone");
        const inputFile = document.getElementById("banner_input");
        const preview = document.getElementById("preview-banner");

        if(checkboxPublico && dropZone){
            // Mostrar/ocultar sección
            checkboxPublico.addEventListener("change", function () {
                if (this.checked) {
                    seccionBanner.classList.remove("d-none");
                } else {
                    seccionBanner.classList.add("d-none");
                    preview.src = "";
                    preview.classList.add("d-none");
                    inputFile.value = "";
                }
            });

            // Click en zona = abrir file
            dropZone.addEventListener("click", function () {
                inputFile.click();
            });

            // Drop soporte
            dropZone.addEventListener("dragover", function (e) {
                e.preventDefault();
                dropZone.classList.add("bg-white", "border-success");
            });

            dropZone.addEventListener("dragleave", function () {
                dropZone.classList.remove("bg-white", "border-success");
            });

            dropZone.addEventListener("drop", function (e) {
                e.preventDefault();
                dropZone.classList.remove("bg-white", "border-success");
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith("image/")) {
                    inputFile.files = e.dataTransfer.files;
                    showPreview(file);
                }
            });

            // Cambio tradicional
            inputFile.addEventListener("change", function () {
                const file = this.files[0];
                if (file && file.type.startsWith("image/")) {
                    showPreview(file);
                }
            });
        }

        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove("d-none");
            };
            reader.readAsDataURL(file);
        }
    });
</script>