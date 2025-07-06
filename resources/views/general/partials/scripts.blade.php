  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!--bootstrap js-->
  <script src="{{ asset("dashboard_resources/assets/js/bootstrap.bundle.min.js"); }}"></script>

  <!--plugins-->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!--plugins-->
  {{-- <script src="{{ asset("dashboard_resources/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"); }}"></script> --}}
  <script src="{{ asset("dashboard_resources/assets/plugins/metismenu/metisMenu.min.js"); }}"></script>
  {{-- <script src="{{ asset("dashboard_resources/assets/plugins/apexchart/apexcharts.min.js"); }}"></script> --}}
  <script src="{{ asset("dashboard_resources/assets/plugins/simplebar/js/simplebar.min.js"); }}"></script>
  <script src="{{ asset("dashboard_resources/assets/plugins/peity/jquery.peity.min.js"); }}"></script>
  <script>
    $(".data-attributes span").peity("donut")
  </script>
  <script src="{{ asset("dashboard_resources/assets/js/main.js"); }}"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      console.log("Sidebar snippet cargado");
        const toggleBtn = document.querySelector('.btn-toggle a');
        let colapsado = false;

        toggleBtn.addEventListener("click", function () {
            colapsado = !colapsado;

            const textos = document.querySelectorAll('.sidebar-principal .sidebar-text');
            textos.forEach(el => {
                el.style.display = colapsado ? 'none' : 'inline';
            });
        });
    });
</script>



  
 

