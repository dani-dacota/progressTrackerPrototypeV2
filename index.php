<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Progress TraKer</title>
        <link rel="icon" href="media/rlogo.png" type="image/gif" sizes="16x16">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Raleway');
            
            html {
                overflow-y:auto;
                overflow-x:hidden;
            }
            
            body {
                display:flex;
                justify-content:center;
                text-align:center;
                min-width:300px;
                max-width:1000px;
                margin-right:auto;
                margin-left:auto;
                margin-top:0px;
                background-color:#443693;
                color:White;
                font-family: 'Raleway', sans-serif;
            }
            
            #modal-box {
                display:none;
                z-index:1;
                text-align:center;
                width:100%;
                height:100%;
                min-width:300px;
                background-color:rgba(0,0,0,0.5);
                position:fixed;
                background: white;
            }
            
            #modal-box-header {
                display:flex;
                justify-content: center;
                height: 50px;
                background: silver;
            }
            
            #modal-box-header img {
                margin-left: auto;
                margin-right: 10px;
                margin-top: 5px;
                height:80%;
                width: auto;
                cursor: pointer;
                opacity: 0.5;
                transition: opacity, transform 0.25s;
            }
            
            #modal-box-header img:hover{
                transform: scale(1.2);
                opacity: 0.75;
            }
            
            #loading-box {
                display:none;
                z-index:1;
                text-align:center;
                width:100%;
                height:100%;
                background-color:rgba(0,0,0,0.5);
                position:fixed;
            }
            
            #loading-content {
                margin-top:100px;
                width:200px;
                margin-right:auto;
                margin-left:auto;
            }
            
            .container{
                width:100%;
                font-size: 120%;
            }

            .card {
                border: solid black 2px;
                border-radius: 5px;
                display: inline-block;
                text-align:center;
                padding: 5px 5px 10px 5px;
                margin: 2px 2px;
                background-color:rgb(200, 200, 200);
                color:Black;
                cursor: pointer;
                transition: transform 0.25s;
                vertical-align:text-bottom;
            }
            
            .card:hover {
                transform: scale(1.05);
                
            }
            
            .card meter {
                background:red;
                width: 80%;
            }
            
            h2, h3 {
                margin:0;
                margin-bottom:7px;
                padding: 0;
            }
            
            .overlay {
                position:relative; 
                bottom:22px; 
                height:0;
                color:black;
            }
            
            .future {
                //border-color: yellow;
                background-color: rgb(100, 100, 100);
                color:white;
            }
            
            p{
                margin: 0;
                padding: 0;
            }
            
            
            @keyframes slide {
               0% { transform: translateY(0px);}
               10% { transform: translateY(-10px);}
               20% { transform: translateY(0px);}
               100% { transform: translateY(0px);}
            }
            
            fieldset{
                margin-bottom: 10px;
                border: solid white 2px;
                min-width:80%;
                margin-right:auto;
                margin-left:auto;
                
            }
            
            fieldset legend {
                font-size:28px;
                cursor:pointer;
            }

            header {
                display:flex;
                justify-content:center;
                margin:0;
                padding:0;
                margin-bottom:10px;
            }
            
            header img{
                width:90%;
                height: 60px;
                object-fit:contain;
            }
            
            #progress-inside, #goal-inside, #settings-inside {
                display:none;
            }
            
            #progress-inside {
                padding: 15px 0px 5px 0px;
                white-space: nowrap;
                overflow-x: auto;
            }
            
            #goal-inside strong {
                font-size:30px;
            }
            
            #expand-progress {
                position: relative;
                bottom:10px;
                float:right;
                height:0;
                display:none;
                cursor:pointer;
                text-decoration:underline;
            }
            
            #modal-progress-form {
                display:flex;
                justify-content:center;
                width:100%;
                color: black;
            }
            
            #modal-progress-form form {
                width:100%;
                max-width: 300px;
                font-size:125%;
            }
            
            #modal-progress-form  form label{
                display: block;
                width:90%;
                margin-right:5%;
                margin-left:5%;
            }

            
            #modal-progress-form  form input{
                display: block;
                margin-bottom:10px;
                width:90%;
                margin-right:5%;
                margin-left:5%;
                font-size:125%;
            }
            
            #modal-progress-form  form textarea{
                display: block;
                margin-bottom:10px;
                width:90%;
                margin-right:5%;
                margin-left:5%;
                resize: vertical;
                font-size:125%;
            }
            
            #modal-progress-form  form input[type=button]{
                display: inline;
                font-size: 16px;
                width:auto;
                float:right;
                background-color:#443693;
                margin: 0 5%;
                color:white;
                padding: 5px 10px;
                border: solid #443693; 1px;
                border-radius: 5px;
            }
            
            #modal-progress-form  form input[type=button]:hover{
                color: #443693; 
                background-color: white;
             }
            
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            
            function formSubmit(item){
                $("#modal-box").hide();
                //console.log("formSubmit");
                //console.log(item.value);
                //console.log(item.form);
                //console.log($(item.form).attr("class"));
                if ($(item.form).attr("class") == "progress-form"){
                    sendData(item.form, "update_daily.php", item.value);
                }
                if ($(item.form).attr("class") == "settings-form"){
                    sendData(item.form, "update_parameter.php", item.value);
                }
            }
            
            function showForm(item){
                //console.log('showing', item.id+"-form");
                onlyShow(item.id+"-form");
                $("#modal-box").show();
            }
            
            //hides other elements of the same parent (except NAV)
            function onlyShow(elem){
                //console.log("only show:" + elem);
                parent = $("#"+elem).parent();
                //console.log('parent:', parent[0].id);
                kids = $("#"+parent[0].id).children();
                //console.log('kids:', kids);
                for (i = 0; i < kids.length; i++) {
                    //console.log("checking: ", kids[i])
                    //console.log("tag:", kids[i].tagName)
                    if (kids[i].tagName != "NAV"){
                        //console.log("is not nav");
                        if (kids[i].id != elem){
                            //console.log("hiding:", kids[i].id);
                            $("#"+kids[i].id).hide(); 
                        }
                        else{
                            //console.log("showing:", kids[i].id);
                            $("#"+kids[i].id).show(); 
                        }
                    }
                }
            }
            
            function toggleSlide(elem,elemName){
                $(elem+"-inside").delay(200).slideToggle();
                if ($(elem).text() == "Show " + elemName) {
                        $(elem).text("Hide " + elemName);
                }
                else {
                    $(elem).text("Show " + elemName);
                }
            }
            
            function upSlideImm(elem, elemName){
                $(elem+"-inside").slideUp();
                $(elem).text("Show " + elemName);
            }
            
            function downSlideImm(elem, elemName){
                $(elem+"-inside").slideDown();
                $(elem).text("Hide " + elemName);
            }
            
            function getData(){
                //console.log("Getting Data");
                $("#loading-box").fadeIn();
                params = "id=" + 0;
		        xmlhttp = new XMLHttpRequest();
		        xmlhttp.onreadystatechange = function() {
    			    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    			        /*
    			        //console.log('Response Received');
    			        xml_response = xmlhttp.responseXML;
    			        //console.log('XML Doc:', xml_response);
    			        
    			        xml_goal = xml_response.getElementsByTagName("goal")[0].childNodes[0];
    			        //console.log('Goal:', xml_goal);
    			        document.getElementById("goal-inside").innerHTML = xml_goal.wholeText;
    			        
    			        xml_progress = xml_response.getElementsByTagName("progress")[0].childNodes[0];
    			        //console.log('Progress:', xml_progress);
    			        document.getElementById("progress-inside").innerHTML = xml_progress.wholeText;
    			        
    			        xml_settings = xml_response.getElementsByTagName("settings")[0].childNodes[0];
    			        document.getElementById("settings-inside").innerHTML = xml_settings.wholeText;
    			        */
    			        
    			        var responseObj = JSON.parse(xmlhttp.responseText);
    			        parseServerResponse(responseObj);
    			        
    			        $("#loading-box").fadeOut();
    			        //initializeForms();
    		    	}
		        };
		        xmlhttp.open("POST","get_data.php",true);
		        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		        xmlhttp.send(params);
		        //xmlhttp.send();
            }
            
            function sendData(form, url, action) {
                $("#loading-box").fadeIn();
                var XHR = new XMLHttpRequest();
                
                //console.log(form);
            
                // Bind the FormData object and the form element
                var FD = new FormData(form);
                FD.append('action', action);
            
                // Define what happens on successful data submission
                XHR.addEventListener("load", function(event) {
                  //alert(event.target.responseText);
                  getData();
                });
            
                // Define what happens in case of error
                XHR.addEventListener("error", function(event) {
                  alert('Oops! Something went wrong.');
                });
            
                // Set up our request
                XHR.open("POST", url);
            
                // The data sent is what the user provided in the form
                XHR.send(FD);
            }
            
            //parses server response
            function parseServerResponse(responseObj){
                if (responseObj["change"].length != 0){
                        changes = responseObj["change"];
                        //console.log(changes);
                        for(key in changes){
                            //console.log(key, changes[key]);
                            $(key).html(changes[key]);
                        }
                    }
                    if (responseObj["hide"].length != 0){
                        //console.log("hide:",responseObj["hide"]);
                        hides = responseObj["hide"];
                        for(key in hides){
                            //console.log(key, hides[key]);
                            $(hides[key]).hide();
                        }
                    }
                    if (responseObj["show"].length != 0){
                        //console.log(responseObj["show"]);
                        shows = responseObj["show"];
                        for(key in shows){
                            //console.log(key, shows[key]);
                            $(shows[key]).show();
                        }
                    }
            }
            
            $(document).ready(function(){
                downSlideImm("#goal","Goal");
                getData();
                
                $("#show-modal-form").click(function(){
                    $("#modal-box").show();
                });
                
                $("#close-modal").click(function(){
                    $("#modal-box").hide();
                });
                
                $("#projects").click(function(){
                    toggleSlide("#projects", "Projects");
                });
                
                $("#goal").click(function(){
                    toggleSlide("#goal","Goal");
                });
                
                $("#progress").click(function(){
                    toggleSlide("#progress", "Progress");
                    $("#expand-progress").slideToggle()
                });
                
                $("#settings").click(function(){
                    toggleSlide("#settings", "Settings");
                });
                
                $("#expand-progress").click(function(){
                    //console.log("expand", $("#progress-inside").css("white-space"));
                    
                    if ($("#progress-inside").css("white-space") == "nowrap"){
                        $("#progress-inside").css("white-space", "normal");
                        $("#expand-progress").text("Show Horizontally");
                    } 
                    else {
                        $("#progress-inside").css("white-space", "nowrap");
                        $("#expand-progress").text("Show Vertically");
                    }
                    
                });
                
            });
        </script>
    </head>
    
    <body>
        <div id="loading-box">
            <div id="loading-content">
                <img width="100%" src="media/loading.gif">
            </div>
        </div>
        
        <div id="modal-box">
            <div id="modal-box-header">
                <img id="close-modal" src="media/x-button.png">
            </div>
            <div id="modal-progress-form">
                Progress Form
            </div>
        </div>
        
        
        <div class="container">
            <header>
                <img src="media/logo.png">
            </header>
            
            <fieldset>
                <legend id="goal">Show Goal</legend>
                <div id="goal-inside">
                </div>
            </fieldset>
            
            <fieldset>
                <legend id="progress">Show Progress</legend>
                <div id="expand-progress">Show Vertically</div>
                <div id="progress-inside">
                </div>
            </fieldset>
        
            <fieldset>
                <legend id="settings">Show Settings</legend>
                <div id="settings-inside">
                </div>
            </fieldset>
        </div>
        
    </body>
</html>