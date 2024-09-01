
$(document).ready(function (event) {

    $( ".unmarked-token" ).on( "click", function() {
        var data1 = $(this).attr('id');
        var myArray = data1.split("-");
        var id = "";
        var which ="";
        id = myArray[0];
        which = myArray[1];
        



          $.ajax({
            type: "POST",
            url: "/api/token-entry/",
            data: {
              'roll-no' : id,
              'which':which
            },
            dataType : 'json',
            success: function (data) {
              // const data = JSON.parse(data);
  
              if (data['Message'] === "Token marked success") {

                var element = document.getElementById(data1);
                element.classList.remove('btn-info');
                element.classList.remove('unmarked-token');
                element.classList.add('btn-success');


         

              
                var elem1 = document.getElementById(id+"-tuesday_status");
                var elem2 = document.getElementById(id+"-wednesday_status");
                var elem3 = document.getElementById(id+"-thursday_status");
                var elem4 = document.getElementById(id+"-sunday_status");

                
                if(data1.search("tuesday")!=-1){
                var count_tuesday = document.getElementById("tuesday-count");
                count_tuesday.innerHTML = count_tuesday.innerHTML - elem1.innerHTML;
                } else if(data1.search("wednesday")!=-1){
                                    var count_wednesday = document.getElementById("wednesday-count");
                count_wednesday.innerHTML = count_wednesday.innerHTML - elem2.innerHTML;

                } else if(data1.search("thursday")!=-1){
                                    var count_thursday = document.getElementById("thursday-count");
                count_thursday.innerHTML = count_thursday.innerHTML - elem3.innerHTML;

                }else if(data1.search("sunday")!=-1){
                                    var count_sunday = document.getElementById("sunday-count");
                count_sunday.innerHTML = count_sunday.innerHTML - elem4.innerHTML;

                }
                
                if(elem1.classList.contains('btn-success') && elem2.classList.contains('btn-success') && elem3.classList.contains('btn-success') && elem4.classList.contains('btn-success')) {
                    var elm = document.getElementById(id);
                    elm.classList.remove('btn-info');
                    elm.classList.add('btn-success');
                    elm.innerHTML = "all marked";
                } else if(elem1.classList.contains('btn-success') || elem2.classList.contains('btn-success') || elem3.classList.contains('btn-success') || elem4.classList.contains('btn-success')){
                        var elm = document.getElementById(id);
                        elm.innerHTML = "partially marked";


                }



                // console.log(elem1);
                

  
              } else {
                
              }
            },
            error: function (request, error) {
              console.log(error);
            },
          });
    } );
    
  });
  
  