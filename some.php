<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

    $(function () {
        $.ajax({
            type: 'GET',
            url: 'http://images/test.php',
            dataType: 'image/jpg',
            success: function (data) {
                console.log('картинка')
            },
            error: function (data) {
                console.log('!картинка')
            }
        })
    });

</script>

<?php
