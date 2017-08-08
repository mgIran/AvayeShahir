$(function () {
    var $body = $("body");
    var $modal = $(".filemanager-modal");

    $(".filemanager-container").each(function () {
        var $input = $(this).find('.filemanager-input input[type="hidden"]');
        var $label = $(this).find('.filemanager-input .filemanager-label');
        if ($input.val()) {
            $(this).find(".filemanager-list-section .filemanager-item[data-file-name='" + $input.val() + "']").addClass('selected');
            $label.text($input.val());
        }
    });

    $modal.on('show.bs.modal', function () {
        var $id = $(this).attr('id');
        fetch($id);
    });

    function fetch($id) {
        var $thisModal = $("#" + $id);
        var $loading = $thisModal.find(".modal-loading-container");
        $.ajax({
            url: $thisModal.data('fetch-url'),
            type: "POST",
            data: {path: $thisModal.data('fetch-path')},
            dataType: 'HTML',
            beforeSend: function () {
                $loading.show();
            },
            success: function (html) {
                $loading.hide();
                $thisModal.find(".filemanager-list-container").html(html);
                var $input = $thisModal.parents(".filemanager-container").find('.filemanager-input input[type="hidden"]');
                if ($input.val())
                    $thisModal.find(".filemanager-list-section .filemanager-item[data-file-name='" + $input.val() + "']").addClass('selected');
            }
        });
    }

    $body.on('click', '.filemanager-item', function () {
        var $thisModal = $(this).parents(".filemanager-modal");
        $thisModal.find(".filemanager-list-section .selected").removeClass('selected');
        $(this).addClass('selected');
    });

    $body.on('click', '.filemanager-submit', function () {
        var $container = $(this).parents(".filemanager-container");
        var $fileSelected = $container.find(".filemanager-list-section .selected");
        var $files;

        if($fileSelected.length > 1)
        {

        }else if($fileSelected.length == 1)
            $files = $container.find(".filemanager-list-section .selected").data('file-name');
        $container.find('.filemanager-input input[type="hidden"]').val($files);
        $container.find('.filemanager-input .filemanager-label').text($files);
        $container.find('.filemanager-modal').modal('toggle');
    });
});