(function($) {

    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    /*  $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    })
*/
    //Datemask2 mm/dd/yyyy
    /*$('#datemask2').inputmask('mm/dd/yyyy', {
    	'placeholder': 'mm/dd/yyyy'
    })
    */
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    //$('#reservation').daterangepicker()

    //Date range picker with time picker
    /*$('#reservationtime').daterangepicker({
    	timePicker: true,
    	timePickerIncrement: 30,
    	format: 'MM/DD/YYYY h:mm A'
    })*/

    //Date range as a button
    /*	$('#daterange-btn').daterangepicker({
    		ranges: {
    			'Today': [moment(), moment()],
    			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    			'This Month': [moment().startOf('month'), moment().endOf('month')],
    			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    		},
    		startDate: moment().subtract(29, 'days'),
    		endDate: moment()
    	}, function(start, end) {
    		$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    	})*/

    //Date picker
    $('.datepicker').datepicker({
            autoclose: true,
            // minDate: '2',
           startDate: new Date(),
           // endDate: '+5y',
            format: "yyyy-mm-dd",
            // todayHighlight: true,
        })

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })

            //blue color scheme for iCheck
            $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })

            //Flat blue color scheme for iCheck
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            })

        //Colorpicker
        //$('.my-colorpicker1').colorpicker()

    //color picker with addon
    //$('.my-colorpicker2').colorpicker()

    //Timepicker
    /*$('.timepicker').timepicker({
    	showInputs: false
    })*/


    //dateFrom picker
    $('.dateFrom').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        // todayHighlight: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('.dateTo').datepicker('setStartDate', minDate);
    });

    //dateTo picker
    $('.dateTo').datepicker({
        autoclose: true,
        // minDate: '2',
        startDate: new Date(),
       // endDate: '+6y',
        format: "yyyy-mm-dd",
        // todayHighlight: true,
    }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('.dateFrom').datepicker('setEndDate', maxDate);
    });

})(jQuery);
