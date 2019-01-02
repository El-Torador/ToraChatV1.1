$(function () {
    $('#home').on('mouseover', function () {
        $('#home').addClass('active');
    });

    $('#home').on('mouseout', function () {
        $('#home').toggleClass('active');
    });

    $('#actu').on('mouseover', function () {
        $('#actu').addClass('disabled');
    });

    $('#actu').on('mouseout', function () {
        $('#actu').toggleClass('disabled');
    });

    $('#actu2').on('mouseover', function () {
        $('#actu2').addClass('active');
    });

    $('#actu2').on('mouseout', function () {
        $('#actu2').toggleClass('active');
    });

    $('#chat').on('mouseover', function () {
        $('#chat').addClass('disabled');
    });

    $('#chat').on('mouseout', function () {
        $('#chat').toggleClass('disabled');
    });

    $('#chat2').on('mouseover', function () {
        $('#chat2').addClass('active');
    });

    $('#chat2').on('mouseout', function () {
        $('#chat2').toggleClass('active');
    });

    $('#new').on('mouseover', function () {
        $('#new').addClass('active');
    });

    $('#new').on('mouseout', function () {
        $('#new').toggleClass('active');
    });
    $(function () {
        $('a').click(function () {
            with($(this)) {
                button('loading');
                setTimeout(function () {
                    button('reset');
                }, 4000);
            }
        })
    });

    function verif() {
        if ($('input[name="masculin"]:checked')) {
            $('input[name="feminin"]').removeAttr('required');
        } else if ($('input[name="feminin"]:checked')) {
            $('input[name="masculin"]').removeAttr('required');
        }
    }


});
