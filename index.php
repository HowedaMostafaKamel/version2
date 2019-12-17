<html>
 <head>
    <title>Project</title>
     <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
     <link type="text/css" href="css/style.css" rel="stylesheet">
 </head>
 <body>
    <button id="getEvents">Get Events</button>
    <div class="div-numbers">
      <form method="post" action="" id="form-numbers">
         <h1>Learn the English letters</h1>
            <label for="numbers">Enter Number of letters</label>
            <input type="number" name="numbers" id="numbers" min="1" max="26" title="Enter Only numbers of charachters from 1 to 26" required>
            <input type="submit" name="submit" id="generate" value="Generate">
      </form>
        
      <div id="letters"></div>
      
    </div>
       
        <table border="1">
          <thead>
              <th>#</th>
              <th>Event Type</th>
              <th>Event Target</th>
              <th>Event Time</th>
          </thead>
          <tbody>
          </tbody>
        </table>
   
 <script type="text/javascript" src="js/jquery.min.js"></script>
 <script type="text/javascript" src="js/bootstrap.min.js"></script>
 <script type="text/javascript">
     /*******************************************Load Event******************************************/
     var load = 0;
     var arr = [];
     window.onload = function()
     {
         load++;
         var time = new Date().getTime(); //For Calculate load Time
 
         var event = new storeEvent("load",load,time); //object

         arr.push(event);
     }
     
    /********************************* Generate Letters Function ****************************************/
    var gen = 0;
    document.querySelector("#form-numbers").addEventListener("submit", function(e)
    { 
         gen++;
         var start = new Date().getTime(); //For Calculate Generate event Time

         var old_btn = document.querySelectorAll('.char'); // get all old letters buttons 
         if(old_btn)
         {
             old_btn.forEach(el => el.remove()); //for remove old letters buttons when generate new letters buttons
         }
        
        e.preventDefault();    //stop form from submitting
        var numbers = document.getElementById("numbers").value;  // get input value
        var letters = document.getElementById("letters");
        
        all_letters =['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        
       var i = 0;
       while(i < numbers)
       {
          var random_letters = all_letters[Math.floor(Math.random()*all_letters.length)];
           
          var btn = document.createElement("BUTTON");   
          btn.innerHTML = random_letters;                   // Insert text on btn html
          letters.appendChild(btn);     
          btn.className = "char";
          btn.onclick = displayImg;
           
          i++;
       }
        
       var end = new Date().getTime();  //calculate end time of execute function
       var time = end - start;
       
       var event = new storeEvent("Generate Letters",gen,time);
       
       //Store click event In localStorage for generate letters
         arr.push(event);
     });
     
     var dis = 0;
     /*********************************** Display Image ***************************************/
     function displayImg()
     {
         dis++;
         var start = new Date().getTime();
         
         var old_img = document.querySelectorAll('.animal'); // get all old Images  
         if(old_img)
         {
             old_img.forEach(el => el.remove());  //for remove old Images when Click on letter 
         }
         
          var img = document.createElement("IMG");   
          document.body.appendChild(img);   
          img.src = "images/" + this.innerHTML + ".jpg" ;
          img.className = "animal";

         var end = new Date().getTime();
         var time = end - start;
         var event = new storeEvent("Click On Letter",dis,time);
        
         //Store click event In localStorage for display image
         arr.push(event);
     }
     
     /**************************************** Uload Event **********************************/
     var unload = 0;
     window.onunload = function()
     {
         unload++;
         var time = new Date().getTime();
 
         var event = new storeEvent("unload",unload,time);

         //Store Unload event In localStorage 
        arr.push(event);
     }
     
        var char = document.getElementsByClassName("char");
        
     /*************************************** Template Function ************************************/
        function storeEvent(eventType,eventTarget,eventTime,displayType)
        {
         this.eventType = eventType;
         this.eventTarget = eventTarget;
         this.eventTime = eventTime;
         this.displayType=function()
         {
            console.log("Event Type: "+this.eventType+" - Event Target: " +this.eventTarget+" - Time: "+ this.eventTime);
            
         }
        }
        
     window.localStorage.setItem('key',JSON.stringify(arr));
     /*********** For Clear LocalStorage Every 5 seconds ***********/

         var x = setInterval(function(){
         if(arr.length > 0)
         {
             $.ajax({
                url:"ajax_post_data.php",
                data: JSON.stringify(arr),
                type:"POST",
                dataType:"JSON",
                contentType: 'application/json',                
                 success:function(data)
                 {
                     arr = [];
                     arr.length = 0;
                     window.localStorage.clear();
                    
                 },error:function(error)
                 {
                     console.log(error);
                 }
             });
             
         }
        }, 5000);
     
     
     $("#getEvents").on("click",function(){
               $("table").css("display","block");
               /******************** get Events From database ***************/
               $.ajax({
                url:"ajax_get_data.php",
                type:"GET",
                dataType:"TEXT",                
                success:function(data)
                {  
                   $('table tbody').html(data);
                }
             })
      })
     
 </script>
 </body>
</html>