
$(document).ready(function (event) {

var warden = "";
var id = "";
var pas_type ="";
var r ="";
var a = "";
    $(".mark-it").on("click", function () {
        $('#exampleModal').modal('show');
        id = $(this).attr('id');
        pas_type = $('#pass-type').val();
        ar = id.split("-")
        r = ar[0];
        a = ar[1];

        
    });
    
            $(".warden").click(
             function (){
            var who_is_this = $(this).attr('id');
            $.ajax({
            type: "POST",
            url: "/api/action/",
            data: {
                "roll-no": r,
                "action": a,
                "type": pas_type,
                "who_is":who_is_this
            },
            dataType: "json",
            success: function (data) {

                if (data['Message'] == "Pass successfully accepted") {
                    var elem1 = document.getElementById(r + "-0");
                    elem1.remove();
                    var elem1 = document.getElementById(r + "-1");
                    elem1.innerHTML = "accepted";
                } else {
                    var elem1 = document.getElementById(r + "-1");
                    elem1.remove();
                    var elem1 = document.getElementById(r + "-0");
                    elem1.innerHTML = "declined";
                }
            },

        });
        }
)

});

