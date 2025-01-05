<!-- build:js assetsvendor/js/core.js -->
<script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('vendor/js/bootstrap.js') }}"></script>

<script src="{{ asset('vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->


<!-- Page JS -->
<script>
    $(document).ready(function(){
        // Attach an event listener to both input fields
        $('#basic-default-quantity-recived-warehouse-class-1, #basic-default-quantity-usebale-next-class-class-1').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-1').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-1').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-1').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-2, #basic-default-quantity-usebale-next-class-class-2').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-2').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-2').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-2').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-3, #basic-default-quantity-usebale-next-class-class-3').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-3').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-3').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-3').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-4, #basic-default-quantity-usebale-next-class-class-4').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-4').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-4').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-4').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-5, #basic-default-quantity-usebale-next-class-class-5').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-5').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-5').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-5').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-6, #basic-default-quantity-usebale-next-class-class-6').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-6').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-6').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-6').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-7, #basic-default-quantity-usebale-next-class-class-7').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-7').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-7').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-7').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-8, #basic-default-quantity-usebale-next-class-class-8').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-8').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-8').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-8').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-9, #basic-default-quantity-usebale-next-class-class-9').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-9').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-9').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-9').val(sum);
        });
        $('#basic-default-quantity-recived-warehouse-class-10, #basic-default-quantity-usebale-next-class-class-10').on('input', function(){
            // Get the values from the input fields
            var value1 = parseFloat($('#basic-default-quantity-recived-warehouse-class-10').val()) || 0;
            var value2 = parseFloat($('#basic-default-quantity-usebale-next-class-class-10').val()) || 0;

            // Calculate the sum
            var sum = value1 - value2;

            // Place the result in the third input field
            $('#basic-default-shaheed-class-10').val(sum);
        });
    });
</script>
