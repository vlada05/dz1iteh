function load_data() {
    $.ajax({
        url: "fetch.php",
        method: "POST",
        data: {
            txtPolje: $('#search_text').val()
        },
        success: function (data) {
            $('#user_data').html(data);
        }
    })
}

$(document).ready(function () {
    load_data();

    $('#user_dialog').dialog({
        autoOpen: false,
        width: 400
    });

    $('#search_text').keyup(function () {
        load_data();
    })

    $("#activityName").keyup(function () {
        $.ajax({
            type: "POST",
            url: "autoSuggestActivities.php",
            data: {
                keyword: $(this).val(),
            },
            success: function (data) {
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
            }
        });
    });

    $('#add').click(function () {
        $('#user_dialog').attr('title', 'Add Activity');
        $('#action').val('insert');
        $('#form_action').val('Insert');
        $('#user_form')[0].reset();
        $('#form_action').attr('disabled', false);
        $("#user_dialog").dialog('open');
        $("#suggesstion-box").hide();
    });

    $('#user_form').on('submit', function (event) {
        event.preventDefault();
        var error_activityName = '';
        var error_startingTime = '';
        var error_endingTime = '';
        var error_description = '';
        // activity name
        if ($('#activityName').val() == '') {
            error_activityName = 'Activity name is required';
            $('#error_activityName').text(error_activityName);
            $('#activityName').css('border-color', '#cc0000');
        } else {
            error_activityName = '';
            $('#error_activityName').text(error_activityName);
            $('#activityName').css('border-color', '');
        }
        // starting time
        if ($('#startingTime').val() == '') {
            error_startingTime = 'Starting time is required';
            $('#error_startingTime').text(error_startingTime);
            $('#startingTime').css('border-color', '#cc0000');
        } else if (!(/[0-9]{2}-[0-9]{2}/).test($('#startingTime').val())) {
            error_startingTime = 'Starting time must not contain digits and must be in format 00-00';
            $('#error_startingTime').text(error_startingTime);
            $('#startingTime').css('border-color', '#cc0000');
        }
        else {
            var sat = $('#startingTime').val().substring(0, 2);
            var minut = $('#startingTime').val().substring(3, 5);
            if (sat > 23 || minut > 59) {
                error_startingTime = 'Start time contains impossible time value!';
                $('#error_startingTime').text(error_startingTime);
                $('#startingTime').css('border-color', '#cc0000');
            } else {
                error_startingTime = '';
                $('#error_startingTime').text(error_startingTime);
                $('#startingTime').css('border-color', '');
            }
        }
        // ending time
        if ($('#endingTime').val() == '') {
            error_endingTime = 'Ending time is required';
            $('#error_endingTime').text(error_endingTime);
            $('#endingTime').css('border-color', '#cc0000');
        } else if (!(/[0-9]{2}-[0-9]{2}/).test($('#endingTime').val())) {
            error_endingTime = 'Ending time must not contain digits and must be in format 00-00';
            $('#error_endingTime').text(error_endingTime);
            $('#endingTime').css('border-color', '#cc0000');
        }
        else {
            var sat = $('#endingTime').val().substring(0, 2);
            var minut = $('#endingTime').val().substring(3, 5);
            if (sat > 23 || minut > 59) {
                error_endingTime = 'Ending time contains impossible time value!';
                $('#error_endingTime').text(error_endingTime);
                $('#endingTime').css('border-color', '#cc0000');
            } else if (!prviPreDrugog()) {
                error_endingTime = 'End time must be after start time!';
                $('#error_endingTime').text(error_endingTime);
                $('#endingTime').css('border-color', '#cc0000');
            } else {
                error_endingTime = '';
                $('#error_endingTime').text(error_endingTime);
                $('#endingTime').css('border-color', '');
            }
        }
        // description
        if ($('#description').val() == '') {
            error_description = 'Description is required';
            $('#error_description').text(error_description);
            $('#description').css('border-color', '#cc0000');
        } else {
            error_description = '';
            $('#error_description').text(error_description);
            $('#description').css('border-color', '');
        }

        if (error_activityName == '' && error_startingTime == '' && error_endingTime == '' && error_description == '') {
            var form_data = $(this).serialize();
            $.ajax({
                url: "includes/action.php",
                method: "post",
                data: form_data,
                success: function (data) {
                    $('#user_dialog').dialog('close');
                    $('#action_alert').html(data);
                    $('#action_alert').dialog('open');
                    load_data();
                    $('#form_action').attr('disabled', false);
                }
            });
        } else {
            return false;
        }
    });
    $('#action_alert').dialog({
        autoOpen: false
    })
});

$(document).on('click', '.lijevi', function () {
    var val = $(this).attr('id');
    $("#activityName").val(val);
    $("#suggesstion-box").hide();
});


$(document).on('click', '.edit', function () {
    var id = $(this).attr('id');
    var action = 'fetch_single';
    $.ajax({
        url: "includes/action.php",
        method: "POST",
        data: { id: id, action: action },
        success: function (data) {
            data = JSON.parse(data);
            $('#activityName').val(data.activityName);
            $('#startingTime').val(data.startingTime);
            $('#endingTime').val(data.endingTime);
            $('#description').val(data.description);
            $('#user_dialog').attr('title', 'Edit Activity');
            $('#action').val('update');
            $('#hidden_id').val(id);
            $('#form_action').val('Update');
            $('#user_dialog').dialog('open');
        }
    });
});

$('#delete_confirmation').dialog({
    autoOpen: false,
    modal: true,
    buttons: {
        Ok: function () {
            var id = $(this).data('id');
            var action = 'delete';
            $.ajax({
                url: "includes/action.php",
                method: "POST",
                data: { id: id, action: action },
                success: function (data) {
                    $('#delete_confirmation').dialog('close');
                    $('#action_alert').html(data);
                    $('#action_alert').dialog('open');
                    load_data();
                }
            });
        },
        Cancel: function () {
            $(this).dialog('close');
        }
    }
});

$(document).on('click', '.delete', function () {
    var id = $(this).attr("id");
    $('#delete_confirmation').data('id', id).dialog('open');
});

function prviPreDrugog() {
    var satPrvog = $('#startingTime').val().substring(0, 2);
    var minutPrvog = $('#startingTime').val().substring(3, 5);
    var satDrugog = $('#endingTime').val().substring(0, 2);
    var minutDrugog = $('#endingTime').val().substring(3, 5);
    console.log(satPrvog + ":" + minutPrvog + "\n" + satDrugog + ":" + minutDrugog);
    console.log("prvi uslov: " + (satPrvog < satDrugog));
    console.log("drugi: " + (satPrvog == satDrugog && minutPrvog < minutDrugog));
    console.log("ceo uslov: " + (satPrvog < satDrugog || (satPrvog == satDrugog && minutPrvog < minutDrugog)));
    return (satPrvog < satDrugog || (satPrvog == satDrugog && minutPrvog < minutDrugog));
}