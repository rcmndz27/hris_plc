$(function(){

                        $('#ref_to').hide();
                        $('#ref_date').hide();
                        $('#ref_to_dis').show();
                        $('#ref_date_dis').show();

    $('#action_taken').change(function(){
                if($('#action_taken').val() === 'Referred'){
                        $('#ref_to').show();
                        $('#ref_date').show();
                        $('#ref_to_dis').hide();
                        $('#ref_date_dis').hide();
                }else{            
                        $('#ref_to').hide();
                        $('#ref_date').hide();
                        $('#ref_to_dis').show();
                        $('#ref_date_dis').show();
                }   
    });

});














