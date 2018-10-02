jQuery(document).ready(function ($) {
    console.log('Import AJAX script');
    var status = 1;
    $('.js-start-import').on('click', function(e){
        loadDataFromExcel({});
    });

    function loadDataFromExcel(data) {

        var count_update = parseInt($('.count_update').text()),
        count_new = parseInt($('.count_new').text()),
        count = count_new + count_update,
        preloader = $('.js-load-ajax');
        preloader.show();
        var importContainer = $('.js-import-container'),
        hsId = importContainer.data('hsid'),
        newNodesFile = importContainer.data('newnodesfile'),
        updateNodesFile = importContainer.data('updatenodesfile');
        data.csvOffset = data.csvOffset || 0;

        $.ajax({
            url: '/admin/hierarchicalStructure/default/import-excel',
            type: 'POST',
            data: {
                hsId: hsId,
                newNodesFile : newNodesFile,
                updateNodesFile : updateNodesFile,
                csvOffset : data.csvOffset,
                isInserting : data.isInserting
            }
        })
            .done(function(data) {
                preloader.hide();
                var result = Math.round((data.processedRows * status) / count * 100);
                if (result > 100) {
                    result = 99;
                }
                if (data.processedRows < 10 && data.processedRows !== 0) {
                    result = 100;
                }
                $('.loading').find('progress').val(result);
                $('.loading').find('.progress').text(result + '%');
                status++;
                if(data.isFinished) {
                    if (data.isInserting) {
                        data.isInserting = 0;
                        data.csvOffset = 0;
                    } else {
                        $('.js-import-result').append('<div>Finished.</div>');
                        $('.js-start-import').hide();
                        $('.js-import-view-hs-btn').show();
                        return;
                    }
                }
                loadDataFromExcel(data);
            })

            .fail(function(xhr, textStatus, errorThrown) {
                preloader.hide();
                $('.js-import-result').html('Status : ' + textStatus + ' - ' + errorThrown);
                console.log(xhr);
            });
    }
});